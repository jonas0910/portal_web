<?php

/**
 * ============================================
 * INDEX.PHP PARA HOSTING COMPARTIDO
 * ============================================
 * 
 * INSTRUCCIONES:
 * 1. Suba este archivo a public_html/index.php
 * 2. Modifique la ruta según la ubicación de su proyecto
 * 
 * ESTRUCTURA ESPERADA:
 * /home/usuario/
 * ├── public_html/     ← Este index.php va aquí
 * └── proyecto/        ← Archivos de Laravel aquí
 * 
 * ============================================
 */

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| CONFIGURAR RUTA DEL PROYECTO
|--------------------------------------------------------------------------
| Modifique esta ruta según donde haya colocado los archivos del proyecto.
| Por defecto asume que está en ../proyecto/ (un nivel arriba de public_html)
*/
$projectPath = __DIR__ . '/../proyecto';

// Si el proyecto está en otra ubicación, modifique aquí:
// $projectPath = '/home/usuario/mi-municipalidad';

/*
|--------------------------------------------------------------------------
| Verificación de archivos necesarios
|--------------------------------------------------------------------------
*/
if (!file_exists($projectPath . '/vendor/autoload.php')) {
    die('Error: No se encontró el autoloader de Composer. Verifique que la ruta del proyecto sea correcta: ' . $projectPath);
}

if (!file_exists($projectPath . '/bootstrap/app.php')) {
    die('Error: No se encontró bootstrap/app.php. Verifique la instalación del proyecto.');
}

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
*/
if (file_exists($maintenance = $projectPath . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
*/
require $projectPath . '/vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
*/
$app = require_once $projectPath . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);

