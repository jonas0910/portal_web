<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$miembros = \Illuminate\Support\Facades\DB::table('gc_miembros_colegio')->get();
foreach ($miembros as $m) {
    echo "TYPE: {$m->tipo} | NAME: {$m->nombre} | CARGO: {$m->cargo} | PERIODO: {$m->periodo}\n";
}

$paginas = \Illuminate\Support\Facades\DB::table('gc_paginas')->whereIn('slug', ['decanos-historicos', 'tribunal-de-honor', 'junta-directiva'])->get();
foreach ($paginas as $p) {
    echo "--- SLUG: {$p->slug} ---\n";
    echo $p->contenido . "\n";
}
