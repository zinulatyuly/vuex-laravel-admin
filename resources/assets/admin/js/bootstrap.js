import _ from 'lodash';
import axios from 'axios';

window._ = _;
window.purify = o => JSON.parse(JSON.stringify(o));
window.mm = null;

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
  console.error('CSRF token not found.');
}

window.axios.interceptors.request.use(
  (config) => {
    const token = document.head.querySelector('meta[name="csrf-token"]');
    if (token) {
      config.headers.common['X-Requested-With'] = 'XMLHttpRequest';
      config.headers.common['X-CSRF-TOKEN'] = token.content;
    }
    return config;
  },
  error => Promise.reject(error),
);

const date_format = document.head.querySelector('meta[name="dp-date"]');
const time_format = document.head.querySelector('meta[name="dp-time"]');
const datetime_format = document.head.querySelector('meta[name="dp-datetime"]');
const app_locale = document.head.querySelector('meta[name="app-locale"]');

if (date_format && time_format && datetime_format) {
  window.date_format_moment = date_format.content;
  window.time_format_moment = time_format.content;
  window.datetime_format_moment = datetime_format.content;
  window.app_locale = app_locale.content;
} else {
  console.error('Moment.js date and time formats not found');
}
