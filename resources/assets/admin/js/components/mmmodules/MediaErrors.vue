<template>
  <div
    v-if="errors.length > 0"
    class="modal-errors"
    transition="expand"
  >
    <ul>
      <li
        v-for="error in errors"
        :key="error"
        style="color: red"
      >{{ error }}</li>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    errors: {
      default() {
        return [];
      },
      type: Array,
    },
  },
};
</script>
