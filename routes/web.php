<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\PostulacionController;
use App\Http\Controllers\CitaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Public portal routes only. No authentication, no admin panel.
| Connects to intranet_municipal database (gc_ prefixed tables).
|
*/

// Pagina principal
Route::get('/', [PublicController::class, 'index'])->name('public.index');

// Preview de plantilla (para gestor de contenidos - renderizado HTML)
Route::get('/preview/plantilla/{id}', [PublicController::class, 'previewPlantilla'])->name('public.preview.plantilla');

// Preview de tema (para gestor de contenidos - visualizar colores, tipografía, etc.)
Route::get('/preview/tema/{id}', [PublicController::class, 'previewTema'])->name('public.preview.tema');

// Postulaciones (publico)
Route::post('/postulaciones', [PostulacionController::class, 'store'])->name('postulaciones.store');

// Rutas publicas especificas
Route::get('/servicios', [PublicController::class, 'servicios'])->name('public.servicios');
Route::get('/colaboradores', [PublicController::class, 'notarios'])->name('public.colaboradores');
Route::get('/galeria', [PublicController::class, 'galeria'])->name('public.galeria');
Route::get('/documentos', [PublicController::class, 'documentos'])->name('public.documentos');
Route::get('/documentos/{id}/descargar', [PublicController::class, 'descargarDocumento'])->name('public.documentos.descargar');
Route::get('/contacto', [PublicController::class, 'contacto'])->name('public.contacto');
Route::post('/contacto', [PublicController::class, 'enviarContacto'])->name('public.contacto.enviar');

// Noticias
Route::get('/noticias', [PublicController::class, 'noticias'])->name('public.noticias');
Route::get('/noticias/{slug}', [PublicController::class, 'noticia'])->name('public.noticia');

// Proyectos
Route::get('/proyectos', [PublicController::class, 'proyectos'])->name('public.proyectos');
Route::get('/proyectos/{slug}', [PublicController::class, 'proyecto'])->name('public.proyecto');

// Bolsa de Trabajo
Route::get('/bolsa-trabajo', [PublicController::class, 'bolsaTrabajo'])->name('public.bolsa-trabajo');
Route::get('/bolsa-trabajo/{slug}', [PublicController::class, 'ofertaEmpleo'])->name('public.oferta-empleo');

// Eventos / Agenda Municipal
Route::get('/agenda-municipal', [PublicController::class, 'eventos'])->name('public.eventos');

// Citas - Agendar cita
Route::get('/citas/crear', [CitaController::class, 'crear'])->name('public.citas.crear');
Route::post('/citas', [CitaController::class, 'store'])->name('public.citas.store');

// Mesa de Partes (Trámite Documentario - rutas separadas)
Route::get('/mesa-partes', [PublicController::class, 'mesaPartes'])->name('public.mesa-partes');
Route::get('/mesa-partes/nuevo', [PublicController::class, 'mesaPartesNuevo'])->name('public.mesa-partes.nuevo');
Route::get('/mesa-partes/consulta', [PublicController::class, 'mesaPartesConsulta'])->name('public.mesa-partes.consulta');
Route::get('/web-api/mesa-partes/consultar', [PublicController::class, 'consultarExpediente'])->name('public.mesa-partes.consultar');
Route::post('/mesa-partes/registrar', [PublicController::class, 'registrarTramite'])->name('public.mesa-partes.registrar');

// API publica para fotos de aniversario (modal)
Route::get('/web-api/fotos-aniversario', [PublicController::class, 'fotosAniversario'])->name('public.fotos-aniversario');

