<?php

namespace Controllers;

use MVC\Router;
use Model\Usuario;
use Model\Direccion;
use Model\Roles;
use Intervention\Image\ImageManagerStatic as Image;

class UsuariosController {

    public static function index(Router $router) {
        session_start();
        
        // Verificar si el usuario tiene permisos de administrador
        if (!is_admin()) {
            header('Location: /login');
            exit();
        }
    
        // Obtener todos los usuarios
        $usuarios = Usuario::all();
        
        // Filtrar usuarios activos
        $usuariosActivos = array_filter($usuarios, function($usuario) {
            return $usuario->estatus == 1;
        });
    
        $alertas = [];
    
        $router->render('admin/system/usuarios/index', [
            'titulo' => 'Gestión de Usuarios',
            'usuarios' => $usuariosActivos,
            'alertas' => $alertas
        ], 'admin-layout');
    }
    
    // public static function crear(Router $router) {
    //     session_start();
    //     if (!is_admin()) {
    //         header('Location: /login');
    //         exit();
    //     }
    
    //     $alertas = [];
    //     $usuario = new Usuario();
    //     $direccion = new Direccion();
    //     $roles = Roles::all();
    
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         // Sincronizar los datos del usuario y dirección con $_POST
    //         $usuario->sincronizar($_POST);
    //         $direccion->sincronizar($_POST);
    
    //         // Verificar si el usuario ya existe
    //         $existeUsuario = Usuario::whereFlexible('email', $usuario->email);
    //         if (!empty($existeUsuario)) {
    //             $alertas['error'][] = 'Ya existe un usuario con el mismo email';
    //         }
    
    //         // Manejar la imagen
    //         $alertas = self::manejarImagen($_FILES['foto'], $alertas);
    
    //         // Validar la cuenta y la dirección
    //         $alertas = array_merge($alertas, $usuario->validar_cuenta());
    //         $alertas = array_merge($alertas, $direccion->validar());
    
    //         // Verificar que las contraseñas coincidan
    //         if ($usuario->password !== $usuario->password2) {
    //             $alertas['error'][] = 'Las contraseñas no coinciden';
    //         }
    
    //         // Si no hay alertas, proceder a guardar la dirección y el usuario
    //         if (empty($alertas)) {
    //             $resultadoDireccion = $direccion->guardar();
    
    //             if (!$resultadoDireccion) {
    //                 $alertas['error'][] = 'Error al guardar la dirección: ' . implode(', ', $direccion->getError());
    //                 debuguear('Error al guardar dirección: ' . print_r($direccion->getError(), true));
    //             } else {
    //                 $usuario->direccion_id = $direccion->id;
    //                 $usuario->rol_id = $_POST['rol_id'] ?? null;
    //                 $usuario->hashPassword();
    //                 $usuario->crearToken();
    
    //                 $resultadoUsuario = $usuario->guardar();
    
    //                 if ($resultadoUsuario) {
    //                     header('Location: /admin/system/usuarios/');
    //                     exit();
    //                 } else {
    //                     $alertas['error'][] = 'Error al guardar el usuario: ' . implode(', ', $usuario->getError());
    //                     debuguear('Error al guardar usuario: ' . print_r($usuario->getError(), true));
    //                 }
    //             }
    //         } else {
    //             debuguear('Alertas: ' . print_r($alertas, true));
    //         }
    //     }
    
    //     $router->render('admin/system/usuarios/crear', [
    //         'titulo' => 'Crear un Nuevo Usuario',
    //         'usuario' => $usuario,
    //         'direccion' => $direccion,
    //         'alertas' => $alertas,
    //         'roles' => $roles
    //     ], 'admin-layout');
    // }

