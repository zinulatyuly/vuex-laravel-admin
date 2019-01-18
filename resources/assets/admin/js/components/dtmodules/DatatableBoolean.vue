<template>
  <div>
    <span v-if="value">
      Включено
    </span>
    <span v-else>
      Отключено
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
