<template>
  <div>
    <span
      v-if="value !== null && typeof value === 'object'"
      :class="{ 'label label-info' : labeled }"
    >
      {{ value[$root.relationships[field]] }}
    </span>
    <span
      v-else
      :class="{ 'label label-info' : labeled }"
    >
      {{ value }}
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
  computed: {
    labeled() {
      return _.includes(this.xprops.labeled, this.field);
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
