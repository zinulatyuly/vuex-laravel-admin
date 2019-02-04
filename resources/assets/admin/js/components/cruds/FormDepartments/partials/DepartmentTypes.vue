<template>
  <div>
    <div class="box-body">
      <div
        class="btn btn-success btn-sm"
        @click="addItem"
      ><i class="fa fa-plus" /> Добавить
      </div>
    </div>
    <div class="box-body">
      <table
        class="table"
        style="width:100%"
      >
        <thead>
          <tr>
            <th width="10%">#</th>
            <th width="90%">Тип</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(item, index) in items"
            :key="index"
          >
            <td class="position-number">{{ index + 1 }}.</td>
            <td class="position-number">
              <input
                :value="item.type"
                required
                type="text"
                class="form-control"
                @input="updateItem(index, 'type', $event.target.value)"
              >
            </td>
            <td>
              <button
                type="button"
                class="btn btn-danger"
                @click="deleteItem(index)"
              >
                <i class="fa fa-trash" />
              </button>
            </td>
          </tr>
        </tbody>

      </table>
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
  },
  methods: {
    addItem() {
      this.$emit('addItem');
    },
    deleteItem(index) {
      this.$emit('deleteItem', index);
    },
    updateItem(index, field, value) {
      this.$emit('updateItem', index, field, value);
    },
    onSearch(search, loading) {
      this.$emit('onSearch', search, loading);
    },
  },
};
</script>

<style scoped>
.position-number {
  display: table-cell;
  vertical-align: middle;
}
</style>
