<template>
  <div
    v-if="isFile(currentFile) && !isFolder(currentFile)"
    class="media-manager-file-picker-sidebar hidden-xs col-sm-3"
  >

    <img
      v-if="isImage(currentFile)"
      id="media-manager-preview-image"
      :src="currentFile.relativePath"
      class="img-responsive center-block"
    >

    <div
      v-else
      class="text-center"
      style="margin-bottom: 20px"
    >
      <i
        class="fa fa-file-text-o"
        style="font-size: 12em"
      />
    </div>

    <table
      class="table-responsive table-condensed table-vmiddle media-manager-file-picker-preview-table"
      style="width: 100%; table-layout: fixed; word-wrap: break-word"
    >
      <tbody>
        <tr>
          <td
            class="description"
            width="35%"
          >Название</td>
          <td class="file-value">{{ currentFile.name }}</td>
        </tr>
        <tr>
          <td
            class="description"
            width="35%"
          >Размер</td>
          <td class="file-value">{{ currentFile.size | humanFileSize }}</td>
        </tr>
        <tr>
          <td
            class="description"
            width="35%"
          >URL</td>
          <td class="file-value">
            <a
              :href="currentFile.relativePath"
              target="_blank"
              rel="noopener"
            >{{ currentFile.relativePath }}</a>
          </td>
        </tr>
        <tr>
          <td
            class="description"
            width="35%"
          >Загружено</td>
          <td class="file-value">{{ currentFile.modified.date | formatDate }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
.icon-file-text2 {
  font-size: 15rem;
}

#media-manager-preview-image {
  max-height: 200px;
}
</style>

<script>
import fileManagerMixin from './mixins/file-manager-mixin';

export default {
  filters: {
    // Take any integer of bytes and convert it into something more human readable...
    humanFileSize(size) {
      const i = Math.floor(Math.log(size) / Math.log(1024));
      return `${(size / Math.pow(1024, i)).toFixed(2) * 1} ${['B', 'kB', 'MB', 'GB', 'TB'][i]}`;
    },
  },

  mixins: [fileManagerMixin],

  props: {
    currentFile: {
      default() {
        return {};
      },
      type: [Object, Boolean],
    },
  },
};
</script>
