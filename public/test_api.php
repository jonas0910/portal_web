<?php
/**
 * Script de diagnóstico para la API de fotos
 * Acceder via: http://127.0.0.1:9000/test_api.php
 */

require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Models\FotoAniversario;

header('Content-Type: application/json');

$resultado = [
    'total_fotos' => FotoAniversario::count(),
    'fotos_activas' => FotoAniversario::activas()->count(),
    'fotos' => []
];

$fotos = FotoAniversario::activas()->orderBy('orden')->get();

foreach ($fotos as $foto) {
    $resultado['fotos'][] = [
        'id' => $foto->id,
        'titulo' => $foto->titulo,
        'activo' => $foto->activo,
        'fecha_inicio' => $foto->fecha_inicio,
        'fecha_fin' => $foto->fecha_fin,
        'fecha_inicio_null' => is_null($foto->fecha_inicio),
        'fecha_fin_null' => is_null($foto->fecha_fin),
        'esta_vigente' => $foto->esta_vigente,
        'imagen_url' => $foto->imagen_url,
    ];
}

echo json_encode($resultado, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);






