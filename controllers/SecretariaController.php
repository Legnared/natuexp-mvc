<?php

namespace Controllers;

use Model\Paciente;
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

class SecretariaController
{

    public static function index(Router $router) {
        session_start();
        // Verificar acceso con roles permitidos y excluidos
        $roles_permitidos = [3]; // Rol de secretaria u otro rol permitido
        $roles_excluidos = [1, 2, 4, 5, 6, 7, 8];  // Roles excluidos

        if (!tiene_acceso($roles_permitidos, $roles_excluidos)) {
            header('Location: /login');
            exit();
        }

        $usuario_id = $_SESSION['id'];
        $alertas = [];

        $totalCitas = Cita::countByColumn('citas', 'paciente_id', $usuario_id);
        $pacientes = Paciente::pacientesPorUsuario($usuario_id);

        // Obtener consultas relacionadas con los pacientes
        $consultas = Consulta::consultasPorPacientes($pacientes);

        $totalPacientes = count($pacientes);
        $citasPorSemana = Cita::citasPorSemana($usuario_id);

        $router->render('secretaria/dashboard/index', [
            'titulo' => 'Panel de Secretaría',
            'subtitulo' => 'Revisión de Pacientes',
            'pacientes' => $pacientes,
            'consultas' => $consultas,
            'totalPacientes' => $totalPacientes,
            'totalCitas' => $totalCitas,
            'citasPorSemana' => $citasPorSemana
        ], 'secretaria-layout');
    }

    public static function expediente(Router $router) {
        session_start();
        // Verificar acceso con roles permitidos y excluidos
        $roles_permitidos = [3]; // Rol de secretaria u otro rol permitido
        $roles_excluidos = [1, 2, 4, 5, 6, 7, 8];  // Roles excluidos

        if (!tiene_acceso($roles_permitidos, $roles_excluidos)) {
            header('Location: /login');
            exit();
        }

        $usuario_id = $_SESSION['id'];

        $pacientes = Paciente::pacientesPorUsuario($usuario_id);
        $consultas = Consulta::consultasPorPacientes($pacientes);

        $router->render('secretaria/expedientes/index', [
            'titulo' => 'Listado de Pacientes',
            'pacientes' => $pacientes,
            'consultas' => $consultas
        ], 'secretaria-layout');
    }

