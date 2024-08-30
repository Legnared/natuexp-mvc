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
    
        // Filtrar roles activos
        $rolesActivos = array_filter($roles, function($rol) {
            return $rol->estatus == 1;
        });
    
        $alertas = [];
    
        $router->render('admin/system/roles/index', [
            'titulo' => 'Gestión de Roles',
            'roles' => $rolesActivos,
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
    // public static function eliminar()
    // {
    //     session_start();
    //     if (!is_admin()) {
    //         header('Location: /login');
    //         exit();
    //     }
    
    //     // Obtener el ID del rol desde el formulario POST
    //     $id = $_POST['id'] ?? null;
    //     if (!$id || !is_numeric($id)) {
    //         header('Location: /admin/system/roles');
    //         exit();
    //     }
    
    //     // Buscar el rol en la base de datos
    //     $rol = Roles::find($id);
    
    //     if (!$rol) {
    //         header('Location: /admin/system/roles');
    //         exit();
    //     }
    
    //     // Llamar al método eliminar, pasando la columna que indica el estatus
    //     $resultado = $rol->eliminar('estatus'); // Aquí 'estatus' es la columna que se usará para inactivar el rol
    
    //     if ($resultado) {
    //         header('Location: /admin/system/roles');
    //         exit();
    //     } else {
    //         // Manejo de error si la inactivación falla
    //         header('Location: /admin/system/roles?error=1');
    //         exit();
    //     }
    // }

    public static function eliminar(Router $router)
    {
        session_start();
        if (!is_admin()) { // Verifica si el usuario tiene permisos de administrador
            header('Location: /admin/dashboard/index');
            exit();
        }

        // Inicializa la variable de alertas
        $alertas = [];

        // Verifica el método de solicitud
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null; // Usa POST para obtener el ID

            // Verifica si el ID es válido
            if (!is_numeric($id)) {
                $alertas['danger'][] = 'ID inválido.';
            } else {
                // Encuentra el rol por ID
                $rol = Roles::find($id);

                if ($rol) {
                    // Establece la fecha de eliminación
                    $rol->actualizado_at = date('Y-m-d H:i:s');
                    // Llama al método eliminar
                    $resultado = $rol->eliminar('estatus'); // Usa 'estatus' o el nombre de la columna que maneja el estado

                    if ($resultado) {
                        // Redirige si la eliminación fue exitosa
                        header('Location: /admin/system/roles');
                        exit();
                    } else {
                        // Maneja el caso en que la eliminación falla
                        $alertas['danger'][] = 'Error al eliminar el rol.';
                    }
                } else {
                    // Maneja el caso en que no se encuentra el rol
                    $alertas['danger'][] = 'Rol no encontrado.';
                }
            }
        }

        // Renderizar la vista de roles con todos los datos cargados
        $router->render('admin/system/roles', [
            'titulo' => 'Eliminar Rol',
            'alertas' => $alertas // Pasa las alertas a la vista si existen
        ], 'admin-layout');
    }


    
    
    
}
