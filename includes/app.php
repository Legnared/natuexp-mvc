<?php 

use Dotenv\Dotenv;
use Model\ActiveRecord;

require __DIR__ . '/../vendor/autoload.php';

// Añadir Dotenv
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Obtener el entorno, por defecto es 'local'
$env = $_ENV['APP_ENV'] ?? 'local';

// Configurar las variables de entorno dependiendo del entorno
if ($env === 'local') {
    $_ENV['DB_HOST'] = $_ENV['LOCAL_DB_HOST'];
    $_ENV['DB_USER'] = $_ENV['LOCAL_DB_USER'];
    $_ENV['DB_PASS'] = $_ENV['LOCAL_DB_PASS'];
    $_ENV['DB_NAME'] = $_ENV['LOCAL_DB_NAME'];
    $_ENV['EMAIL_HOST'] = $_ENV['LOCAL_EMAIL_HOST'];
    $_ENV['EMAIL_PORT'] = $_ENV['LOCAL_EMAIL_PORT'];
    $_ENV['EMAIL_USER'] = $_ENV['LOCAL_EMAIL_USER'];
    $_ENV['EMAIL_PASS'] = $_ENV['LOCAL_EMAIL_PASS'];
    $_ENV['EMAIL_SSL'] = $_ENV['LOCAL_EMAIL_SSL'];
    $_ENV['HOST'] = $_ENV['LOCAL_HOST'];
} else {
    $_ENV['DB_HOST'] = $_ENV['REMOTE_DB_HOST'];
    $_ENV['DB_USER'] = $_ENV['REMOTE_DB_USER'];
    $_ENV['DB_PASS'] = $_ENV['REMOTE_DB_PASS'];
    $_ENV['DB_NAME'] = $_ENV['REMOTE_DB_NAME'];
    $_ENV['EMAIL_HOST'] = $_ENV['REMOTE_EMAIL_HOST'];
    $_ENV['EMAIL_PORT'] = $_ENV['REMOTE_EMAIL_PORT'];
    $_ENV['EMAIL_USER'] = $_ENV['REMOTE_EMAIL_USER'];
    $_ENV['EMAIL_PASS'] = $_ENV['REMOTE_EMAIL_PASS'];
    $_ENV['EMAIL_SSL'] = $_ENV['REMOTE_EMAIL_SSL'];
    $_ENV['HOST'] = $_ENV['REMOTE_HOST'];
}

require 'funciones.php';
require 'database.php';

// Conectarnos a la base de datos
ActiveRecord::setDB($db);
