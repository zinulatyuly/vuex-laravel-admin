<template>
  <section
    class="content-wrapper"
    style="min-height: 960px;"
  >
    <section class="content-header">
      <h1>{{ title }}</h1>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <RouterView />
        </div>
      </div>
    </section>
  </section>
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
