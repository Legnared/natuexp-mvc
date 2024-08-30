<?php

namespace Controllers;

use Model\Pacient;
use Model\Consulta;
use Model\Direccion;
use Model\DatosConsulta;
use Model\AntecedentesMedicos;
use Model\Cita;
use Model\Sexo;
use MVC\Router;
use Intervention\Image\ImageManagerStatic as Image;

class ExpedienteController
{
    public static function index(Router $router) {
        session_start();
        if (!is_admin()) {
            header('Location: /login');
            exit();
        }
    
        $usuario_id = $_SESSION['id'];
        $alertas = [];
    
        $totalCitas = Cita::countByColumn('citas', 'paciente_id', $usuario_id);
        $pacientes = Pacient::pacientesPorUsuario($usuario_id);
    
        // Obtener consultas relacionadas con los pacientes
        $consultas = Consulta::consultasPorPacientes($pacientes);
    
        $totalPacientes = count($pacientes);
        $citasPorSemana = Cita::citasPorSemana($usuario_id);
    
        $router->render('admin/dashboard/index', [
            'titulo' => 'Panel de Administración',
            'subtitulo' => 'Revisión Médica',
            'pacientes' => $pacientes,
            'consultas' => $consultas,
            'totalPacientes' => $totalPacientes,
            'totalCitas' => $totalCitas,
            'citasPorSemana' => $citasPorSemana
        ], 'admin-layout');
    }
    

    public static function expediente(Router $router) {
        session_start();
        if (!is_admin()) {
            header('Location: /login');
            exit();
        }
    
        $usuario_id = $_SESSION['id'];
    
        $pacientes = Pacient::pacientesPorUsuario($usuario_id);
        $consultas = Consulta::consultasPorPacientes($pacientes);
    
        $router->render('admin/expedientes/index', [
            'titulo' => 'Listado de Pacientes a Consulta',
            'pacientes' => $pacientes,
            'consultas' => $consultas
        ], 'admin-layout');
    }
    
    
    public static function crear(Router $router)
    {
        session_start();
        if (!is_admin()) {
            header('Location: /login');
            exit();
        }
    
        $alertas = [];
        $generos = Sexo::all('ASC');
        $paciente = new Pacient(); 
        $direccion = new Direccion(); 
        $antecedentes = new AntecedentesMedicos(); 
        $datosConsulta = new DatosConsulta(); 
        $consultas = new Consulta(); 
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = array_map('htmlspecialchars', $_POST);
            $_POST['usuario_id'] = $_SESSION['id'];
            $_POST['url_avance'] = md5(uniqid(rand(), true));
            $_POST['fecha_creacion'] = date('Y-m-d H:i:s');
            $_POST['estatus'] = 1;
            $_POST['rol_id'] = 5; // Asignar automáticamente el rol de Paciente
    
            // Manejo de checkboxes
            $checkboxes = [
                'diabetes', 'cancer', 'obesidad', 'infartos', 'alergias',
                'depresion', 'artritis', 'estreñimiento', 'gastritis',
                'comida_chatarra', 'fumas', 'bebes', 'cirugias', 'embarazos', 'abortos'
            ];
            foreach ($checkboxes as $checkbox) {
                $_POST[$checkbox] = isset($_POST[$checkbox]) ? 1 : 0;
            }
    
            // Manejo de archivos
            $alertas = self::manejarArchivos($_FILES, $alertas);
            $paciente->sincronizar($_POST);
            $alertas = array_merge($alertas, $paciente->validar());
    
            if (empty($alertas)) {
                try {
                    // Guardar paciente
                    if ($paciente->guardar()) {
                        // Obtener el id del paciente guardado
                        $pacienteId = $paciente->id;
                        
                        // Guardar antecedentes médicos
                        $antecedentes = new AntecedentesMedicos([
                            'paciente_id' => $pacienteId,
                            'diabetes' => $_POST['diabetes'],
                            'cancer' => $_POST['cancer'],
                            'obesidad' => $_POST['obesidad'],
                            'infartos' => $_POST['infartos'],
                            'alergias' => $_POST['alergias'],
                            'depresion' => $_POST['depresion'],
                            'artritis' => $_POST['artritis'],
                            'estreñimiento' => $_POST['estreñimiento'],
                            'gastritis' => $_POST['gastritis'],
                            'comida_chatarra' => $_POST['comida_chatarra'],
                            'fumas' => $_POST['fumas'],
                            'bebes' => $_POST['bebes'],
                            'cirugias' => $_POST['cirugias'],
                            'embarazos' => $_POST['embarazos'],
                            'abortos' => $_POST['abortos'],
                            'num_cirugias' => $_POST['num_cirugias'] ?? null,
                            'desc_cirugias' => $_POST['desc_cirugias'] ?? '',
                            'num_embarazos' => $_POST['num_embarazos'] ?? null,
                            'num_abortos' => $_POST['num_abortos'] ?? null
                        ]);
                        $antecedentes->guardar();
                        
                        // Guardar dirección
                        if (isset($_POST['calle'])) {
                            $direccion = new Direccion([
                                'usuario_id' => $pacienteId,
                                'calle' => $_POST['calle'],
                                'pais' => $_POST['pais'],
                                'numero_exterior' => $_POST['numero_exterior'],
                                'numero_interior' => $_POST['numero_interior'],
                                'colonia' => $_POST['colonia'],
                                'municipio' => $_POST['municipio'],
                                'estado' => $_POST['estado'],
                                'codigo_postal' => $_POST['codigo_postal']
                            ]);
                            $direccion->guardar();
                        }
                        
                        // Guardar datos de consulta
                        if (isset($_POST['presion_arterial'])) {
                            $datosConsulta = new DatosConsulta([
                                'paciente_id' => $pacienteId,
                                'presion_arterial' => $_POST['presion_arterial'],
                                'nivel_azucar' => $_POST['nivel_azucar'],
                                'peso' => $_POST['peso'],
                                'estatura' => $_POST['estatura'],
                                'temperatura' => $_POST['temperatura']
                            ]);
                            $datosConsulta->guardar();
                        }
    
                        // Guardar consulta
                        if (isset($_POST['motivo_consulta'])) {
                            $consultas = new Consulta([
                                'paciente_id' => $pacienteId,
                                'motivo_consulta' => $_POST['motivo_consulta'],
                                'tratamiento_sugerido' => $_POST['tratamiento_sugerido'] ?? '',
                                'tiempo_tratamiento_clinico' => $_POST['tiempo_tratamiento_clinico'] ?? '',
                                'diagnostico' => $_POST['diagnostico'] ?? '',
                                'observaciones' => $_POST['observaciones'] ?? '',
                                'tiempo_tratamiento_sugerido' => $_POST['tiempo_tratamiento_sugerido'] ?? '',
                                'dosis_tratamiento' => $_POST['dosis_tratamiento'] ?? ''
                            ]);
                            $consultas->guardar();
                        }
    
                        $_SESSION['redirect'] = '/admin/expedientes'; 
                        $alertas['success'][] = 'Paciente creado correctamente!, espere 5 segundos serás redireccionado al Listado de Pacientes';
                    } else {
                        $alertas['error'][] = 'El Paciente no se registró correctamente!';
                    }
                } catch (\Exception $e) {
                    $alertas['error'][] = 'Error al guardar el paciente: ' . $e->getMessage();
                }
            }
        }
    
