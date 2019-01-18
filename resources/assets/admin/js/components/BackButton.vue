<template>
  <button
    type="button"
    class="btn btn-default btn-sm"
    @click="routerBack"
  >
    <span class="glyphicon glyphicon-chevron-left" /> Назад
  </button>
</template>

<script>
export default {
  data() {
    return {
      // Code...
    };
  },
  created() {
    // Code...
  },
  methods: {
    routerBack() {
      this.$router.go(-1);
    },
  },
};
</script>
