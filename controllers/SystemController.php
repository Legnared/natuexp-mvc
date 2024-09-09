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
        // Verificar acceso con roles permitidos y excluidos
        $roles_permitidos = [1, 2, 3]; // Por ejemplo, rol de administrador
        $roles_excluidos = [4, 5, 6, 7, 8];  // Por ejemplo, rol excluido (usuario regular)

        if (!tiene_acceso($roles_permitidos, $roles_excluidos)) {
            header('Location: /login');
            exit();
        }
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
                    $alertas['danger'][] = 'Email no válido, ya pertenece a otra cuenta';
                } else {
                    $usuario->guardar();
                    $alertas['success'][] = 'Datos Actulizados y Guardados Correctamente!';
                    
                    // Combinar las alertas nuevas con las existentes
                    $alertas = array_merge_recursive($alertas, $usuario->getAlertas());
                    
                    $_SESSION['nombre'] = $usuario->nombre;
                    $_SESSION['apellido'] = $usuario->apellido;
                }
            }
        }
        
        $router->render('admin/system/perfil/index', [
            'titulo' => 'Perfil',
            'usuario' => $usuario,
            'alertas' => $alertas
        ], 'admin-layout');
    }


    public static function cambiarPassword(Router $router) {
        session_start();
        // Verificar acceso con roles permitidos y excluidos
        $roles_permitidos = [1, 2, 3]; // Por ejemplo, rol de administrador
        $roles_excluidos = [4, 5, 6, 7, 8];  // Por ejemplo, rol excluido (usuario regular)

        if (!tiene_acceso($roles_permitidos, $roles_excluidos)) {
            header('Location: /login');
            exit();
        }
        $alertas = [];
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = Usuario::find($_SESSION['id']);
            $usuario->sincronizar($_POST);
    
            // Validar la nueva contraseña
            $alertas = $usuario->nuevo_password();
    
            if (empty($alertas)) {
                // Verificar la contraseña actual
                if ($usuario->comprobar_password()) {
                    // Asignar la nueva contraseña y hashearla
                    $usuario->password = $usuario->password_nuevo;
                    $usuario->hashPassword();
    
                    // Guardar el cambio
                    if ($usuario->guardar()) {
                        $alertas['success'][] = 'Password Guardado Correctamente!';
                    } else {
                        $alertas['danger'][] = 'Error al guardar la nueva contraseña';
                    }
                } else {
                    $alertas['danger'][] = 'Password Incorrecto';
                }
            }
        }
    
        // Renderizar la vista con las alertas
        $router->render('admin/system/perfil/cambiar-password', [
            'titulo' => 'Cambiar Password',
            'alertas' => $alertas
        ], 'admin-layout');
    }
    

    public static function cambiarFoto(Router $router)
    {
        session_start();
        // Verificar acceso con roles permitidos y excluidos
        $roles_permitidos = [1, 2, 3]; // Por ejemplo, rol de administrador
        $roles_excluidos = [4, 5, 6, 7, 8];  // Por ejemplo, rol excluido (usuario regular)

        if (!tiene_acceso($roles_permitidos, $roles_excluidos)) {
            header('Location: /login');
            exit();
        }
        $alertas = [];
        $usuario = Usuario::find($_SESSION['id']);
        $usuario->foto_actual = $usuario->foto;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            if (!empty($_FILES['foto']['tmp_name'])) {
                $carpeta_imagenes = '../public/img/users/';
                if (!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0777, true);
                }

                $imagen_png = Image::make($_FILES['foto']['tmp_name'])->fit(800, 800)->encode('png', 80);
                $imagen_webp = Image::make($_FILES['foto']['tmp_name'])->fit(800, 800)->encode('webp', 80);
                $imagen_jpg = Image::make($_FILES['foto']['tmp_name'])->fit(800, 800)->encode('jpg', 80);
                $foto_perfil = md5(uniqid(rand(), true));
                $_POST['foto'] = $foto_perfil;
            } else {
                $_POST['foto'] = $usuario->foto_actual;
            }
            $usuario->sincronizar($_POST);

            if (empty($alertas)) {
                $imagen_png->save($carpeta_imagenes . '/' . $foto_perfil . ".png");
                $imagen_jpg->save($carpeta_imagenes . '/' . $foto_perfil . ".jpg");
                $imagen_webp->save($carpeta_imagenes . '/' . $foto_perfil . ".webp");
                $resultado = $usuario->guardar();
                if ($resultado) {
                    $alertas['success'][] = 'Foto de Perfil Guardada Correctamente!';
                    $alertas = $usuario->getAlertas();
                    $_SESSION['foto'] = $usuario->foto;
                } else {
                    $alertas['danger'][] = 'Foto de Perfil No Guardada';
                    $alertas = $usuario->getAlertas();
                }
            }
        }

        $router->render('admin/system/perfil/cambiar-foto', [
            'titulo' => 'Cambiar Foto de Perfil',
            'usuario' => $usuario,
            'alertas' => $alertas
        ], 'admin-layout');
    }

    public static function configuracion(Router $router)
    {
        session_start();
        // Verificar acceso con roles permitidos y excluidos
        $roles_permitidos = [1, 2, 3]; // Por ejemplo, rol de administrador
        $roles_excluidos = [4, 5, 6, 7, 8];  // Por ejemplo, rol excluido (usuario regular)

        if (!tiene_acceso($roles_permitidos, $roles_excluidos)) {
            header('Location: /login');
            exit();
        }
        // Aquí iría la lógica para manejar la configuración del sistema
        $router->render('admin/system/configuracion/index', [
            'titulo' => 'Configuración'
        ], 'admin-layout');
    }

    public static function gestionUsuarios(Router $router)
    {
        session_start();
        // Verificar acceso con roles permitidos y excluidos
        $roles_permitidos = [1, 2, 3]; // Por ejemplo, rol de administrador
        $roles_excluidos = [4, 5, 6, 7, 8];  // Por ejemplo, rol excluido (usuario regular)

        if (!tiene_acceso($roles_permitidos, $roles_excluidos)) {
            header('Location: /login');
            exit();
        }
        // Aquí iría la lógica para manejar la gestión de usuarios
        $router->render('admin/system/usuarios/index', [
            'titulo' => 'Gestión de Usuarios'
        ], 'admin-layout');
    }


    public static function logs(Router $router)
    {
        session_start();
        // Verificar acceso con roles permitidos y excluidos
        $roles_permitidos = [1, 2, 3]; // Por ejemplo, rol de administrador
        $roles_excluidos = [4, 5, 6, 7, 8];  // Por ejemplo, rol excluido (usuario regular)

        if (!tiene_acceso($roles_permitidos, $roles_excluidos)) {
            header('Location: /login');
            exit();
        }
        // Aquí iría la lógica para manejar los logs del sistema
        $router->render('admin/system/logs/index', [
            'titulo' => 'Logs del Sistema'
        ], 'admin-layout');
    }

    public static function respaldo(Router $router)
    {
        session_start();
        // Verificar acceso con roles permitidos y excluidos
        $roles_permitidos = [1, 2, 3]; // Por ejemplo, rol de administrador
        $roles_excluidos = [4, 5, 6, 7, 8];  // Por ejemplo, rol excluido (usuario regular)

        if (!tiene_acceso($roles_permitidos, $roles_excluidos)) {
            header('Location: /login');
            exit();
        }
        // Aquí iría la lógica para manejar el respaldo de datos
        $router->render('admin/system/backup/index', [
            'titulo' => 'Respaldo de Datos'
        ], 'admin-layout');
    }

    public static function notificaciones(Router $router)
    {
        session_start();
        // Verificar acceso con roles permitidos y excluidos
        $roles_permitidos = [1, 2, 3]; // Por ejemplo, rol de administrador
        $roles_excluidos = [4, 5, 6, 7, 8];  // Por ejemplo, rol excluido (usuario regular)

        if (!tiene_acceso($roles_permitidos, $roles_excluidos)) {
            header('Location: /login');
            exit();
        }
        // Aquí iría la lógica para manejar las notificaciones del sistema
        $router->render('admin/system/notificaciones/index', [
            'titulo' => 'Notificaciones'
        ], 'admin-layout');
    }
}
