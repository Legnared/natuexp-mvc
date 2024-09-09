<?php
namespace Controllers;

use Model\Pacient;
use Model\Sexo;
use Model\Usuario;
use Model\Consulta;
use Model\DatosConsulta;
use MVC\Router;

class RecetaMedicaController
{
    public static function index(Router $router)
    {
        session_start();

        // Verificar si el usuario tiene permisos de administrador
        if (!is_admin()) {
            header('Location: /admin/dashboard/index');
            exit();
        }

        // Obtener el token del parámetro de la URL
        $token = $_GET['id'] ?? null;

        // Verificar si el token es válido
        if (!$token) {
            header('Location: /admin/dashboard/');
            exit();
        }

        // Buscar al paciente usando el token
        $paciente = Pacient::where('url_avance', $token);
        if (!$paciente) {
            header('Location: /admin/dashboard/');
            exit();
        }

        // Obtener el nombre del género desde el modelo Sexo
        $sexo = Sexo::findId($paciente->sexo_id);
        $nombre_sexo = $sexo ? $sexo->sexo : 'Desconocido';

        // Obtener las consultas relacionadas con el paciente
        $consultas = Consulta::findByPacienteId($paciente->id);
        
        // Verifica si se obtienen consultas
        if (!$consultas) {
            $consultas = new Consulta(); // O un array vacío, según lo que esperes
        }

        // Obtener los datos de consulta por paciente_id
        $datos_consulta = DatosConsulta::findByPacienteId($paciente->id);

        // Verifica si se obtienen datos de consulta
        if (!$datos_consulta) {
            $datos_consulta = new DatosConsulta(); // O un objeto vacío
        }

        // Obtener los datos del usuario autenticado
        $usuario = Usuario::findId($_SESSION['id']);

        // Verifica si se obtuvo el usuario
        if (!$usuario) {
            $usuario = new Usuario(); // O un objeto vacío
        }

        // Preparar los datos para la vista
        $router->render('admin/receta/index', [
            'titulo' => 'Diagnóstico del Paciente | Receta',
            'nombre_paciente' => htmlspecialchars($paciente->nombre . " " . $paciente->apellidos),
            'edad' => htmlspecialchars($paciente->edad),
            'sexo' => htmlspecialchars($nombre_sexo),
            'peso' => htmlspecialchars($datos_consulta->peso ?? 'N/A'),
            'estatura' => htmlspecialchars($datos_consulta->estatura ?? 'N/A'),
            'presion_arterial' => htmlspecialchars($datos_consulta->presion_arterial ?? 'N/A'),
            'nivel_azucar' => htmlspecialchars($datos_consulta->nivel_azucar ?? 'N/A'),
            'motivo_consulta' => htmlspecialchars($consultas->motivo_consulta ?? 'N/A'),
            'observaciones' => htmlspecialchars($consultas->observaciones ?? 'N/A'),
            'tiempo_tratamiento_clinico' => htmlspecialchars($consultas->tiempo_tratamiento_clinico ?? 'N/A'),
            'tiempo_tratamiento_sujerido' => htmlspecialchars($consultas->tiempo_tratamiento_sugerido ?? 'N/A'),
            'diagnostico' => htmlspecialchars($consultas->diagnostico ?? 'N/A'),
            'tratamiento_sujerido' => htmlspecialchars($consultas->tratamiento_sugerido ?? 'N/A'),
            'dosis_tratamiento' => htmlspecialchars($consultas->dosis_tratamiento ?? 'N/A'),
            'medico' => $usuario
        ], 'admin-layout');
    }

}