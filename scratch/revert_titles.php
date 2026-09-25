<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    DB::table('gc_menus')->where('id', 14)->update(['nombre' => 'Trámites']);
    DB::table('gc_menus')->where('id', 17)->update(['nombre' => 'Servicios Administrativos']);
    
    DB::table('gc_servicios')->where('id', 1)->update(['nombre' => 'Certificación de firma ante el CNT']);
    DB::table('gc_servicios')->where('id', 2)->update(['nombre' => 'Capacitación Permanente']);
    
    echo "Títulos revertidos a sus originales. Contenido mantenido.";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
