<template>
  <section
    class="content-wrapper"
    style="min-height: 960px;"
  >
    <section class="content-header">
      <h1>Справочник</h1>
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
                  <label>Название</label>
                  <input
                    :value="item.displayName"
                    type="text"
                    class="form-control"
                    @input="updateDisplayName"
                  >
                </div>
                <div class="form-group">
                  <label>Ключ</label>
                  <input
                    :value="item.key"
                    type="text"
                    class="form-control"
                    @input="updateKey"
                  >
                </div>
                <div class="form-group">
                  <label>Значение</label>
                  <input
                    :value="item.value"
                    type="text"
                    class="form-control"
                    @input="updateValue"
                  >
                </div>
                <div class="form-group">
                  <label>Группа</label>
                  <input
                    :value="item.group"
                    type="text"
                    class="form-control"
                    @input="updateGroup"
                  >
                </div>
                <div class="form-group">
                  <label>Тип</label>
                  <input
                    :value="item.type"
                    type="text"
                    class="form-control"
                    @input="updateType"
                  >
                </div>
                <div class="form-group">
                  <label>Порядок</label>
                  <input
                    :value="item.sortOrder"
                    type="number"
                    class="form-control"
                    @input="updateOrder"
                  >
                </div>
                <div class="form-group">
                  <label>Примечания</label>
                  <textarea
                    rows="10"
                    class="form-control"
                    @input="updateDetails"
                  >{{ item.details }}</textarea>
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
  computed: {
    ...mapGetters('SettingsSingle', ['item', 'loading']),
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
    ...mapActions('SettingsSingle', [
      'fetchData',
      'updateData',
      'resetState',
      'setDisplayName',
      'setKey',
      'setValue',
      'setGroup',
      'setType',
      'setOrder',
      'setDetails',
    ]),
    updateDisplayName(e) {
      this.setDisplayName(e.target.value);
    },
    updateKey(e) {
      this.setKey(e.target.value);
    },
    updateValue(e) {
      this.setValue(e.target.value);
    },
    updateGroup(e) {
      this.setGroup(e.target.value);
    },
    updateType(e) {
      this.setType(e.target.value);
    },
    updateOrder(e) {
      this.setOrder(e.target.value);
    },
    updateDetails(e) {
      this.setDetails(e.target.value);
    },
    submitForm() {
      this.updateData()
        .then(() => {
          this.$router.push({ name: 'settings.index' });
          this.$eventHub.$emit('create-success');
        })
        .catch((error) => {
          console.error(error);
        });
    },
  },
};
</script>
