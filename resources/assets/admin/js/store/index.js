import Vue from 'vue';
import Vuex from 'vuex';

import UsersIndex from './modules/Users';
import UsersSingle from './modules/Users/single';

import SettingsIndex from './modules/Settings';
import SettingsSingle from './modules/Settings/single';
import MenusIndex from './modules/Menus';
import MenusSingle from './modules/Menus/single';
import RolesIndex from './modules/Roles';
import RolesSingle from './modules/Roles/single';
import FormsIndex from './modules/Forms';
import FormsSingle from './modules/Forms/single';
import FormDepartmentsIndex from './modules/FormDepartments';
import FormDepartmentsSingle from './modules/FormDepartments/single';

import Alert from './modules/alert';
import ChangePassword from './modules/change_password';

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
  modules: {
    Alert,
    ChangePassword,
    UsersIndex,
    UsersSingle,
    SettingsIndex,
    SettingsSingle,
    MenusIndex,
    MenusSingle,
    RolesIndex,
    RolesSingle,
    FormsIndex,
    FormsSingle,
    FormDepartmentsIndex,
    FormDepartmentsSingle,
  },
  strict: debug,
});
