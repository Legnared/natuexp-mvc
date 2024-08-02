<?php 

use Dotenv\Dotenv;
use Model\ActiveRecord;

require __DIR__ . '/../vendor/autoload.php';

// Detectar entorno basándose en la URL del servidor
$host = $_SERVER['HTTP_HOST'];

if (strpos($host, 'localhost') !== false) {
    // Cargar configuración local
    $dotenv = Dotenv::createImmutable(__DIR__, '.env.local');
} elseif (strpos($host, 'staging.veynoqe.nyc.dom.my.id') !== false) {
    // Cargar configuración para staging
    $dotenv = Dotenv::createImmutable(__DIR__, '.env.staging');
} elseif (strpos($host, 'www.natuexp.com') !== false) {
    // Cargar configuración para producción
    $dotenv = Dotenv::createImmutable(__DIR__, '.env.production');
} else {
    // Cargar configuración remota por defecto
    $dotenv = Dotenv::createImmutable(__DIR__, '.env.remote');
}

$dotenv->load();

require 'funciones.php';
require 'database.php';

// Conectarnos a la base de datos
ActiveRecord::setDB($db);