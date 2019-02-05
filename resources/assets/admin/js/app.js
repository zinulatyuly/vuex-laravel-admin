import './bootstrap';
import Vue from 'vue';

import VueAWN from 'vue-awesome-notifications';
import vSelect from 'vue-select';
import VueSweetalert2 from 'vue-sweetalert2';
import ToggleButton from 'vue-js-toggle-button';
import Datatable from './components/Datatable';
import VueDatatable from './datatable';
import locale from './components/dtmodules/locale';
import store from './store';
import router from './routes';
import '../../vendor/talvbansal/media-manager/js/media-manager';

import BackButton from './components/BackButton';
import Alert from './components/Alert';
import EventHub from './components/EventHub';
import VueButtonSpinner from './components/VueButtonSpinner';
import RelationSelect from './components/RelationSelect';
import ManagerWindow from './components/ManagerWindow';
import ManagerModal from './components/ManagerModal';

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
Vue.use(VueSweetalert2);
Vue.use(ToggleButton);

Vue.component('datatable', Datatable);
Vue.component('back-buttton', BackButton);
Vue.component('bootstrap-alert', Alert);
Vue.component('event-hub', EventHub);
Vue.component('vue-button-spinner', VueButtonSpinner);
Vue.component('v-select', vSelect);
Vue.component('relation-select', RelationSelect);
Vue.component('manager-window', ManagerWindow);
Vue.component('manager-modal', ManagerModal);

moment.updateLocale(window.app_locale, {
  week: {
    dow: 1,
  },
});

const app = new Vue({
  router,
  store,
}).$mount('#app');
