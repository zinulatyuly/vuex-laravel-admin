<template>
  <table class="table">
    <thead>
      <tr>
        <th colspan="2">
          Название
        </th>
      </tr>
    </thead>
    <tbody v-if="products">
      <tr
        v-for="(p, index) in products"
        :key="index"
      >
        <td>{{ p.shortName }}</td>
        <td>
          <button
            type="button"
            class="btn btn-danger"
            @click="$emit('remove-item', index)"
          >
            <i class="fa fa-trash" /> Удалить
          </button>
        </td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td>
          <div class="form-group">
            <VSelect
              :value="selectedProduct"
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
        </td>
        <td>
          <button
            type="button"
            class="btn btn-success"
            @click="$emit('add-item', selectedProduct)"
          >
            <i class="fa fa-plus" /> Добавить
          </button>
        </td>
      </tr>
    </tfoot>
  </table>
</template>

<script>
import debounce from 'debounce-promise';

export default {
  props: {
    products: {
      type: Array,
    },
  },
  data() {
    return {
      foundProducts: [],
      selectedProduct: null,
    };
  },
  methods: {
    selectProduct(product) {
      this.selectedProduct = product;
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
