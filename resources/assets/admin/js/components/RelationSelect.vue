<template>
  <div>
    <div class="box-body">
      <div
        class="btn btn-success btn-sm"
        @click="addItem"
      ><i class="fa fa-plus" /> Добавить</div>
    </div>
    <div class="box-body">
      <ul
        v-for="(item, index) in items"
        :key="index"
        class="list-unstyled"
      >
        <li>
          <ul class="list-inline group-cells">
            <li
              class="btn-cell"
              style="width: 30px;"
            >{{ index + 1 }}.</li>
            <li class="input-cell">
              <v-select
                v-if="isSelect"
                :value="item"
                :label="label"
                :filterable="false"
                :options="options"
                @input="updateItem(index, $event)"
                @search="onSearch"
              >
                <template slot="no-options">
                  {{ placeholder }}
                </template>
                <template
                  slot="option"
                  slot-scope="option"
                >
                  <div>
                    {{ option[field] }}
                  </div>
                </template>
                <template
                  slot="selected-option"
                  slot-scope="option"
                >
                  <div class="selected">
                    {{ option[field] }}
                  </div>
                </template>
              </v-select>
              <input
                v-else
                :value="item[label]"
                type="text"
                class="form-control"
                name="name"
                @input="updateItem(index, $event.target.value)"
              >
            </li>
            <li class="btn-cell">
              <div class="btn-group btn-group-xs">
                <button
                  type="button"
                  class="btn btn-danger"
                  @click="deleteItem(index)"
                >
                  <i class="fa fa-trash" />
                </button>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    items: {
      type: Array,
      default() {
        return [];
      },
    },
    options: {
      type: Array,
      default() {
        return [];
      },
    },
    field: {
      type: String,
      default: '',
    },
    placeholder: {
      type: String,
      default: '',
    },
    isSelect: {
      type: Boolean,
      default: false,
    },
    label: {
      type: String,
      default: 'value',
    },
  },
  methods: {
    addItem() {
      this.$emit('addItem');
    },
    deleteItem(index) {
      this.$emit('deleteItem', index);
    },
    updateItem(index, value) {
      this.$emit('updateItem', index, value);
    },
    onSearch(search, loading) {
      this.$emit('onSearch', search, loading);
    },
  },
};
</script>

<style scoped>
.group-cells {
  display: table;
  margin-bottom: 15px;
}
.input-cell {
  display: table-cell;
}
.btn-cell {
  display: table-cell;
  width: 1%;
  vertical-align: middle;
}
</style>
