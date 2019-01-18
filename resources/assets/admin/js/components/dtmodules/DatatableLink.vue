<template>
  <a
    v-if="value !== null"
    :href="value"
  ><i class="fa fa-2x fa-link" /></a>
</template>


<script>
export default {
  props: ['value'],
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
