<template>
  <div>
    <span>{{ cutedText }}</span>
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
  computed: {
    cutedText() {
      if (!this.value) return this.value;
      if (this.value.length > 60) return `${this.value.substring(0, 70)}...`;
      return this.value;
    },
  },
  methods: {
    // Code...
  },
};
</script>
