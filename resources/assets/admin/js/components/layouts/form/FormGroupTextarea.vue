<template>
  <div class="form-group">
    <label :for="id">
      {{ label }}
    </label>
    <textarea
      :id="id"
      :value="value"
      class="form-control"
      @input="$emit('input', $event.target.value)"
    />
  </div>
</template>

<script>
export default {
  name: 'FormGroupTextarea',
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
