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
        $paciente = new Pacient(); // Instanciar el modelo Pacient
        $direccion = new Direccion(); // Instanciar el modelo Direccion
        $antecedentes = new AntecedentesMedicos(); // Instanciar el modelo AntecedentesMedicos
        $datosConsulta = new DatosConsulta(); // Instanciar el modelo DatosConsulta
        $consultas = new Consulta(); // Instanciar el modelo Consulta

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = array_map('htmlspecialchars', $_POST);
            $_POST['usuario_id'] = $_SESSION['id'];
            $_POST['url_avance'] = md5(uniqid(rand(), true));
            $_POST['fecha_creacion'] = date('Y-m-d H:i:s');
            $_POST['estatus'] = 1;

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
                    $resultado = $paciente->guardar();
                    if ($resultado) {
                        // Guardar antecedentes médicos
                        $antecedentes = new AntecedentesMedicos([
                            'paciente_id' => $paciente->id,
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
                                'paciente_id' => $paciente->id,
                                'calle' => $_POST['calle'],
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
                                'paciente_id' => $paciente->id,
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
                                'paciente_id' => $paciente->id,
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

                        $_SESSION['redirect'] = '/admin/expedientes'; // Asigna la URL de redirección
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
            exit;
        }

        $paciente = Pacient::findId($id);
        // debuguear($paciente, 'Paciente');

        if (!$paciente) {
            header('Location: /admin/pacientes');
            exit;
        }

        // Inicializar modelos relacionados
        $direccion = Direccion::findByPacienteId($id);
        $antecedentes = AntecedentesMedicos::findByPacienteId($id);
        $datosConsulta = DatosConsulta::findByPacienteId($id);
        $consultas = Consulta::findByPacienteId($id);

        // Convertir arrays a objetos si es necesario
        if (is_array($direccion)) {
            $direccion = new Direccion($direccion);
        }
        if (is_array($antecedentes)) {
            $antecedentes = new AntecedentesMedicos($antecedentes);
        }
        if (is_array($datosConsulta)) {
            $datosConsulta = new DatosConsulta($datosConsulta);
        }
        if (is_array($consultas)) {
            $consultas = new Consulta($consultas);
        }

        // debuguear($direccion, 'Direccion');
        // debuguear($antecedentes, 'Antecedentes');
        //debuguear($datosConsulta, 'DatosConsulta');
        //debuguear($consultas, 'Consultas');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = array_map('htmlspecialchars', $_POST);
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

            // debuguear($_POST, 'Datos POST');

            $paciente->sincronizar($_POST);
            $alertas = self::manejarArchivos($_FILES, $alertas);
            $alertas = array_merge($alertas, $paciente->validar());

            if (empty($alertas)) {
                try {
                    // Guardar paciente
                    $resultado = $paciente->guardar();
                    // debuguear($resultado, 'Resultado de guardar paciente');
                    
                    if ($resultado) {
                        // Actualizar antecedentes médicos
                        if ($antecedentes) {
                            $antecedentes->sincronizar([
                                'diabetes' => $_POST['diabetes'],
                                'cancer' => $_POST['cancer'],
                                'obesidad' => $_POST['obesidad'],
                                'infartos' => $_POST['infartos'],
                                'alergias' => $_POST['alergias'],
                                'depresion' => $_POST['depresion'],
                                'artritis' => $_POST['artritis'],
                                'estrenimiento' => $_POST['estrenimiento'],
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
                        } else {
                            // Crear antecedentes médicos si no existen
                            $antecedentes = new AntecedentesMedicos([
                                'paciente_id' => $paciente->id,
                                'diabetes' => $_POST['diabetes'],
                                'cancer' => $_POST['cancer'],
                                'obesidad' => $_POST['obesidad'],
                                'infartos' => $_POST['infartos'],
                                'alergias' => $_POST['alergias'],
                                'depresion' => $_POST['depresion'],
                                'artritis' => $_POST['artritis'],
                                'estrenimiento' => $_POST['estrenimiento'],
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
                        }

                        // Actualizar dirección
                        if (isset($_POST['calle'])) {
                            if ($direccion) {
                                $direccion->sincronizar([
                                    'calle' => $_POST['calle'],
                                    'numero_exterior' => $_POST['numero_exterior'],
                                    'numero_interior' => $_POST['numero_interior'],
                                    'colonia' => $_POST['colonia'],
                                    'municipio' => $_POST['municipio'],
                                    'estado' => $_POST['estado'],
                                    'codigo_postal' => $_POST['codigo_postal']
                                ]);
                                $direccion->guardar();
                            } else {
                                // Crear dirección si no existe
                                $direccion = new Direccion([
                                    'paciente_id' => $paciente->id,
                                    'calle' => $_POST['calle'],
                                    'numero_exterior' => $_POST['numero_exterior'],
                                    'numero_interior' => $_POST['numero_interior'],
                                    'colonia' => $_POST['colonia'],
                                    'municipio' => $_POST['municipio'],
                                    'estado' => $_POST['estado'],
                                    'codigo_postal' => $_POST['codigo_postal']
                                ]);
                                $direccion->guardar();
                            }
                        }

                        // Actualizar datos de consulta
                        if (isset($_POST['presion_arterial'])) {
                            if ($datosConsulta) {
                                $datosConsulta->sincronizar([
                                    'presion_arterial' => $_POST['presion_arterial'],
                                    'nivel_azucar' => $_POST['nivel_azucar'],
                                    'peso' => $_POST['peso'],
                                    'estatura' => $_POST['estatura'],
                                    'temperatura' => $_POST['temperatura']
                                ]);
                                $datosConsulta->guardar();
                            } else {
                                // Crear datos de consulta si no existen
                                $datosConsulta = new DatosConsulta([
                                    'paciente_id' => $paciente->id,
                                    'presion_arterial' => $_POST['presion_arterial'],
                                    'nivel_azucar' => $_POST['nivel_azucar'],
                                    'peso' => $_POST['peso'],
                                    'estatura' => $_POST['estatura'],
                                    'temperatura' => $_POST['temperatura']
                                ]);
                                $datosConsulta->guardar();
                            }
                        }

                        // Actualizar consulta
                        if (isset($_POST['motivo_consulta'])) {
                            if ($consultas) {
                                $consultas->sincronizar([
                                    'motivo_consulta' => $_POST['motivo_consulta'],
                                    'tratamiento_sugerido' => $_POST['tratamiento_sugerido'] ?? '',
                                    'tiempo_tratamiento_clinico' => $_POST['tiempo_tratamiento_clinico'] ?? '',
                                    'diagnostico' => $_POST['diagnostico'] ?? '',
                                    'observaciones' => $_POST['observaciones'] ?? '',
                                    'tiempo_tratamiento_sugerido' => $_POST['tiempo_tratamiento_sugerido'] ?? '',
                                    'dosis_tratamiento' => $_POST['dosis_tratamiento'] ?? ''
                                ]);
                                $consultas->guardar();
                            } else {
                                // Crear consulta si no existe
                                $consultas = new Consulta([
                                    'paciente_id' => $paciente->id,
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
                        }

                        // Redirigir a la lista de pacientes
                        header('Location: /admin/expedientes');
                        exit;
                    }
                } catch (Exception $e) {
                    debuguear($e->getMessage(), 'Error');
                    $alertas['danger'][] = 'Ocurrió un error al guardar la información.';
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
                        Pacient::setAlert('error', 'El archivo es demasiado grande');
                    } else {
                        move_uploaded_file($fileTmpName, $destination);
                        $_POST['expediente_file'] = $newFileName;
                    }
                } else {
                    $alertas['danger'][] = 'Tipo de archivo no permitido';
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
            header('Location: /admin/expedientes');
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
                header('Location: /admin/expedientes');
            } else {
                // Maneja el caso en que no se encuentra el paciente
                $alertas['danger'][] = 'Paciente no encontrado.';
            }
        }
    
        // Renderiza la vista para confirmar eliminación
        $router->render('admin/expedientes', [
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
