<template>
  <div style="max-width:200px;">
    <a
      v-if="!isCustomFiles"
      href="#"
      @click="showModal = true"
    >
      <img
        :src="`/200x200/${internalFile}`"
        style="max-width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;"
      >
    </a>
    <a
      v-else
      href="#"
      style="max-width:250px; height:auto; clear:both; display:block; margin-bottom:5px;"
      @click="showModal = true"
    >
      {{ internalFile }}
    </a>
    <input
      :accept="accept"
      type="file"
      name="file"
      @input="uploadFile"
    >
    <manager-modal
      v-model="showModal"
      :first-folder="folder"
      @selected-file="internalFile = $event"
    />
  </div>
</template>

<script>
export default {
  props: {
    file: {
      type: String,
      default: '',
    },
    folder: {
      type: String,
      default: '',
    },
    accept: {
      type: String,
      default: 'image/*',
    },
  },
  data() {
    return {
      showModal: false,
    };
  },
  computed: {
    isCustomFiles() {
      return this.accept !== 'image/*';
    },
    internalFile: {
      get() {
        if (this.isCustomFiles) {
          return this.file == null ? 'Файл не загружен' : this.file.replace(/^.*(\\|\/|\:)/, '');
        }

        return this.file == null ? '/images/no-image.png' : this.file;
      },
      set(newValue) {
        this.$emit('selected-file', newValue);
      },
    },
  },
  methods: {
    uploadFile(e) {
      const data = new FormData();

      const files = e.target.files || e.dataTransfer.files;

      if (!files.length) {
        return;
      }

      const fileName = files[0].name.toLowerCase().trim();

      data.append('path', this.folder);
      data.append('file', files[0], fileName);

      const config = {
        headers: { 'content-type': 'multipart/form-data' },
      };

      axios.post('/api/internal/admin/media/upload', data, config).then((response) => {
        this.$emit('uploaded-file', `/uploads/${this.folder}/${response.data.data.hash}`);
      });
    },
  },
};
</script>
