<?php

namespace Controllers;

use Model\Roles;
use MVC\Router;

class RolesController
{
    // Mostrar todos los roles
    public static function index(Router $router)
    {
        session_start();
        // Verificar si el usuario tiene permisos de administrador
        if (!is_admin()) {
            header('Location: /login');
            exit();
        }

        // Obtener todos los roles
        $roles = Roles::all();

        $alertas = [];

        $router->render('admin/system/roles/index', [
            'titulo' => 'Gestión de Roles',
            'roles' => $roles,
            'alertas' => $alertas
        ], 'admin-layout');
    }

    // Mostrar formulario para crear un rol
    public static function crear(Router $router)
    {
        session_start();
        if (!is_admin()) {
            header('Location: /login');
            exit();
        }

        $rol = new Roles;
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sincronizar con los datos del formulario
            $rol->sincronizar($_POST);

            // Validar los datos
            $alertas = $rol->validar();

            if (empty($alertas)) {
                // Guardar en la base de datos
                $resultado = $rol->guardar();

                if ($resultado) {
                    header('Location: /admin/system/roles');
                    exit();
                }
            }
        }

        $router->render('admin/system/roles/crear', [
            'titulo' => 'Crear Rol',
            'rol' => $rol,
            'alertas' => $alertas
        ], 'admin-layout');
    }

    // Mostrar formulario para editar un rol
    public static function editar(Router $router)
    {
        session_start();
        if (!is_admin()) {
            header('Location: /login');
            exit();
        }

        // Obtener el ID del rol desde la URL
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /admin/system/roles');
            exit();
        }

        // Buscar el rol en la base de datos
        $rol = Roles::find($id);

        if (!$rol) {
            header('Location: /admin/system/roles');
            exit();
        }

        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sincronizar con los datos del formulario
            $rol->sincronizar($_POST);

            // Validar los datos
            $alertas = $rol->validar();

            if (empty($alertas)) {
                // Guardar los cambios en la base de datos
                $resultado = $rol->guardar();

                if ($resultado) {
                    header('Location: /admin/system/roles');
                    exit();
                }
            }
        }

        $router->render('admin/system/roles/editar', [
            'titulo' => 'Editar Rol',
            'rol' => $rol,
            'alertas' => $alertas
        ], 'admin-layout');
    }

    // Eliminar un rol
    public static function eliminar()
    {
        session_start();
        if (!is_admin()) {
            header('Location: /login');
            exit();
        }

        // Obtener el ID del rol desde la URL
        $id = $_POST['id'] ?? null;
        if (!$id) {
            header('Location: /admin/system/roles');
            exit();
        }

        // Buscar el rol en la base de datos
        $rol = Roles::find($id);

        if (!$rol) {
            header('Location: /admin/system/roles');
            exit();
        }

        // Eliminar el rol
        $resultado = $rol->eliminar();

        if ($resultado) {
            header('Location: /admin/system/roles');
            exit();
        }
    }
}
