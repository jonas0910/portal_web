<?php

/**
 * ============================================
 * INDEX.PHP PARA HOSTING EN RAÍZ
 * ============================================
 * 
 * INSTRUCCIONES:
 * 1. Suba TODOS los archivos del proyecto a public_html
 * 2. Copie los archivos de la carpeta public/ también a public_html
 * 3. Reemplace el index.php con este archivo
 * 4. Reemplace bootstrap/app.php con el archivo app-raiz.php
 * 
 * ============================================
 */

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determinar si la aplicación está en modo mantenimiento
// Nota: Ahora storage está en la misma carpeta raíz
if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Registrar el autoloader de Composer
// Nota: Ahora vendor está en la misma carpeta raíz
require __DIR__.'/vendor/autoload.php';

// Iniciar Laravel y manejar la solicitud
/** @var Application $app */
$app = require_once __DIR__.'/bootstrap/app.php';

$app->handleRequest(Request::capture());

