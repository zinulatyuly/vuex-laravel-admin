import Vue from 'vue';
import VueRouter from 'vue-router';

import Dashboard from '../components/Dashboard';
import ManagerWindow from '../components/ManagerWindow';
import ChangePassword from '../components/ChangePassword';

import SettingsIndex from '../components/cruds/Settings/Index';
import SettingsCreate from '../components/cruds/Settings/Create';
import SettingsShow from '../components/cruds/Settings/Show';
import SettingsEdit from '../components/cruds/Settings/Edit';

import MenusIndex from '../components/cruds/Menus/Index';
import MenusCreate from '../components/cruds/Menus/Create';
import MenusConstruct from '../components/cruds/Menus/Construct';
import MenusEdit from '../components/cruds/Menus/Edit';

import UsersIndex from '../components/cruds/Users/Index';
import UsersCreate from '../components/cruds/Users/Create';
import UsersShow from '../components/cruds/Users/Show';
import UsersEdit from '../components/cruds/Users/Edit';

Vue.use(VueRouter);

const routes = [
  {
    path: '/dashboard',
    component: Dashboard,
    name: 'dashboard',
  },
  {
    path: '/file-manager',
    component: ManagerWindow,
    name: 'file-manager',
  },
  {
    path: '/change-password',
    component: ChangePassword,
    name: 'auth.change_password',
  },
  { path: '/users', component: UsersIndex, name: 'users.index' },
  { path: '/users/create', component: UsersCreate, name: 'users.create' },
  { path: '/users/:id', component: UsersShow, name: 'users.show' },
  { path: '/users/:id/edit', component: UsersEdit, name: 'users.edit' },
  
  { path: '/settings', component: SettingsIndex, name: 'settings.index' },
  { path: '/settings/create', component: SettingsCreate, name: 'settings.create' },
  { path: '/settings/:id', component: SettingsShow, name: 'settings.show' },
  { path: '/settings/:id/edit', component: SettingsEdit, name: 'settings.edit' },

  { path: '/menus', component: MenusIndex, name: 'menus.index' },
  { path: '/menus/create', component: MenusCreate, name: 'menus.create' },
  { path: '/menus/:id', component: MenusConstruct, name: 'menus.construct' },
  { path: '/menus/:id/edit', component: MenusEdit, name: 'menus.edit' },

];

export default new VueRouter({
  mode: 'history',
  base: '/admin',
  routes: routes,
});
