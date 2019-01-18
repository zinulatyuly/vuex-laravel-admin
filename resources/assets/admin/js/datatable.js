import VueDatatable from 'vue2-datatable-component/src/index';

VueDatatable.install = (Vue, options) => {
  const locale = options ? options.locale : {};

  // this might be the simplest i18n solution
  Vue.prototype.$i18nForDatatable = srcTxt => locale[srcTxt] || srcTxt;

  Vue.component('vue-datatable', VueDatatable);
};

if (typeof window !== 'undefined' && window.Vue) {
  window.Vue.use(VueDatatable);
}

export default VueDatatable;
