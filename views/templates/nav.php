<?php
$current_page = $_SERVER['REQUEST_URI'];
?>

<!-- Sidebar Scroll Container -->
<div id="sidebar-scroll">
    <!-- Sidebar Content -->
    <div class="sidebar-content">
        <!-- Side Header -->
        <div class="content-header content-header-fullrow px-15">
            <!-- Mini Mode -->
            <div class="content-header-section sidebar-mini-visible-b">
                <!-- Logo -->
                <span class="content-header-item font-w700 font-size-xl float-left animated fadeIn">
                    <span class="text-dual-primary-dark">c</span><span class="text-primary">b</span>
                </span>
                <!-- END Logo -->
            </div>
            <!-- END Mini Mode -->

            <!-- Normal Mode -->
            <div class="content-header-section text-center align-parent sidebar-mini-hidden">
                <!-- Close Sidebar, Visible only on mobile screens -->
                <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r" data-toggle="layout"
                    data-action="sidebar_close">
                    <i class="fa fa-times text-danger"></i>
                </button>
                <!-- END Close Sidebar -->

                <div class="content-header-item">
                    <a class="link-effect font-w700" href="/admin/dashboard">
                        <i class="fa fa-heartbeat text-info"></i>
                        <span class="font-size-xl text-dual-primary-dark">E</span><span
                            class="font-size-xl text-info">Clínicos</span>
                    </a>
                </div>
                <!-- END Logo -->
            </div>
            <!-- END Normal Mode -->
        </div>
        <!-- END Side Header -->

        <!-- Side User -->
        <div class="content-side content-side-full content-side-user px-10 align-parent">
            <!-- Visible only in mini mode -->
            <div class="sidebar-mini-visible-b align-v animated fadeIn">
                <img class="img-avatar img-avatar32"
                    src="<?php echo $_ENV['HOST'] . '/img/photosperfil/' . $_SESSION["foto"]; ?>.png"
                    alt="Foto de Perfil">
            </div>
            <!-- END Visible only in mini mode -->

            <!-- Visible only in normal mode -->
            <div class="sidebar-mini-hidden-b text-center">
                <a class="img-link" href="/admin/system/perfil/cambiar-foto">
                    <img class="img-avatar"
                        src="<?php echo $_ENV['HOST'] . '/img/photosperfil/' . $_SESSION["foto"]; ?>.png"
                        alt="Foto Perfil">
                </a>
                <ul class="list-inline mt-10">
                    <li class="list-inline-item">
                        <a class="link-effect text-dual-primary-dark font-size-xs font-w600 text-uppercase"
                            href="/admin/perfil"><?php echo $_SESSION["nombre"]; ?></a>
                    </li>
                    <li class="list-inline-item">
                        <a class="link-effect text-dual-primary-dark" data-toggle="layout"
                            data-action="sidebar_style_inverse_toggle" href="javascript:void(0)">
                            <i class="si si-drop"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <form method="POST" action="/logout" class="link-effect text-dual-primary-dark">
                            <button type="submit" class="btn btn-dual-secondary">
                                <i class="si si-logout"></i>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
            <!-- END Visible only in normal mode -->
        </div>
        <!-- END Side User -->

        <!-- Side Navigation -->
        <div class="content-side content-side-full">
            <ul class="nav-main">
                <li class="<?php echo ($current_page == '/admin/dashboard') ? 'open' : ''; ?>">
                    <a href="/admin/dashboard" class="<?php echo ($current_page == '/admin/dashboard') ? 'active' : ''; ?>">
                        <i class="fa fa-dashboard"></i><span class="sidebar-mini-hide">Inicio</span>
                    </a>
                </li>

                <?php if ($_SESSION["perfil"] == "admin") : ?>
                <li class="nav-main-heading"><span class="sidebar-mini-visible"></span><span class="sidebar-mini-hidden">Consultas y Citas</span></li>
                <li class="<?php echo (strpos($current_page, '/admin/cita') !== false || strpos($current_page, '/admin/pacientes') !== false || strpos($current_page, '/admin/historico') !== false) ? 'open' : ''; ?>">
                    <a class="nav-submenu <?php echo (strpos($current_page, '/admin/cita') !== false || strpos($current_page, '/admin/pacientes') !== false || strpos($current_page, '/admin/historico') !== false) ? 'active' : ''; ?>" data-toggle="nav-submenu" href="#">
                        <i class="si si-calendar"></i><span class="sidebar-mini-hide">Consultas y Citas</span>
                    </a>
                    <ul>
                        <li>
                            <a href="/admin/cita_programada" class="<?php echo ($current_page == '/admin/cita_programada') ? 'active' : ''; ?>">
                                <span class="sidebar-mini-hide">Citas Programadas</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/pacientes" class="<?php echo ($current_page == '/admin/pacientes') ? 'active' : ''; ?>">
                                <span class="sidebar-mini-hide">Pacientes</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/cita" class="<?php echo ($current_page == '/admin/cita') ? 'active' : ''; ?>">
                                <span class="sidebar-mini-hide">Citas</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/historico" class="<?php echo ($current_page == '/admin/historico') ? 'active' : ''; ?>">
                                <span class="sidebar-mini-hide">Historico</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif ?>
                
                <li class="nav-main-heading"><span class="sidebar-mini-visible">C</span><span class="sidebar-mini-hidden">Sistema</span></li>
                <li class="<?php echo (strpos($current_page, '/admin/system') !== false) ? 'open' : ''; ?>">
                    <a class="nav-submenu <?php echo (strpos($current_page, '/admin/system') !== false) ? 'active' : ''; ?>" data-toggle="nav-submenu" href="#">
                        <i class="fa fa-cogs"></i><span class="sidebar-mini-hide">Sistema</span>
                    </a>
                    <ul>
                        <li>
                            <a href="/admin/system/perfil" class="<?php echo ($current_page == '/admin/system/perfil') ? 'active' : ''; ?>">
                                <span class="sidebar-mini-hide">Perfil</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/system/configuracion" class="<?php echo ($current_page == '/admin/system/configuracion') ? 'active' : ''; ?>">
                                <span class="sidebar-mini-hide">Configuración</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/system/usuarios" class="<?php echo ($current_page == '/admin/system/usuarios') ? 'active' : ''; ?>">
                                <span class="sidebar-mini-hide">Gestión de Usuarios</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/system/roles" class="<?php echo ($current_page == '/admin/system/roles') ? 'active' : ''; ?>">
                                <span class="sidebar-mini-hide">Gestión de Roles</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/system/logs" class="<?php echo ($current_page == '/admin/system/logs') ? 'active' : ''; ?>">
                                <span class="sidebar-mini-hide">Logs del Sistema</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/system/backup" class="<?php echo ($current_page == '/admin/system/backup') ? 'active' : ''; ?>">
                                <span class="sidebar-mini-hide">Respaldo de Datos</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/system/notificaciones" class="<?php echo ($current_page == '/admin/system/notificaciones') ? 'active' : ''; ?>">
                                <span class="sidebar-mini-hide">Notificaciones</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <form method="POST" action="/logout" class="nav-submenu">
                        <button type="submit" class="btn btn-rounded btn-dual-secondary">
                            <i class="si si-logout"></i><span class="sidebar-mini-hide">Cerrar Sesión</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
        <!-- END Side Navigation -->
    </div>
    <!-- Sidebar Content -->
</div>
<!-- END Sidebar Scroll Container -->
