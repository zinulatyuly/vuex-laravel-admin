<template>
  <img
    :src="`/90x90/${image}`"
    style="max-width: 90px;"
  >
</template>


<script>
export default {
  props: ['value'],
  data() {
    return {
      // Code...
    };
  },
  computed: {
    image() {
      return this.value == null ? '/images/no-image.png' : this.value;
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
