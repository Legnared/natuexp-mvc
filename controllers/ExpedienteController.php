<?php

namespace Controllers;

use Model\Pacient;
use Model\Usuario;
use Model\Roles;
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
        // Verificar acceso con roles permitidos y excluidos
        $roles_permitidos = [1, 2, 3]; // Por ejemplo, rol de administrador
        $roles_excluidos = [4, 5, 6, 7, 8];  // Por ejemplo, rol excluido (usuario regular)

        if (!tiene_acceso($roles_permitidos, $roles_excluidos)) {
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
    
        // Verificar acceso con roles permitidos y excluidos
        $roles_permitidos = [1, 2, 3]; // Por ejemplo, rol de administrador y rol 3 específico
        $roles_excluidos = [4, 5, 6, 7, 8];  // Por ejemplo, rol excluido (usuario regular)
    
        if (!tiene_acceso($roles_permitidos, $roles_excluidos)) {
            header('Location: /login');
            exit();
        }
    
        $usuario_id = $_SESSION['id'];
        $usuario_rol = $_SESSION['rol_id']; // Obtener el rol del usuario
    
        if ($usuario_rol === 1 || $usuario_rol === 3) {
            // Si el usuario es un administrador o tiene rol 3, obtén todos los pacientes
            $pacientes = Pacient::all();
        } else {
            // Si el usuario no es administrador ni rol 3, obtén solo los pacientes asociados al usuario
            $pacientes = Pacient::pacientesPorUsuario($usuario_id);
        }
    
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
        // Verificar acceso con roles permitidos y excluidos
        $roles_permitidos = [1, 2, 3]; // Administrador, rol adicional
        $roles_excluidos = [4, 5, 6, 7, 8];  // Otros roles excluidos

        if (!tiene_acceso($roles_permitidos, $roles_excluidos)) {
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

         // Obtener usuarios según el rol actual
        if ($_SESSION['rol_id'] == 1 || $_SESSION['rol_id'] == 3) {
            // Roles 1 y 3 pueden ver todos los médicos y otros roles si es necesario
            $usuarios = Usuario::whereIn('rol_id', [2]);
        } elseif ($_SESSION['rol_id'] == 2) {
            // Rol 2 (médico) solo puede ver a sí mismo
            $usuarios = Usuario::where('id', $_SESSION['id']);
        }


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = array_map('htmlspecialchars', $_POST);
            $_POST['usuario_id'] = in_array($_SESSION['rol_id'], [1, 3]) ? ($_POST['usuario_id'] ?? null) : $_SESSION['id']; // Rol 1 o 3 puede seleccionar; otros usan su propio ID
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

            // Validar paciente
            $paciente->sincronizar($_POST);
            $alertas = array_merge($alertas, $paciente->validar());

            // Validar Dirección
            $direccion->sincronizar($_POST);
            $alertas = array_merge($alertas, $direccion->validar());

            // Validar antecedentes médicos
            $antecedentes->sincronizar($_POST);
            $alertas = array_merge($alertas, $antecedentes->validar());

            // Validar datos de consulta
            $datosConsulta->sincronizar($_POST);
            $alertas = array_merge($alertas, $datosConsulta->validar());

            // Validar consulta
            $consultas->sincronizar($_POST);
            $alertas = array_merge($alertas, $consultas->validar());

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
                        if (isset($_POST['pais']) && !empty($_POST['pais'])) {
                            $direccion = new Direccion([
                                'pais' => $_POST['pais'],
                                'calle' => $_POST['calle'],
                                'numero_exterior' => $_POST['numero_exterior'] ?? '',
                                'numero_interior' => $_POST['numero_interior'] ?? '',
                                'colonia' => $_POST['colonia'] ?? '',
                                'municipio' => $_POST['municipio'] ?? '',
                                'estado' => $_POST['estado'] ?? '',
                                'codigo_postal' => $_POST['codigo_postal'] ?? ''
                            ]);
                            $direccion->guardar();

                            // Asignar la dirección al paciente
                            $paciente->direccion_id = $direccion->id;
                            $paciente->guardar();
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
                        $alertas['success'][] = 'Paciente creado correctamente! Espera 5 segundos para ser redireccionado al Listado de Pacientes';
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
            'titulo' => 'Nuevo Paciente',
            'paciente' => $paciente,
            'generos' => $generos,
            'direccion' => $direccion,
            'antecedentes' => $antecedentes,
            'datosConsulta' => $datosConsulta,
            'consultas' => $consultas,
            'usuarios' => $usuarios,
            'esMedico' => $_SESSION['rol_id'] == 2
        ], 'admin-layout');
    }

    
    public static function editar(Router $router)
    {
        session_start();
        // Verificar acceso con roles permitidos y excluidos
        $roles_permitidos = [1, 2, 3]; // Administrador, rol adicional
        $roles_excluidos = [4, 5, 6, 7, 8];  // Otros roles excluidos

        if (!tiene_acceso($roles_permitidos, $roles_excluidos)) {
            header('Location: /login');
            exit();
        }

        $alertas = [];
        $generos = Sexo::all('ASC');
        $paciente = Pacient::find($_GET['id']);
        $direccion = Direccion::find($paciente->direccion_id ?? null);
        $antecedentes = AntecedentesMedicos::find($paciente->id);
        $datosConsulta = DatosConsulta::find($paciente->id);
        $consultas = Consulta::find($paciente->id);

      
          // Obtener usuarios según el rol actual
          if ($_SESSION['rol_id'] == 1 || $_SESSION['rol_id'] == 3) {
            // Roles 1 y 3 pueden ver todos los médicos y otros roles si es necesario
            $usuarios = Usuario::whereIn('rol_id', [2]);
        } elseif ($_SESSION['rol_id'] == 2) {
            // Rol 2 (médico) solo puede ver a sí mismo
            $usuarios = Usuario::where('id', $_SESSION['id']);
        }

        if (!$paciente) {
            header('Location: /admin/expedientes');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = array_map('htmlspecialchars', $_POST);
              // Ajustar el valor de usuario_id basado en el rol del usuario
            $_POST['usuario_id'] = in_array($_SESSION['rol_id'], [1, 3]) ? ($_POST['usuario_id'] ?? $paciente->usuario_id) : $_SESSION['id']; // Rol 1 o 3 puede seleccionar; otros usan su propio ID
        // Rol 1 o 3 puede seleccionar; otros usan su propio ID
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

            // Validar paciente
            $paciente->sincronizar($_POST);
            $alertas = array_merge($alertas, $paciente->validar());

            // Validar Dirección
            $direccion->sincronizar($_POST);
            $alertas = array_merge($alertas, $direccion->validar());

            // Validar antecedentes médicos
            $antecedentes->sincronizar($_POST);
            $alertas = array_merge($alertas, $antecedentes->validar());


            // Validar datos de consulta
            $datosConsulta->sincronizar($_POST);
            $alertas = array_merge($alertas, $datosConsulta->validar());

            // Validar consulta
            $consultas->sincronizar($_POST);
            $alertas = array_merge($alertas, $consultas->validar());

            if (empty($alertas)) {
                try {
                    // Actualizar paciente
                    if ($paciente->guardar()) {
                        // Actualizar antecedentes médicos
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

                        // Actualizar dirección
                        if (isset($_POST['pais']) && !empty($_POST['pais'])) {
                            $direccion = new Direccion([
                                'pais' => $_POST['pais'],
                                'calle' => $_POST['calle'],
                                'numero_exterior' => $_POST['numero_exterior'] ?? '',
                                'numero_interior' => $_POST['numero_interior'] ?? '',
                                'colonia' => $_POST['colonia'] ?? '',
                                'municipio' => $_POST['municipio'] ?? '',
                                'estado' => $_POST['estado'] ?? '',
                                'codigo_postal' => $_POST['codigo_postal'] ?? ''
                            ]);
                            $direccion->guardar();

                            // Asignar la dirección al paciente
                            $paciente->direccion_id = $direccion->id;
                            $paciente->guardar();
                        }

                        // Actualizar datos de consulta
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

                        // Actualizar consulta
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

                        $_SESSION['redirect'] = '/admin/expedientes'; 
                        $alertas['success'][] = 'Paciente editado correctamente! Espera 5 segundos para ser redireccionado al Listado de Pacientes';
                    } else {
                        $alertas['error'][] = 'El Paciente no se actualizó correctamente!';
                    }
                } catch (\Exception $e) {
                    $alertas['error'][] = 'Error al actualizar el paciente: ' . $e->getMessage();
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
            'consultas' => $consultas,
            'usuarios' => $usuarios,
            'esMedico' => $_SESSION['rol_id'] == 2
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
        // Verificar acceso con roles permitidos y excluidos
        $roles_permitidos = [1, 2, 3]; // Por ejemplo, rol de administrador
        $roles_excluidos = [4, 5, 6, 7, 8];  // Por ejemplo, rol excluido (usuario regular)

        if (!tiene_acceso($roles_permitidos, $roles_excluidos)) {
            header('Location: /login');
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
        // Verificar acceso con roles permitidos y excluidos
        $roles_permitidos = [1, 2, 3]; // Por ejemplo, rol de administrador
        $roles_excluidos = [4, 5, 6, 7, 8];  // Por ejemplo, rol excluido (usuario regular)

        if (!tiene_acceso($roles_permitidos, $roles_excluidos)) {
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
        // Verificar acceso con roles permitidos y excluidos
        $roles_permitidos = [1, 2, 3]; // Por ejemplo, rol de administrador
        $roles_excluidos = [4, 5, 6, 7, 8];  // Por ejemplo, rol excluido (usuario regular)

        if (!tiene_acceso($roles_permitidos, $roles_excluidos)) {
            header('Location: /login');
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