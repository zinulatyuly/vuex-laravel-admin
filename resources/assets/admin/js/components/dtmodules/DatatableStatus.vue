<template>
  <div>
    <span
      v-if="value"
      class="label label-success"
    >
      ДА
    </span>
    <span
      v-else
      class="label label-danger"
    >
      НЕТ
    </span>
  </div>
</template>


<script>
export default {
  props: ['value', 'field', 'xprops'],
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
