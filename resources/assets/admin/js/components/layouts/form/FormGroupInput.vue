<template>
  <div class="form-group">
    <label :for="id">
      {{ label }}
    </label>
    <input
      :id="id"
      :value="value"
      :type="type"
      class="form-control"
      @input="$emit('input', $event.target.value)"
    >
  </div>
</template>

<script>
export default {
  name: 'FormGroupInput',
  props: {
    id: {
      type: String,
    },
    type: {
      type: String,
      default: 'text',
    },
    label: {
      type: String,
    },
    value: {
      type: [Number, String],
    },
  },
  computed: {
    localValue: {
      get() {
        return this.value;
      },
      set(v) {
        this.$emit('input', v);
      },
    },
  },
};
</script>
