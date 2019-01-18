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

            <div class="modal-header">
              <button
                class="close"
                type="button"
                @click="close()"
              >×</button>
              <h4 class="modal-title">Создать папку</h4>
            </div>

            <div
              v-if="loading"
              class="text-center"
            >
              <span class="fa fa-spin fa-refresh" /> Загрузка...
            </div>

            <div v-else>
              <div class="modal-body">
                <div class="form-group fg-line">
                  <label>Название папки</label>
                  <input
                    ref="folderName"
                    v-model="newFolderName"
                    type="text"
                    class="form-control"
                    @keyup.enter="createFolder()"
                  >
                </div>

                <media-errors :errors="errors" />

              </div>

              <div class="modal-footer">
                <button
                  class="btn btn-success"
                  type="button"
                  @click="createFolder()"
                >
                  Добавить
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
      newFolderName: null,
      size: 'modal-md',
    };
  },

  watch: {
    show(val) {
      if (val) {
        window.Vue.nextTick(() => {
          this.$refs.folderName.focus();
        });
      }
    },
  },

  mounted() {
    document.addEventListener('keydown', (e) => {
      if (this.show && e.keyCode === 13) {
        this.createFolder();
      }
    });
  },

  methods: {
    close() {
      this.newFolderName = null;
      this.loading = false;
      this.errors = [];
      this.$emit('media-modal-close');
    },

    createFolder() {
      if (!this.newFolderName) {
        this.errors = ['Ошибка! Имя папки не должно быть пустым.'];
        return;
      }

      const data = {
        folder: this.currentPath,
        new_folder: this.newFolderName,
      };

      this.loading = true;
      axios.post(`${this.prefix}browser/folder`, data).then(
        (response) => {
          this.mediaManagerNotify(response.data.success);
          this.$emit('reload-folder');
          this.close();
        },
        (errors) => {
          this.errors = errors.response.data.error
            ? errors.response.data.error
            : errors.response.statusText;
          this.loading = false;
        },
      );
    },
  },
};
</script>
