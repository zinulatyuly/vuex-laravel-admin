import Vue from 'vue';
import Vuex from 'vuex';

import UsersIndex from './modules/Users';
import UsersSingle from './modules/Users/single';

import SettingsIndex from './modules/Settings';
import SettingsSingle from './modules/Settings/single';

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
  },
  strict: debug,
});
