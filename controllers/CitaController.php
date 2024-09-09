<?php

namespace Controllers;

use Model\Cita;
use Model\Pacient;
use MVC\Router;

class CitaController
{
    public static function index(Router $router)
    {
        session_start();
        
        // Verificar acceso con roles permitidos y excluidos
        $roles_permitidos = [1, 2, 3]; // Administrador, otro rol permitido
        $roles_excluidos = [4, 5, 6, 7, 8];  // Otros roles excluidos

        if (!tiene_acceso($roles_permitidos, $roles_excluidos)) {
            header('Location: /login');
            exit();
        }

        $usuario_id = $_SESSION['id']; // Obtener el usuario_id de la sesión
        $rol_id = $_SESSION['rol_id']; // Obtener el rol del usuario desde la sesión
        $alertas = [];
        
        // Si el usuario es administrador o tiene rol_id 3, muestra todas las citas
        if ($rol_id == 1 || $rol_id == 3) {
            $citas = Cita::all(); // Mostrar todas las citas
        } else {
            // Si es otro rol, solo mostrar las citas del usuario logueado
            $citas = Cita::todos($usuario_id); // Mostrar solo las citas del usuario actual
        }

        // Usa el layout admin-layout.php para vistas en la carpeta admin
        $router->render('admin/cita/index', [
            'titulo' => 'Mostrar Citas',
            'alertas' => $alertas,
            'citas' => $citas
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
        $cita = new Cita();
        
        // Obtener el ID y rol del usuario logueado (médico)
        $usuario_id = $_SESSION['id'];
        $rol_id = $_SESSION['rol_id'];
        
        // Verificar si el usuario es administrador o tiene rol con privilegios
        if ($rol_id == 1 || $rol_id == 3) {
            // Si es administrador o rol privilegiado, obtener todos los pacientes
            $pacientes = Pacient::all();
        } else {
            // Si no es administrador, obtener solo los pacientes asociados al usuario actual
            $pacientes = Pacient::pacientesPorUsuario($usuario_id);
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cita->sincronizar($_POST); // Sincronizar datos del formulario con el objeto Cita
            $alertas = $cita->validar(); // Validar los datos de la cita
        
            // Obtener el paciente seleccionado
            $paciente_id = $_POST['paciente_id'];
            $paciente = Pacient::find($paciente_id);
        
            if (!$paciente) {
                $alertas['error'][] = 'El paciente seleccionado no existe.';
            } else {
                // Asignar nombre y apellidos del paciente a la cita
                $cita->nombre_paciente = $paciente->nombre;
                $cita->apellidos_paciente = $paciente->apellidos;
            }
        
            // Validar si la fecha y hora de la cita están en el rango permitido
            $fecha_cita = $_POST['fecha']; // Campo de fecha
            $hora_cita = $_POST['hora'];   // Campo de hora
        
            $timestamp_cita = strtotime($fecha_cita . ' ' . $hora_cita);
            $dia_semana = date('N', $timestamp_cita); // 1 = Lunes, 7 = Domingo
            $hora = date('H:i', $timestamp_cita);
        
            // Verificar si es un día entre lunes (1) y viernes (5)
            if ($dia_semana < 1 || $dia_semana > 5) {
                $alertas['error'][] = 'Solo puedes agendar citas de lunes a viernes.';
            }
        
            // Verificar si la hora está entre las 9:00 AM y la 1:00 PM
            if ($hora < '09:00' || $hora > '13:00') {
                $alertas['error'][] = 'Las citas solo se pueden agendar entre las 9:00 AM y la 1:00 PM.';
            }
        
            if (empty($alertas)) {
                // Asignar el usuario actual si es necesario
                $cita->usuario_id = $_SESSION['id']; 
                
                try {
                    $resultado = $cita->guardar();
        
                    if ($resultado) {
                        // Redirigir después de guardar exitosamente
                        $_SESSION['redirect'] = '/admin/cita'; 
                        $alertas['success'][] = 'Cita guardada correctamente.';
                    } else {
                        $alertas['error'][] = 'Error al guardar la cita. Inténtalo de nuevo.';
                    }
                } catch (\Exception $e) {
                    $alertas['error'][] = 'Error al guardar la cita: ' . $e->getMessage();
                }
            }
        }

        // Escapar los nombres y apellidos de los pacientes
        foreach ($pacientes as $paciente) {
            $paciente->nombre = htmlspecialchars($paciente->nombre, ENT_QUOTES, 'UTF-8');
            $paciente->apellidos = htmlspecialchars($paciente->apellidos, ENT_QUOTES, 'UTF-8');
        }

        // Renderizar la vista con la lista de pacientes disponibles
        $router->render('admin/cita/crear', [
            'titulo' => 'Agendar Cita',
            'alertas' => $alertas,
            'cita' => $cita,
            'pacientes' => $pacientes
        ], 'admin-layout');
    }

    
    public static function historico(Router $router)
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
        $citas = [];
        $nombre_paciente = $_GET['nombre'] ?? null;

        if ($nombre_paciente) {
            $nombre_paciente = trim($nombre_paciente);
            // Buscar citas por nombre del paciente
            $citas = Cita::buscarPorNombrePaciente($nombre_paciente);

            if (empty($citas)) {
                $alertas[] = ['tipo' => 'warning', 'mensaje' => 'No se encontraron citas para el nombre de paciente proporcionado.'];
            }
        }

        // Verificar si es una solicitud AJAX
        if (isset($_GET['ajax'])) {
            echo json_encode($citas);
            exit; // Asegurarse de que no se ejecute más código después de enviar la respuesta JSON
        } else {
            // Usa el layout admin-layout.php para vistas en la carpeta admin
            $router->render('admin/historico/index', [
                'titulo' => 'Histórico de Citas',
                'alertas' => $alertas,
                'citas' => $citas
            ], 'admin-layout');
        }
    }
}
?>
