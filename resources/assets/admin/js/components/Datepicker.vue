<template>
  <div class="input-group date">
    <div class="input-group-addon">
      <i class="fa fa-calendar" />
    </div>
    <input
      :value="value"
      type="text"
      class="form-control pull-right datepicker"
    >
  </div>
</template>

<script>
export default {
  props: ['value'],
  mounted() {
    $('.datepicker')
      .datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        language: 'ru',
      })
      .on('changeDate', (e) => {
        this.$emit('input', e.format());
      });
  },
};
</script>
