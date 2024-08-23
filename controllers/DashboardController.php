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
        // Verificar si el usuario tiene permisos de administrador
        if (!is_admin()) {
            header('Location: /login');
            exit();
        }

        $usuario_id = $_SESSION['id'];
        $alertas = [];

        // Obtener el número total de citas del usuario
        $totalCitas = Cita::countByColumn('citas', 'paciente_id', $usuario_id);

        // Obtener el número total de pacientes
        $pacientes = Paciente::pacientesPorUsuario($usuario_id);
        $totalPacientes = count($pacientes);

        // Obtener el número de citas por semana
        $citasPorSemana = Cita::citasPorSemana($usuario_id);

        $router->render('admin/dashboard/index', [
            'titulo' => 'Panel de Administración',
            'subtitulo' => 'Revisión Médica',
            'pacientes' => $pacientes,
            'totalPacientes' => $totalPacientes,
            'totalCitas' => $totalCitas,
            'citasPorSemana' => $citasPorSemana
        ], 'admin-layout');
    }


    public static function expediente(Router $router)
    {
        session_start();
        // Verificar si el usuario tiene permisos de administrador
        if (!is_admin()) {
            header('Location: /login');
            exit();
        }

        $id = $_SESSION['id'];
        $alertas = [];
        
        $pacientes = Paciente::pacientesPorUsuario($id);

        $router->render('admin/pacientes/index', [
            'alertas' => $alertas,
            'titulo' => 'Listado de Pacientes',
            'pacientes' => $pacientes
        ], 'admin-layout');
    }

    public static function crear(Router $router) {
        session_start();
        // Verificar si el usuario tiene permisos de administrador
        if (!is_admin()) {
            header('Location: /login');
            exit();
        }
    
        $alertas = [];
        $generos = Sexo::all('ASC'); // Obtener todos los géneros disponibles
        $paciente = new Paciente();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitizar datos de entrada
            $_POST = array_map('htmlspecialchars', $_POST);
    
            // Asignar valores adicionales
            $_POST['usuario_id'] = $_SESSION['id'];
            $_POST['url_avance'] = md5(uniqid(rand(), true));
            $_POST['fecha_creacion'] = date('Y-m-d H:i:s');
            $_POST['estatus'] = 1; // Establecer estatus como activo
    
            // Manejo de checkboxes
            $checkboxes = [
                'diabetes', 'cancer', 'obesidad', 'infartos', 'alergias', 
                'depresion', 'artritis', 'estrenimiento', 'gastritis', 
                'comida_chatarra', 'fumas', 'bebes', 'cirugias', 'embarazos', 'abortos'
            ];
            foreach ($checkboxes as $checkbox) {
                $_POST[$checkbox] = isset($_POST[$checkbox]) ? 1 : 0;
            }
    
            // Manejo de archivos
            $alertas = self::manejarArchivos($_FILES, $alertas);
    
            // Sincronizar datos del paciente
            $paciente->sincronizar($_POST);
    
            // Validar datos del paciente
            $alertas = array_merge($alertas, $paciente->validar());
    
            if (empty($alertas)) {
                try {
                    $resultado = $paciente->guardar();
                    if ($resultado) {
                        $_SESSION['redirect'] = '/admin/pacientes'; // Asigna la URL de redirección
                        $alertas['success'][] = 'Paciente creado correctamente!, espere 5 segundos serás redireccionado al Listado de Pacientes';
                        // No redirigir aquí; el redireccionamiento se maneja en la vista
                    } else {
                        $alertas['error'][] = 'El Paciente no se registró correctamente!';
                    }
                } catch (\Exception $e) {
                    $alertas['error'][] = 'Error al guardar el paciente: ' . $e->getMessage();
                }
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
        // Verificar si el usuario tiene permisos de administrador
        if (!is_admin()) {
            header('Location: /login');
            exit();
        }

        $alertas = [];
        $generos = Sexo::all('ASC');
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /admin/pacientes');
            exit;
        }

        $paciente = Paciente::findId($id);

        if (!$paciente) {
            header('Location: /admin/pacientes');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = array_map('htmlspecialchars', $_POST);

            // Manejo de estatura
            $_POST['estatura'] = isset($_POST['estatura']) ? floatval($_POST['estatura']) : 0;

            // Manejo de checkboxes
            $checkboxes = [
                'diabetes', 'cancer', 'obesidad', 'infartos', 'alergias',
                'depresion', 'artritis', 'estrenimiento', 'gastritis',
                'comida_chatarra', 'fumas', 'bebes', 'cirugias', 'embarazos', 'abortos'
            ];
            foreach ($checkboxes as $checkbox) {
                $_POST[$checkbox] = isset($_POST[$checkbox]) ? 1 : 0;
            }

            // Sincronizar datos del paciente
            $paciente->sincronizar($_POST);

            // Manejo de archivos
            $alertas = self::manejarArchivos($_FILES, $alertas);

            // Validación de los datos del paciente
            $alertas = array_merge($alertas, $paciente->validar());

            if (empty($alertas)) {
                if ($paciente->guardar()) {
                    $_SESSION['redirect'] = '/admin/pacientes'; // Asigna la URL de redirección
                    $alertas['success'][] = 'Paciente editado correctamente!, espere 5 segundos serás redireccionado al Listado de Pacientes';
                    // No redirigir aquí; el redireccionamiento se maneja en la vista
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
    
    private static function manejarArchivos($files, $alertas) {
        $fileTmpPath = '../public/docs/patients/';
        $imageTmpPath = '../public/img/patients/';
    
        if (!is_dir($fileTmpPath)) mkdir($fileTmpPath, 0777, true);
        if (!is_dir($imageTmpPath)) mkdir($imageTmpPath, 0777, true);
    
        if (!empty($files['expediente_file']['tmp_name'][0])) {
            foreach ($files['expediente_file']['tmp_name'] as $key => $tmp_name) {
                $fileName = $files['expediente_file']['name'][$key];
                $fileTmpName = $files['expediente_file']['tmp_name'][$key];
                $fileSize = $files['expediente_file']['size'][$key];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
                if (in_array($fileExtension, ['png', 'jpg', 'jpeg', 'webp'])) {
                    $newFileName = md5(uniqid(rand(), true));
                    $destination = $imageTmpPath . '/' . $newFileName . '.' . $fileExtension;
    
                    $imagen = Image::make($fileTmpName)->fit(800, 800)->encode($fileExtension, 80);
                    $imagen->save($destination);
    
                    $_POST['foto'] = $newFileName . '.' . $fileExtension;
                } elseif (in_array($fileExtension, ['pdf', 'doc', 'docx'])) {
                    $newFileName = md5(uniqid(rand(), true)) . '.' . $fileExtension;
                    $destination = $fileTmpPath . '/' . $newFileName;
    
                    if ($fileSize > 10000000) {
                        Paciente::setAlert('error', 'El archivo es demasiado grande');
                    } else {
                        move_uploaded_file($fileTmpName, $destination);
                        $_POST['expediente'] = $newFileName;
                    }
                } else {
                    $alertas['danger'][] = 'Archivo no permitido';
                }
            }
        }
    
        return $alertas;
    }

    
  
    public static function eliminar(Router $router)
    {
        session_start();
        is_admin();
        // Verificar si el usuario tiene permisos de administrador
        if (!is_admin()) {
        header('Location: /admin/dashboard/index');
        exit();
        }// Asegúrate de que el usuario esté autenticado
        $id = $_GET['id'] ?? null; // Usa null si no existe el parámetro
    
        // Verifica si el ID es válido
        if (!is_numeric($id)) {
            header('Location: /admin/pacientes');
            exit;
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Encuentra al paciente por ID
            $paciente = Paciente::find($id);
    
            if ($paciente) {
                // Establece la fecha de eliminación
                $paciente->fecha_eliminacion = date('Y-m-d H:i:s');
                // Llama al método eliminar
                $paciente->eliminar('estatus'); // Usa 'estatus' o el nombre de la columna que maneja el estado
                header('Location: /admin/pacientes');
            } else {
                // Maneja el caso en que no se encuentra el paciente
                $alertas['danger'][] = 'Paciente no encontrado.';
            }
        }
    
        // Renderiza la vista para confirmar eliminación
        $router->render('admin/pacientes', [
            'titulo' => 'Eliminar Paciente'
        ], 'site-layout');
    }
    

    public static function verExpediente(Router $router)
    {
        session_start();
        id_admin();
    
        // Verificar si el usuario tiene permisos de administrador
        if (!is_admin()) {
            header('Location: /login');
            exit();
        }
    
        // Obtener el token del parámetro de la URL
        $token = $_GET['id'] ?? null;
    
        // Verificar si el token es válido
        if (!$token) {
            header('Location: /dashboard');
            exit();
        }
    
        // Buscar al paciente usando el token
        $generos = Sexo::find($id); // Obtener todos los géneros disponibles
        $paciente = Paciente::findByUrlAvance($token);
    
        // Verificar si el paciente existe y pertenece al usuario autenticado
        if (!$paciente || ($paciente->usuario_id !== $_SESSION['id'] && !is_admin())) {
            header('Location: /dashboard');
            exit();
        }
    
        // Preparar los datos para la vista
        $router->render('admin/receta_medica/ver', [
            'titulo' => 'Ver Expediente',
            'nombre_paciente' => $paciente->nombre . " " . $paciente->apellidos,
            'edad' => $paciente->edad,
            'sexo' => $paciente->sexo,
            'peso' => $paciente->peso,
            'estatura' => $paciente->estatura,
            'motivo_consulta' => $paciente->motivo_consulta,
            'diagnostico' => $paciente->diagnostico,
            'tratamiento_sujerido' => $paciente->tratamiento_sujerido,
            'dosis_tratamiento' => $paciente->dosis_tratamiento
        ], 'admin-layout');
    }
    


    public static function cita_programada(Router $router) {
        session_start();
        is_admin();
        // Verificar si el usuario tiene permisos de administrador
        if (!is_admin()) {
        header('Location: /admin/dashboard/index');
        exit();
        }
    
        // Obtener todas las citas programadas
        $citas = CitaMedica::todas();
    
        $router->render('admin/cita_programada/index', [
            'titulo' => 'Citas Programadas desde el Sitio',
            'citas' => $citas
        ], 'admin-layout');
    }
    
    
}