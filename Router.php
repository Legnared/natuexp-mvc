<?php

namespace MVC;

// Define una clase llamada Router dentro del espacio de nombres MVC
class Router
{
    // Declaración de dos propiedades públicas que almacenarán las rutas GET y POST
    public array $getRoutes = [];
    public array $postRoutes = [];

    // Método para agregar una ruta GET
    public function get($url, $fn)
    {
        // Asigna una función a una URL específica en el array de rutas GET
        $this->getRoutes[$url] = $fn;
    }

    // Método para agregar una ruta POST
    public function post($url, $fn)
    {
        // Asigna una función a una URL específica en el array de rutas POST
        $this->postRoutes[$url] = $fn;
    }

    // Método para comprobar y manejar las rutas actuales
    public function comprobarRutas()
    {
        // Normalizar la URL actual
        $url_actual = strtok($_SERVER['REQUEST_URI'], '?') ?? '/';
        //$url_actual = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $url_actual = $url_actual === '/' ? '/' : rtrim($url_actual, '/');
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            $fn = $this->getRoutes[$url_actual] ?? null;
        } else {
            $fn = $this->postRoutes[$url_actual] ?? null;
        }

        if ($fn) {
            try {
                call_user_func($fn, $this);
            } catch (\Exception $e) {
                $this->render('error/500', ['error' => $e->getMessage()]);
            }
        } else {
            $this->render('error/404');
        }
    }

    // Método para renderizar una vista
    public function render($view, $datos = [], $layout = 'layout')
    {
        // Extrae los datos del array $datos para que puedan ser utilizados en la vista
        foreach ($datos as $key => $value) {
            $$key = $value;
        }

        // Captura la salida de la vista en un buffer
        ob_start();
        include_once __DIR__ . "/views/$view.php";
        // Asigna la salida capturada a la variable $contenido
        $contenido = ob_get_clean();

        // Incluye el layout especificado y pasa el contenido capturado a él
        include_once __DIR__ . "/views/{$layout}.php";
    }

    // Método para redirigir a otra URL
    public function redirect($url)
    {
        // Envía una cabecera de redirección HTTP al navegador
        header("Location: $url");
        // Detiene la ejecución del script
        exit();
    }
}
?>