<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "--- CONFIGURACION DE CONTACTO ---\n";
    $configs = DB::table('gc_configuracion_sitio')->where('categoria', 'contacto')->get();
    foreach ($configs as $c) {
        echo "[Clave:{$c->clave}] Valor: {$c->valor}\n";
    }

    echo "\n--- BUSQUEDA DE PAGINAS POR TITULO ---\n";
    $paginasBusqueda = DB::table('gc_paginas')
        ->where('titulo', 'like', '%Legalización%')
        ->orWhere('titulo', 'like', '%Capacitación%')
        ->orWhere('slug', 'like', '%legalizacion%')
        ->orWhere('slug', 'like', '%capacitacion%')
        ->get();
    foreach ($paginasBusqueda as $p) {
        echo "[ID:{$p->id}] Titulo: {$p->titulo} (Slug: {$p->slug})\n";
    }

    echo "\n--- BUSQUEDA DE SERVICIOS POR NOMBRE ---\n";
    $serviciosBusqueda = DB::table('gc_servicios')
        ->where('nombre', 'like', '%Legalización%')
        ->orWhere('nombre', 'like', '%Capacitación%')
        ->get();
    foreach ($serviciosBusqueda as $s) {
        echo "[ID:{$s->id}] Nombre: {$s->nombre}\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
