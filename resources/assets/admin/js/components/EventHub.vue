<template>
  <div />
</template>


<script>
export default {
  data() {
    return {
      // Code...
    };
  },
  created() {
    this.$eventHub.$on('create-success', this.itemCreated);
    this.$eventHub.$on('update-success', this.itemUpdated);
    this.$eventHub.$on('delete-success', this.itemDeleted);
    this.$eventHub.$on('import-success', this.importSuccess);
  },
  methods: {
    itemCreated() {
      this.$awn.success('Запись успешно записана.');
    },
    itemUpdated() {
      this.$awn.success('Запись успешно обновлена.');
    },
    itemDeleted() {
      this.$awn.success('Запись успешно удалена.');
    },
    importSuccess() {
      this.$awn.success('Импорт успешно завершен.');
    },
  },
};
</script>