    public static function crear(Router $router) {
        session_start();
        if (!is_admin()) {
            header('Location: /login');
            exit();
        }
    
        $alertas = [];
        $usuario = new Usuario();
        $direccion = new Direccion();
        $roles = Roles::all(); // Cargar roles para el formulario
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitizar y sincronizar datos
            $_POST = array_map(function($value) {
                return is_string($value) ? htmlspecialchars($value, ENT_QUOTES, 'UTF-8') : $value;
            }, $_POST);
    
            // Sincronizar datos del usuario y la dirección
            $usuario->sincronizar($_POST);
            $direccion->sincronizar($_POST);
    
            // Asignar rol al usuario
            $usuario->rol_id = $_POST['rol'] ?? null;
    
            // Validar datos del usuario
            $alertas = $usuario->validar_cuenta();
    
            // Verificar si el usuario ya existe
            if (Usuario::whereFlexible('email', $usuario->email)) {
                Usuario::setAlerta('error', 'El Usuario ya está registrado');
                $alertas = Usuario::getAlertas();
            }
    
            // Manejar la imagen si se subió
            $alertas = self::manejarArchivos($_FILES['foto'], $alertas);
            $usuario->foto = $_POST['foto'] ?? null;
    
            // Validar y guardar la dirección si se proporciona
            if (!empty($_POST['calle'])) {
                $alertas = array_merge($alertas, $direccion->validar());
    
                if (empty($alertas)) {
                    $direccion->guardar();
                    $usuario->direccion_id = $direccion->id; // Asignar dirección al usuario
                } else {
                    // Renderizar la vista con alertas si hay errores en la dirección
                    $router->render('admin/system/usuarios/crear', [
                        'titulo' => 'Crear Usuario',
                        'usuario' => $usuario,
                        'direccion' => $direccion,
                        'roles' => $roles,
                        'alertas' => $alertas
                    ], 'admin-layout');
                    return;
                }
            }
    
            // Verificar si hay alertas y mostrar la vista si es necesario
            if (!empty($alertas)) {
                $router->render('admin/system/usuarios/crear', [
                    'titulo' => 'Crear Usuario',
                    'usuario' => $usuario,
                    'direccion' => $direccion,
                    'roles' => $roles,
                    'alertas' => $alertas
                ], 'admin-layout');
                return;
            }
    
            // Asignar estatus del usuario
            $usuario->estatus = $_POST['estatus'] ?? 1; // Confirmar el usuario directamente
    
            // Continuar con la creación del usuario
            $usuario->hashPassword();
            unset($usuario->password2);
            $usuario->crearToken(); // Este paso puede no ser necesario si no se usa confirmación por token
            $usuario->fecha_creacion = date('Y-m-d H:i:s');
    
            try {
                if ($usuario->guardar()) {
                    header('Location: /admin/system/usuarios');
                    exit();
                } else {
                    throw new \Exception('Error al guardar el usuario en la base de datos.');
                }
            } catch (\Exception $e) {
                error_log('Error al guardar el usuario: ' . $e->getMessage());
                die('Error crítico al guardar el usuario.');
            }
        }
    
