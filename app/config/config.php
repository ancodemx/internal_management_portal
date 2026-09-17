<?php

# Base de datos

// Database name
define( 'DB_NAME', $_ENV['DB_NAME'] );

// Database username
define( 'DB_USER', $_ENV['DB_USER'] );

// Database password
define( 'DB_PASSWORD', $_ENV['DB_PASSWORD'] );

// Database hostname
define( 'DB_HOST', $_ENV['DB_HOST'] );

// Port
define( 'DB_PORT', $_ENV['DB_PORT'] );



# Entorno de la app

// Titulo
define ('APP_TITLE', $_ENV['APP_NAME'] );

// Nombre del proyecto
define ('PROJECT_NAME', $_ENV['APP_NAME'] );

// Nombre de la lógica del proyecto
// Este nombre se utiliza para identificar la lógica del proyecto en el código
define ('LOGIC_NAME', 'hotel_management_dashboard' );

// Ruta absoluta del proyecto
define('PROJECT_PATH', rtrim(str_replace('\\', '/', realpath(__DIR__ . '/../../')), '/') . '/');

// Detectar esquema y host (soporta reverse proxy via X-Forwarded-Proto)
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    ? 'https'
    : ((!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https') ? 'https' : 'http');
$host = $_SERVER['HTTP_HOST'] ?? '';
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';

// Ruta real de la carpeta public del proyecto
$projectPublicReal = realpath(PROJECT_PATH . 'public');
$docRootReal = isset($_SERVER['DOCUMENT_ROOT']) ? realpath($_SERVER['DOCUMENT_ROOT']) : null;

// Si el DocumentRoot del servidor es la carpeta public del proyecto (vhost apuntando a public)
if ($docRootReal && $projectPublicReal && $docRootReal === $projectPublicReal) {
    $basePath = rtrim(dirname($scriptName), '/');

    $basePath = ($basePath === '' || $basePath === '.') ? '/' : $basePath . '/';

    define('URL_PATH', $scheme . '://' . $host . $basePath);
    // define('URL_PATH', rtrim($scheme . '://' . $host . $basePath, '/'));
    define('PUBLIC_URL_PATH', rtrim(URL_PATH, '/'));

    define('APP_PATH', PROJECT_PATH . 'app/');
    define('PUBLIC_PATH', PROJECT_PATH . 'public');
    define('APP_FOLDER', basename(trim(PROJECT_PATH, '/')));
} else {
    // Caso instalación en subcarpeta o DocumentRoot distinto: inferir base desde SCRIPT_NAME
    if (strpos($scriptName, '/public/index.php') !== false) {
        $base = substr($scriptName, 0, strpos($scriptName, '/public/index.php'));
    } else {
        $base = rtrim(dirname($scriptName), '/');
    }

    $base = ($base === '.' || $base === '') ? '' : $base;
    $baseWithSlash = ($base === '') ? '/' : $base . '/';

    define('URL_PATH', $scheme . '://' . $host . $baseWithSlash);
    // define('URL_PATH', rtrim($scheme . '://' . $host . $baseWithSlash, '/'));
    define('PUBLIC_URL_PATH', rtrim(URL_PATH, '/') . '/public');

    define('APP_PATH', PROJECT_PATH . 'app/');
    define('PUBLIC_PATH', PROJECT_PATH . 'public');
    define('APP_FOLDER', trim($base, '/'));
}



# Recursos y plantillas

// Ruta a recursos
define ('RESOURCES_PATH', PUBLIC_URL_PATH . '/libs');

// Ruta de la carpeta de las plantillas
// define( 'TEMPLATE_PATH', '/lib_ancode/resources/adminlte320');
define( 'TEMPLATE_PATH', PUBLIC_URL_PATH . '/libs/adminlte320');

// El valor declarado en la constante LOGOUT es el nombre de la ruta que se le asignará al botón de cerrar sesión
define ('LOGOUT', 'login');



# Ruta a los controladores

// En el caso de manejar API, se puede definir una constante para la ruta de los controladores de la API
// Se descomenta VERSION si se maneja una versión de la API y se le asigna un valor en este caso $url[0] para que sea de manera dinámica
// Y en ENTITY se define la entidad que se está manejando en la API, se le asigna el valor de $url[1] para que sea de manera dinámica
// Ejemplo de url local: http://localhost/api/v1/user
// Ejemplo de url en producción: https://api.dominio.com/v1/user

// Manejo seguro de $_GET['url']
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);
// define('VERSION', $url[0]);
define('ENTITY', isset($url[0]) ? $url[0] : '');



# General

define('LOGO_MENU_LEFT', 0);

?>