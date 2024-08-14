<?php

namespace Controllers;

use Model\Paciente;
use Model\Cita; 
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

        $usuario_id = $_SESSION['id'];
        $alertas = [];

        // Obtener el número total de citas del usuario
        $totalCitas = Cita::countByColumn('citas', 'paciente_id', $usuario_id);

        // Obtener el número total de pacientes
        $pacientes = Paciente::pacientesPorUsuario($usuario_id);
        $totalPacientes = count($pacientes);

        $router->render('admin/dashboard/index', [
            'titulo' => 'Panel de Administración',
            'subtitulo' => 'Revisión Médica',
            'pacientes' => $pacientes,
            'totalPacientes' => $totalPacientes,
            'totalCitas' => $totalCitas // Pasar el conteo de citas
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

            // Obtener y validar los datos de metros y centímetros
            $metros = isset($_POST['metros']) ? $_POST['metros'] : '0';
            $centimetros = isset($_POST['centimetros']) ? $_POST['centimetros'] : '0';

            if (!is_numeric($metros) || !is_numeric($centimetros)) {
                $alertas['danger'][] = 'Los valores de metros y centímetros deben ser numéricos.';
            } else {
                $metros = floatval($metros);
                $centimetros = floatval($centimetros);
                $estatura = $metros + ($centimetros / 100);
                $_POST['estatura'] = $estatura;
            }

            $_POST['usuario_id'] = $_SESSION['id'];
            $_POST['url_avance'] = md5(uniqid(rand(), true));
            $_POST['fecha_creacion'] = date('Y-m-d H:i:s');

            $checkboxes = ['diabetes', 'cancer', 'obesidad', 'infartos', 'alergias', 'depresion', 'artritis', 'estrenimiento', 'gastritis', 'comida_chatarra', 'fumas', 'bebes', 'cirugias', 'embarazos', 'abortos'];
            foreach ($checkboxes as $checkbox) {
                $_POST[$checkbox] = isset($_POST[$checkbox]) ? 1 : 0;
            }

            $paciente = new Paciente($_POST);
            $paciente->sincronizar($_POST);

            // Manejo de archivo
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
                    $alertas['success'][] = 'Paciente creado correctamente!';
                    $_SESSION['redirect'] = '/admin/pacientes';
                    // No hagas la redirección inmediata
                } else {
                    $alertas['danger'][] = 'El Paciente no se registró correctamente!';
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

            // Obtener y validar los datos de metros y centímetros
            $metros = isset($_POST['metros']) ? $_POST['metros'] : '0';
            $centimetros = isset($_POST['centimetros']) ? $_POST['centimetros'] : '0';

            if (!is_numeric($metros) || !is_numeric($centimetros)) {
                $alertas['danger'][] = 'Los valores de metros y centímetros deben ser numéricos.';
            } else {
                $metros = floatval($metros);
                $centimetros = floatval($centimetros);
                $estatura = $metros + ($centimetros / 100);
                $_POST['estatura'] = $estatura;
            }

            // Asignar los valores al paciente
            $paciente->metros = $metros;
            $paciente->centimetros = $centimetros;
            $paciente->estatura = $estatura;

            $checkboxes = ['diabetes', 'cancer', 'obesidad', 'infartos', 'alergias', 'depresion', 'artritis', 'estrenimiento', 'gastritis', 'comida_chatarra', 'fumas', 'bebes', 'cirugias', 'embarazos', 'abortos'];
            foreach ($checkboxes as $checkbox) {
                $_POST[$checkbox] = isset($_POST[$checkbox]) ? 1 : 0;
            }

            // Fecha de modificación
            $_POST['fecha_modificacion'] = date('Y-m-d H:i:s');

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
                    $_SESSION['redirect'] = '/admin/pacientes';
                    // No hagas la redirección inmediata
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
             // Fecha de eliminación
            $paciente->fecha_eliminacion = date('Y-m-d H:i:s');
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