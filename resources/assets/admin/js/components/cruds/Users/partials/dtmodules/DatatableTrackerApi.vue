<template>
  <span>
    {{ queryCountByMonth }} | {{ queryCountByYear }}
  </span>
</template>


<script>
export default {
  props: ['value', 'field', 'xprops'],
  data() {
    return {
      // Code...
    };
  },
  computed: {
    queryCountByYear() {
      return _.reduce(this.value, (total, item) => total + item.queryCount, 0);
    },
    queryCountByMonth() {
      return _.reduce(
        this.value,
        (total, item) => {
          if (item.month == new Date().getMonth() + 1) {
            return total + item.queryCount;
          }

          return total;
        },
        0,
      );
    },
  },
  created() {
    // Code...
  },
  methods: {
    // Code...
  },
};
</script>
