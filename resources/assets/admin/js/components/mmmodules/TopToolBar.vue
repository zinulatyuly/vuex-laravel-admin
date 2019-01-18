<template>
  <div
    class="btn-toolbar"
    role="toolbar"
  >
    <div class="btn-group pull-left">
      <!-- File input wont get triggered if this is a button so use a label instead -->
      <label
        class="btn btn-primary btn-sm"
        title="Нажмите для выбора файла или перетащите файлы в данное окно"
      >
        <i class="fa fa-upload" />
        <span class="hidden-xs">Загрузить</span>
        <input
          multiple
          class="hidden"
          name="files[]"
          type="file"
          @change="uploadFile($event.target.name, $event.target.files)"
        >
      </label>

      <button
        class="btn btn-success btn-sm"
        type="button"
        title="Нажмите для создания папки"
        @click="openModalCreateFolder()"
      >
        <i class="fa fa-plus-square" />
        <span class="hidden-xs">Добавить папку</span>
      </button>

      <button
        class="btn btn-default btn-sm"
        type="button"
        title="Нажмите для обновления"
        @click="refresh()"
      >
        <i class="fa fa-refresh" />
        <span class="hidden-xs">Обновить</span>
      </button>
    </div>

    <div class="btn-group pull-right">
      <button
        v-if="!isModal"
        :disabled="!isFile(currentFile)"
        class="btn btn-default btn-sm"
        type="button"
        title="Выберите файл для перемещения"
        @click="openModalMoveItem()"
      >
        <i class="fa fa-arrow-right" />
        <span class="hidden-xs">Переместить</span>
      </button>

      <button
        :disabled="!isFile(currentFile)"
        class="btn btn-default btn-sm"
        type="button"
        title="Выберите файл для удаления"
        @click="openModalDeleteItem()"
      >
        <i class="fa fa-trash" />
        <span class="hidden-xs">Удалить</span>
      </button>

      <button
        :disabled="!isFile(currentFile)"
        class="btn btn-default btn-sm"
        type="button"
        title="Выберите файл для изменения"
        @click="openModalRenameItem()"
      >
        <i class="fa fa-pencil" />
        <span class="hidden-xs">Переименовать</span>
      </button>
    </div>

  </div>
</template>

<script>
import fileManagerMixin from './mixins/file-manager-mixin';

export default {
  mixins: [fileManagerMixin],

  props: {
    currentFile: {
      default() {
        return {};
      },
      type: [Object, Boolean],
    },
    currentPath: {
      default: '',
      type: String,
    },
    isModal: {
      default: false,
      type: Boolean,
    },
  },

  methods: {
    refresh() {
      this.$emit('reload-folder');
    },

    uploadFile(fileName, fileList) {
      this.$emit('upload-file', {
        name: fileName,
        files: fileList,
      });
    },

    openModalCreateFolder() {
      this.$emit('open-modal-create-folder');
    },

    openModalMoveItem() {
      this.$emit('open-modal-move-item');
    },

    openModalDeleteItem() {
      this.$emit('open-modal-delete-item');
    },

    openModalRenameItem() {
      this.$emit('open-modal-rename-item');
    },
  },
};
</script>
