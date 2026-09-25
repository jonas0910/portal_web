<?php

/**
 * ============================================
 * INDEX.PHP PARA SUBCARPETA: public_html/muni/
 * ============================================
 * 
 * ESTRUCTURA:
 * public_html/
 * └── muni/
 *     ├── app/
 *     ├── bootstrap/
 *     ├── config/
 *     ├── ... (todo el proyecto)
 *     ├── index.php  ← ESTE ARCHIVO
 *     └── .htaccess
 * 
 * URL: https://tu-dominio.com/muni/
 * 
 * ============================================
 */

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determinar si la aplicación está en modo mantenimiento
if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Registrar el autoloader de Composer
require __DIR__.'/vendor/autoload.php';

// Iniciar Laravel y manejar la solicitud
/** @var Application $app */
$app = require_once __DIR__.'/bootstrap/app.php';

$app->handleRequest(Request::capture());

