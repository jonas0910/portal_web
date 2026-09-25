<?php
/**
 * Script de diagnóstico para verificar configuración de URLs
 * SUBIR A: public_html/muni/diagnostico.php
 * EJECUTAR: https://munilayaradalospalos.gob.pe/muni/diagnostico.php
 * ELIMINAR DESPUÉS DE USAR
 */

// Cargar Laravel
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "<!DOCTYPE html><html><head><meta charset='utf-8'><title>Diagnóstico Laravel</title></head><body>";
echo "<h1>🔍 Diagnóstico de Configuración Laravel</h1>";

echo "<h2>1. Variables de Entorno (.env)</h2>";
echo "<pre>";
echo "APP_ENV: " . env('APP_ENV', 'NO DEFINIDO') . "\n";
echo "APP_URL: " . env('APP_URL', 'NO DEFINIDO') . "\n";
echo "ASSET_URL: " . env('ASSET_URL', 'NO DEFINIDO') . "\n";
echo "</pre>";

echo "<h2>2. Configuración Cacheada (config)</h2>";
echo "<pre>";
echo "app.env: " . config('app.env') . "\n";
echo "app.url: " . config('app.url') . "\n";
echo "app.asset_url: " . (config('app.asset_url') ?: 'NULL/VACÍO') . "\n";
echo "</pre>";

echo "<h2>3. URLs Generadas por Laravel</h2>";
echo "<pre>";
echo "url('/'): " . url('/') . "\n";
echo "url('/admin'): " . url('/admin') . "\n";
echo "asset('css/app.css'): " . asset('css/app.css') . "\n";
echo "asset('vendor/adminlte/dist/css/adminlte.min.css'): " . asset('vendor/adminlte/dist/css/adminlte.min.css') . "\n";
echo "asset('vendor/jquery/jquery.min.js'): " . asset('vendor/jquery/jquery.min.js') . "\n";
echo "</pre>";

echo "<h2>4. Verificación de Archivos</h2>";
echo "<pre>";
$archivos = [
    'vendor/adminlte/dist/css/adminlte.min.css',
    'vendor/jquery/jquery.min.js',
    'vendor/bootstrap/js/bootstrap.bundle.min.js',
    'vendor/fontawesome-free/css/all.min.css',
];

foreach ($archivos as $archivo) {
    $ruta = __DIR__ . '/' . $archivo;
    $existe = file_exists($ruta);
    $icono = $existe ? '✅' : '❌';
    echo "$icono $archivo: " . ($existe ? 'EXISTE' : 'NO EXISTE') . "\n";
}
echo "</pre>";

echo "<h2>5. Test de Carga de CSS</h2>";
$cssUrl = asset('vendor/adminlte/dist/css/adminlte.min.css');
echo "<p>Intentando cargar: <a href='$cssUrl' target='_blank'>$cssUrl</a></p>";
echo "<link rel='stylesheet' href='$cssUrl'>";
echo "<div class='card' style='max-width: 400px; margin: 20px 0;'>";
echo "<div class='card-header'>Si ves este card con estilo AdminLTE, funciona</div>";
echo "<div class='card-body'><p>Card body text</p></div>";
echo "</div>";

echo "<h2>6. Caché de Config</h2>";
echo "<pre>";
$cacheFile = base_path('bootstrap/cache/config.php');
if (file_exists($cacheFile)) {
    echo "⚠️ EXISTE caché de configuración: $cacheFile\n";
    echo "Última modificación: " . date('Y-m-d H:i:s', filemtime($cacheFile)) . "\n";
    echo "\n👉 Ejecuta: php artisan config:clear\n";
} else {
    echo "✅ No hay caché de configuración (leyendo .env directo)\n";
}
echo "</pre>";

echo "<hr>";
echo "<h2>🔧 Acciones Recomendadas</h2>";
echo "<ol>";
echo "<li>Verificar que el .env tenga: <code>ASSET_URL=https://munilayaradalospalos.gob.pe/muni</code></li>";
echo "<li>Ejecutar: <code>php artisan config:clear</code></li>";
echo "<li>Verificar que la carpeta <code>vendor/</code> existe en <code>public_html/muni/</code></li>";
echo "</ol>";

echo "<p><strong>ELIMINAR ESTE ARCHIVO DESPUÉS DE USAR</strong></p>";
echo "</body></html>";

