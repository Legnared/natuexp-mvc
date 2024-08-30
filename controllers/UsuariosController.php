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
            return $usuario->estado == 1;
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
            // Sincronizar los datos del usuario y la dirección
            $usuario->sincronizar($_POST);
            $direccion->sincronizar($_POST);
    
            // Validar los datos del usuario
            $alertas = $usuario->validar_cuenta();
            
            // Verificar si el usuario ya existe
            $existeUsuario = Usuario::whereFlexible('email', $usuario->email);
            if ($existeUsuario) {
                Usuario::setAlerta('error', 'El Usuario ya está registrado');
                $alertas = Usuario::getAlertas();
            }
    
            // Validar y guardar la dirección si se proporciona
            if (!empty($_POST['calle'])) {
                $alertas = array_merge($alertas, $direccion->validar());
                
                if (empty($alertas)) {
                    $direccion->guardar();
                    $usuario->direccion_id = $direccion->id;
                } else {
                    self::renderView($router, $usuario, $direccion, $alertas, $roles);
                    return;
                }
            }
    
            // Verificar si hay alertas y mostrar la vista si es necesario
            if (!empty($alertas)) {
                self::renderView($router, $usuario, $direccion, $alertas, $roles);
                return;
            }
    
            // Asignar rol y estado del usuario
            $usuario->estado = $_POST['estado'] ?? 1; // Confirmar el usuario directamente
            
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
    
        // Mostrar la vista de creación de cuenta
        self::renderView($router, $usuario, $direccion, $alertas, $roles);
    }
    
    private static function renderView(Router $router, Usuario $usuario, Direccion $direccion, array $alertas, array $roles) {
        $data = [
            'titulo' => 'Crear un Nuevo Usuario',
            'usuario' => $usuario,
            'direccion' => $direccion,
            'roles' => $roles,
            'alertas' => $alertas
        ];
        $router->render('admin/system/usuarios/crear', $data, 'admin-layout');
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
    
        // Buscar la dirección usando el usuario_id en lugar de direccion_id
        $direccion = Direccion::whereFlexible('usuario_id', $usuario->id) ?? new Direccion();
        $roles = Roles::all();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $direccion->sincronizar($_POST);
    
            // Manejo de imagen
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $resultadoImagen = self::manejarImagen($_FILES['foto'], $alertas);
                if ($resultadoImagen) {
                    $usuario->foto = $resultadoImagen;
                }
            }
    
            // Manejo de la contraseña
            if (!empty($usuario->password) && !empty($usuario->password2)) {
                if ($usuario->password !== $usuario->password2) {
                    $alertas['error'][] = 'Las contraseñas no coinciden';
                } else {
                    $usuario->hashPassword();
                }
            }
    
            // Validación del rol
            if (empty($usuario->rol_id) || !in_array($usuario->rol_id, array_column($roles, 'id'))) {
                $alertas['error'][] = 'Selecciona un rol válido';
            }
    
            // Validaciones finales
            $alertas = array_merge($alertas, $usuario->validar_cuenta(), $direccion->validar());
    
            if (empty($alertas)) {
                // Guardar dirección y usuario
                $direccion->usuario_id = $usuario->id; // Asignar usuario_id a la dirección
    
                if ($direccion->guardar()) {
                    if ($usuario->guardar()) {
                        header('Location: /admin/system/usuarios/');
                        exit();
                    } else {
                        $alertas['error'][] = 'Error al actualizar el usuario: ' . implode(', ', $usuario->getError());
                    }
                } else {
                    $alertas['error'][] = 'Error al guardar la dirección: ' . implode(', ', $direccion->getError());
                }
            }
        }
    
        $router->render('admin/system/usuarios/editar', [
            'titulo' => 'Editar Usuario',
            'usuario' => $usuario,
            'direccion' => $direccion,
            'alertas' => $alertas,
            'roles' => $roles
        ], 'admin-layout');
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
                    $resultado = $usuario->eliminar('estado'); // Usa 'estatus' o el nombre de la columna que maneja el estado

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
                    $usuario->estado = 1;
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
    
    
    
    
    
    
    // Método para manejar la carga de imágenes
    private static function manejarImagen($archivo, &$alertas) {
        // Validar el tipo de archivo
        if (isset($archivo) && $archivo['error'] === UPLOAD_ERR_OK) {
            $nombreArchivo = $archivo['name'];
            $rutaTemporal = $archivo['tmp_name'];
            $tipoArchivo = mime_content_type($rutaTemporal);
            
            if (in_array($tipoArchivo, ['image/jpeg', 'image/png', 'image/webp'])) {
                // Validar el tamaño del archivo
                if ($archivo['size'] <= 5 * 1024 * 1024) { // 5MB
                    $imagen = Image::make($rutaTemporal);
                    $imagen->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    
                    $rutaDestino = 'path_to_images_directory/' . $nombreArchivo;
                    $imagen->save($rutaDestino);
                    
                    return $nombreArchivo;
                } else {
                    $alertas['error'][] = 'El archivo es demasiado grande. Tamaño máximo permitido: 5MB';
                }
            } else {
                $alertas['error'][] = 'Formato de imagen no válido. Solo se permiten JPG, PNG y WEBP.';
            }
        } else {
            $alertas['error'][] = 'Error al cargar la imagen.';
        }
        return null;
    }
}
