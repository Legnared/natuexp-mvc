<?php 

use Dotenv\Dotenv;
use Model\ActiveRecord;

require __DIR__ . '/../vendor/autoload.php';

// Detectar entorno basándose en la URL del servidor
$host = $_SERVER['HTTP_HOST'];

if (strpos($host, 'localhost') !== false) {
    // Cargar configuración local
    $dotenv = Dotenv::createImmutable(__DIR__, '.env.local');
} elseif (strpos($host, 'veynoqe.nyc.dom.my.id') !== false) {
    // Cargar configuración para staging
    $dotenv = Dotenv::createImmutable(__DIR__, '.env');
} elseif (strpos($host, 'www.natuexp.com') !== false) {
    // Cargar configuración para producción
    $dotenv = Dotenv::createImmutable(__DIR__, '.env.production');
} else {
    // Cargar configuración remota por defecto
    $dotenv = Dotenv::createImmutable(__DIR__, '.env.remote');
}

try {
    $dotenv->load();
} catch (Exception $e) {
    die('Error al cargar las variables de entorno: ' . $e->getMessage());
}

require_once 'funciones.php'; // Usa require_once para evitar inclusiones múltiples
require_once 'database.php';  // Usa require_once para evitar inclusiones múltiples

// Conectarnos a la base de datos
try {
    ActiveRecord::setDB($db);
} catch (Exception $e) {
    die('Error al conectar a la base de datos: ' . $e->getMessage());
}
