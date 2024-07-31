<?php

namespace Controllers;

use Model\Cita;
use Model\Paciente;
use MVC\Router;

class CitaController
{
    public static function index(Router $router)
    {
        session_start();
        isAuth();
    
        $usuario_id = $_SESSION['id']; // Obtener el usuario_id de la sesión
        $alertas = [];
        $citas = Cita::todos($usuario_id); // Obtener todas las citas del usuario actual
    
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
        isAuth();
        
        $alertas = [];
        $cita = new Cita();
        
        // Obtener el ID del usuario logueado (médico)
        $usuario_id = $_SESSION['id'];
        
        // Obtener la lista de pacientes asociados al usuario logueado
        $pacientes = Paciente::pacientesPorUsuario($usuario_id);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cita->sincronizar($_POST); // Sincronizar datos del formulario con el objeto Cita
            $alertas = $cita->validar(); // Validar los datos de la cita
    
            // Obtener el paciente seleccionado
            $paciente_id = $_POST['paciente_id'];
            $paciente = Paciente::find($paciente_id);
    
            if (!$paciente) {
                $alertas[] = ['tipo' => 'danger', 'mensaje' => 'El paciente seleccionado no existe.'];
            } else {
                // Asignar nombre y apellidos del paciente a la cita
                $cita->nombre_paciente = $paciente->nombre;
                $cita->apellidos_paciente = $paciente->apellidos;
            }
    
            if (empty($alertas)) {
                // Continuar con el proceso de guardado de la cita
                $cita->usuario_id = $_SESSION['id']; // Asignar usuario actual si es necesario
                
                try {
                    $resultado = $cita->guardar();
    
                    if ($resultado) {
                        // Redirigir después de guardar exitosamente
                        header('Location: /admin/cita');
                        exit;
                    } else {
                        // Manejar errores de guardado
                        $alertas[] = ['tipo' => 'danger', 'mensaje' => 'Error al guardar la cita. Inténtalo de nuevo.'];
                    }
                } catch (\Exception $e) {
                    // Capturar excepciones y mostrar mensaje de error
                    $alertas[] = ['tipo' => 'danger', 'mensaje' => 'Error al guardar la cita: ' . $e->getMessage()];
                }
            }
        }
    
        // Escapar los nombres y apellidos de los pacientes
        foreach ($pacientes as $paciente) {
            $paciente->nombre = htmlspecialchars($paciente->nombre, ENT_QUOTES, 'UTF-8');
            $paciente->apellidos = htmlspecialchars($paciente->apellidos, ENT_QUOTES, 'UTF-8');
        }
    
        // Usa el layout admin-layout.php para vistas en la carpeta admin
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
        isAuth();

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
