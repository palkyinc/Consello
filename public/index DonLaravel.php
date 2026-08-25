<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Cambia esto:
// require __DIR__.'/../vendor/autoload.php';

// Por esto (apuntando a tu carpeta privada):
require __DIR__.'/../consello_app/vendor/autoload.php';
// Cambia esto:
// $app = require_once __DIR__.'/../bootstrap/app.php';

// Por esto (apuntando a tu carpeta privada):
$app = require_once __DIR__.'/../consello_app/bootstrap/app.php';

// IMPORTANTÍSIMO: Indicarle a Laravel cuál es su nueva carpeta pública
$app->usePublicPath(__DIR__);

// Manejar la petición
$app->handleRequest(Request::capture());