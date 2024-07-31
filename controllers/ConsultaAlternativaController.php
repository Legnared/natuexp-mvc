<?php

namespace Controllers;

use Model\ConsultaAlternativa;
use Model\Usuario;
use MVC\Router;

class ConsultaAlternativaController
{
    public static function index(Router $router)
    {
        session_start();
        isAuth();
        $id = $_SESSION['id'];
        $alertas = [];
        $pacientes = ConsultaAlternativa::belongsTo('usuario_id', $id);

        // Usa el layout admin-layout.php para vistas en la carpeta admin
        $router->render('admin/consulta_terapia_alternativa/index', [
            'titulo' => 'Consulta',
            'alertas' => $alertas,
            'pacientes' => $pacientes
        ], 'admin-layout');
    }

    public static function crear(Router $router)
    {
        session_start();
        isAuth();
        $alertas = [];
        if (!is_admin()) {
            header('Location: /admin/dashboard/index');
            exit();
        }

        $paciente = new ConsultaAlternativa();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /admin/dashboard/index');
                exit();
            }
            $paciente = new ConsultaAlternativa($_POST);
            $paciente->sincronizar($_POST);

            if (!empty($_FILES['expediente_file']['tmp_name'])) {
                $fileTmpPath = '../public/docs/consult/';
                if (!is_dir($fileTmpPath)) {
                    mkdir($fileTmpPath, 0777, true);
                }
                $extension = explode('.', $_FILES['expediente_file']['name']);
                $new_name = md5(uniqid(rand(), true)) . '.' . $extension[1];
                $destination = '../public/docs/consult/' . $new_name;
                $extension = pathinfo($new_name, PATHINFO_EXTENSION);
                $file = $_FILES['expediente_file']['tmp_name'];
                if (!in_array($extension, ['zip', 'pdf', 'docx', 'doc'])) {
                    ConsultaAlternativa::setAlerta('error', 'Los archivos deben ser en formato .zip, .pdf, .doc o .docx!');
                    $alertas = $paciente->getAlertas();
                } elseif ($_FILES['expediente_file']['size'] > 1000000) {
                    ConsultaAlternativa::setAlerta('error', 'Archivo muy grande, debe pesar menos de 1 Megabyte');
                    $alertas = $paciente->getAlertas();
                } else {
                    if (move_uploaded_file($file, $destination)) {
                        $_POST['expediente_file'] = $new_name;
                    }
                }
            }
            $paciente->sincronizar($_POST);
            $alertas = $paciente->validar();
            if (empty($alertas)) {
                $hash = md5(uniqid());
                $paciente->url_avance = $hash;
                date_default_timezone_set('America/Mexico_City');
                $paciente->fecha_creacion = date_create()->format('Y-m-d H:i:s');
                $paciente->usuario_id = $_SESSION['id'];
                ConsultaAlternativa::setAlerta('exito', 'Paciente Registrado Correctamente!');
                $alertas = $paciente->getAlertas();
                $paciente->guardar();
            } else {
                ConsultaAlternativa::setAlerta('error', 'Paciente No Registrado');
                $alertas = $paciente->getAlertas();
            }
        }

        $router->render('admin/consulta_terapia_alternativa/crear', [
            'alertas' => $alertas,
            'titulo' => 'Agregar Paciente'
        ], 'admin-layout');
    }

    public static function consulta(Router $router)
    {
        session_start();
        isAuth();
        if (!is_admin()) {
            header('Location: /admin/dashboard/index');
            exit();
        }
        $token = $_GET['id'];
        if (!$token) {
            header('Location: /dashboard');
            exit();
        }
        $pacientes = ConsultaAlternativa::where('url_avance', $token);
        $usuario = Usuario::find($_SESSION['id']);
        if ($pacientes->usuario_id !== $_SESSION['id']) {
            header('Location: /dashboard');
            exit();
        }

        $router->render('admin/consulta/index', [
            'titulo' => 'Diagnóstico del Paciente',
            'nombre_paciente' => $pacientes->nombre . " " . $pacientes->apellidos,
            'edad' => $pacientes->edad,
            'sexo' => $pacientes->sexo,
            'peso' => $pacientes->peso,
            'estatura' => $pacientes->estatura,
            'diabetes' => $pacientes->diabetes,
            'tratamiento' => $pacientes->tratamiento,
            'sintoma_diagnostico' => $pacientes->sintoma_diagnostico,
            'resultado_corazon' => $pacientes->r_corazon,
            'resultado_rinon' => $pacientes->r_rinon,
            'resultado_cerebro' => $pacientes->r_cerebro,
            'resultado_estomago' => $pacientes->r_estomago,
            'resultado_huesos' => $pacientes->r_huesos,
            'medico' => $usuario
        ], 'admin-layout');
    }

    public static function editar(Router $router)
    {
        session_start();
        isAuth();
        $alertas = [];
        if (!is_admin()) {
            header('Location: /admin/dashboard/index');
            exit();
        }
        $paciente = new ConsultaAlternativa();

        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: /admin/consulta_terapia_alternativa');
            exit();
        }
        $paciente = ConsultaAlternativa::find($id);

        if (!$paciente) {
            header('Location: /admin/consulta_terapia_alternativa');
            exit();
        }

        $paciente->expediente_actual = $paciente->expediente_file;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /admin/dashboard/index');
                exit();
            }
            $fileTmpPath = '../public/docs/consult/';
            if (!is_dir($fileTmpPath)) {
                mkdir($fileTmpPath, 0777, true);
            }
            $extension = explode('.', $_FILES['expediente_file']['name']);
            $new_name = md5(uniqid(rand(), true)) . '.' . $extension[1];
            $destination = '../public/docs/consult/' . $new_name;
            $extension = pathinfo($new_name, PATHINFO_EXTENSION);
            $file = $_FILES['expediente_file']['tmp_name'];
            if (!in_array($extension, ['zip', 'pdf', 'docx', 'doc'])) {
                ConsultaAlternativa::setAlerta('error', 'Los archivos deben ser en formato .zip, .pdf, .doc o .docx!');
                $alertas = $paciente->getAlertas();
            } elseif ($_FILES['expediente_file']['size'] > 1000000) {
                ConsultaAlternativa::setAlerta('error', 'Archivo muy grande, debe pesar menos de 1 Megabyte');
                $alertas = $paciente->getAlertas();
            } else {
                if (move_uploaded_file($file, $destination)) {
                    $_POST['expediente_file'] = $new_name;
                } else {
                    $_POST['expediente_file'] = $paciente->expediente_actual;
                }
            }

            $paciente->sincronizar($_POST);
            $alertas = $paciente->validar();
            if (empty($alertas)) {
                date_default_timezone_set('America/Mexico_City');
                $paciente->fecha_modificacion = date_create()->format('Y-m-d H:i:s');
                $hash = md5(uniqid());
                $paciente->url_avance = $hash;
                $paciente->usuario_id = $_SESSION['id'];
                $paciente->guardar();
                ConsultaAlternativa::setAlerta('exito', 'Paciente Actualizado Correctamente!');
                $alertas = $paciente->getAlertas();
            } else {
                ConsultaAlternativa::setAlerta('error', 'Paciente No Actualizado');
                $alertas = $paciente->getAlertas();
            }
        }

        $router->render('admin/consulta_terapia_alternativa/editar', [
            'alertas' => $alertas,
            'titulo' => 'Actualizar Paciente',
            'paciente' => $paciente
        ], 'admin-layout');
    }

    public static function eliminar()
    {
        if (!is_admin()) {
            header('Location: /admin/dashboard/index');
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /admin/dashboard/index');
                exit();
            }
            $id = $_POST['id'];
            $paciente = ConsultaAlternativa::find($id);
            date_default_timezone_set('America/Mexico_City');
            $paciente->fecha_eliminacion = date_create()->format('Y-m-d H:i:s');

            if (!isset($paciente)) {
                header('Location: /admin/consulta_terapia_alternativa');
                exit();
            }
            $resultado = $paciente->eliminar();
            if ($resultado) {
                header('Location: /admin/consulta_terapia_alternativa');
                exit();
            }
        }
    }
}