        $router->render('admin/system/usuarios/crear', [
            'titulo' => 'Crear Usuario',
            'usuario' => $usuario,
            'direccion' => $direccion,
            'roles' => $roles,
            'alertas' => $alertas
        ], 'admin-layout');
    }
    
    
    public static function editar(Router $router) {
        session_start();
    
        if (!is_admin()) {
            header('Location: /login');
            exit();
        }
    
        $alertas = [];
        $id = $_GET['id'] ?? null;
    
        if (!$id) {
            header('Location: /admin/system/usuarios/');
            exit();
        }
    
        $usuario = Usuario::find($id);
        if (!$usuario) {
            header('Location: /admin/system/usuarios/');
            exit();
        }
    
        // Buscar la dirección asociada al usuario
        $direccion = Direccion::find($usuario->direccion_id) ?: new Direccion();
        $roles = Roles::all();
        
        // Verificar roles
        if (!$roles) {
            echo 'No se encontraron roles';
            exit();
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitizar y sincronizar datos
            $_POST = array_map(function($value) {
                return is_string($value) ? htmlspecialchars($value, ENT_QUOTES, 'UTF-8') : $value;
            }, $_POST);
    
            // Sincronizar datos del usuario y la dirección
            $usuario->sincronizar($_POST);
            $direccion->sincronizar($_POST);
    
            // Manejo de la foto
            if (!empty($_FILES['foto']['tmp_name'])) {
                $alertas = self::manejarArchivos($_FILES['foto'], $alertas);
                if (empty($alertas['error'])) {
                    $usuario->foto = $_POST['foto'];
                }
            } else {
                $usuario->foto = $usuario->foto_actual;
            }
    
            // Manejo de roles por el usuario
            $rolesIds = array_column($roles, 'id');
            if (isset($_POST['rol_id']) && in_array((int)$_POST['rol_id'], $rolesIds)) {
                $usuario->rol_id = (int)$_POST['rol_id'];
            } else {
                $alertas['error'][] = 'Selecciona un rol válido';
            }
    
            // Validar contraseña solo si se proporciona
            if (!empty($_POST['password'])) {
                $usuario->password = $_POST['password'];
                $alertas = array_merge($alertas, $usuario->validar_password());
            }
    
            // Validaciones finales
            $alertas = array_merge($alertas, $direccion->validar());
    
            if (empty($alertas)) {
                // Guardar dirección
                $direccion->usuario_id = $usuario->id; // Asignar usuario_id a la dirección
                if (!$direccion->guardar()) {
                    $alertas['warning'][] = 'La dirección no se guardó correctamente. Verifica los datos.';
                }
    
                // Guardar usuario
                if ($usuario->guardar()) {
                    $_SESSION['redirect'] = '/admin/system/usuarios'; 
                    $alertas['success'][] = 'Usuario actualizado correctamente, espera 5 segundos para ser redireccionado al Listado de Usuarios';
                } else {
                    $alertas['error'][] = 'Error al actualizar el usuario: ' . implode(', ', $usuario->getError());
                }
            }
        }
    
        $router->render('/admin/system/usuarios/editar', [
            'titulo' => 'Editar Usuario',
            'usuario' => $usuario,
            'direccion' => $direccion,
            'roles' => $roles,
            'alertas' => $alertas
        ], 'admin-layout');
    }
    
    
    
    public static function cambiarPassword(Router $router) {
        session_start();

        if (!is_admin()) {
            header('Location: /login');
            exit();
        }

        $alertas = [];
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /admin/system/usuarios/');
            exit();
        }

        $usuario = Usuario::find($id);
        if (!$usuario) {
            header('Location: /admin/system/usuarios/');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = array_map(function($value) {
                return is_string($value) ? htmlspecialchars($value, ENT_QUOTES, 'UTF-8') : $value;
            }, $_POST);

            $password_nuevo = trim($_POST['password_nuevo']);
            $password2 = trim($_POST['password_nuevo_confirm']);

            if ($password_nuevo !== $password2) {
                $alertas['error'][] = 'Las contraseñas no coinciden';
            } else {
                // Cambiar la contraseña
                $resultado = $usuario->resetPassword($password_nuevo);

                if ($resultado) {
                    $_SESSION['redirect'] = '/admin/system/usuarios';
                    $alertas['success'][] = 'Contraseña actualizada correctamente';
                } else {
                    $alertas['error'][] = 'Hubo un problema al actualizar la contraseña. Por favor, intenta de nuevo.';
                }
            }
        }

        $router->render('/admin/system/usuarios/cambiar-password', [
            'titulo' => 'Restablecer Contraseña',
            'usuario' => $usuario,
            'alertas' => $alertas
        ], 'admin-layout');
    }
    
    
    
    
    
     // Método para manejar la carga de imágenes
     private static function manejarArchivos($files, $alertas) {
        $fileTmpPath = '../public/img/users/';
        $imageTmpPath = '../public/img/users/'; // Cambiado a users si estás guardando imágenes de usuarios
    
        if (!is_dir($fileTmpPath)) mkdir($fileTmpPath, 0777, true);
    
        $imagenFileNames = [];
    
        if (!empty($files['tmp_name'])) {
            foreach ($files['tmp_name'] as $key => $tmp_name) {
                $fileName = $files['name'][$key];
                $fileTmpName = $files['tmp_name'][$key];
                $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    
                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
    
                if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'webp'])) {
                    if (move_uploaded_file($fileTmpName, $imageTmpPath . $newFileName)) {
                        $imagenFileNames[] = $newFileName;
                    } else {
                        $alertas['error'][] = 'No se pudo subir la imagen ' . $fileName;
                    }
                } else {
                    $alertas['error'][] = 'Formato de archivo no soportado: ' . $fileName;
                }
            }
        }
    
        if (!empty($imagenFileNames)) {
            $_POST['foto'] = implode(',', $imagenFileNames);
        }
    
        return $alertas;
    }
    
    
    
    public static function eliminar(Router $router) {
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
                $usuario = Usuario::find($id);

                if ($usuario) {
                    // Establece la fecha de eliminación
                    $usuario->fecha_eliminacion = date('Y-m-d H:i:s');
                    // Llama al método eliminar
                    $resultado = $usuario->eliminar('estatus'); // Usa 'estatus' o el nombre de la columna que maneja el estatus

                    if ($resultado) {
                        // Redirige si la eliminación fue exitosa
                        header('Location: /admin/system/usuarios');
                        exit();
                    } else {
                        // Maneja el caso en que la eliminación falla
                        $alertas['danger'][] = 'Error al eliminar el Usuario.';
                    }
                } else {
                    // Maneja el caso en que no se encuentra el rol
                    $alertas['danger'][] = 'Rol no encontrado.';
                }
            }
        }

        // Renderizar la vista de roles con todos los datos cargados
        $router->render('admin/system/usuarios', [
            'titulo' => 'Eliminar Usuario',
            'alertas' => $alertas // Pasa las alertas a la vista si existen
        ], 'admin-layout');
    }
    
    public static function activar() {
        session_start();
    
        // Verificar si el usuario tiene permisos de administrador
        if (!is_admin()) {
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
                $alertas['error'][] = 'ID inválido.';
            } else {
                // Encuentra el usuario por ID
                $usuario = Usuario::find($id);
    
                if ($usuario) {
                    // Activar usuario y limpiar el token
                    $usuario->estatus = 1;
                    $usuario->confirmado = 1;
                    $usuario->token = ''; // Limpia el token al activar el usuario
    
                    // Guarda los cambios
                    $resultado = $usuario->guardar();
    
                    if ($resultado) {
                        // Muestra un mensaje de éxito
                        $alertas['success'][] = 'Usuario activado exitosamente.';
                    } else {
                        // Muestra un mensaje de error
                        $alertas['error'][] = 'Error al activar el usuario.';
                    }
                } else {
                    // Maneja el caso en que no se encuentra el usuario
                    $alertas['error'][] = 'Usuario no encontrado.';
                }
            }
        } else {
            // Maneja el caso en que no se recibe el método POST
            $alertas['error'][] = 'Método de solicitud no válido.';
        }
    
        // Devolver las alertas como respuesta JSON
        header('Content-Type: application/json');
        echo json_encode($alertas);
        exit();
    }
    
   
    public static function desactivar() {
        session_start();
    
        // Verificar si el usuario tiene permisos de administrador
        if (!is_admin()) {
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
                $alertas['error'][] = 'ID inválido.';
            } else {
                // Encuentra el usuario por ID
                $usuario = Usuario::find($id);
    
                if ($usuario) {
                    // Desactivar usuario
                    $usuario->estatus = 0; // Establece el estatus a 0 para desactivar
                    $usuario->confirmado = 0; // Opcional: marcar como no confirmado
    
                    // Guarda los cambios
                    $resultado = $usuario->guardar();
    
                    if ($resultado) {
                        // Muestra un mensaje de éxito
                        $alertas['success'][] = 'Usuario desactivado exitosamente.';
                    } else {
                        // Muestra un mensaje de error
                        $alertas['error'][] = 'Error al desactivar el usuario.';
                    }
                } else {
                    // Maneja el caso en que no se encuentra el usuario
                    $alertas['error'][] = 'Usuario no encontrado.';
                }
            }
        } else {
            // Maneja el caso en que no se recibe el método POST
            $alertas['error'][] = 'Método de solicitud no válido.';
        }
    
        // Devolver las alertas como respuesta JSON
        header('Content-Type: application/json');
        echo json_encode($alertas);
        exit();
    }
    
    
}