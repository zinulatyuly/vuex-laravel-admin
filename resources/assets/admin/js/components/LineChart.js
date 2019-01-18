import { Line } from 'vue-chartjs';

export default {
  extends: Line,
  props: {
    data: {},
  },
  watch: {
    data() {
      const arr = [];

      for (const item in this.data) {
        arr.push(~~this.data[item]);
      }

      this.renderChart({
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
        datasets: [
          {
            label: 'Продажи',
            backgroundColor: '#247edf',
            data: arr,
          },
        ],
      });
    },
  },
};