    public static function crear(Router $router)
    {
        session_start();
        // Verificar acceso con roles permitidos y excluidos
        $roles_permitidos = [3]; // Rol de secretaria u otro rol permitido
        $roles_excluidos = [1, 2, 4, 5, 6, 7, 8];  // Roles excluidos

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
        

       // Obtener usuarios con rol_id 1 y 2
       $usuarios = Usuario::whereIn('rol_id', [1, 2]); // Obtener usuarios con rol_id 1 y 2

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = array_map('htmlspecialchars', $_POST);
            $_POST['usuario_id'] = $_SESSION['id'];  // Este campo solo se usa para propósitos administrativos
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

            // Validar Direccion
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
                                'tiempo_tratamiento_clinico' => $_POST['tiempo_tratamiento_clinico'] ?? ''
                            ]);
                            $consultas->guardar();
                        }

                        // Mostrar alerta de éxito
                        $alertas['success'][] = 'Paciente registrado exitosamente';
                    }
                } catch (\Exception $e) {
                    $alertas['danger'][] = 'Error al guardar los datos: ' . $e->getMessage();
                }
            }
        }

        $router->render('admin/secretaria/expedientes/crear', [
            'alertas' => $alertas,
            'titulo' => 'Nuevo Paciente',
            'paciente' => $paciente,
            'generos' => $generos,
            'direccion' => $direccion,
            'antecedentes' => $antecedentes,
            'datosConsulta' => $datosConsulta,
            'consultas' => $consultas,
            'usuarios' => $usuarios
        ], 'secretaria-layout');
    }


    private static function manejarArchivos($archivos, $alertas)
    {
        // Manejar archivos cargados
        if (isset($archivos['expediente_file']) && $archivos['expediente_file']['error'] === UPLOAD_ERR_OK) {
            $file = $archivos['expediente_file'];
            $validTypes = ['image/png', 'image/jpeg', 'image/webp', 'application/pdf'];
            $uploadDir = __DIR__ . '/../uploads/';

            if (in_array($file['type'], $validTypes)) {
                $filename = uniqid() . '-' . basename($file['name']);
                $uploadFile = $uploadDir . $filename;

                if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
                    return $alertas;
                } else {
                    $alertas['danger'][] = 'Error al subir el archivo';
                }
            } else {
                $alertas['danger'][] = 'Tipo de archivo no permitido';
            }
        } else {
            $alertas['danger'][] = 'No se seleccionó ningún archivo';
        }

        return $alertas;
    }

    public static function editar(Router $router) {
        session_start();
        // Verificar acceso con roles permitidos y excluidos
        $roles_permitidos = [3]; // Rol de secretaria u otro rol permitido
        $roles_excluidos = [1, 2, 4, 5, 6, 7, 8];  // Roles excluidos

        if (!tiene_acceso($roles_permitidos, $roles_excluidos)) {
            header('Location: /login');
            exit();
        }

        $alertas = [];
        $paciente_id = $_GET['id'] ?? null;

        if (!$paciente_id) {
            header('Location: /secretaria/expediente');
            exit();
        }

        $paciente = Paciente::find($paciente_id);
        if (!$paciente) {
            header('Location: /secretaria/expediente');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = array_map('htmlspecialchars', $_POST);
            $_POST['usuario_id'] = $_SESSION['id'];
            $_POST['fecha_actualizacion'] = date('Y-m-d H:i:s');

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

            // Validar y actualizar paciente
            $paciente->sincronizar($_POST);
            $alertas = array_merge($alertas, $paciente->validar());

            if (empty($alertas)) {
                try {
                    // Actualizar paciente
                    if ($paciente->guardar()) {
                        // Actualizar antecedentes médicos
                        $antecedentes = AntecedentesMedicos::find($paciente->id);
                        $antecedentes->sincronizar($_POST);
                        $antecedentes->guardar();

                        // Actualizar dirección
                        if (isset($_POST['pais']) && !empty($_POST['pais'])) {
                            $direccion = Direccion::find($paciente->direccion_id);
                            if ($direccion) {
                                $direccion->sincronizar($_POST);
                                $direccion->guardar();
                            } else {
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

                                // Asignar la nueva dirección al paciente
                                $paciente->direccion_id = $direccion->id;
                                $paciente->guardar();
                            }
                        }

                        // Actualizar datos de consulta
                        if (isset($_POST['presion_arterial'])) {
                            $datosConsulta = DatosConsulta::find($paciente->id);
                            if ($datosConsulta) {
                                $datosConsulta->sincronizar($_POST);
                                $datosConsulta->guardar();
                            } else {
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
                            $consulta = Consulta::find($paciente->id);
                            if ($consulta) {
                                $consulta->sincronizar($_POST);
                                $consulta->guardar();
                            } else {
                                $consulta = new Consulta([
                                    'paciente_id' => $paciente->id,
                                    'motivo_consulta' => $_POST['motivo_consulta'],
                                    'tratamiento_sugerido' => $_POST['tratamiento_sugerido'] ?? '',
                                    'tiempo_tratamiento_clinico' => $_POST['tiempo_tratamiento_clinico'] ?? ''
                                ]);
                                $consulta->guardar();
                            }
                        }

                        // Mostrar alerta de éxito
                        $alertas['success'][] = 'Paciente actualizado exitosamente';
                    }
                } catch (\Exception $e) {
                    $alertas['danger'][] = 'Error al actualizar los datos: ' . $e->getMessage();
                }
            }
        }

        $router->render('admin/secretaria/expedientes/editar', [
            'titulo' => 'Editar Paciente',
            'paciente' => $paciente,
            'alertas' => $alertas
        ], 'secretaria-layout');
    }

    public static function eliminar(Router $router) {
        session_start();
        // Verificar acceso con roles permitidos y excluidos
        $roles_permitidos = [3]; // Rol de secretaria u otro rol permitido
        $roles_excluidos = [1, 2, 4, 5, 6, 7, 8];  // Roles excluidos

        if (!tiene_acceso($roles_permitidos, $roles_excluidos)) {
            header('Location: /login');
            exit();
        }

        $paciente_id = $_GET['id'] ?? null;

        if ($paciente_id) {
            $paciente = Paciente::find($paciente_id);
            if ($paciente) {
                try {
                    // Eliminar antecedentes médicos
                    $antecedentes = AntecedentesMedicos::find($paciente_id);
                    if ($antecedentes) {
                        $antecedentes->eliminar();
                    }

                    // Eliminar datos de consulta
                    $datosConsulta = DatosConsulta::find($paciente_id);
                    if ($datosConsulta) {
                        $datosConsulta->eliminar();
                    }

                    // Eliminar consulta
                    $consulta = Consulta::find($paciente_id);
                    if ($consulta) {
                        $consulta->eliminar();
                    }

                    // Eliminar dirección
                    $direccion = Direccion::find($paciente->direccion_id);
                    if ($direccion) {
                        $direccion->eliminar();
                    }

                    // Eliminar paciente
                    $paciente->eliminar();
                    $alertas['success'][] = 'Paciente eliminado exitosamente';
                } catch (\Exception $e) {
                    $alertas['danger'][] = 'Error al eliminar el paciente: ' . $e->getMessage();
                }
            } else {
                $alertas['danger'][] = 'Paciente no encontrado';
            }
        } else {
            $alertas['danger'][] = 'ID de paciente no proporcionado';
        }

        $router->render('admin/secretaria/expedientes/eliminar', [
            'titulo' => 'Eliminar Paciente',
            'alertas' => $alertas
        ], 'secretaria-layout');
    }
}
