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
                        <th>Название</th>
                        <td>{{ item.displayName }}</td>
                      </tr>
                      <tr>
                        <th>Ключ</th>
                        <td>{{ item.key }}</td>
                      </tr>
                      <tr>
                        <th>Значение</th>
                        <td>{{ item.value }}</td>
                      </tr>
                      <tr>
                        <th>Группа</th>
                        <td>{{ item.group }}</td>
                      </tr>
                      <tr>
                        <th>Тип</th>
                        <td>{{ item.type }}</td>
                      </tr>
                      <tr>
                        <th>Порядок</th>
                        <td>{{ item.order }}</td>
                      </tr>
                      <tr>
                        <th>Примечания</th>
                        <td>{{ item.details }}</td>
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
    ...mapGetters('SettingsSingle', ['item']),
  },
  watch: {
    '$route.params.id': function () {
      this.resetState();
      this.fetchData(this.$route.params.id);
    },
  },
  methods: {
    ...mapActions('SettingsSingle', ['fetchData', 'resetState']),
  },
};
</script>
