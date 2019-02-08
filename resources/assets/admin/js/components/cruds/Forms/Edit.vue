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
                <h3 class="box-title">Создать</h3>
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
                  <label for="department">
                    Подразделение
                  </label>
                  <select
                          id="department"
                          class="form-control"
                          :value="item.departmentId"
                          @input="updateDepartmentId"
                  >
                    <option
                            v-for="(department, index) in departments"
                            :key="index"
                            :value="department.id"
                    >{{ department.department }}
                    </option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="type">Тип</label>
                  <select
                          id="type"
                          class="form-control"
                          v-model="selectedType"
                  >
                    <option
                            v-for="(type, index) in types"
                            :key="index"
                            :value="type.id"
                    >{{ type.type }}
                    </option>
                  </select>
                </div>

                <div class="form-group">
                  <label>Страницы</label>
                  <relation-select
                          :is-select="false"
                          :items="item.slugs"
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
      types: function () {
        let buff = this.departments.find(item => item.id === this.item.departmentId);
        if (buff && buff.departmentTypes) return buff.departmentTypes; else return [];
      },
      selectedType: {
        get() {
          return this.item.typeId;
        },
        set(value) {
          this.setTypeId(Number(value))
        }
      }
    },
    watch: {
      '$route.params.id': function () {
        this.resetState();
        this.fetchData(this.$route.params.id);
      }
    },
    destroyed() {
      this.resetState();
    },
    created() {
      this.fetchDepartments();
      this.fetchData(this.$route.params.id);
    },
    methods: {
      ...mapActions('FormsSingle', [
        'fetchData',
        'updateData',
        'resetState',
        'fetchDepartments',
        'setName',
        'setTypeId',
        'setDepartmentId',
        'addFormSlug',
        'deleteFormSlug',
        'updateFormSlug',
        'setFormSlug',
      ]),
      updateName(e) {
        this.setName(e.target.value);
      },
      updateDepartmentId(e) {
        this.setDepartmentId(Number(e.target.value));
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
