<template>
  <div>
    <span v-if="value !== null">
      {{ value['code'] }}
    </span>
  </div>
</template>


<script>
export default {
  props: ['value', 'field'],
};
</script>
