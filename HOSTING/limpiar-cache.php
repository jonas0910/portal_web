<?php
/**
 * Script temporal para limpiar caché de Laravel
 * SUBIR A: public_html/muni/limpiar-cache.php
 * EJECUTAR: https://munilayaradalospalos.gob.pe/muni/limpiar-cache.php
 * ELIMINAR DESPUÉS DE USAR
 */

// Cargar Laravel
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "<h2>Limpiando caché de Laravel...</h2>";
echo "<pre>";

try {
    // Limpiar caché de configuración
    Artisan::call('config:clear');
    echo "✓ Config cache limpiado\n";
    echo Artisan::output();
    
    // Limpiar caché de vistas
    Artisan::call('view:clear');
    echo "✓ View cache limpiado\n";
    echo Artisan::output();
    
    // Limpiar caché general
    Artisan::call('cache:clear');
    echo "✓ Cache general limpiado\n";
    echo Artisan::output();
    
    // Limpiar caché de rutas
    Artisan::call('route:clear');
    echo "✓ Route cache limpiado\n";
    echo Artisan::output();
    
    // Regenerar caché de configuración
    Artisan::call('config:cache');
    echo "✓ Config cache regenerado\n";
    echo Artisan::output();
    
    echo "\n</pre>";
    echo "<h3 style='color:green'>✅ Caché limpiado correctamente!</h3>";
    echo "<p><strong>IMPORTANTE:</strong> Elimina este archivo después de usarlo.</p>";
    echo "<p><a href='/muni/admin'>Ir al Admin</a> | <a href='/muni'>Ir al Portal</a></p>";
    
    // Mostrar configuración actual
    echo "<hr><h4>Configuración actual:</h4><pre>";
    echo "APP_URL: " . config('app.url') . "\n";
    echo "ASSET_URL: " . config('app.asset_url') . "\n";
    echo "APP_ENV: " . config('app.env') . "\n";
    echo "</pre>";
    
} catch (Exception $e) {
    echo "\n</pre>";
    echo "<h3 style='color:red'>❌ Error: " . $e->getMessage() . "</h3>";
}

