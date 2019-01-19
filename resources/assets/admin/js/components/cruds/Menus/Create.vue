<template>
  <section
    class="content-wrapper"
    style="min-height: 960px;"
  >
    <section class="content-header">
      <h1>Меню</h1>
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
                  <label>Порядок</label>
                  <input
                    type="number"
                    class="form-control"
                    @input="updateSortOrder"
                  >
                </div>
                <div class="form-group">
                  <label>Название</label>
                  <input
                    type="text"
                    class="form-control"
                    @input="updateName"
                  >
                </div>
                <div class="form-group">
                  <label>Статус (опубликовано)</label>
                  <div>
                    <toggle-button
                      v-model="status"
                      :sync="true"
                      :labels="{checked: 'Да', unchecked: 'Нет'}"
                    />
                  </div>
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
    return {};
  },
  computed: {
    ...mapGetters('MenusSingle', ['item', 'loading']),
    status: {
      get() {
        return this.item.status;
      },
      set(value) {
        this.setStatus(value);
      },
    },
  },
  destroyed() {
    this.resetState();
  },
  methods: {
    ...mapActions('MenusSingle', [
      'fetchData',
      'storeData',
      'resetState',
      'setSortOrder',
      'setStatus',
      'setName',
    ]),
    updateName(e) {
      this.setName(e.target.value);
    },
    updateSortOrder(e) {
      this.setSortOrder(e.target.value);
    },
    submitForm() {
      this.storeData()
        .then(() => {
          this.$router.push({ name: 'menus.index' });
          this.$eventHub.$emit('create-success');
        })
        .catch((error) => {
          console.error(error);
        });
    },
  },
};
</script>
