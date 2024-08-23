<?php

namespace Controllers;

use Model\Permisos;
use Model\Roles;
use MVC\Router;

class PermisosController
{
    // Mostrar todos los permisos
    public static function index(Router $router)
    {
        session_start();
        if (!is_admin()) {
            header('Location: /login');
            exit();
        }

        $permisos = Permisos::all();
        $alertas = [];

        $router->render('admin/system/permisos/index', [
            'titulo' => 'Gestión de Permisos',
            'permisos' => $permisos,
            'alertas' => $alertas
        ], 'admin-layout');
    }

    // Mostrar formulario para crear un permiso
    public static function crear(Router $router)
    {
        session_start();
        if (!is_admin()) {
            header('Location: /login');
            exit();
        }
    
        $permiso = new Permisos;
        $roles = Roles::all(); 
        $alertas = [];
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Imprimir datos del formulario para depuración
           
            
            // Sincronizar con los datos del formulario
            $permiso->sincronizar($_POST);
          
    
            // Validar los datos
            $alertas = $permiso->validar();
            //debuguear($alertas);
    
            if (empty($alertas)) {
                // Guardar en la base de datos
                $resultado = $permiso->guardar();
    
                if ($resultado) {
                    header('Location: /admin/system/permisos');
                    exit();
                }
            }
        }
    
        $router->render('admin/system/permisos/crear', [
            'titulo' => 'Crear Permiso',
            'permiso' => $permiso,
            'roles' => $roles,
            'alertas' => $alertas
        ], 'admin-layout');
    }
    

    // Mostrar formulario para editar un permiso
    public static function editar(Router $router)
    {
        session_start();
        if (!is_admin()) {
            header('Location: /login');
            exit();
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /admin/system/permisos');
            exit();
        }

        $permiso = Permisos::find($id);
        $roles = Roles::all(); 

        if (!$permiso) {
            header('Location: /admin/system/permisos');
            exit();
        }

        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $permiso->sincronizar($_POST);
            $alertas = $permiso->validar();

            if (empty($alertas)) {
                $resultado = $permiso->guardar();

                if ($resultado) {
                    header('Location: /admin/system/permisos');
                    exit();
                }
            }
        }

        $router->render('admin/system/permisos/editar', [
            'titulo' => 'Editar Permiso',
            'permiso' => $permiso,
            'roles' => $roles,
            'alertas' => $alertas
        ], 'admin-layout');
    }

    // Eliminar un permiso
    public static function eliminar()
    {
        session_start();
        if (!is_admin()) {
            header('Location: /login');
            exit();
        }

        $id = $_POST['id'] ?? null;
        if (!$id) {
            header('Location: /admin/system/permisos');
            exit();
        }

        $permiso = Permisos::find($id);

        if (!$permiso) {
            header('Location: /admin/system/permisos');
            exit();
        }

        $resultado = $permiso->eliminar();

        if ($resultado) {
            header('Location: /admin/system/permisos');
            exit();
        }
    }
}
