<template>
  <section
    class="content-wrapper"
    style="min-height: 960px;"
  >
    <section class="content-header">
      <h1>Пользователи</h1>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <form @submit.prevent="submitForm">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Изменить</h3>
              </div>

              <div class="box-body">
                <back-buttton />
              </div>

              <bootstrap-alert />

              <div class="box-body">
                <div class="form-group">
                  <label for="name">Имя</label>
                  <input
                    :value="item.name"
                    type="text"
                    class="form-control"
                    name="name"
                    @input="updateName"
                  >
                </div>
                <div class="form-group">
                  <label for="email">Электронная почта</label>
                  <input
                    :value="item.email"
                    type="email"
                    class="form-control"
                    name="email"
                    @input="updateEmail"
                  >
                </div>
                <div class="form-group">
                  <label for="password">Пароль</label>
                  <input
                    :value="item.password"
                    type="password"
                    class="form-control"
                    name="password"
                    @input="updatePassword"
                  >
                </div>
                <div class="form-group">
                  <label for="role">Роль</label>
                  <v-select
                    :value="item.role"
                    :options="rolesAll"
                    name="role"
                    label="displayName"
                    @input="updateRole"
                  />
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
    ...mapGetters('UsersSingle', ['item', 'loading', 'rolesAll']),
  },
  watch: {
    '$route.params.id': function () {
      this.resetState();
      this.fetchData(this.$route.params.id);
    },
  },
  created() {
    this.fetchData(this.$route.params.id);
  },
  destroyed() {
    this.resetState();
  },
  methods: {
    ...mapActions('UsersSingle', [
      'fetchData',
      'updateData',
      'resetState',
      'setName',
      'setEmail',
      'setPassword',
      'setRole',
      'fetchRolesAll'
    ]),
    updateName(e) {
      this.setName(e.target.value);
    },
    updateEmail(e) {
      this.setEmail(e.target.value);
    },
    updatePassword(e) {
      this.setPassword(e.target.value);
    },
    updateRole(value) {
      this.setRole(value);
    },
    submitForm() {
      this.updateData()
        .then(() => {
          this.$router.push({ name: 'users.index' });
          this.$eventHub.$emit('update-success');
        })
        .catch((error) => {
          console.error(error);
        });
    },
  },
};
</script>
