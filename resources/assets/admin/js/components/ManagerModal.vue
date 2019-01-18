<template>
  <transition
    v-if="value"
    name="modal"
    @media-modal-close="$emit('input', false)"
  >
    <div
      class="modal modal-mask"
      @click="$emit('input', false)"
    >
      <div class="modal-wrapper">
        <div
          :class="[size]"
          class="modal-dialog"
          @click.stop
        >
          <div class="modal-content">
            <media-manager
              :first-folder="firstFolder"
              :is-modal="true"
              @media-modal-close="$emit('input', false)"
              @selected-file="$emit('selected-file', $event)"
            />
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
import MediaManager from './mmmodules/MediaManager';

export default {
  components: {
    MediaManager,
  },
  props: {
    size: {
      default: 'modal-lg',
      type: String,
    },
    value: {
      type: Boolean,
      default: false,
    },
    firstFolder: {
      type: String,
      default: '',
    },
  },
  data() {
    return {};
  },
  watch: {
    show() {
      this.$emit('show', !this.show);
    },
  },
  mounted() {
    document.addEventListener('keydown', (e) => {
      if (this.show && e.keyCode == 27) {
        this.close();
      }
    });
  },
};
</script>

<style>
/*.modal-dialog {
  overflow-y: auto;
  overflow-x: hidden;
}*/

.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
  max-width: 1000px;
}

.modal-container {
  width: auto;
  margin: 3em;
  padding: 1.5em;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;
}

.modal-lg {
  margin: 5em !important;
  width: auto !important;
}

.modal-header h4 {
  margin-top: 0;
}

.modal-body {
  margin: 20px 0;
  max-height: calc(100vh - 265px);
}

.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}
</style>
