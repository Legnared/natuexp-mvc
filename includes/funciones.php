<?php


// Configuración de la duración de la sesión
// ini_set('session.gc_maxlifetime', 300);
// session_set_cookie_params(300);


function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function close_session(){
    session_unset();
    session_destroy();
}


function pagina_actual($path ) : bool {
    return str_contains( $_SERVER['PATH_INFO'] ?? '/', $path  ) ? true : false;
}

function is_auth() : bool {
    if (!isset($_SESSION)) {
        session_start();
    }
    return isset($_SESSION['nombre']) && !empty($_SESSION);
}

//Función que revisa que el usuario esta autenticado
function isAuth() : void {
    if (!isset($_SESSION['login'])) {
       header('Location: /login');
    }
}

function is_admin() : bool {
    if (!isset($_SESSION)) {
        session_start();
    }
    return isset($_SESSION['perfil']) && !empty($_SESSION['perfil']);
}

function aos_animation() : void{
    $efectos = ['fade-up', 'fade-down', 'zoom-in', 'zoom-in-up', 'zoom-in-down', 'zoom-out'];
    $efecto = array_rand($efectos, 1);
    echo ' data-aos="' . $efectos[$efecto] . '" ';
}


