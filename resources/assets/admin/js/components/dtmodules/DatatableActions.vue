<template>
  <div class="btn-group btn-group-xs">
    <router-link
      :to="{ name: xprops.route + '.show', params: { id: row.id } }"
      class="btn btn-primary"
    >
      <i class="fa fa-eye" />
    </router-link>
    <router-link
      :to="{ name: xprops.route + '.edit', params: { id: row.id } }"
      class="btn btn-warning"
    >
      <i class="fa fa-edit" />
    </router-link>
    <button
      type="button"
      class="btn btn-danger"
      @click="destroyData(row.id)"
    >
      <i class="fa fa-trash" />
    </button>
  </div>
</template>


<script>
export default {
  props: ['row', 'xprops'],
  data() {
    return {
      // Code...
    };
  },
  created() {
    // Code...
  },
  methods: {
    destroyData(id) {
      this.$swal({
        title: 'Вы уверены?',
        text: 'Это действие необратимо!',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Удалить',
        cancelButtonText: 'Отмена',
        confirmButtonColor: '#dd4b39',
        focusCancel: true,
        reverseButtons: true,
      }).then((result) => {
        if (result.value) {
          this.$store.dispatch(`${this.xprops.module}/destroyData`, id).then((result) => {
            this.$eventHub.$emit('delete-success');
          });
        }
      });
    },
  },
};
</script>
