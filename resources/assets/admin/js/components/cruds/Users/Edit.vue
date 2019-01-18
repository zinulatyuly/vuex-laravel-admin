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
                <div class="form-group">
                  <label for="partner">Партнер</label>
                  <v-select
                    :value="item.partner"
                    :filterable="false"
                    :options="partnersAll"
                    name="partner"
                    label="shortName"
                    @input="updatePartner"
                    @search="onSearchPartners"
                  >
                    <template slot="no-options">
                      Введите код партнера...
                    </template>
                    <template
                      slot="option"
                      slot-scope="option"
                    >
                      <div>
                        {{ option.shortName }}
                      </div>
                    </template>
                    <template
                      slot="selected-option"
                      slot-scope="option"
                    >
                      <div class="selected">
                        {{ option.shortName }}
                      </div>
                    </template>
                  </v-select>
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
    ...mapGetters('UsersSingle', ['item', 'loading', 'rolesAll', 'partnersAll']),
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
      'fetchRolesAll',
      'setPartner',
      'fetchPartnersAll',
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
    updatePartner(value) {
      this.setPartner(value);
    },
    onSearchPartners(search, loading) {
      loading(true);
      this.fetchPartnersAll(search).then(() => {
        loading(false);
      });
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
