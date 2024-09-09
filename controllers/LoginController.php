<?php
namespace Controllers;

use MVC\Router;
use Model\Usuario;
use Model\Direccion;
use Classes\Email;

class LoginController
{
    public static function login(Router $router)
    {
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarLogin();

            if (empty($alertas)) {
                // Verificar que el usuario exista
                $usuario = Usuario::whereFlexible('email', $usuario->email);

                if (!$usuario || !$usuario->confirmado) {
                    Usuario::setAlerta('danger', 'El Usuario no existe o no está confirmado');
                } else {
                    // Verificar contraseña
                    if (password_verify($_POST['password'], $usuario->password)) {
                        // Iniciar sesión
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['apellido'] = $usuario->apellido;
                        $_SESSION['telefono'] = $usuario->telefono;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['foto'] = $usuario->foto;
                        $_SESSION['perfil'] = $usuario->perfil ?? null;
                        $_SESSION['rol_id'] = $usuario->rol_id; // Almacenar el rol
                        $_SESSION['login'] = true;

                        // Redireccionar según el rol
                        if ($usuario->rol_id == 1 || $usuario->rol_id == 2 || $usuario->rol_id == 3) {
                            $redirectUrl = '/admin/dashboard';
                        } else {
                            $redirectUrl = '/user/dashboard';
                        }

                        header('Location: ' . $redirectUrl);
                        exit();
                    } else {
                        Usuario::setAlerta('danger', 'Contraseña Incorrecta');
                    }
                }
            }
        }

        $alertas = Usuario::getAlertas();

