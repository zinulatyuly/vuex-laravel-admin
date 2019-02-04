<template>
  <section
    class="content-wrapper"
    style="min-height: 960px;"
  >
    <section class="content-header">
      <h1>Подразделения и типы</h1>
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
                  <label>Подразделение</label>
                  <input
                    type="text"
                    class="form-control"
                    name="department"
                    @input="updateDepartment"
                  >
                </div>
                <div class="form-group">
                  <label>Типы</label>
                  <types
                    :items="item.departmentTypes"
                    @addItem="addDepartmentType"
                    @deleteItem="deleteDepartmentType"
                    @updateItem="updateDepartmentType"
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
import Types from './partials/DepartmentTypes';

export default {
  components: {
    Types,
  },
  data() {
    return {};
  },
  computed: {
    ...mapGetters('FormDepartmentsSingle', ['item', 'loading']),
  },
  destroyed() {
    this.resetState();
  },
  methods: {
    ...mapActions('FormDepartmentsSingle', [
      'storeData',
      'resetState',
      'setDepartment',
      'addDepartmentType',
      'deleteDepartmentType',
      'setDepartmentType',
    ]),
    updateDepartment(e) {
      this.setDepartment(e.target.value);
    },
    updateDepartmentType(index, field, value) {
      this.setDepartmentType({ index, field, value });
    },
    submitForm() {
      this.storeData()
        .then(() => {
          this.$router.push({ name: 'form-departments.index' });
          this.$eventHub.$emit('create-success');
        })
        .catch((error) => {
          console.error(error);
        });
    },
  },
};
</script>
