<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\LoginController;
use Controllers\ConsultaAlternativaController;
use Controllers\DashboardController;
use Controllers\SitioController;
use Controllers\CitaController;
use Controllers\SystemController;
use Controllers\RolesController;
use Controllers\PermisosController;
use Controllers\RecetaMedicaController;
use Controllers\ExpedienteController;

use MVC\Router;

$router = new Router();

// Login
$router->get('/login', [LoginController::class, 'login']);
$router->post('/login', [LoginController::class, 'login']);
$router->post('/logout', [LoginController::class, 'logout']);

// Crear Cuenta
$router->get('/crear', [LoginController::class, 'crear']);
$router->post('/crear', [LoginController::class, 'crear']);

// Olvido el Password
$router->get('/olvide', [LoginController::class, 'olvide']);
$router->post('/olvide', [LoginController::class, 'olvide']);

// Reestablecer Password
$router->get('/reestablecer', [LoginController::class, 'reestablecer']);
$router->post('/reestablecer', [LoginController::class, 'reestablecer']);

// Confirmar Cuenta
$router->get('/mensaje', [LoginController::class, 'mensaje']);
$router->get('/confirmar', [LoginController::class, 'confirmar']);

// Rutas del sitio
$router->get('/', [SitioController::class, 'inicio']);
$router->post('/', [SitioController::class, 'inicio']);
$router->get('/mapa', [SitioController::class, 'mapa']);
$router->get('/about', [SitioController::class, 'about']);
$router->get('/services', [SitioController::class, 'services']);
$router->get('/contacto', [SitioController::class, 'contacto']);
$router->post('/contacto', [SitioController::class, 'contacto']);
$router->get('/agendar_cita', [SitioController::class, 'agendar_cita']);
$router->post('/agendar_cita', [SitioController::class, 'agendar_cita']);
$router->get('/terms', [SitioController::class, 'terms']);
$router->post('/terms', [SitioController::class, 'terms']);
$router->get('/privacy', [SitioController::class, 'privacy']);
$router->post('/privacy', [SitioController::class, 'privacy']);


// Zona de Administrador
$router->get('/admin/dashboard', [DashboardController::class, 'index']);
$router->post('/admin/dashboard/logout', [DashboardController::class, 'logout']);

$router->get('/admin/pacientes', [DashboardController::class, 'expediente']);
$router->get('/admin/pacientes/crear', [DashboardController::class, 'crear']);
$router->post('/admin/pacientes/crear', [DashboardController::class, 'crear']);
$router->get('/admin/pacientes/editar', [DashboardController::class, 'editar']);
$router->post('/admin/pacientes/editar', [DashboardController::class, 'editar']);
$router->post('/admin/pacientes/eliminar', [DashboardController::class, 'eliminar']);

$router->get('/admin/dashboard', [ExpedienteController::class, 'index']);
$router->post('/admin/dashboard/logout', [ExpedienteController::class, 'logout']);

$router->get('/admin/expedientes', [ExpedienteController::class, 'expediente']);
$router->get('/admin/expedientes/crear', [ExpedienteController::class, 'crear']);
$router->post('/admin/expedientes/crear', [ExpedienteController::class, 'crear']);
$router->get('/admin/expedientes/editar', [ExpedienteController::class, 'editar']);
$router->post('/admin/expedientes/editar', [ExpedienteController::class, 'editar']);
$router->post('/admin/expedientes/eliminar', [ExpedienteController::class, 'eliminar']);

// En tu archivo de rutas, por ejemplo, routes.php
$router->get('/admin/receta', [RecetaMedicaController::class, 'index']);


$router->get('/admin/consulta_terapia_alternativa', [ConsultaAlternativaController::class, 'index']);
$router->get('/admin/consulta_terapia_alternativa/crear', [ConsultaAlternativaController::class, 'crear']);
$router->post('/admin/consulta_terapia_alternativa/crear', [ConsultaAlternativaController::class, 'crear']);
$router->get('/admin/consulta_terapia_alternativa/editar', [ConsultaAlternativaController::class, 'editar']);
$router->post('/admin/consulta_terapia_alternativa/editar', [ConsultaAlternativaController::class, 'editar']);
$router->post('/admin/consulta_terapia_alternativa/eliminar', [ConsultaAlternativaController::class, 'eliminar']);
$router->get('/admin/consulta', [ConsultaAlternativaController::class, 'consulta']);
$router->get('/admin/cita', [CitaController::class, 'index']);
$router->get('/admin/cita/crear', [CitaController::class, 'crear']);
$router->post('/admin/cita/crear', [CitaController::class, 'crear']);
$router->get('/admin/historico', [CitaController::class, 'historico']);

$router->get('/admin/cita_programada', [DashboardController::class, 'cita_programada']);
$router->post('/admin/cita_programada', [DashboardController::class, 'cita_programada']);


// Rutas del sistema
$router->get('/admin/system/perfil', [SystemController::class, 'perfil']);
$router->post('/admin/system/perfil', [SystemController::class, 'perfil']);
$router->get('/admin/system/configuracion', [SystemController::class, 'configuracion']);
$router->get('/admin/system/usuarios', [SystemController::class, 'gestionUsuarios']);


// Configuración de Roles
$router->get('/admin/system/roles', [RolesController::class, 'index']);
$router->get('/admin/system/roles/crear', [RolesController::class, 'crear']);
$router->post('/admin/system/roles/crear', [RolesController::class, 'crear']);
$router->get('/admin/system/roles/editar', [RolesController::class, 'editar']);
$router->post('/admin/system/roles/editar', [RolesController::class, 'editar']);
$router->get('/admin/system/roles/eliminar', [RolesController::class, 'eliminar']);

//Configuracion de Permisos
// Rutas para los permisos del sistema
$router->get('/admin/system/permisos', [PermisosController::class, 'index']);
$router->get('/admin/system/permisos/crear', [PermisosController::class, 'crear']);
$router->post('/admin/system/permisos/crear', [PermisosController::class, 'crear']);
$router->get('/admin/system/permisos/editar', [PermisosController::class, 'editar']);
$router->post('/admin/system/permisos/editar', [PermisosController::class, 'editar']);
$router->post('/admin/system/permisos/eliminar', [PermisosController::class, 'eliminar']);



$router->get('/admin/system/logs', [SystemController::class, 'logs']);
$router->get('/admin/system/backup', [SystemController::class, 'respaldo']);
$router->get('/admin/system/notificaciones', [SystemController::class, 'notificaciones']);

$router->get('/admin/system/perfil/', [SystemController::class, 'perfil']);
$router->post('/admin/system/perfil/', [SystemController::class, 'perfil']);
$router->get('/admin/system/perfil/cambiar-password', [SystemController::class, 'cambiarPassword']); // Cambiar aquí
$router->post('/admin/system/perfil/cambiar-password', [SystemController::class, 'cambiarPassword']); // Cambiar aquí
$router->get('/admin/system/perfil/cambiar-foto', [SystemController::class, 'cambiarFoto']);
$router->post('/admin/system/perfil/cambiar-foto', [SystemController::class, 'cambiarFoto']);



// Página de Error pagina no encontrada
// $router->get('/404', [PaginasController::class, 'error']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
