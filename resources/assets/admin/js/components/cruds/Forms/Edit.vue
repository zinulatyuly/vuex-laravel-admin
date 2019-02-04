<template>
  <section
    class="content-wrapper"
    style="min-height: 960px;"
  >
    <section class="content-header">
      <h1>Веб-формы</h1>
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
                    :value="item.name"
                    type="text"
                    class="form-control"
                    name="name"
                    @input="updateName"
                  >
                </div>

                <div class="form-group">
                  <label>Подразделение</label>
                  <select
                    v-model="dep"
                    class="form-control"
                  >
                    <option
                      v-for="(id, index) in departments"
                      :key="index"
                      :value="id.department"
                    >{{ id.department }}
                    </option>
                  </select>
                </div>

                <div
                  v-for="(id, index) in departments"
                  :key="index"
                >
                  <div
                    v-if="id.department === item.department"
                    class="form-group"
                  >
                    <label>Тип</label>
                    <select
                      v-model="type"
                      class="form-control"
                    >
                      <option
                        v-for="(type, index) in id.departmentTypes"
                        :key="index"
                        :value="type.type"
                      >{{ type.type }}
                      </option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label>Страницы</label>
                  <relation-select
                    :is-select="false"
                    :items="item.formSlugs"
                    label="slug"
                    @addItem="addFormSlug"
                    @deleteItem="deleteFormSlug"
                    @updateItem="updateFormSlug"
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
    return {};
  },
  computed: {
    ...mapGetters('FormsSingle', ['item', 'loading', 'departments']),
    dep: {
      get() {
        return this.item.department;
      },
      set(value) {
        this.setDepartment(value);
      },
    },
    type: {
      get() {
        return this.item.type;
      },
      set(value) {
        this.setType(value);
      },
    },
  },
  watch: {
    '$route.params.id': function () {
      this.resetState();
      this.fetchData(this.$route.params.id);
    },
  },
  created() {
    this.fetchData(this.$route.params.id);
    this.fetchDepartments();
  },
  destroyed() {
    this.resetState();
  },
  methods: {
    ...mapActions('FormsSingle', [
      'fetchData',
      'updateData',
      'resetState',
      'fetchDepartments',
      'setName',
      'setType',
      'setDepartment',
      'addFormSlug',
      'deleteFormSlug',
      'setFormSlug',
    ]),
    updateName(e) {
      this.setName(e.target.value);
    },
    updateType(e) {
      this.setType(e.target.value);
    },
    updateDepartment(e) {
      this.setDepartment(e.target.value);
    },
    updateFormSlug(index, slug) {
      this.setFormSlug({ index, slug });
    },
    submitForm() {
      this.updateData()
        .then(() => {
          this.$router.push({ name: 'forms.index' });
          this.$eventHub.$emit('update-success');
        })
        .catch((error) => {
          console.error(error);
        });
    },
  },
};
</script>
