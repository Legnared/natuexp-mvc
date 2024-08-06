<?php
namespace Controllers;

use MVC\Router;
use Model\Usuario;
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
                $usuario = Usuario::where('email', $usuario->email);

                if (!$usuario || !$usuario->confirmado) {
                    Usuario::setAlerta('danger', 'El Usuario No Existe o no está confirmado');
                } else {
                    // El Usuario existe, verificar contraseña
                    if (password_verify($_POST['password'], $usuario->password)) {
                        // Iniciar la sesión
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['apellido'] = $usuario->apellido;
                        $_SESSION['telefono'] = $usuario->telefono;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['foto'] = $usuario->foto;
                        $_SESSION['perfil'] = $usuario->perfil ?? null;
                        $_SESSION['login'] = true;

                        // Debug para verificar la sesión
                        //debuguear($_SESSION);

                        // Redireccionar
                        header('Location: /admin/dashboard');
                        exit();
                    } else {
                        
                        Usuario::setAlerta('danger', 'Contraseña Incorrecta');
                    }
                }
            }
        }

        $alertas = Usuario::getAlertas();

        // Render a la vista
        $router->render('auth/login', [
            'title' => 'Iniciar Sesión',
            'sitio' => 'www.natuexp.com',
            'alertas' => $alertas
        ], 'layout');
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

    public static function crear(Router $router) {
        $alertas = [];
        $usuario = new Usuario;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);

            $alertas = $usuario->validar_cuenta();

            if (empty($alertas)) {
                $existeUsuario = Usuario::where('email', $usuario->email);

                if ($existeUsuario) {
                    
                    Usuario::setAlerta('danger', 'El Usuario ya está registrado');
                    $alertas = Usuario::getAlertas();
                } else {
                    // Hashear el password
                    $usuario->hashPassword();

                    // Eliminar password2
                    unset($usuario->password2);

                    // Generar el Token
                    $usuario->crearToken();

                    // Crear un nuevo usuario
                    $usuario->fecha_creacion = date('Y-m-d H:i:s');
                    $resultado = $usuario->guardar();

                    // Enviar email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();

                    if ($resultado) {
                        header('Location: /mensaje');
                        exit();
                    }
                }
            }
        }

        // Render a la vista
        $router->render('auth/crear', [
            'title' => 'Crear Cuenta',
            'sitio' => 'www.natuexp.com',
            'usuario' => $usuario,
            'alertas' => $alertas
        ], 'layout' );
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
}
