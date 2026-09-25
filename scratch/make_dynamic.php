<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $slug = 'tramites-notariales';
    $pagina = DB::table('gc_paginas')->where('slug', $slug)->first();
    if ($pagina) {
        $nuevoContenido = str_replace('052-630739', '{telefono}', $pagina->contenido);
        DB::table('gc_paginas')->where('slug', $slug)->update(['contenido' => $nuevoContenido]);
        echo "Contenido actualizado con placeholder {telefono}.";
    } else {
        echo "No se encontró la página.";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
