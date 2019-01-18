<template>
  <transition
    v-if="show"
    name="modal"
    @media-modal-close="close()"
  >
    <div
      class="modal modal-mask"
      @click="close()"
    >
      <div class="modal-wrapper">
        <div
          class="modal-md modal-dialog"
          @click.stop
        >
          <div class="modal-content">
            <div>
              <div class="modal-header">
                <button
                  class="close"
                  type="button"
                  @click="close()"
                >×
                </button>
                <h4 class="modal-title">Удалить</h4>
              </div>

              <div
                v-if="loading"
                class="text-center"
              >
                <span class="fa fa-spin fa-refresh" /> Загрузка...
              </div>

              <div v-else>
                <div class="modal-body">
                  <div class="form-group">
                    <label>Вы уверены, что хотите удалить данный файл (папку)?</label>
                    <p class="form-control-static">{{ getItemName(currentFile) }}</p>
                  </div>

                </div>

                <div class="modal-footer">
                  <button
                    class="btn btn-danger"
                    type="button"
                    @click="deleteItem()"
                  >
                    Удалить
                  </button>
                  <button
                    class="btn btn-default"
                    type="button"
                    @click="close"
                  >
                    Отменить
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
import axios from 'axios';
import fileManagerMixin from './mixins/file-manager-mixin';

export default {
  mixins: [fileManagerMixin],

  props: {
    currentPath: {
      default: '',
      type: String,
    },

    currentFile: {
      default() {
        return {};
      },
      type: [Object, Boolean],
    },

    /**
     * Default route prefix
     */
    prefix: {
      default: '/admin/',
      type: String,
    },

    show: {
      default: false,
      type: Boolean,
    },
  },

  data: () => ({
    loading: false,
    newItemName: null,
    size: 'modal-md',
  }),

  mounted() {
    document.addEventListener('keydown', (e) => {
      if (this.show && e.keyCode === 13) {
        this.deleteItem();
      }
    });
  },

  methods: {
    close() {
      this.newItemName = null;
      this.loading = false;
      this.$emit('media-modal-close');
    },

    deleteItem(route, data) {
      if (this.isFolder(this.currentFile)) {
        return this.deleteFolder(route, data);
      }
      return this.deleteFile(route, data);
    },

    deleteFile() {
      if (this.currentFile) {
        const data = {
          path: this.currentFile.fullPath,
        };
        this.rm(`${this.prefix}browser/file`, data);
      }
    },

    deleteFolder() {
      if (this.isFolder(this.currentFile)) {
        const data = {
          path: this.currentFile.fullPath,
        };
        this.rm(`${this.prefix}browser/folder`, data);
      }
    },

    rm(route, payload) {
      this.loading = true;
      axios.delete(route, { params: payload }).then(
        (response) => {
          this.$emit('reload-folder');
          this.mediaManagerNotify(response.data.success);
          this.close();
        },
        (errors) => {
          const error = errors.response.data.error
            ? errors.response.data.error
            : errors.response.statusText;
          this.mediaManagerNotify(error, 'danger');
          this.close();
        },
      );
    },
  },
};
</script>
