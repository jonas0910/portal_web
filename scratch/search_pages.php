<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$paginas = \Illuminate\Support\Facades\DB::table('gc_paginas')->get();
foreach ($paginas as $p) {
    if (strpos($p->titulo, 'Decano') !== false || strpos($p->slug, 'decano') !== false || strpos($p->slug, 'tribunal') !== false) {
        echo "--- SLUG: {$p->slug} | TITULO: {$p->titulo} ---\n";
        echo $p->contenido . "\n\n";
    }
}
