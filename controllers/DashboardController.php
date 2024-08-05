<?php

namespace Controllers;

use Model\Paciente;
use Model\CitaMedica;
use Model\Sexo;
use Model\Usuario;
use MVC\Router;
use Intervention\Image\ImageManagerStatic as Image;

class DashboardController
{
    public static function index(Router $router)
    {
        session_start();
        isAuth();

        $router->render('admin/dashboard/index', [
            'titulo' => 'Panel de Administración',
            'subtitulo' => 'Revisión Médica'
        ], 'admin-layout');
    }

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
                    $alertas['danger'][] = 'Email no válido, ya pertenece a otra cuenta';
                   
                    $alertas = $usuario->getAlertas();
                } else {
                    $usuario->guardar();
                    $alertas['success'][] = 'Guardado Correctamente!';
                   
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

    public static function cambiarPassword(Router $router)
    {
        session_start();
        isAuth();
        $alertas = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = Usuario::find($_SESSION['id']);
            $usuario->sincronizar($_POST);
            $alertas = $usuario->nuevo_password();
            if (empty($alertas)) {
                $resultado = $usuario->comprobar_password();
                if ($resultado) {
                    $usuario->password = $usuario->password_nuevo;
                    unset($usuario->password_actual);
                    unset($usuario->password_nuevo);
                    $usuario->hashPassword();
                    $resultado = $usuario->guardar();
                    if ($resultado) {
                        $alertas['success'][] = 'Password Guardado Correctamente!';
                       
                        $alertas = $usuario->getAlertas();
                    }
                } else {
                    $alertas['danger'][] = 'Password Incorrecto';
                    $alertas = $usuario->getAlertas();
                }
            }
        }

        $router->render('admin/perfil/cambiar-password', [
            'titulo' => 'Cambiar Password',
            'alertas' => $alertas
        ], 'admin-layout');
    }

    public static function cambiarFoto(Router $router)
    {
        session_start();
        isAuth();
        $alertas = [];
        $usuario = Usuario::find($_SESSION['id']);
        $usuario->foto_actual = $usuario->foto;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            if (!empty($_FILES['foto']['tmp_name'])) {
                $carpeta_imagenes = '../public/img/photosperfil';
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

        $router->render('admin/perfil/cambiar-foto', [
            'titulo' => 'Cambiar Foto de Perfil',
            'usuario' => $usuario,
            'alertas' => $alertas
        ], 'admin-layout');
    }

    public static function expediente(Router $router)
    {
        session_start();
        isAuth();
        $id = $_SESSION['id'];
        $alertas = [];
        
        $pacientes = Paciente::pacientesPorUsuario($id);

        $router->render('admin/pacientes/index', [
            'alertas' => $alertas,
            'titulo' => 'Listado de Pacientes',
            'pacientes' => $pacientes
        ], 'admin-layout');
    }

    public static function crear(Router $router)
    {
        session_start();
        isAuth();
        $alertas = [];
        $generos = Sexo::all('ASC');
        
        $paciente = new Paciente();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = array_map(function ($item) {
                return htmlspecialchars($item, ENT_QUOTES, 'UTF-8');
            }, $_POST);

            $metros = $_POST['metros'];
            $centimetros = $_POST['centimetros'];
            $estatura = floatval($metros + ($centimetros / 100));
            $_POST['estatura'] = $estatura;
            $_POST['usuario_id'] = $_SESSION['id'];
            $_POST['url_avance'] = md5(uniqid(rand(), true));

            $checkboxes = ['diabetes', 'cancer', 'obesidad', 'infartos', 'alergias', 'depresion', 'artritis', 'estrenimiento', 'gastritis', 'comida_chatarra', 'fumas', 'bebes', 'cirugias', 'embarazos', 'abortos'];
            foreach ($checkboxes as $checkbox) {
                $_POST[$checkbox] = isset($_POST[$checkbox]) ? 1 : 0;
            }

            $paciente = new Paciente($_POST);
            $paciente->sincronizar($_POST);

            if (!empty($_FILES['expediente_file']['tmp_name'])) {
                $fileTmpPath = '../public/docs/patients/';
                if (!is_dir($fileTmpPath)) {
                    mkdir($fileTmpPath, 0777, true);
                }
                $extension = explode('.', $_FILES['expediente_file']['name']);
                $new_name = md5(uniqid(rand(), true)) . '.' . $extension[1];
                $destination = '../public/docs/patients/' . $new_name;
                $extension = pathinfo($new_name, PATHINFO_EXTENSION);
                $file = $_FILES['expediente_file']['tmp_name'];
                if (!in_array($extension, ['zip', 'pdf', 'docx', 'doc'])) {
                    Paciente::setAlerta('error', 'Los archivos deben ser en formato .zip, .pdf, .doc o .docx!');
                    $alertas = $paciente->getAlertas();
                } elseif ($_FILES['expediente_file']['size'] > 10000000) {
                    Paciente::setAlerta('error', 'El archivo excede el tamaño permitido de 10MB.');
                    $alertas = $paciente->getAlertas();
                } else {
                    move_uploaded_file($file, $destination);
                    $_POST['expediente_file'] = $new_name;
                    $paciente->expediente_file = $new_name;
                }
            } else {
                $paciente->expediente_file = '';
            }
            $alertas = $paciente->validar();

            if (empty($alertas)) {
                $resultado = $paciente->guardar();
                if ($resultado) {
                    $alertas['success'][] = 'Paciente Creado correctamente!';
                    //header('Location: admin/pacientes');
                } else {
                    $alertas['danger'][] = 'El Paciente no se registro correctamente!';
                }
            } else {
                $alertas = $paciente->getAlertas();
            }
        }

        $router->render('admin/pacientes/crear', [
            'alertas' => $alertas,
            'titulo' => 'Crear Paciente',
            'paciente' => $paciente,
            'generos' => $generos
        ], 'admin-layout');
    }

    public static function editar(Router $router)
    {
        session_start();
        isAuth();
        $alertas = [];
        $generos = Sexo::all('ASC');
        $id = $_GET['id'];

        $paciente = Paciente::find($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = array_map(function ($item) {
                return htmlspecialchars($item, ENT_QUOTES, 'UTF-8');
            }, $_POST);

            $metros = $_POST['metros'];
            $centimetros = $_POST['centimetros'];
            $estatura = floatval($metros + ($centimetros / 100));
            $_POST['estatura'] = $estatura;

            $checkboxes = ['diabetes', 'cancer', 'obesidad', 'infartos', 'alergias', 'depresion', 'artritis', 'estrenimiento', 'gastritis', 'comida_chatarra', 'fumas', 'bebes', 'cirugias', 'embarazos', 'abortos'];
            foreach ($checkboxes as $checkbox) {
                $_POST[$checkbox] = isset($_POST[$checkbox]) ? 1 : 0;
            }

            $paciente->sincronizar($_POST);

            if (!empty($_FILES['expediente_file']['tmp_name'])) {
                $fileTmpPath = '../public/docs/patients/';
                if (!is_dir($fileTmpPath)) {
                    mkdir($fileTmpPath, 0777, true);
                }
                $extension = explode('.', $_FILES['expediente_file']['name']);
                $new_name = md5(uniqid(rand(), true)) . '.' . $extension[1];
                $destination = '../public/docs/patients/' . $new_name;
                $extension = pathinfo($new_name, PATHINFO_EXTENSION);
                $file = $_FILES['expediente_file']['tmp_name'];
                if (!in_array($extension, ['zip', 'pdf', 'docx', 'doc'])) {
                    Paciente::setAlerta('error', 'Los archivos deben ser en formato .zip, .pdf, .doc o .docx!');
                    $alertas = $paciente->getAlertas();
                } elseif ($_FILES['expediente_file']['size'] > 10000000) {
                    Paciente::setAlerta('error', 'El archivo excede el tamaño permitido de 10MB.');
                    $alertas = $paciente->getAlertas();
                } else {
                    move_uploaded_file($file, $destination);
                    $_POST['expediente_file'] = $new_name;
                    $paciente->expediente_file = $new_name;
                }
            } else {
                $_POST['expediente_file'] = $paciente->expediente_file;
            }
            $alertas = $paciente->validar();

            if (empty($alertas)) {
                $resultado = $paciente->guardar();
                if ($resultado) {
                    $alertas['success'][] = 'Paciente editado correctamente!';
                   
                   // header('Location: admin/pacientes');
                } else {
                    $alertas['danger'][] = 'Error al editar paciente';
                }
            } else {
                $alertas = $paciente->getAlertas();
            }
        }

        $router->render('admin/pacientes/editar', [
            'alertas' => $alertas,
            'titulo' => 'Editar Paciente',
            'paciente' => $paciente,
            'generos' => $generos
        ], 'admin-layout');
    }

    public static function eliminar(Router $router)
    {
        session_start();
        isAuth();
        $id = $_GET['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $paciente = Paciente::find($id);
            $paciente->eliminar();
            header('Location: /dashboard/expediente');
        }
    }

    public static function verExpediente(Router $router)
    {
        session_start();
        isAuth();
        $id = $_GET['id'];
        $alertas = [];

        $paciente = Paciente::find($id);

        $router->render('admin/receta_medica/ver', [
            'alertas' => $alertas,
            'titulo' => 'Ver Expediente',
            'paciente' => $paciente
        ], 'admin-layout');
    }

    

    public static function cita_programada(Router $router) {
        session_start();
        isAuth();
    
        // Obtener todas las citas programadas
        $citas = CitaMedica::todas();
    
        $router->render('admin/cita_programada/index', [
            'titulo' => 'Citas Programadas desde el Sitio',
            'citas' => $citas
        ], 'admin-layout');
    }
    
    
}