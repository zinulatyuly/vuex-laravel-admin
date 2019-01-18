<template>
  <vue-datatable
    :columns="columns"
    :data="paginate(filteredData)"
    :total="filteredData.length"
    :query="query"
    :xprops="xprops"
  >
    <div class="row">
      <div class="col-md-3">
        <div class="input-group">
          <span
            id="search-input"
            class="input-group-addon"
          ><i class="fa fa-search" /></span>
          <input
            v-model="keyword"
            type="text"
            class="form-control"
            placeholder="Найти..."
            aria-describedby="search-input"
          >
        </div>
      </div>
    </div>
  </vue-datatable>
</template>

<script>
import Fuse from 'fuse.js';

export default {
  props: ['columns', 'data', 'total', 'query', 'xprops'],
  data() {
    return {
      keyword: '',
      options: {
        shouldSort: true,
        threshold: 0.3,
        location: 0,
        distance: 100,
        maxPatternLength: 32,
        minMatchCharLength: 1,
        keys: _.map(
          _.filter(
            this.columns,
            item => 'field' in item && item.field !== 'id' && item.searchable !== false,
          ),
          (item) => {
            if ('searchableField' in item) {
              return item.searchableField;
            }
            if (this.$root.relationships) {
              if (this.$root.relationships[item.field]) {
                return `${item.field}.${this.$root.relationships[item.field]}`;
              }
            }
            return item.field;
          },
        ),
      },
    };
  },
  computed: {
    filteredData() {
      let rows = this.data;

      if (this.keyword !== '') {
        const fuse = new Fuse(this.data, this.options);
        rows = fuse.search(this.keyword);
      }

      if (this.query.sort && this.keyword === '') {
        rows = _.orderBy(rows, this.query.sort, this.query.order);
      }

      return rows;
    },
  },
  methods: {
    paginate(data) {
      return data.slice(this.query.offset, this.query.offset + this.query.limit);
    },
  },
};
</script>
