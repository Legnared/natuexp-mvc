<?php
namespace Controllers;

use Model\Paciente;
use Model\Sexo;
use Model\Usuario;
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
        $paciente = Paciente::where('url_avance', $token);

       

        // Obtener el nombre del género desde el modelo Sexo
        $sexo = Sexo::findId($paciente->sexo_id);
        $nombre_sexo = $sexo ? $sexo->sexo : 'Desconocido';

        // Obtener los datos del usuario autenticado
        $usuario = Usuario::findId($_SESSION['id']);

        // Preparar los datos para la vista
        $router->render('admin/receta/index', [
            'titulo' => 'Diagnóstico del Paciente | Receta',
            'nombre_paciente' => $paciente->nombre . " " . $paciente->apellidos,
            'edad' => $paciente->edad,
            'sexo' => $nombre_sexo, // Usar el nombre del género
            'peso' => $paciente->peso,
            'estatura' => $paciente->estatura,
            'presion_arterial' => $paciente->presion_arterial,
            'nivel_azucar' => $paciente->nivel_azucar,
            'motivo_consulta' => $paciente->motivo_consulta,
            'observaciones' => $paciente->observaciones,
            'tiempo_tratamiento_clinico' => $paciente->tiempo_tratamiento_clinico,
            'tiempo_tratamiento_sujerido' => $paciente->tiempo_tratamiento_sujerido,
            'diagnostico' => $paciente->diagnostico,
            'tratamiento_sujerido' => $paciente->tratamiento_sujerido,
            'dosis_tratamiento' => $paciente->dosis_tratamiento,

            'medico' => $usuario
        ], 'admin-layout');
    }
}
