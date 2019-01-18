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
                <h4 class="modal-title">Переименовать</h4>
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
                    <label>Имя</label>
                    <p class="form-control-static">{{ getItemName(currentFile) }}</p>
                  </div>

                  <div class="form-group fg-line">
                    <label>Новое имя</label>
                    <input
                      ref="newItemName"
                      v-model="newItemName"
                      type="text"
                      class="form-control"
                      @keyup.enter="renameItem()"
                    >
                  </div>

                  <media-errors :errors="errors" />

                </div>

                <div class="modal-footer">
                  <button
                    class="btn btn-primary"
                    type="button"
                    @click="renameItem()"
                  >
                    Переименовать
                  </button>
                  <button
                    class="btn btn-default"
                    type="button"
                    @click="close()"
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
import MediaErrors from './MediaErrors';

export default {
  components: {
    'media-errors': MediaErrors,
  },

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

  data() {
    return {
      errors: [],
      loading: false,
      newItemName: null,
      size: 'modal-md',
    };
  },

  watch: {
    show(val) {
      if (val) {
        window.Vue.nextTick(() => {
          this.$refs.newItemName.focus();
        });
      }
    },
  },

  mounted() {
    document.addEventListener('keydown', (e) => {
      if (this.show && e.keyCode === 13) {
        this.renameItem();
      }
    });
  },

  methods: {
    close() {
      this.errors = [];
      this.newItemName = null;
      this.loading = false;
      this.$emit('media-modal-close');
    },

    renameItem() {
      if (!this.newItemName) {
        this.errors = ['Необходимо ввести новое имя для файла.'];
      } else {
        this.loading = true;
        const original = this.getItemName(this.currentFile);

        const data = {
          path: this.currentPath,
          original,
          newName: this.newItemName,
          type: this.isFolder(this.currentFile) ? 'Folder' : 'File',
        };

        axios
          .post(`${this.prefix}browser/rename`, data)
          .then((response) => {
            this.$emit('reload-folder');
            this.mediaManagerNotify(response.data.success);
            this.close();
          })
          .catch((error) => {
            this.errors = error.response.data.error
              ? error.response.data.error
              : error.response.statusText;
            this.loading = false;
          });
      }
    },
  },
};
</script>
