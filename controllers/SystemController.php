<?php

namespace Controllers;

use Model\Usuario;
use MVC\Router;
use Intervention\Image\ImageManagerStatic as Image;

class SystemController
{
    public static function perfil(Router $router)
    {
        session_start();
        isAuth();
        $alertas = [];
        $usuario = Usuario::find($_SESSION['id']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            date_default_timezone_set('America/Mexico_City');
            $usuario->fecha_modificacion = date_create()->format('Y-m-d H:i:s');
            $alertas = $usuario->validar_perfil();
            if (empty($alertas)) {
                $existeUsuario = Usuario::where('email', $usuario->email);
                if ($existeUsuario && $existeUsuario->id !== $usuario->id) {
                    Usuario::setAlerta('danger', 'Email no válido, ya pertenece a otra cuenta');
                    $alertas = $usuario->getAlertas();
                } else {
                    $usuario->guardar();
                    Usuario::setAlerta('success', 'Guardado Correctamente!');
                    $alertas = $usuario->getAlertas();
                    $_SESSION['nombre'] = $usuario->nombre;
                    $_SESSION['apellido'] = $usuario->apellido;
                }
            }
        }
        
        $router->render('admin/perfil/index', [
            'titulo' => 'Perfil',
            'usuario' => $usuario,
            'alertas' => $alertas
        ], 'admin-layout');
    }

    public static function configuracion(Router $router)
    {
        session_start();
        isAuth();
        // Aquí iría la lógica para manejar la configuración del sistema
        $router->render('admin/system/configuracion/index', [
            'titulo' => 'Configuración'
        ], 'admin-layout');
    }

    public static function gestionUsuarios(Router $router)
    {
        session_start();
        isAuth();
        // Aquí iría la lógica para manejar la gestión de usuarios
        $router->render('admin/system/usuarios/index', [
            'titulo' => 'Gestión de Usuarios'
        ], 'admin-layout');
    }

    public static function gestionRoles(Router $router)
    {
        session_start();
        isAuth();
        // Aquí iría la lógica para manejar la gestión de roles
        $router->render('admin/system/roles/index', [
            'titulo' => 'Gestión de Roles'
        ], 'admin-layout');
    }

    public static function logs(Router $router)
    {
        session_start();
        isAuth();
        // Aquí iría la lógica para manejar los logs del sistema
        $router->render('admin/system/logs/index', [
            'titulo' => 'Logs del Sistema'
        ], 'admin-layout');
    }

    public static function respaldo(Router $router)
    {
        session_start();
        isAuth();
        // Aquí iría la lógica para manejar el respaldo de datos
        $router->render('admin/system/backup/index', [
            'titulo' => 'Respaldo de Datos'
        ], 'admin-layout');
    }

    public static function notificaciones(Router $router)
    {
        session_start();
        isAuth();
        // Aquí iría la lógica para manejar las notificaciones del sistema
        $router->render('admin/system/notificaciones/index', [
            'titulo' => 'Notificaciones'
        ], 'admin-layout');
    }
}
