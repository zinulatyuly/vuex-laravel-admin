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
                  <table
                    class="table table-bordered table-striped"
                    style="table-layout: fixed;"
                  >
                    <tbody>
                      <tr>
                        <th>#</th>
                        <td>{{ item.id }}</td>
                      </tr>
                      <tr>
                        <th>Имя</th>
                        <td>{{ item.name }}</td>
                      </tr>
                      <tr>
                        <th>Электронная почта</th>
                        <td>{{ item.email }}</td>
                      </tr>
                      <tr>
                        <th>Роль</th>
                        <td>
                          <span
                            v-if="item.role !== null"
                            class="label label-info"
                          >
                            {{ item.role.displayName }}
                          </span>
                        </td>
                      </tr>
                      <tr>
                        <th>Партнер</th>
                        <td>
                          <span v-if="item.partner !== null">
                            {{ item.partner.shortName }}
                          </span>
                        </td>
                      </tr>
                      <tr>
                        <th>Код партнера</th>
                        <td>
                          <span v-if="item.partner !== null">
                            {{ item.partner.code }}
                          </span>
                        </td>
                      </tr>
                      <tr>
                        <th>
                          <router-link
                            :to="{ name: 'tokens.index', params: { id: $route.params.id } }"
                            class="btn btn-default"
                          >
                            OAuth авторизация
                          </router-link>
                        </th>
                        <td>&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                  <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      <li class="active">
                        <a
                          href="#tab_1"
                          data-toggle="tab"
                          aria-expanded="true"
                        >Запросы к API</a>
                      </li>
                    </ul>
                    <div class="tab-content">
                      <div
                        id="tab_1"
                        class="tab-pane active"
                      >
                        <tracker-api-chart
                          :data="item.api"
                          :height="250"
                        />
                      </div>
                    </div>
                  </div>
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
import TrackerApiChart from './partials/TrackerApiChart';

export default {
  components: {
    TrackerApiChart,
  },
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
    ...mapGetters('UsersSingle', ['item']),
  },
  watch: {
    '$route.params.id': function () {
      this.resetState();
      this.fetchData(this.$route.params.id);
    },
  },
  methods: {
    ...mapActions('UsersSingle', ['fetchData', 'resetState']),
  },
};
</script>
