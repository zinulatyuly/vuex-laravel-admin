<template>
  <datatable
    :columns="columns"
    :data="data"
    :total="total"
    :query="query"
    :xprops="xprops"
  >
    <div class="form-group has-feedback pull-left">
      <input
        v-model.trim="query.filter"
        type="search"
        class="form-control"
        placeholder="Поиск"
      >
      <i class="form-control-feedback fa fa-search" />
    </div>
  </datatable>
</template>

<script>
export default {
  props: ['columns', 'data', 'total', 'query', 'xprops'],
  data() {
    return {
      // Code...
    };
  },
  created() {
    // Code...
  },
  methods: {
    // Code...
  },
};
</script>
