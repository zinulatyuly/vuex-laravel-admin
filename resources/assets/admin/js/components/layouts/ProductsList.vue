<template>
  <table class="table table-bordered">
    <tbody v-if="products">
      <tr
        v-for="(p, i) in products"
        :key="i"
      >
        <td>
          <img
            v-if="p.image.file"
            :src="imagePath + p.image.file"
          >
        </td>
        <td>
          <p class="h4">
            {{ p.vendorCode }}
          </p>
          <p>{{ p.shortName }}</p>
          {{ p.id }}
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  props: {
    products: {
      type: Array,
      required: false,
    },
    imagePath: {
      type: String,
      required: false,
      default: 'https://ekfgroup.com/120x120/uploads/products/',
    },
  },
};
</script>

<style scoped>
.h4 {
  margin-top: 0;
}
</style>
