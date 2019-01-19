@inject('request', 'Illuminate\Http\Request')
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <ul class="sidebar-menu">

            <li>
                <router-link :to="{ name: 'dashboard' }">
                    <i class="fa fa-wrench"></i>
                    <span class="title">Панель управления</span>
                </router-link>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-wpforms"></i>
                    <span>Веб-формы</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <router-link :to="{ name: 'forms.index' }">
                            <i class="fa fa-wpforms"></i>
                            <span>Веб-формы</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link :to="{ name: 'form-departments.index' }">
                            <i class="fa fa-wpforms"></i>
                            <span>Подразделения и типы</span>
                        </router-link>
                    </li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>Управление пользователями</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <router-link :to="{ name: 'roles.index' }">
                            <i class="fa fa-briefcase"></i>
                            <span>Роли</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link :to="{ name: 'users.index' }">
                            <i class="fa fa-user"></i>
                            <span>Пользователи</span>
                        </router-link>
                    </li>
                </ul>
            </li>
            <li>
                <router-link :to="{ name: 'menus.index' }">
                    <i class="fa fa-bars"></i>
                    <span class="title">Менеджер меню</span>
                </router-link>
            </li>
            <li>
                <router-link :to="{ name: 'file-manager' }">
                    <i class="fa fa-folder"></i>
                    <span class="title">Файловый менеджер</span>
                </router-link>
            </li>
            <li>
                <router-link :to="{ name: 'settings.index' }">
                    <i class="fa fa-book"></i>
                    <span class="title">Справочник</span>
                </router-link>
            </li>
            <li>
                <a href="{{ url('/admin/logout') }}">
                    <i class="fa fa-arrow-left"></i>
                    <span class="title">Выйти</span>
                </a>
            </li>
        </ul>
    </section>
</aside>
