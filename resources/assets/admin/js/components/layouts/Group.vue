<template>
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
        {{ title }}
      </h3>
    </div>

    <BootstrapAlert />

    <RouterView />
  </div>
</template>

<script>
export default {
  props: {
    title: {
      type: String,
    },
  },
};
</script>