// Proxy de media: sirve imágenes del backend intranet (8000) o desde disco si el backend no está disponible
Route::get('/media/{path}', function (Request $request, string $path) {
    if (str_contains($path, '..')) abort(404);
    $path = ltrim($path, '/');
    
    // Normalizar la ruta eliminando el prefijo 'storage/' si existe
    $normPath = str_replace('storage/', '', $path);
    
    // 1. INTENTAR DESDE DISCO LOCAL DEL PORTAL (Más rápido y seguro)
    if (\Illuminate\Support\Facades\Storage::disk('public')->exists($normPath)) {
        return response()->file(\Illuminate\Support\Facades\Storage::disk('public')->path($normPath), [
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }

    // 2. PROXY AL BACKEND (Evitar bucles infinitos en localhost:8000)
    $intranetBase = rtrim(config('app.intranet_storage_url', 'http://localhost:8000'), '/');
    $currentBase = url('/');
    
    if (!(str_contains($intranetBase, 'localhost:8000') && str_contains($currentBase, 'localhost:8000'))) {
        $url = $intranetBase . '/media/' . $path;
        try {
            $response = Http::timeout(2)->get($url);
            if ($response->successful()) {
                $mime = $response->header('Content-Type') ?? 'image/jpeg';
                return response($response->body(), 200, [
                    'Content-Type' => $mime,
                    'Cache-Control' => 'public, max-age=86400',
                ]);
            }
        } catch (\Throwable $e) {}
    }
    
    // 3. INTENTAR DESE DISCO DEL INTRANET (Búsqueda por ruta absoluta)
    $intranetDiskPath = config('app.intranet_storage_path') ?: base_path('../intranet-backend/storage/app/public');
    $fullPath = rtrim($intranetDiskPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $normPath);
    
    if (file_exists($fullPath) && is_file($fullPath)) {
        return response()->file($fullPath, [
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
    
    abort(404);
})->where('path', '.+')->name('media.proxy');

// --- Servir archivos desde Storage (evita depender del enlace public/storage) ---

Route::get('/archivos/proyectos/principal/{filename}', function (string $filename) {
    $path = 'proyectos/' . $filename;
    if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
        abort(404);
    }
    return response()->file(\Illuminate\Support\Facades\Storage::disk('public')->path($path));
})->where('filename', '[a-zA-Z0-9_.\-]+')->name('archivo.proyecto.principal');

Route::get('/archivos/proyectos/galeria/{filename}', function (string $filename) {
    $path = 'proyectos/galeria/' . $filename;
    if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
        abort(404);
    }
    return response()->file(\Illuminate\Support\Facades\Storage::disk('public')->path($path));
})->where('filename', '[a-zA-Z0-9_.\-]+')->name('archivo.galeria');

Route::get('/archivos/noticias/principal/{filename}', function (string $filename) {
    $path = 'noticias/' . $filename;
    if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
        abort(404);
    }
    return response()->file(\Illuminate\Support\Facades\Storage::disk('public')->path($path));
})->where('filename', '[a-zA-Z0-9_.\-]+')->name('archivo.noticia.principal');

Route::get('/archivos/noticias/miniatura/{filename}', function (string $filename) {
    $path = 'noticias/miniaturas/' . $filename;
    if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
        abort(404);
    }
    return response()->file(\Illuminate\Support\Facades\Storage::disk('public')->path($path));
})->where('filename', '[a-zA-Z0-9_.\-]+')->name('archivo.noticia.miniatura');

Route::get('/archivos/noticias/galeria/{filename}', function (string $filename) {
    $path = 'noticias/galeria/' . $filename;
    if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
        abort(404);
    }
    return response()->file(\Illuminate\Support\Facades\Storage::disk('public')->path($path));
})->where('filename', '[a-zA-Z0-9_.\-]+')->name('archivo.noticia.galeria');

// Servir fotos de aniversario localmente para evitar 404 en el proxy
Route::get('/storage/fotos_aniversario/{filename}', function (string $filename) {
    $path = 'fotos_aniversario/' . $filename;
    if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
        abort(404);
    }
    return response()->file(\Illuminate\Support\Facades\Storage::disk('public')->path($path));
})->where('filename', '[a-zA-Z0-9_. \-()]+')->name('archivo.foto_aniversario');

// Alias para compatibilidad con el prefijo /media/storage/
Route::get('/media/storage/fotos_aniversario/{filename}', function (string $filename) {
    $path = 'fotos_aniversario/' . $filename;
    if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
        abort(404);
    }
    return response()->file(\Illuminate\Support\Facades\Storage::disk('public')->path($path));
})->where('filename', '[a-zA-Z0-9_. \-()]+');

// Catch-all para paginas dinamicas (DEBE IR AL FINAL)
Route::get('/{slug}', [PublicController::class, 'pagina'])->name('public.pagina');
