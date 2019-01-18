import _Quill from 'quill';
import VueEditor from './VueEditor';

const Quill = window.Quill || _Quill;

const Vue2Editor = {
  VueEditor,
  install(Vue) {
    Vue.component(VueEditor.name, VueEditor);
  },
};

if (typeof window !== 'undefined' && window.Vue) {
  window.Vue.use(Vue2Editor);
}

export default Vue2Editor;
export { VueEditor, Quill };
