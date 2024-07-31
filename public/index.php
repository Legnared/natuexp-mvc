<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\LoginController;
use Controllers\ConsultaAlternativaController;
use Controllers\DashboardController;
use Controllers\SitioController;
use Controllers\CitaController;
use Controllers\SystemController;  // Añadir el controlador de sistema
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
$router->get('/admin/perfil', [DashboardController::class, 'perfil']);
$router->post('/admin/perfil', [DashboardController::class, 'perfil']);
$router->get('/admin/perfil/cambiar-password', [DashboardController::class, 'cambiarPassowrd']);
$router->post('/admin/perfil/cambiar-password', [DashboardController::class, 'cambiarPassowrd']);
$router->get('/admin/perfil/cambiar-foto', [DashboardController::class, 'cambiarFoto']);
$router->post('/admin/perfil/cambiar-foto', [DashboardController::class, 'cambiarFoto']);
$router->get('/admin/pacientes', [DashboardController::class, 'expediente']);
$router->get('/admin/pacientes/crear', [DashboardController::class, 'crear']);
$router->post('/admin/pacientes/crear', [DashboardController::class, 'crear']);
$router->get('/admin/pacientes/editar', [DashboardController::class, 'editar']);
$router->post('/admin/pacientes/editar', [DashboardController::class, 'editar']);
$router->post('/admin/pacientes/eliminar', [DashboardController::class, 'eliminar']);
$router->get('/admin/receta_medica', [DashboardController::class, 'evolucion_clinica']);
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
$router->get('/admin/system/roles', [SystemController::class, 'gestionRoles']);
$router->get('/admin/system/logs', [SystemController::class, 'logs']);
$router->get('/admin/system/backup', [SystemController::class, 'respaldo']);
$router->get('/admin/system/notificaciones', [SystemController::class, 'notificaciones']);


// Página de Error pagina no encontrada
// $router->get('/404', [PaginasController::class, 'error']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