        $router->render('admin/expedientes/crear', [
            'alertas' => $alertas,
            'titulo' => 'Crear Paciente',
            'paciente' => $paciente,
            'generos' => $generos,
            'direccion' => $direccion,
            'antecedentes' => $antecedentes,
            'datosConsulta' => $datosConsulta,
            'consultas' => $consultas
        ], 'admin-layout');
    }
    
    

    
    public static function editar(Router $router)
    {
        session_start();
        if (!is_admin()) {
            header('Location: /login');
            exit();
        }
    
        $alertas = [];
        $generos = Sexo::all('ASC');
        $id = $_GET['id'] ?? null;
    
        if (!$id) {
            header('Location: /admin/pacientes');
            exit();
        }
    
        $paciente = Pacient::findId($id);
    
        if (!$paciente) {
            header('Location: /admin/pacientes');
            exit();
        }
    
        $direccion = Direccion::findByPacienteId($id) ?: new Direccion();
       
        $datosConsulta = DatosConsulta::findByPacienteId($id) ?: new DatosConsulta();
        $consultas = Consulta::findByPacienteId($id) ?: new Consulta();
        $antecedentes = AntecedentesMedicos::findByPacienteId($id) ?: new AntecedentesMedicos();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           // Sanitizar valores en $_POST
            $_POST = array_map(function($value) {
                return is_string($value) ? htmlspecialchars($value, ENT_QUOTES, 'UTF-8') : $value;
            }, $_POST);

            // Convertir checkboxes a 1 o 0
            $checkboxes = [
                'diabetes', 'cancer', 'obesidad', 'infartos', 'alergias',
                'depresion', 'artritis', 'estrenimiento', 'gastritis',
                'comida_chatarra', 'fumas', 'bebes', 'cirugias', 'embarazos', 'abortos'
            ];

    
            foreach ($checkboxes as $checkbox) {
                $_POST[$checkbox] = isset($_POST[$checkbox]) ? 1 : 0;
            }
    
            // Convertir campos adicionales a tipos adecuados
            $_POST['num_cirugias'] = isset($_POST['num_cirugias']) ? (int) $_POST['num_cirugias'] : null;
            $_POST['desc_cirugias'] = isset($_POST['desc_cirugias']) ? htmlspecialchars($_POST['desc_cirugias'], ENT_QUOTES, 'UTF-8') : '';
            $_POST['num_embarazos'] = isset($_POST['num_embarazos']) ? (int) $_POST['num_embarazos'] : null;
            $_POST['num_abortos'] = isset($_POST['num_abortos']) ? (int) $_POST['num_abortos'] : null;
    
            //debuguear($_POST);
            // Manejo de archivos
            $alertas = self::manejarArchivos($_FILES, $alertas);
    
            $paciente->sincronizar($_POST);
            $alertas = array_merge($alertas, $paciente->validar());
    
            if (empty($alertas)) {
                try {
                    $resultado = $paciente->guardar();
    
                    if ($resultado) {
                        // Sincronizar y guardar antecedentes médicos
                        $antecedentes->sincronizar($_POST);
                       
                        $antecedentes->guardar();
                        
                        
                        if (isset($_POST['calle'])) {
                            $direccion->sincronizar($_POST);
                            $direccion->guardar();
                        }
    
                        if (isset($_POST['presion_arterial'])) {
                            $datosConsulta->sincronizar($_POST);
                            $datosConsulta->guardar();
                        }
    
                        if (isset($_POST['motivo_consulta'])) {
                            $consultas->sincronizar($_POST);
                            $consultas->guardar();
                        }
    
                        $_SESSION['redirect'] = '/admin/expedientes'; 
                        $alertas['success'][] = 'Paciente actualizado correctamente, espera 5 segundos para ser redireccionado al Listado de Pacientes';
                    } else {
                        $alertas['error'][] = 'El Paciente no se actualizó correctamente!';
                    }
                } catch (\Exception $e) {
                    $alertas['error'][] = 'Error al guardar el paciente: ' . $e->getMessage();
                }
            }
        }
    
        $router->render('admin/expedientes/editar', [
            'alertas' => $alertas,
            'titulo' => 'Editar Paciente',
            'paciente' => $paciente,
            'generos' => $generos,
            'direccion' => $direccion,
            'antecedentes' => $antecedentes,
            'datosConsulta' => $datosConsulta,
            'consultas' => $consultas
        ], 'admin-layout');
    }
    
    


    private static function manejarArchivos($files, $alertas) {
        $fileTmpPath = '../public/docs/patients/';
        $imageTmpPath = '../public/img/patients/';
        
        if (!is_dir($fileTmpPath)) mkdir($fileTmpPath, 0777, true);
        if (!is_dir($imageTmpPath)) mkdir($imageTmpPath, 0777, true);
        
        $expedienteFileNames = [];
        $imagenFileNames = [];
    
        // Manejo de archivos de documentos
        if (!empty($files['documentos_file']['tmp_name'][0])) {
            foreach ($files['documentos_file']['tmp_name'] as $key => $tmp_name) {
                $fileName = $files['documentos_file']['name'][$key];
                $fileTmpName = $files['documentos_file']['tmp_name'][$key];
                $fileSize = $files['documentos_file']['size'][$key];
                $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    
                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
    
                if (in_array($fileExtension, ['pdf', 'doc', 'docx'])) {
                    if (move_uploaded_file($fileTmpName, $fileTmpPath . $newFileName)) {
                        $expedienteFileNames[] = $newFileName;
                    } else {
                        $alertas['error'][] = 'No se pudo subir el archivo ' . $fileName;
                    }
                } else {
                    $alertas['error'][] = 'Formato de archivo no soportado: ' . $fileName;
                }
            }
        }
    
        // Manejo de archivos de imágenes
        if (!empty($files['imagenes_file']['tmp_name'][0])) {
            foreach ($files['imagenes_file']['tmp_name'] as $key => $tmp_name) {
                $fileName = $files['imagenes_file']['name'][$key];
                $fileTmpName = $files['imagenes_file']['tmp_name'][$key];
                $fileSize = $files['imagenes_file']['size'][$key];
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
    
        // Aquí puedes guardar las rutas de los archivos en la base de datos
        // Por ejemplo, en un campo 'expediente_file' en la tabla de pacientes
        if (!empty($expedienteFileNames)) {
            $_POST['expediente_file'] = implode(',', $expedienteFileNames);
        }
        if (!empty($imagenFileNames)) {
            $_POST['foto'] = implode(',', $imagenFileNames);
        }
    
        return $alertas;
    }
    
    
    

    public static function eliminar(Router $router)
    {
        session_start();
        is_admin(); // Verifica que el usuario tenga permisos de administrador

        // Asegúrate de que el usuario esté autenticado
        if (!is_admin()) {
            header('Location: /admin/dashboard/index');
            exit();
        }

        $id = $_POST['id'] ?? null; // Usa POST para obtener el ID

        // Verifica si el ID es válido
        if (!is_numeric($id)) {
            header('Location: /admin/expedientes');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Encuentra al paciente por ID
            $paciente = Pacient::find($id);

            if ($paciente) {
                // Establece la fecha de eliminación
                $paciente->fecha_eliminacion = date('Y-m-d H:i:s');
                // Llama al método eliminar
                $paciente->eliminar('estatus'); // Usa 'estatus' o el nombre de la columna que maneja el estado
                header('Location: /admin/expedientes');
                exit();
            } else {
                // Maneja el caso en que no se encuentra el paciente
                $alertas['danger'][] = 'Paciente no encontrado.';
            }
        }
        
        // Renderizar la vista de edición con todos los datos cargados
        $router->render('admin/expedientes', [
            'titulo' => 'Eliminar Paciente',
            'alertas' => $alertas ?? [] // Pasa las alertas a la vista si existen
        ], 'admin-layout');
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
        $paciente = Pacient::findByUrlAvance($token);
    
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