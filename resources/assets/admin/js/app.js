import './bootstrap';
import Vue from 'vue';

import VueAWN from 'vue-awesome-notifications';
import vSelect from 'vue-select';
import datePicker from 'vue-bootstrap-datetimepicker';
import VueSweetalert2 from 'vue-sweetalert2';
import ToggleButton from 'vue-js-toggle-button';
import Multiselect from 'vue-multiselect';
import Datatable from './components/Datatable';
import VueDatatable from './datatable';
import locale from './components/dtmodules/locale';
import store from './store';
import router from './routes';
import 'eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css';
import '../../vendor/talvbansal/media-manager/js/media-manager';

import BackButton from './components/BackButton';
import Alert from './components/Alert';
import EventHub from './components/EventHub';
import VueButtonSpinner from './components/VueButtonSpinner';
import RelationSelect from './components/RelationSelect';
import ManagerWindow from './components/ManagerWindow';
import ManagerModal from './components/ManagerModal';
import FileSelect from './components/FileSelect';
import Datepicker from './components/Datepicker';

import ProductManager from './components/layouts/ProductManager';
import ProductsList from './components/layouts/ProductsList';
import ProductsManager from './components/layouts/ProductsManager';
import FormGroupInput from './components/layouts/form/FormGroupInput';
import FormGroupTextarea from './components/layouts/form/FormGroupTextarea';

Vue.prototype.$eventHub = new Vue();

Vue.use(VueDatatable, { locale });
Vue.use(VueAWN, {
  labels: {
    tip: '',
    info: '',
    success: '',
    warning: '',
    alert: '',
    async: '',
    confirm: '',
  },
  position: 'top-right',
});
Vue.use(datePicker);
Vue.use(VueSweetalert2);
Vue.use(ToggleButton);

Vue.component('datatable', Datatable);
Vue.component('back-buttton', BackButton);
Vue.component('bootstrap-alert', Alert);
Vue.component('event-hub', EventHub);
Vue.component('vue-button-spinner', VueButtonSpinner);
Vue.component('v-select', vSelect);
Vue.component('file-select', FileSelect);
Vue.component('datepicker', Datepicker);
Vue.component('relation-select', RelationSelect);
Vue.component('manager-window', ManagerWindow);
Vue.component('manager-modal', ManagerModal);
Vue.component('multiselect', Multiselect);

Vue.component('product-manager', ProductManager);
Vue.component('products-manager', ProductsManager);
Vue.component('products-list', ProductsList);
Vue.component('form-group-input', FormGroupInput);
Vue.component('form-group-textarea', FormGroupTextarea);

moment.updateLocale(window.app_locale, {
  week: {
    dow: 1,
  },
});

const app = new Vue({
  data: {
    relationships: {},
    dpconfigDate: {
      format: window.date_format_moment,
    },
    dpconfigTime: {
      format: window.time_format_moment,
    },
    dpconfigDatetime: {
      format: window.datetime_format_moment,
      sideBySide: true,
    },
  },
  router,
  store,
}).$mount('#app');
