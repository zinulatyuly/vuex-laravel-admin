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

import RolesIndex from '../components/cruds/Roles/Index';
import RolesCreate from '../components/cruds/Roles/Create';
import RolesShow from '../components/cruds/Roles/Show';
import RolesEdit from '../components/cruds/Roles/Edit';

import FormsIndex from '../components/cruds/Forms/Index';
import FormsCreate from '../components/cruds/Forms/Create';
import FormsShow from '../components/cruds/Forms/Show';
import FormsEdit from '../components/cruds/Forms/Edit';

import FormDepartmentsIndex from '../components/cruds/FormDepartments/Index';
import FormDepartmentsCreate from '../components/cruds/FormDepartments/Create';
import FormDepartmentsShow from '../components/cruds/FormDepartments/Show';
import FormDepartmentsEdit from '../components/cruds/FormDepartments/Edit';


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
  
  { path: '/roles', component: RolesIndex, name: 'roles.index' },
  { path: '/roles/create', component: RolesCreate, name: 'roles.create' },
  { path: '/roles/:id', component: RolesShow, name: 'roles.show' },
  { path: '/roles/:id/edit', component: RolesEdit, name: 'roles.edit' },
  
  { path: '/forms', component: FormsIndex, name: 'forms.index' },
  { path: '/forms/create', component: FormsCreate, name: 'forms.create' },
  { path: '/forms/:id', component: FormsShow, name: 'forms.show' },
  { path: '/forms/:id/edit', component: FormsEdit, name: 'forms.edit' },
  
  { path: '/form-departments', component: FormDepartmentsIndex, name: 'form-departments.index' },
  { path: '/form-departments/create', component: FormDepartmentsCreate, name: 'form-departments.create' },
  { path: '/form-departments/:id', component: FormDepartmentsShow, name: 'form-departments.show' },
  { path: '/form-departments/:id/edit', component: FormDepartmentsEdit, name: 'form-departments.edit' },
  
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
