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
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Просмотр</h3>
            </div>

            <div class="box-body">
              <back-buttton />
            </div>

            <div class="box-body">
              <div class="row">
                <div class="col-xs-12">
                  <table class="table table-bordered table-striped">
                    <tbody>
                      <tr>
                        <th>#</th>
                        <td>{{ item.id }}</td>
                      </tr>
                      <tr>
                        <th>Подразделение</th>
                        <td>{{ item.department }}</td>
                      </tr>
                    </tbody>
                  </table>
                  <table class="table table-bordered table-striped">
                    <thead>
                      <th
                        colspan="3"
                        height="50px"
                        style="text-align: center"
                      >Типы</th>
                    </thead>
                    <tbody>
                      <tr
                        v-for="(type, index) in item.departmentTypes"
                        :key="index"
                      >
                        <td>{{ type.type }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
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
  created() {
    this.fetchData(this.$route.params.id);
  },
  destroyed() {
    this.resetState();
  },
  computed: {
    ...mapGetters('FormDepartmentsSingle', ['item']),
  },
  watch: {
    '$route.params.id': function () {
      this.resetState();
      this.fetchData(this.$route.params.id);
    },
  },
  methods: {
    ...mapActions('FormDepartmentsSingle', ['fetchData', 'resetState']),
  },
};
</script>
