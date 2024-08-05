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
        isAuth();

        if (!is_admin()) {
            header('Location: /admin/dashboard/index');
            exit();
        }

        $token = $_GET['id'] ?? null;

        if (!$token) {
            header('Location: /dashboard');
            exit();
        }

        $paciente = Paciente::where('url_avance', $token); // Usa first() para obtener un solo paciente
        if (!$paciente) {
            header('Location: /dashboard');
            exit();
        }

        $usuario = Usuario::find($_SESSION['id']);

        // Verifica si el paciente pertenece al usuario
        if ($paciente->usuario_id !== $_SESSION['id']) {
            header('Location: /dashboard');
            exit();
        }

        // Obtén el nombre del género a partir del sexo_id
        $sexo = Sexo::find($paciente->sexo_id);
        $nombre_sexo = $sexo ? $sexo->sexo : 'Desconocido';

        $router->render('admin/receta/index', [
            'titulo' => 'Diagnóstico del Paciente',
            'nombre_paciente' => $paciente->nombre . " " . $paciente->apellidos,
            'edad' => $paciente->edad,
            'sexo' => $nombre_sexo, // Usa el nombre del género
            'peso' => $paciente->peso,
            'estatura' => $paciente->estatura,
            'presion_arterial' => $paciente->presion_arterial,
            'motivo_consulta' => $paciente->motivo_consulta,
            'diagnostico' => $paciente->diagnostico,
            'tratamiento_sujerido' => $paciente->tratamiento_sujerido,
            'dosis_tratamiento' => $paciente->dosis_tratamiento,

            'medico' => $usuario
        ], 'admin-layout');
    }
}
