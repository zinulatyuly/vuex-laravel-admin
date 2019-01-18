<template>
  <div>
    <span
      v-for="item in value"
      v-if="typeof item === 'object'"
      :key="item"
      :class="{ 'label label-info' : labeled }"
    >
      {{ item[$root.relationships[field]] }}
    </span>
    <span
      v-else
      :class="{ 'label label-info' : labeled }"
    >
      {{ item }}
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
