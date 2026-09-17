<?php

// error_reporting(0);

use app\Core\EnvLoader;

// Importa el proveedor de servicios para el patrón Observer (observador),
// encargado de registrar y gestionar los eventos globales de la aplicación.
use app\Providers\ObserverServiceProvider;
use app\Providers\EventServiceProvider;

EnvLoader::load(); // Carga el archivo .env

// Cargamos librerias
require_once 'config/config.php';

// Registra todos los eventos definidos en la aplicación mediante el proveedor Observer.
ObserverServiceProvider::register();

// Registra los eventos definidos en la aplicación mediante el proveedor EventServiceProvider.
EventServiceProvider::register();

// require_once 'utils/Sentry.php';

// Inicializamos Fecha y Hora local
date_default_timezone_set($_ENV['APP_TIMEZONE']);


?>