<template>
  <div
    v-if="message"
    class="row row-alert"
  >
    <div class="col-xs-6">
      <div
        :class="'alert-' + color"
        class="alert"
      >
        <h4>
          <i
            v-if="color == 'success'"
            class="icon fa fa-check"
          />
          <i
            v-if="color == 'danger'"
            class="icon fa fa-ban"
          /> {{ message }}
        </h4>
        <ul v-if="errors">
          <li
            v-for="(value, key) in errors"
            :key="key"
          >
            {{ value[0] }}
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
  name: 'BootstrapAlert',
  data() {
    return {
      // Code...
    };
  },
  computed: {
    ...mapGetters('Alert', ['message', 'errors', 'color']),
  },
  watch: {
    '$route.params.id': function () {
      this.resetState();
    },
  },
  created() {
    // Code...
  },
  destroyed() {
    this.resetState();
  },
  methods: {
    ...mapActions('Alert', ['resetState']),
  },
};
</script>

<style scoped>
.row-alert {
  padding: 10px;
}
</style>
