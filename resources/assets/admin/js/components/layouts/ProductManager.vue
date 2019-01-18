<template>
  <div class="form-group">
    <label>Номенклатура</label>
    <VSelect
      :value="product"
      :filterable="false"
      :options="foundProducts"
      name="product"
      label="shortName"
      @input="selectProduct"
      @search="onSearchProducts"
    >
      <template slot="no-options">
        Введите артикул номенклатуры...
      </template>
      <template
        slot="option"
        slot-scope="option"
      >
        <div>{{ option.shortName }}</div>
      </template>
      <template
        slot="selected-option"
        slot-scope="option"
      >
        <div class="selected">
          {{ option.shortName }}
        </div>
      </template>
    </VSelect>
  </div>
</template>

<script>
import debounce from 'debounce-promise';

export default {
  props: {
    product: {
      type: [Object, null],
    },
  },
  data() {
    return {
      foundProducts: [],
    };
  },
  methods: {
    selectProduct(product) {
      if (product) {
        this.$emit('change', product);
      }
    },
    onSearchProducts(search, loading) {
      loading(true);
      this.searchProducts(search)
        .then((result) => {
          this.foundProducts = result;
          loading(false);
        })
        .catch((error) => {
          console.log(error);
          // loading(false);
        });
    },
    searchProducts: debounce(
      search => new Promise((resolve, reject) => {
        axios
          .get(`/api/internal/admin/products?searchText=${search}`)
          .then((response) => {
            resolve(response.data.data);
          })
          .catch((error) => {
            reject(error);
          })
          .finally(() => {
            resolve();
          });
      }),
      350,
    ),
  },
};
</script>
