<template>
  <section
    class="content-wrapper"
    style="min-height: 960px"
  >
    <section class="content-header">
      <h1>Файловый менеджер</h1>
    </section>
    <section class="content">
      <div class="box">
        <media-manager />
      </div>
    </section>
  </section>
</template>

<script>
import MediaManager from './mmmodules/MediaManager';

export default {
  components: {
    MediaManager,
  },
};
</script>

<style>
</style>
