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
              <h3 class="box-title">Список</h3>
            </div>

            <div class="box-body">
              <div class="btn-group">
                <router-link
                  :to="{ name: xprops.route + '.create' }"
                  class="btn btn-success btn-sm"
                >
                  <i class="fa fa-plus" /> Создать
                </router-link>
                <button
                  type="button"
                  class="btn btn-default btn-sm"
                  @click="fetchData"
                >
                  <i
                    :class="{'fa-spin': loading}"
                    class="fa fa-refresh"
                  /> Обновить
                </button>
              </div>
            </div>

            <div class="box-body">
              <div
                v-if="loading"
                class="row"
              >
                <div class="col-xs-4 col-xs-offset-4">
                  <div class="alert text-center">
                    <i class="fa fa-spin fa-refresh" /> Загрузка
                  </div>
                </div>
              </div>
              <datatable
                v-if="!loading"
                :columns="columns"
                :data="data"
                :total="total"
                :query="query"
                :xprops="xprops"
              />
            </div>
          </div>
        </div>
      </div>
    </section>
  </section>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import DatatableActions from '../../dtmodules/DatatableActions';

export default {
  data() {
    return {
      columns: (() => {
        const columns = [
          {
            title: '#',
            field: 'id',
            sortable: true,
            colStyle: 'width: 50px;',
          },
          { title: 'Название', field: 'displayName', sortable: true },
          { title: 'Ключ', field: 'key', sortable: true },
          { title: 'Значение', field: 'value', sortable: true },
          { title: 'Группа', field: 'group', sortable: true },
          { title: 'Тип', field: 'type', sortable: true },
          {
            title: 'Действия',
            tdComp: DatatableActions,
            visible: true,
            thClass: 'text-right',
            tdClass: 'text-right',
            colStyle: 'width: 130px;',
          },
        ];

        return columns.map((column) => {
          column.group = 'Колонки';

          return column;
        });
      })(),
      query: { sort: 'id', sortOrder: 'desc' },
      xprops: {
        module: 'SettingsIndex',
        route: 'settings',
      },
    };
  },
  created() {
    this.$root.relationships = this.relationships;
    this.fetchData();
  },
  destroyed() {
    this.resetState();
  },
  computed: {
    ...mapGetters('SettingsIndex', ['data', 'total', 'loading', 'relationships']),
  },
  watch: {
    query: {
      handler(query) {
        this.setQuery(query);
      },
      deep: true,
    },
  },
  methods: {
    ...mapActions('SettingsIndex', ['fetchData', 'setQuery', 'resetState']),
  },
};
</script>
