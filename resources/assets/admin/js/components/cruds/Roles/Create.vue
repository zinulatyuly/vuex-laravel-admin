<template>
  <section
    class="content-wrapper"
    style="min-height: 960px;"
  >
    <section class="content-header">
      <h1>Роли</h1>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <form @submit.prevent="submitForm">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Создать</h3>
              </div>

              <div class="box-body">
                <back-buttton />
              </div>

              <bootstrap-alert />

              <div class="box-body">
                <div class="form-group">
                  <label for="name">Название</label>
                  <input
                    :value="item.name"
                    type="text"
                    class="form-control"
                    name="name"
                    @input="updateName"
                  >
                </div>
                <div class="form-group">
                  <label for="display_name">Отображаемое название</label>
                  <input
                    :value="item.displayName"
                    type="text"
                    class="form-control"
                    name="display_name"
                    @input="updateDisplayName"
                  >
                </div>
              </div>

              <div class="box-footer">
                <vue-button-spinner
                  :is-loading="loading"
                  :disabled="loading"
                  class="btn btn-primary btn-sm"
                >
                  Сохранить
                </vue-button-spinner>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>
  </section>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
  data() {
    return {
      // Code...
    };
  },
  computed: {
    ...mapGetters('RolesSingle', ['item', 'loading']),
  },
  created() {
    // Code ...
  },
  destroyed() {
    this.resetState();
  },
  methods: {
    ...mapActions('RolesSingle', ['storeData', 'resetState', 'setName', 'setDisplayName']),
    updateName(e) {
      this.setName(e.target.value);
    },
    updateDisplayName(e) {
      this.setDisplayName(e.target.value);
    },
    submitForm() {
      this.storeData()
        .then(() => {
          this.$router.push({ name: 'roles.index' });
          this.$eventHub.$emit('create-success');
        })
        .catch((error) => {
          console.error(error);
        });
    },
  },
};
</script>
