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
                        $redirectUrl = $usuario->rol_id == 1 ? '/admin/dashboard' : '/user/dashboard';
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
        $usuario = new Usuario;
        $direccion = new Direccion; // Instanciar el modelo Dirección
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sincronizar los datos del usuario
            $usuario->sincronizar($_POST);
        
            // Validar los datos del usuario
            $alertas = $usuario->validar_cuenta();
            if (!empty($alertas)) {
                // Mostrar la vista con las alertas si hay errores
                $data = [
                    'title' => 'Crear Cuenta',
                    'sitio' => 'www.natuexp.com',
                    'usuario' => $usuario,
                    'direccion' => $direccion,
                    'alertas' => $alertas
                ];
                $router->render('auth/crear', $data, 'layout');
                return;
            }
        
            // Verificar si el usuario ya existe
            $existeUsuario = Usuario::where('email', $usuario->email);
            if ($existeUsuario) {
                Usuario::setAlerta('danger', 'El Usuario ya está registrado');
                $alertas = Usuario::getAlertas();
                $data = [
                    'title' => 'Crear Cuenta',
                    'sitio' => 'www.natuexp.com',
                    'direccion' => $direccion,
                    'usuario' => $usuario,
                    'alertas' => $alertas
                ];
                $router->render('auth/crear', $data, 'layout');
                return;
            }
        
            // Validar y guardar la dirección si se proporciona
            if (!empty($_POST['calle'])) {
                $direccion->sincronizar($_POST);
                $alertas = $direccion->validar();
        
                if (empty($alertas)) {
                    // Guardar la dirección en la base de datos
                    $direccion->guardar();
                    // Asignar el ID de la dirección al usuario
                    $usuario->direccion_id = $direccion->id;
                } else {
                    // Mostrar la vista con las alertas si hay errores en la dirección
                    $data = [
                        'title' => 'Crear Cuenta',
                        'sitio' => 'www.natuexp.com',
                        'usuario' => $usuario,
                        'direccion' => $direccion,
                        'alertas' => $alertas
                    ];
                    $router->render('auth/crear', $data, 'layout');
                    return;
                }
            }
        
            // Continuar con la creación del usuario
            $usuario->hashPassword();
            unset($usuario->password2);
            $usuario->crearToken();
            $usuario->fecha_creacion = date('Y-m-d H:i:s');
        
            try {
                $resultado = $usuario->guardar();
            
                if ($resultado) {
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token, $usuario->fecha_creacion);
                    $email->enviarConfirmacion();
                    header('Location: /mensaje');
                    exit();
                } else {
                    throw new \Exception('Error al guardar el usuario en la base de datos.');
                }
            } catch (\Exception $e) {
                error_log('Error al guardar el usuario: ' . $e->getMessage());
                // Puedes agregar más detalles aquí si es necesario
                die('Error crítico al guardar el usuario.');
            }
            
        }
        
        // Mostrar la vista de creación de cuenta
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
                $usuario = Usuario::where('email', $usuario->email);
                if ($usuario && $usuario->confirmado) {
                    // Generar un nuevo token
                    $usuario->crearToken();
                    unset($usuario->password2);
                    // Actualizar el usuario
                    $usuario->guardar();
                    // Enviar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                     // Imprimir la alerta
                    $alertas['success'][] = 'Hemos enviado las instrucciones a tu email';
                    //Usuario::setAlerta('success', 'Hemos enviado las instrucciones a tu email');
                } else {
                    $alertas['danger'][] = 'El Usuario no existe o no esta confirmado';
                    //Usuario::setAlerta('danger', 'El Usuario no existe o no está confirmado');
                   
                }
            }
        }

        // Muestra la vista
        $router->render('auth/olvide', [
            'title' => 'Olvidé mi Contraseña',
            'alertas' => $alertas
        ], 'layout' );
    }

    public static function reestablecer(Router $router)
    {
        $token = s($_GET['token']);
        $token_valido = true;

        if (!$token) {
            header('Location: /login');
            exit();
        }

        // Identificar el usuario con este token
        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            $alertas['danger'][] = 'Token No Válido, intenta de nuevo';
            //Usuario::setAlerta('danger', 'Token No Válido, intenta de nuevo');
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
                $usuario->token = null;

                // Guardar el usuario en la BD
                $resultado = $usuario->guardar();

                if ($resultado) {
                    header('Location: /login');
                    exit();
                }
            }
        }

        $alertas = Usuario::getAlertas();

        // Muestra la vista
        $router->render('auth/reestablecer', [
            'title' => 'Reestablecer Contraseña',
            'alertas' => $alertas,
            'token_valido' => $token_valido
        ], 'layout' );
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
        $token = s($_GET['token']);

        if (!$token) {
            header('Location: /');
            exit();
        }

        // Encontrar al usuario con este token
        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            $alertas['danger'][] = 'Token No Válido, la cuenta no se confirmo';
            //Usuario::setAlerta('danger', 'Token No Válido, la cuenta no se confirmo');
        } else {
            // Confirmar la cuenta
            $usuario->confirmado = 1;
            $usuario->token = '';
            unset($usuario->password2);

            // Guardar en la BD
            $usuario->guardar();

            Usuario::setAlerta('success', 'Cuenta confirmada Exitosamente!');
            
            $alertas = $usuario->getAlertas();
        }
        $router->render('auth/confirmar', [
            'title' => 'Confirma tu cuenta',
            'alertas' => $alertas
        ], 'layout' );
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
            header('Location: /');
            exit();
        }
    }
}