        // Renderizar vista de login
        $router->render('auth/login', [
            'title' => 'Iniciar Sesión',
            'sitio' => 'www.natuexp.com',
            'alertas' => $alertas
        ], 'layout');
    }


    public static function crear(Router $router) {
        $alertas = [];
        $usuario = new Usuario();
        $direccion = new Direccion();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sincronizar los datos del usuario
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validar_cuenta();
            
            // Verificar si el usuario ya existe
            $existeUsuario = Usuario::whereFlexible('email', $usuario->email);
            if ($existeUsuario) {
                Usuario::setAlerta('danger', 'El Usuario ya está registrado');
                $alertas = array_merge($alertas, Usuario::getAlertas());
            }
    
            // Asignar rol y estatus del usuario
            $usuario->rol_id = $_POST['rol_id'] ?? 1;
            $usuario->estatus = $_POST['estatus'] ?? 1;
    
            // Verifica si se ha proporcionado información para la dirección
            if (!empty($_POST['pais'])) {
                $direccion->sincronizar($_POST);  // Sincroniza los datos del formulario con el modelo
                $alertasDireccion = $direccion->validar();  // Valida los datos de la dirección
    
                if (empty($alertasDireccion)) {
                    // No guardes la dirección aún
                    $direccion->usuario_id = null; // Temporalmente sin asignar usuario_id
                } else {
                    $alertas = array_merge($alertas, $alertasDireccion);  // Agrega alertas de validación
                }
            }
            
            // Verificar si hay alertas y mostrar la vista si es necesario
            if (!empty($alertas)) {
                self::renderView($router, $usuario, $direccion, $alertas);
                return;
            }
    
            // Continuar con la creación del usuario
            $usuario->hashPassword();
            unset($usuario->password2);
            $usuario->crearToken();
            $usuario->fecha_creacion = date('Y-m-d H:i:s');
            
            try {
                if ($usuario->guardar()) {
                    // Ahora que el usuario tiene un ID válido, guarda la dirección
                    if (!empty($_POST['pais'])) {
                        $direccion->usuario_id = $usuario->id; // Asocia la dirección con el usuario guardado
                        if ($direccion->guardar()) {
                            // Dirección guardada exitosamente
                            // Se puede actualizar el campo dirección_id del usuario si es necesario
                            $usuario->direccion_id = $direccion->id;
                            if (!$usuario->guardar()) {
                                throw new \Exception('Error al actualizar el usuario con el ID de dirección.');
                            }
                        } else {
                            $alertas['danger'][] = "Error al guardar la dirección en la base de datos: " . implode(", ", $direccion->getError());
                        }
                    }
    
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token, $usuario->fecha_creacion);
                    $email->enviarConfirmacion();
                    header('Location: /mensaje');
                    exit();
                } else {
                    throw new \Exception('Error al guardar el usuario en la base de datos.');
                }
            } catch (\Exception $e) {
                error_log('Error al guardar el usuario: ' . $e->getMessage());
                $alertas['danger'][] = 'Error crítico al guardar el usuario: ' . $e->getMessage();
                self::renderView($router, $usuario, $direccion, $alertas);
            }
        }
        
        // Mostrar la vista de creación de cuenta
        self::renderView($router, $usuario, $direccion, $alertas);
    }
    
    
    
    
    
    private static function renderView(Router $router, Usuario $usuario, Direccion $direccion, array $alertas) {
        $data = [
            'title' => 'Crear Cuenta',
            'sitio' => 'www.natuexp.com',
            'usuario' => $usuario,
            'direccion' => $direccion,
            'alertas' => $alertas
        ];
        $router->render('auth/crear', $data, 'layout');
    }
    
    
    
    
    
    public static function olvide(Router $router)
    {
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarEmail();
            if (empty($alertas)) {
                // Buscar el usuario
                $usuario = Usuario::whereFlexible('email', $usuario->email);
                if ($usuario && $usuario->confirmado) {
                    // Generar un nuevo token
                    $usuario->crearToken();
                    unset($usuario->password2);
                    // Actualizar el usuario
                    $usuario->guardar();
                    // Enviar el email
                    $fechaHora = date('Y-m-d H:i:s'); // Valor de ejemplo
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token, $fechaHora);
                    $email->enviarInstrucciones();
    
                    // Imprimir la alerta
                    $alertas['success'][] = 'Hemos enviado las instrucciones a tu email';
                } else {
                    $alertas['danger'][] = 'El Usuario no existe o no está confirmado';
                }
            }
        }
    
        // Muestra la vista
        $router->render('auth/olvide', [
            'title' => 'Olvidé mi Contraseña',
            'alertas' => $alertas
        ], 'layout');
    }
    

    public static function reestablecer(Router $router)
    {
        $token = s($_GET['token']);
        $token_valido = true;
        $alertas = [];

        if (!$token) {
            header('Location: /login');
            exit();
        }

        // Identificar el usuario con este token
        $usuario = Usuario::whereFlexible('token', $token);

        if (empty($usuario)) {
            $alertas['danger'][] = 'Token No Válido, intenta de nuevo';
            $token_valido = false;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Añadir el nuevo password
            $usuario->sincronizar($_POST);

            // Validar el password
            $alertas = $usuario->validarPassword();

            if (empty($alertas)) {
                // Hashear el nuevo password
                $usuario->hashPassword();

                // Eliminar el Token
                $usuario->token = '';
                $usuario->fecha_modificacion = date('Y-m-d H:i:s');

                // Guardar el usuario en la BD
                $resultado = $usuario->guardar();

                if ($resultado) {
                    header('Location: /login');
                    exit();
                } else {
                    $alertas['danger'][] = 'No se pudo guardar el nuevo password. Inténtalo de nuevo.';
                }
            }
        }

        // Si hay alertas, se mostrarán en la vista
        if (empty($alertas)) {
            $alertas = Usuario::getAlertas();
        }

        // Muestra la vista
        $router->render('auth/reestablecer', [
            'title' => 'Reestablecer Contraseña',
            'alertas' => $alertas,
            'token_valido' => $token_valido
        ], 'layout');
    }


    public static function mensaje(Router $router)
    {
        $router->render('auth/mensaje', [
            'title' => 'Cuenta Creada Exitosamente'
        ], 'layout' );
    }

    public static function confirmar(Router $router)
    {
        $alertas = [];
        $token = ($_GET['token']);
        
        if (!$token) {
            header('Location: /');
            exit();
        }
        
       
        
        // Encontrar al usuario con este token usando whereFlexible
        $usuario = Usuario::whereFlexible('token', $token);
        
        // Debug: Verificar si se encontró al usuario
        if (is_null($usuario)) {
            
            $alertas['danger'][] = 'Token No Válido, la cuenta no se confirmó';
        } else {
            // Confirmar la cuenta
            $usuario->confirmado = 1;
            $usuario->estatus = 1;
            $usuario->token = ''; // Limpiar el token después de la confirmación
            unset($usuario->password2);
    
            // Guardar en la BD
            try {
                $resultado = $usuario->guardar();
                if ($resultado) {
                    Usuario::setAlerta('success', 'Cuenta confirmada Exitosamente!');
                } else {
                    $alertas['danger'][] = 'Error al confirmar la cuenta. Intenta de nuevo.';
                }
            } catch (\Exception $e) {
                // Debug: Mostrar el error
                echo "Error al guardar el usuario: " . $e->getMessage() . "<br>";
            }
    
            $alertas = $usuario->getAlertas(); // Obtener alertas actualizadas
        }
        
     
        
        $router->render('auth/confirmar', [
            'title' => 'Confirma tu cuenta',
            'alertas' => $alertas
        ], 'layout');
    }
    

    // Métodos para manejar errores 404 y 500
    public static function error404(Router $router)
    {
        $router->render('error/404', [
            'title' => 'Página no encontrada'
        ], 'layout' );
    }

    public static function error500(Router $router)
    {
        $router->render('error/500', [
            'title' => 'Error del servidor'
        ], 'layout' );
    }

    public static function logout()
    {
        session_start(); // Iniciar sesión
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_unset(); // Destruir variables de sesión
            session_destroy(); // Destruir sesión
            $_SESSION = [];
            header('Location: /login');
            exit();
        }
    }
}