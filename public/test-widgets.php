<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Http\Kernel');

$response = $kernel->handle(
    $request = Illuminate\Http\Request::create('/', 'GET')
);

$content = $response->getContent();

// Buscar los widgets en el HTML
$widgets_encontrados = [];

if (strpos($content, 'estadisticas-section') !== false) {
    $widgets_encontrados[] = 'Estadísticas';
}

if (strpos($content, 'notarios-destacados') !== false) {
    $widgets_encontrados[] = 'Notarios';
}

if (strpos($content, 'Widget de Servicios') !== false || strpos($content, 'servicios-destacados') !== false) {
    $widgets_encontrados[] = 'Servicios';
}

if (strpos($content, 'formulario-contacto') !== false || strpos($content, 'Formulario de Contacto') !== false) {
    $widgets_encontrados[] = 'Contacto';
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Test de Widgets</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        .result { background: white; padding: 20px; margin: 10px 0; border-radius: 5px; }
        .success { border-left: 4px solid #4CAF50; }
        .error { border-left: 4px solid #f44336; }
        .widget-found { color: #4CAF50; font-weight: bold; }
        .widget-missing { color: #f44336; font-weight: bold; }
    </style>
</head>
<body>
    <h1>🧪 Test de Widgets</h1>
    
    <div class="result <?php echo count($widgets_encontrados) > 0 ? 'success' : 'error'; ?>">
        <h2>Resultado:</h2>
        <p><strong>Widgets encontrados en el HTML:</strong> <?php echo count($widgets_encontrados); ?>/4</p>
        
        <?php if (count($widgets_encontrados) > 0): ?>
            <ul>
                <?php foreach ($widgets_encontrados as $widget): ?>
                    <li class="widget-found">✅ <?php echo $widget; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="widget-missing">❌ No se encontraron widgets en el HTML renderizado</p>
        <?php endif; ?>
        
        <?php
        $esperados = ['Estadísticas', 'Notarios', 'Servicios', 'Contacto'];
        $faltantes = array_diff($esperados, $widgets_encontrados);
        if (count($faltantes) > 0):
        ?>
            <h3>Widgets que faltan:</h3>
            <ul>
                <?php foreach ($faltantes as $widget): ?>
                    <li class="widget-missing">❌ <?php echo $widget; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    
    <div class="result">
        <h2>Información de Debug:</h2>
        <p><strong>Tamaño del HTML:</strong> <?php echo number_format(strlen($content)); ?> bytes</p>
        <p><strong>Contiene 'Widget':</strong> <?php echo strpos($content, 'Widget') !== false ? '✅ SÍ' : '❌ NO'; ?></p>
        <p><strong>Contiene 'Widgets Dinámicos':</strong> <?php echo strpos($content, 'Widgets Dinámicos') !== false ? '✅ SÍ' : '❌ NO'; ?></p>
    </div>
    
    <div class="result">
        <h2>Acciones:</h2>
        <ol>
            <li>Si ves widgets aquí pero no en la página principal, limpia el caché del navegador</li>
            <li>Abre en modo incógnito: <a href="http://127.0.0.1:9000" target="_blank">http://127.0.0.1:9000</a></li>
            <li>Si aún no aparecen, revisa la consola del navegador (F12)</li>
        </ol>
    </div>
    
    <hr>
    <small>Archivo: public/test-widgets.php</small>
</body>
</html>
<?php
$kernel->terminate($request, $response);
?>

