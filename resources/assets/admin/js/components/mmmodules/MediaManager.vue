<template>
  <div
    id="media-manager-file-picker"
    class="media-manager-main"
  >
    <div class="modal-header">
      <top-toolbar
        :is-modal="isModal"
        :current-file="currentFile"
        :current-path="currentPath"
        @reload-folder="loadFolder( currentPath )"
        @open-modal-create-folder="showCreateFolderModal = true"
        @open-modal-delete-item="showDeleteItemModal = true"
        @open-modal-move-item="showMoveItemModal = true"
        @open-modal-rename-item="showRenameItemModal = true"
        @upload-file="uploadFile"
      />

    </div>

    <div
      id="mediaManagerDropZone"
      class="modal-body"
    >
      <div
        v-if="loading"
        class="media-manager-alternative-content loading"
      >
        <p>
          <span class="fa fa-spin fa-refresh" /> Загрузка...
        </p>

        <h4 v-if="uploadProgress > 0">{{ uploadProgress }} %</h4>
      </div>

      <div v-else>

        <div class="media-manager-file-browser">
          <div class="row">
            <div class="col-xs-12">
              <ol class="breadcrumb">

                <li
                  v-for="(name, key) in breadCrumbs"
                  :key="name"
                >
                  <a
                    class="media-manager-modal-a"
                    href="javascript:void(0);"
                    @click="loadFolder(key)"
                  >{{ name }}</a>
                </li>

                <li class="active">
                  {{ folderName }}
                </li>
              </ol>
            </div>
          </div>

          <div
            v-if="isFolderEmpty"
            class="media-manager-alternative-content"
          >
            <h4>Папка пуста.</h4>
            <p>Переместите файлы в данное окно для загрузки.</p>
          </div>

          <div
            v-else
            class="row"
          >
            <div
              :class="{ 'col-sm-12' : !isFile(currentFile) || isFolder(currentFile), 'col-sm-9' : isFile(currentFile) && ! isFolder(currentFile) }"
              class="col-xs-12"
              style="overflow: auto; max-height: 550px"
            >

              <div class="table-responsive media-manager-file-picker-list">

                <table class="table">
                  <thead>
                    <tr>
                      <th><a
                        class="media-manager-modal-a"
                        href="javascript:void(0);"
                        @click="orderBy('name')"
                      >Название</a></th>
                      <th><a
                        class="media-manager-modal-a"
                        href="javascript:void(0);"
                        @click="orderBy('mimeType')"
                      >Тип</a></th>
                      <th><a
                        class="media-manager-modal-a"
                        href="javascript:void(0);"
                        @click="orderBy('modified.date')"
                      >Дата</a></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="folder in folders"
                      :key="folder.name"
                      :class="[ (folder == currentFile) ? 'bg-primary-media-manager-modal' : '' ]"
                    >
                      <td>
                        <a
                          class="media-manager-modal-a"
                          href="javascript:void(0);"
                          @click="previewFile(folder)"
                          @dblclick="loadFolder(folder.fullPath)"
                          @keyup.enter="loadFolder(folder.fullPath)"
                        >
                          <i class="fa fa-folder" />
                          {{ folder.name }}
                        </a>
                      </td>
                      <td>folder</td>
                      <td>{{ folder.modified.date | formatDate('DD/MM/YYYY') }}</td>
                    </tr>

                    <tr
                      v-for="file in files"
                      :key="file.name"
                      :class="[ (file == currentFile) ? 'bg-primary-media-manager-modal' : '' ]"
                    >
                      <td>
                        <a
                          v-if="isModal"
                          class="media-manager-modal-a"
                          href="javascript:void(0);"
                          @click="previewFile(file)"
                          @keyup.enter="selectFile(file)"
                          @dblclick="selectFile(file)"
                        >
                          <i
                            v-if="isImage(file)"
                            class="fa fa-file-image-o"
                          />
                          <i
                            v-else
                            class="fa fa-file-text-o"
                          />
                          {{ file.name }}
                        </a>
                        <a
                          v-else
                          class="media-manager-modal-a"
                          href="javascript:void(0);"
                          @click="previewFile(file)"
                        >
                          <i
                            v-if="isImage(file)"
                            class="fa fa-file-image-o"
                          />
                          <i
                            v-else
                            class="fa fa-file-text-o"
                          />
                          {{ file.name }}
                        </a>

                      </td>
                      <td> {{ file.mimeType }}</td>
                      <td> {{ file.modified.date | formatDate('DD/MM/YYYY') }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <preview-sidebar :current-file="currentFile" />
          </div>
        </div>
      </div>

      <div class="modal-footer vertical-center">
        <div class="item-count">
          {{ itemsCount }} файлов
        </div>

        <!-- Buttons to be rendered if the media-manager is in a modal window-->
        <div
          v-if="isModal"
          class="buttons"
        >
          <button
            v-show="currentFile && !isFolder(currentFile)"
            type="button"
            class="btn btn-primary"
            @click="selectFile()"
          >
            Выбрать
          </button>
          <button
            type="button"
            class="btn btn-default"
            @click="close()"
          >
            Отменить
          </button>
        </div>
      </div>
    </div>

    <modal-create-folder
      :current-path="currentPath"
      :prefix="prefix"
      :show="showCreateFolderModal"
      @media-modal-close="showCreateFolderModal = false"
      @reload-folder="loadFolder( currentPath )"
    />

    <modal-delete-item
      :current-path="currentPath"
      :current-file="currentFile"
      :prefix="prefix"
      :show="showDeleteItemModal"
      @media-modal-close="showDeleteItemModal = false"
      @reload-folder="loadFolder( currentPath )"
    />

    <modal-move-item
      :current-path="currentPath"
      :current-file="currentFile"
      :prefix="prefix"
      :show="showMoveItemModal"
      @media-modal-close="showMoveItemModal = false"
      @reload-folder="loadFolder( currentPath )"
    />

    <modal-rename-item
      :current-path="currentPath"
      :current-file="currentFile"
      :prefix="prefix"
      :show="showRenameItemModal"
      @media-modal-close="showRenameItemModal = false"
      @reload-folder="loadFolder( currentPath )"
    />

  </div>
</template>

<script>
import axios from 'axios';
import { orderBy } from 'lodash';
import fileManagerMixin from './mixins/file-manager-mixin';
import RenameItemModal from './RenameItemModal';
import CreateFolderModal from './CreateFolderModal';
import ConfirmDeleteModal from './ConfirmDeleteModal';
import MoveItemModal from './MoveItemModal';
import PreviewSideBar from './PreviewSideBar';
import TopToolBar from './TopToolBar';

export default {
  components: {
    'modal-rename-item': RenameItemModal,
    'modal-create-folder': CreateFolderModal,
    'modal-delete-item': ConfirmDeleteModal,
    'modal-move-item': MoveItemModal,
    'preview-sidebar': PreviewSideBar,
    'top-toolbar': TopToolBar,
  },
  mixins: [fileManagerMixin],
  props: {
    /**
     * Is this instance of the media manager a modal window.
     * If so then this property is used to show the close
     * buttons at the top and bottom of the screen.
     */
    isModal: {
      default: false,
      type: Boolean,
    },
    /**
     * Default route prefix
     */
    prefix: {
      default: '/api/internal/admin/',
      type: String,
    },
    /**
     * The event to be fired when selectItem() is called.
     * The actual event name emitted is prefixed w/
     * "media-manager-selected-" so to avoid
     * clashes w/ other events.
     */
    selectedEventName: {
      default: '',
      type: String,
    },
    /**
     * If this instance is a modal window then this
     * property is used to show or hide the
     * modal window.
     */
    show: {
      default: false,
      type: Boolean,
    },

    firstFolder: {
      default: '',
      type: String,
    },
  },
  data() {
    return {
      /**
       * breadCrumbs for the current path that are used to go
       * backwards through the directory tree.
       */
      breadCrumbs: {},
      /**
       * The currently highlighted file
       */
      currentFile: {},
      /**
       * The current path that the media manager is displaying
       */
      currentPath: '',
      /**
       * All of the files in the current path
       */
      files: [],
      /**
       * The current path's folder name
       */
      folderName: null,
      /**
       * All of the sub folders in the current path
       */
      folders: [],
      /**
       * Property to show the loading indicator
       */
      loading: true,
      /**
       * Property to show upload progress
       */
      uploadProgress: 0,
      /**
       * Total files and folder count
       */
      itemsCount: 0,
      /**
       * properties to show and hide internal modal windows
       */
      showCreateFolderModal: false,
      showDeleteItemModal: false,
      showMoveItemModal: false,
      showRenameItemModal: false,
      /**
       * property to hold direction of column sorting
       */
      sortDirection: false,
    };
  },
  computed: {
    isFolderEmpty() {
      return this.files.length + this.folders.length === 0;
    },
  },
  mounted() {
    this.loadFolder(this.firstFolder);
    this.dragUpload();
    if (!this.prefix.endsWith('/')) {
      this.prefix = `${this.prefix}/`;
    }
  },
  methods: {
    /**
     * sort files and folders...
     * @param column
     */
    orderBy(column) {
      this.sortDirection = !this.sortDirection;
      const order = this.sortDirection ? 'desc' : 'asc';
      this.files = orderBy(this.files, [column], [order]);
      this.folders = orderBy(this.folders, [column], [order]);
    },
    close() {
      this.breadCrumbs = {};
      this.currentFile = {};
      this.currentPath = '';
      this.files = {};
      this.folderName = '';
      this.folders = {};
      this.itemsCount = 0;
      this.$emit('media-modal-close');
    },
    loadFolder(path) {
      this.uploadProgress = 0;
      if (!path) {
        path = this.currentPath ? this.currentPath : '';
      }
      this.loading = true;
      this.currentFile = false;
      axios.get(`${this.prefix}browser/index?path=${path}`).then(
        (response) => {
          this.breadCrumbs = response.data.breadCrumbs;
          if (this.firstFolder) {
            const paths = this.firstFolder.split('/');
            paths.pop();
            for (path of paths) {
              delete this.breadCrumbs[`/${path}`];
            }
            delete this.breadCrumbs['/'];
          }
          this.currentFile = {};
          this.currentPath = response.data.folder;
          this.loading = false;
          this.files = response.data.files;
          this.folderName = response.data.folderName;
          this.folders = response.data.subFolders;
          this.itemsCount = response.data.itemsCount;
        },
        (response) => {
          if (response.data.error) {
            this.mediaManagerNotify(response.data.error, 'danger');
          }
          this.loading = false;
          this.currentFile = {};
        },
      );
    },
    previewFile(file) {
      this.currentFile = file;
    },
    uploadFile(payload) {
      const fieldName = payload.name;
      const fileList = payload.files;
      /**
       * Create a new form request object.
       * Gather all of the files to be uploaded and append them to it.
       * Attach the current path so the server knows where to upload the files to.
       * Send a post request to the server...
       */
      const form = new FormData();
      Array.from(Array(fileList.length).keys()).map((x) => {
        form.append(fieldName, fileList[x], fileList[x].name);
      });

      form.append('folder', this.currentPath);
      this.loading = true;
      axios
        .post(`${this.prefix}browser/file`, form, {
          progress(e) {
            if (e.lengthComputable) {
              this.uploadProgress = parseFloat(Math.round((e.loaded / e.total) * 100)).toFixed(2);
            }
          },
        })
        .then(
          (response) => {
            this.mediaManagerNotify(response.data.success);
            this.loadFolder(this.currentPath);
          },
          (response) => {
            const error = response.data.error ? response.data.error : response.statusText;
            // when uploading we might have some files uploaded and others fail
            if (response.data.notices) this.mediaManagerNotify(response.data.notices);
            this.mediaManagerNotify(error, 'danger', 5000);
            this.loadFolder(this.currentPath);
          },
        );
    },
    selectFile() {
      /**
       * Only dispatch an event if a custom event has been defined
       */
      if (this.selectedEventName) {
        window.eventHub.$emit(`media-manager-selected-${this.selectedEventName}`, this.currentFile);
      }

      this.$emit('selected-file', this.currentFile.relativePath);
      this.close();
    },
    dragUpload() {
      let Dropzone = require('dropzone'); //eslint-disable-line
      Dropzone.autoDiscover = false;
      this.dropzone = new Dropzone('div#mediaManagerDropZone', {
        clickable: false,
        createImageThumbnails: false,
        dictDefaultMessage: '',
        enqueueForUpload: true,
        paramName: 'files',
        previewsContainer: null,
        previewTemplate: '<span class="hidden"></span>',
        hiddenInputContainer: true,
        uploadMultiple: true,
        url: `${this.prefix}browser/file`,
        headers: {
          'X-CSRF-TOKEN': window.axios.defaults.headers.common['X-CSRF-TOKEN'],
        },
        sending: (file, xhr, form) => {
          this.loading = true;
          form.append('folder', this.currentPath);
        },
        completemultiple: () => {
          this.loading = false;
          this.loadFolder(this.currentPath);
        },
        errormultiple: (files, response) => {
          this.mediaManagerNotify(response.error);
        },
        successmultiple: (files, response) => {
          this.mediaManagerNotify(response.success);
        },
        totaluploadprogress: (uploadProgress) => {
          this.uploadProgress = parseFloat(Math.round(uploadProgress * 100) / 100).toFixed(2);
          if (this.uploadProgress < 100) {
            this.loading = true;
          } else {
            this.uploadProgress = 0;
            this.loading = false;
          }
        },
      });
    },
  },
};
</script>

<style>
.media-manager-modal-a {
  color: #333 !important;
}

.bg-primary-media-manager-modal {
  background-color: #337ab7;
  color: #fff;
}

.bg-primary-media-manager-modal .media-manager-modal-a {
  background-color: #337ab7;
  color: #fff !important;
}

.modal-mask {
  display: table;
  width: 100%;
  height: 100%;
}
</style>
