import { Bar } from 'vue-chartjs';

export default {
  extends: Bar,
  props: ['data'],
  data() {
    return {
      labels: [
        'Январь',
        'Февраль',
        'Март',
        'Апрель',
        'Май',
        'Июнь',
        'Июль',
        'Август',
        'Сентябрь',
        'Октябрь',
        'Ноябрь',
        'Декабрь',
      ],
      backgroundColors: [
        '#357ca5',
        '#00a7d0',
        '#008d4c',
        '#db8b0b',
        '#30bbbb',
        '#555299',
        '#ca195a',
        '#d33724',
      ],
    };
  },
  watch: {
    data() {
      const datasets = [];

      _.forIn(_.groupBy(this.data, 'method'), (value, key) => {
        const group = _.map(_.groupBy(value, 'month'), (value, key) => ({
          month: key,
          queries: _.reduce(value, (total, item) => total + item.queryCount, 0),
        }));

        const data = _.map(this.labels, (item, index) => {
          const result = _.find(group, { month: (index + 1).toString() });

          if (result) {
            return result.queries;
          }

          return 0;
        });

        datasets.push({
          label: key,
          backgroundColor: this.backgroundColors[datasets.length],
          data,
        });
      });

      this.renderChart(
        {
          labels: this.labels,
          datasets,
        },
        {
          scales: {
            yAxes: [
              {
                stacked: true,
              },
            ],
            xAxes: [
              {
                stacked: true,
                categoryPercentage: 0.5,
                barPercentage: 1,
              },
            ],
          },
          legend: {
            display: true,
          },
          responsive: true,
          maintainAspectRatio: false,
        },
      );
    },
  },
};
