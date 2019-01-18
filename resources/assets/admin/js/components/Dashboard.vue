<template>
  <section
    class="content-wrapper"
    style="min-height: 960px"
  >
    <section class="content-header">
      <h1>Панель управления</h1>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Статистика продаж</h3>
              <div class="box-tools pull-right">
                <button
                  type="button"
                  class="btn btn-default btn-sm"
                  @click="fetchData"
                >
                  <i
                    :class="{'fa-spin': isLoading}"
                    class="fa fa-refresh"
                  />
                </button>
              </div>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-8">
                  <p class="text-center">
                    <strong>Период: 1 Январь, {{ (new Date()).getFullYear() }} - 31 Декабрь, {{ (new Date()).getFullYear() }}</strong>
                  </p>
                  <div class="chart">
                    <line-chart
                      :height="150"
                      :data="orders.chart"
                    />
                  </div>
                </div>
                <div class="col-md-4">
                  <p class="text-center">
                    <strong>Статус заказов за текущий месяц</strong>
                  </p>
                  <div class="progress-group">
                    <span class="progress-text">Всего заказов</span>
                    <span class="progress-number">
                      <b>{{ orders.monthsStat.total }}</b>/{{ ~~orders.avgMonthsStat.total || 1 }}
                    </span>
                    <div class="progress sm">
                      <div
                        class="progress-bar progress-bar-aqua"
                        :style="{ 'width': ( (orders.monthsStat.total * 100) / orders.avgMonthsStat.total) + '%' }"
                      />
                    </div>
                  </div>
                  <div class="progress-group">
                    <span class="progress-text">Обработанных заказов</span>
                    <span class="progress-number">
                      <b>{{ orders.monthsStat.successful }}</b>/{{ ~~orders.avgMonthsStat.successful || 1 }}
                    </span>
                    <div class="progress sm">
                      <div
                        class="progress-bar progress-bar-green"
                        :style="{ 'width': ( (orders.monthsStat.successful * 100) / orders.avgMonthsStat.successful) + '%' }"
                      />
                    </div>
                  </div>
                  <div class="progress-group">
                    <span class="progress-text">Отмененных заказов</span>
                    <span class="progress-number">
                      <b>{{ orders.monthsStat.canceled }}</b>/{{ ~~orders.avgMonthsStat.canceled || 1 }}
                    </span>
                    <div class="progress sm">
                      <div
                        class="progress-bar progress-bar-red"
                        :style="{ 'width': ( (orders.monthsStat.canceled * 100) / orders.avgMonthsStat.canceled) + '%' }"
                      />
                    </div>
                  </div>
                  <div class="progress-group">
                    <span class="progress-text">Заказов в интернет-магазин</span>
                    <span class="progress-number">
                      <b>{{ orders.monthsStat.online }}</b>/{{ ~~orders.avgMonthsStat.online || 1 }}
                    </span>
                    <div class="progress sm">
                      <div
                        class="progress-bar progress-bar-yellow"
                        :style="{ 'width': ( (orders.monthsStat.online * 100) / orders.avgMonthsStat.online) + '%' }"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <span
                      class="description-percentage"
                      :class="[ (orders.amount.day / orders.avgAmount.day) < 1 ? 'text-red' : 'text-green' ]"
                    >
                      <i :class="[ (orders.amount.day / orders.avgAmount.day) < 1 ? 'fa fa-caret-down' : 'fa fa-caret-up' ]" />
                      {{ ~~(Math.abs((orders.amount.day / orders.avgAmount.day) - 1)*100) }}%
                    </span>
                    <h5 class="description-header">{{ orders.amount.day | hundredth }}</h5>
                    <span class="description-text">Продажи за день</span>
                  </div>
                </div>
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <span
                      class="description-percentage"
                      :class="[ (orders.amount.week / orders.avgAmount.week) < 1 ? 'text-red' : 'text-green' ]"
                    >
                      <i :class="[ (orders.amount.week / orders.avgAmount.week) < 1 ? 'fa fa-caret-down' : 'fa fa-caret-up' ]" />
                      {{ ~~(Math.abs((orders.amount.week / orders.avgAmount.week) - 1)*100) }}%
                    </span>
                    <h5 class="description-header">{{ orders.amount.week | hundredth }}</h5>
                    <span class="description-text">Продажи за неделю</span>
                  </div>
                </div>
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <span
                      class="description-percentage"
                      :class="[ (orders.amount.month / orders.avgAmount.month) < 1 ? 'text-red' : 'text-green' ]"
                    >
                      <i :class="[ (orders.amount.month / orders.avgAmount.month) < 1 ? 'fa fa-caret-down' : 'fa fa-caret-up' ]" />
                      {{ ~~(Math.abs((orders.amount.month / orders.avgAmount.month) - 1)*100) }}%
                    </span>
                    <h5 class="description-header">{{ orders.amount.month | hundredth }}</h5>
                    <span class="description-text">Продажи за месяц</span>
                  </div>
                </div>
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block">
                    <span
                      class="description-percentage"
                      :class="[ (orders.amount.year / orders.avgAmount.year) < 1 ? 'text-red' : 'text-green' ]"
                    >
                      <i :class="[ (orders.amount.year / orders.avgAmount.year) < 1 ? 'fa fa-caret-down' : 'fa fa-caret-up' ]" />
                      {{ ~~(Math.abs((orders.amount.year / orders.avgAmount.year) - 1)*100) }}%
                    </span>
                    <h5 class="description-header">{{ orders.amount.year | hundredth }}</h5>
                    <span class="description-text">Продажи за год</span>
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
import LineChart from './LineChart';

export default {
  components: { LineChart },
  filters: {
    hundredth(item) {
      return Number(item).toFixed(2);
    },
  },
  data() {
    return {
      orders: {
        amount: {
          total: null,
          year: null,
          month: null,
          week: null,
          day: null,
        },
        avgAmount: {
          year: null,
          month: null,
          week: null,
          day: null,
        },
        monthsStat: {
          total: null,
          online: null,
          successful: null,
          canceled: null,
        },
        avgMonthsStat: {
          total: null,
          online: null,
          successful: null,
          canceled: null,
        },
        chart: {},
      },
      isLoading: true,
    };
  },
  created() {
    this.fetchData();
  },
  methods: {
    fetchData() {
      axios
        .get('/api/internal/admin/dashboard')
        .then(({ data }) => {
          this.orders = data;
        })
        .catch((error) => {
          const message = error.response.data.message || error.message;
          console.log(message);
        })
        .finally(() => {
          this.isLoading = false;
        });
    },
  },
};
</script>
