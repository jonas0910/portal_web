<?php

/**
 * ============================================
 * SCRIPT PARA ACTUALIZAR URLs A SUBCARPETA /muni/
 * ============================================
 * 
 * INSTRUCCIONES:
 * 1. Sube este archivo a public_html/muni/
 * 2. Ejecuta: php actualizar_urls_muni.php
 * 3. O abre en navegador: https://tu-dominio.com/muni/actualizar_urls_muni.php
 * 4. ELIMINA este archivo después de ejecutarlo
 * 
 * ============================================
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "<h1>Actualizando URLs para subcarpeta /muni/</h1>";
echo "<pre>";

// 1. Limpiar cachés
echo "\n== Limpiando cachés ==\n";
Artisan::call('config:clear');
echo Artisan::output();
Artisan::call('cache:clear');
echo Artisan::output();
Artisan::call('route:clear');
echo Artisan::output();
Artisan::call('view:clear');
echo Artisan::output();

// 2. Verificar APP_URL
echo "\n== Verificando configuración ==\n";
$appUrl = config('app.url');
echo "APP_URL actual: {$appUrl}\n";

if (strpos($appUrl, '/muni') === false) {
    echo "\n⚠️ WARNING: APP_URL no contiene /muni\n";
    echo "Debes editar el archivo .env y agregar:\n";
    echo "APP_URL=https://munilayaradalospalos.gob.pe/muni\n";
    echo "ASSET_URL=https://munilayaradalospalos.gob.pe/muni\n";
}

// 3. Actualizar URLs de menús que empiezan con /
echo "\n== Actualizando URLs de menús ==\n";

$menus = DB::table('menus')->get();
$updated = 0;

foreach ($menus as $menu) {
    $url = $menu->url;
    
    // Si la URL empieza con / pero NO con /muni
    if ($url && strpos($url, '/') === 0 && strpos($url, '/muni') !== 0 && strpos($url, 'http') !== 0) {
        $newUrl = '/muni' . $url;
        
        // Si es solo /, cambiar a /muni
        if ($url === '/') {
            $newUrl = '/muni';
        }
        
        DB::table('menus')->where('id', $menu->id)->update(['url' => $newUrl]);
        echo "Menu '{$menu->nombre}': {$url} → {$newUrl}\n";
        $updated++;
    }
}

echo "\nMenus actualizados: {$updated}\n";

// 4. Actualizar URLs de páginas si tienen URLs hardcodeadas
echo "\n== Verificando páginas ==\n";
$paginas = DB::table('paginas')->get();
echo "Páginas encontradas: " . count($paginas) . "\n";

// 5. Actualizar configuración del sitio
echo "\n== Actualizando configuración del sitio ==\n";

$configs = ['logo_header', 'logo_navbar', 'logo_footer', 'favicon'];
foreach ($configs as $key) {
    $config = DB::table('configuracion_sitio')->where('clave', $key)->first();
    if ($config && $config->valor) {
        $valor = $config->valor;
        // Si es una ruta que empieza con /storage pero no con /muni
        if (strpos($valor, '/storage') === 0 && strpos($valor, '/muni') !== 0) {
            $newValor = '/muni' . $valor;
            DB::table('configuracion_sitio')->where('clave', $key)->update(['valor' => $newValor]);
            echo "{$key}: {$valor} → {$newValor}\n";
        }
    }
}

// 6. Actualizar URLs de banners
echo "\n== Actualizando banners ==\n";
$banners = DB::table('banners')->get();
foreach ($banners as $banner) {
    $updates = [];
    
    if ($banner->link && strpos($banner->link, '/') === 0 && strpos($banner->link, '/muni') !== 0) {
        $updates['link'] = '/muni' . $banner->link;
        echo "Banner '{$banner->titulo}' link: {$banner->link} → {$updates['link']}\n";
    }
    
    if (!empty($updates)) {
        DB::table('banners')->where('id', $banner->id)->update($updates);
    }
}

// 7. Limpiar cachés de nuevo
echo "\n== Limpiando cachés finales ==\n";
Artisan::call('config:clear');
Artisan::call('cache:clear');
Artisan::call('view:clear');

echo "\n✅ PROCESO COMPLETADO\n";
echo "\n⚠️ IMPORTANTE: Elimina este archivo del servidor\n";
echo "</pre>";

echo "<h2>Siguiente paso:</h2>";
echo "<p>Recarga la página principal: <a href='/muni'>https://munilayaradalospalos.gob.pe/muni/</a></p>";

