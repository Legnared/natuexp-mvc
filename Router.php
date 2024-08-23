<?php

namespace MVC;

class Router
{
    public array $getRoutes = [];
    public array $postRoutes = [];

    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }

    public function comprobarRutas()
    {
        $url_actual = strtok($_SERVER['REQUEST_URI'], '?') ?? '/';
        $url_actual = $url_actual === '/' ? '/' : rtrim($url_actual, '/');
        $method = $_SERVER['REQUEST_METHOD'];

        $fn = ($method === 'GET') ? ($this->getRoutes[$url_actual] ?? null) : ($this->postRoutes[$url_actual] ?? null);

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

    public function render($view, $datos = [], $layout = 'layout')
    {
        // Verificar que el archivo de vista exista
        $viewPath = __DIR__ . "/views/$view.php";
        if (!file_exists($viewPath)) {
            $view = 'error/404';
        }

        // Extraer variables
        extract($datos);

        ob_start();
        include_once $viewPath;
        $contenido = ob_get_clean();

        $layoutPath = __DIR__ . "/views/{$layout}.php";
        if (file_exists($layoutPath)) {
            include_once $layoutPath;
        } else {
            echo $contenido; // Si no hay layout, simplemente mostrar el contenido
        }
    }

    public function redirect($url)
    {
        header("Location: $url");
        exit();
    }
}
?>
