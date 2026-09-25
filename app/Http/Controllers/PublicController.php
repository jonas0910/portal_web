<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documento;
use App\Models\Servicio;
use App\Models\Contacto;
use App\Models\Pagina;
use App\Models\Menu;
use App\Models\Banner;
use App\Models\ConfiguracionSitio;
use App\Models\Tema;
use App\Models\CategoriaDocumento;
use App\Models\Noticia;
use App\Models\Proyecto;
use App\Models\FotoAniversario;
use App\Models\Evento;
use App\Models\Plantilla;
use Illuminate\Support\Facades\Http;

class PublicController extends Controller
{
    /**
     * Pagina principal publica dinamica
     */
    public function index()
    {
        $paginaInicio = Pagina::where('slug', 'inicio')->activas()->first();

        if (!$paginaInicio) {
            $paginaInicio = Pagina::create([
                'titulo' => 'Colegio de Notarios',
                'slug' => 'inicio',
                'descripcion' => 'Portal oficial del Colegio de Notarios',
                'contenido' => '<h1>Bienvenido al Colegio de Notarios</h1><p>Seguridad jurídica y fe pública al servicio de la región.</p>',
                'tipo' => 'landing',
                'activa' => true,
                'mostrar_en_menu' => false,
                'orden' => 0
            ]);
        }

        $tema = Tema::obtenerPredeterminado();
        if (!$tema) {
            $tema = new Tema();
            $tema->fuente_principal = 'Inter';
            $tema->color_primario = '#007bff';
            $tema->color_secundario = '#6c757d';
            $tema->color_acento = '#28a745';
            $tema->color_navbar = '#e8f5e9';
            $tema->mostrar_header_accesos = true;
            $tema->mostrar_footer = true;
        }
        $configuracion = $tema->configuracion ?? [];

        if (is_string($configuracion)) {
            $configuracion = json_decode($configuracion, true) ?? [];
        }

        $widgets = $configuracion['widgets'] ?? [];

        try {
            $banners = Banner::obtenerPrincipales();
        } catch (\Exception $e) {
            $banners = collect([]);
        }

        $notariosDestacados = collect([]);
        $serviciosDestacados = Servicio::where('activo', true)->take(60)->get();

        $noticiasRecientes = Noticia::publicadas()
            ->orderBy('fecha_publicacion', 'desc')
            ->take(6)
            ->get();

        $proyectosEnCurso = Proyecto::publicados()
            ->enCurso()
            ->orderBy('fecha_inicio', 'desc')
            ->take(4)
            ->get();

        $estadisticas = [
            'proyectos' => Proyecto::where('publicado', true)->whereIn('estado', ['en_curso', 'planificacion'])->count(),
            'servicios' => Servicio::where('activo', true)->count(),
            'documentos' => Documento::where('publico', true)->count(),
            'anos_experiencia' => ConfiguracionSitio::obtener('anos_experiencia', 25)
        ];

        $plantillaSlug = $paginaInicio->plantilla?->slug ?? 'landing';
        $vistaPlantilla = 'plantillas.' . $plantillaSlug;

        if (!view()->exists($vistaPlantilla)) {
            $vistaPlantilla = 'public.index';
        }

        $plantillaComponentes = [];
        $plantillaDB = \App\Models\Plantilla::where('slug', $plantillaSlug)->first();
        if ($plantillaDB && $plantillaDB->componentes) {
            $plantillaComponentes = is_array($plantillaDB->componentes) ? $plantillaDB->componentes : json_decode($plantillaDB->componentes, true) ?? [];
        }

        return view($vistaPlantilla, compact(
            'paginaInicio', 'banners', 'notariosDestacados', 'serviciosDestacados',
            'noticiasRecientes', 'proyectosEnCurso', 'estadisticas', 'tema', 'widgets',
            'plantillaComponentes'
        ));
    }

    /**
     * Preview de un tema (para gestor de contenidos).
     * Renderiza la página principal con el tema especificado para visualizar colores, tipografía, etc.
     */
    public function previewTema(int $id)
    {
        $tema = Tema::find($id);
        if (!$tema) {
            abort(404, 'Tema no encontrado');
        }

        $configuracion = $tema->configuracion ?? [];
        if (is_string($configuracion)) {
            $configuracion = json_decode($configuracion, true) ?? [];
        }
        $widgets = $configuracion['widgets'] ?? [];

        try {
            $banners = Banner::obtenerPrincipales();
        } catch (\Exception $e) {
            $banners = collect([]);
        }

        $notariosDestacados = collect([]);
        $serviciosDestacados = Servicio::where('activo', true)->take(6)->get();
        $noticiasRecientes = Noticia::publicadas()->orderBy('fecha_publicacion', 'desc')->take(6)->get();
        $proyectosEnCurso = Proyecto::publicados()->enCurso()->orderBy('fecha_inicio', 'desc')->take(4)->get();
        $estadisticas = [
            'proyectos' => Proyecto::where('publicado', true)->whereIn('estado', ['en_curso', 'planificacion'])->count(),
            'servicios' => Servicio::where('activo', true)->count(),
            'documentos' => Documento::where('publico', true)->count(),
            'anos_experiencia' => ConfiguracionSitio::obtener('anos_experiencia', 25)
        ];

        $paginaInicio = Pagina::where('slug', 'inicio')->activas()->first();
        if (!$paginaInicio) {
            $paginaInicio = new \stdClass();
            $paginaInicio->titulo = 'Preview del Tema';
            $paginaInicio->slug = 'inicio';
            $paginaInicio->descripcion = 'Vista previa del tema ' . $tema->nombre;
            $paginaInicio->plantilla_id = null;
            $paginaInicio->plantilla = null;
        }

        $plantillaSlug = $paginaInicio->plantilla?->slug ?? 'landing';
        $vistaPlantilla = 'plantillas.' . $plantillaSlug;
        if (!view()->exists($vistaPlantilla)) {
            $vistaPlantilla = 'public.index';
        }

        $plantillaComponentes = ['banner', 'estadisticas', 'servicios', 'noticias', 'proyectos'];
        $plantillaDB = Plantilla::where('slug', $plantillaSlug)->first();
        if ($plantillaDB && $plantillaDB->componentes) {
            $plantillaComponentes = is_array($plantillaDB->componentes) ? $plantillaDB->componentes : json_decode($plantillaDB->componentes, true) ?? $plantillaComponentes;
        }

        return view($vistaPlantilla, compact(
            'paginaInicio', 'banners', 'notariosDestacados', 'serviciosDestacados',
            'noticiasRecientes', 'proyectosEnCurso', 'estadisticas', 'tema', 'widgets',
            'plantillaComponentes'
        ));
    }

    /**
     * Preview HTML de una plantilla (para gestor de contenidos).
     * Renderiza la plantilla con datos de ejemplo.
     */
    public function previewPlantilla(int $id)
    {
        $plantilla = Plantilla::find($id);
        if (!$plantilla) {
            abort(404, 'Plantilla no encontrada');
        }

        $tema = Tema::obtenerPredeterminado();
        if (!$tema) {
            $tema = new Tema();
            $tema->fuente_principal = 'Inter';
            $tema->color_primario = '#007bff';
            $tema->color_secundario = '#6c757d';
            $tema->color_acento = '#28a745';
            $tema->color_navbar = '#e8f5e9';
            $tema->mostrar_header_accesos = true;
            $tema->mostrar_footer = true;
        }
        $configuracion = $tema->configuracion ?? [];
        if (is_string($configuracion)) {
            $configuracion = json_decode($configuracion, true) ?? [];
        }
        $widgets = $configuracion['widgets'] ?? [];

        try {
            $banners = Banner::obtenerPrincipales();
        } catch (\Exception $e) {
            $banners = collect([]);
        }

        $notariosDestacados = collect([]);
        $serviciosDestacados = Servicio::where('activo', true)->take(6)->get();
        $noticiasRecientes = Noticia::publicadas()->orderBy('fecha_publicacion', 'desc')->take(6)->get();
        $proyectosEnCurso = Proyecto::publicados()->enCurso()->orderBy('fecha_inicio', 'desc')->take(4)->get();
        $estadisticas = [
            'proyectos' => Proyecto::where('publicado', true)->whereIn('estado', ['en_curso', 'planificacion'])->count(),
            'servicios' => Servicio::where('activo', true)->count(),
            'documentos' => Documento::where('publico', true)->count(),
            'anos_experiencia' => ConfiguracionSitio::obtener('anos_experiencia', 25)
        ];

        $plantillaComponentes = is_array($plantilla->componentes) ? $plantilla->componentes : (json_decode($plantilla->componentes ?? '[]', true) ?? []);
        if (empty($plantillaComponentes)) {
            $plantillaComponentes = ['banner', 'estadisticas', 'servicios', 'noticias', 'proyectos'];
        }

        $vista = $plantilla->vista ?? 'plantillas.landing';
        if (!view()->exists($vista)) {
            $vista = 'plantillas.landing';
        }
        if (!view()->exists($vista)) {
            $vista = 'public.index';
        }

        $paginaInicio = new \stdClass();
        $paginaInicio->titulo = 'Preview: ' . $plantilla->nombre;
        $paginaInicio->slug = 'inicio';
        $paginaInicio->descripcion = $plantilla->descripcion ?? '';
        $paginaInicio->plantilla_id = $plantilla->id;
        $paginaInicio->plantilla = $plantilla;

        $pagina = new \stdClass();
        $pagina->titulo = 'Preview: ' . $plantilla->nombre;
        $pagina->slug = 'preview';
        $pagina->descripcion = $plantilla->descripcion ?? '';
        $pagina->meta_titulo = $plantilla->nombre;
        $pagina->meta_descripcion = $plantilla->descripcion ?? '';
        $pagina->meta_keywords = 'municipalidad, preview';
        $pagina->contenido = '<h2>Vista previa de la plantilla</h2><p>Este es un contenido de ejemplo para visualizar cómo se verá la plantilla <strong>' . e($plantilla->nombre) . '</strong> en el portal.</p><p>Los componentes, estilos y estructura corresponden a la configuración actual de la plantilla.</p>';
        $pagina->imagen_principal = null;
        $pagina->imagen_principal_url = null;
        $pagina->imagenes_adicionales = [];
        $pagina->imagenes_adicionales_urls = [];
        $pagina->tipo = 'pagina';
        $pagina->plantilla_id = $plantilla->id;
        $pagina->plantilla = $plantilla;

        $datosAdicionales = [];
        $regidores = [];

        $vars = compact(
            'pagina', 'paginaInicio', 'tema', 'datosAdicionales', 'regidores',
            'banners', 'notariosDestacados', 'serviciosDestacados',
            'noticiasRecientes', 'proyectosEnCurso', 'estadisticas', 'widgets',
            'plantillaComponentes'
        );

        return view($vista, $vars);
    }

    /**
     * Pagina dinamica por slug
     */
    public function pagina($slug)
    {
        $pagina = Pagina::where('slug', $slug)->activas()->firstOrFail();

        // Reemplazo de variables dinámicas en el contenido
        if ($pagina->contenido) {
            $pagina->contenido = str_replace(
                ['{telefono}', '{celular}', '{email}'],
                [
                    ConfiguracionSitio::obtener('telefono_contacto', '052-630739'),
                    ConfiguracionSitio::obtener('telefono_contacto', '052-630739'), // Usamos el mismo si no hay celular separado
                    ConfiguracionSitio::obtener('email_contacto', 'colegionotariostacna@gmail.com')
                ],
                $pagina->contenido
            );
        }

        $tema = Tema::obtenerPredeterminado();

        $datosAdicionales = [];

        switch ($pagina->tipo) {
            case 'servicios':
                $datosAdicionales['servicios'] = Servicio::where('activo', true)->get();
                break;
            case 'documentos':
                $datosAdicionales['documentos'] = Documento::where('publico', true)->with(['categoria'])->paginate(10);
                break;
        }

        // Carga de miembros según el slug si corresponde
        $miembrosSlugs = [
            'junta-directiva' => 'junta_directiva',
            'tribunal-honor' => 'tribunal_honor',
            'decanos' => 'decano_historico'
        ];

        if (isset($miembrosSlugs[$slug])) {
            $datosAdicionales['miembros'] = \App\Models\MiembroColegio::activos()
                ->porTipo($miembrosSlugs[$slug])
                ->orderBy('orden')
                ->get();
        }

        $vista = 'public.pagina';

        if ($pagina->plantilla_id) {
            $plantilla = $pagina->plantilla;
            if ($plantilla && $plantilla->activa && $plantilla->vista) {
                $vistaCandidata = $plantilla->vista;
                $vista = view()->exists($vistaCandidata) ? $vistaCandidata : $vista;
            }
        }

        if ($slug === 'regidores') {
            $datosAdicionales['regidores'] = self::extraerRegidoresDeContenido($pagina->contenido);
        }

        return view($vista, array_merge(compact('pagina', 'tema'), $datosAdicionales));
    }

    /**
     * Mesa de Partes - Página principal con opciones (nuevo / consulta)
     */
    public function mesaPartes()
    {
        $tiposTramite = [];
        $baseUrl = rtrim(config('app.intranet_storage_url', 'http://localhost:8000'), '/');
        $urlTipos = $baseUrl . '/api/tramite-documentario/publico/tipos';
        try {
            $response = Http::timeout(5)->get($urlTipos);
            if ($response->successful()) {
                $data = $response->json();
                $tiposTramite = $data['data'] ?? [];
            }
        } catch (\Throwable $e) {
            // Si el backend no está disponible, mostrar lista vacía
        }

        return view('public.mesa-partes', compact('tiposTramite'));
    }

    /**
     * Mesa de Partes - Formulario de nuevo trámite (ruta separada)
     */
    public function mesaPartesNuevo()
    {
        return view('public.mesa-partes-nuevo');
    }

    /**
     * Mesa de Partes - Formulario de consulta de expediente (ruta separada)
     */
    public function mesaPartesConsulta(Request $request)
    {
        $resultadoConsulta = null;
        $errorConsulta = null;
        if ($request->filled('codigo')) {
            $codigo = trim($request->codigo);
            $baseUrl = rtrim(config('app.intranet_storage_url', 'http://localhost:8000'), '/');
            $urlConsulta = $baseUrl . '/api/tramite-documentario/publico/consultar/' . urlencode($codigo);
            try {
                $resp = Http::timeout(5)->get($urlConsulta);
                if ($resp->successful()) {
                    $resultadoConsulta = $resp->json();
                } else {
                    $err = $resp->json();
                    $errorConsulta = $err['message'] ?? 'Expediente no encontrado';
                }
            } catch (\Throwable $e) {
                $errorConsulta = 'Error al consultar. Verifique su conexión.';
            }
        }

        return view('public.mesa-partes-consulta', compact('resultadoConsulta', 'errorConsulta'));
    }

    /**
     * API: Consultar expediente (para AJAX desde mesa-partes)
     */
    public function consultarExpediente(Request $request)
    {
        $codigo = trim($request->input('codigo', ''));
        if ($codigo === '') {
            return response()->json(['success' => false, 'message' => 'Ingrese el número de expediente o código']);
        }
        $baseUrl = rtrim(config('app.intranet_storage_url', 'http://localhost:8000'), '/');
        $url = $baseUrl . '/api/tramite-documentario/publico/consultar/' . urlencode($codigo);
        try {
            $resp = Http::timeout(5)->get($url);
            $data = $resp->json();
            if ($resp->successful()) {
                return response()->json($data);
            }
            return response()->json(['success' => false, 'message' => $data['message'] ?? 'Expediente no encontrado']);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => 'Error al consultar. Verifique su conexión.']);
        }
    }

    /**
     * Registrar trámite desde portal (mesa de partes público)
     */
    public function registrarTramite(Request $request)
    {
        $request->validate([
            'tipo_tramite_id' => 'nullable|integer',
            'tipo_documento_presenta' => 'nullable|string|max:80',
            'asunto' => 'required|string|max:500',
            'descripcion' => 'nullable|string|max:2000',
            'tipo_documento' => 'nullable|string|in:DNI,CE,RUC,PASAPORTE,OTRO',
            'numero_documento' => 'required|string|max:30',
            'nombres' => 'required|string|max:200',
            'apellidos' => 'nullable|string|max:200',
            'razon_social' => 'nullable|string|max:200',
            'ruc' => 'nullable|string|max:15',
            'email' => 'required|email',
            'telefono' => 'nullable|string|max:30',
            'celular' => 'nullable|string|max:30',
            'direccion' => 'nullable|string|max:500',
            'folios' => 'nullable|integer|min:1|max:999',
            'numero_documento_externo' => 'nullable|string|max:80',
            'fecha_documento_externo' => 'nullable|date',
            'archivos' => 'nullable|array',
            'archivos.*' => 'file|max:5120|mimes:pdf,doc,docx,jpg,jpeg,png',
            'acepto_terminos' => 'required|accepted',
        ]);

        $baseUrl = rtrim(config('app.intranet_storage_url', 'http://localhost:8000'), '/');
        $url = $baseUrl . '/api/tramite-documentario/publico/registrar';

        $multipart = [];
        $fields = [
            'tipo_tramite_id', 'tipo_documento_presenta', 'asunto', 'descripcion', 'tipo_documento', 'numero_documento',
            'nombres', 'apellidos', 'razon_social', 'ruc', 'email', 'telefono', 'celular', 'direccion', 'folios',
            'numero_documento_externo', 'fecha_documento_externo'
        ];
        foreach ($fields as $f) {
            if ($request->filled($f)) {
                $multipart[] = ['name' => $f, 'contents' => (string) $request->input($f)];
            }
        }

        $archivos = $request->file('archivos');
        if (is_array($archivos)) {
            foreach ($archivos as $file) {
                if ($file && $file->isValid()) {
                    $multipart[] = [
                        'name' => 'archivos[]',
                        'contents' => fopen($file->getRealPath(), 'r'),
                        'filename' => $file->getClientOriginalName(),
                    ];
                }
            }
        }

        try {
            $resp = Http::timeout(30)->asMultipart()->post($url, $multipart);
            $data = $resp->json();
            if ($resp->successful() && ($data['success'] ?? false)) {
                return response()->json($data);
            }
            return response()->json([
                'success' => false,
                'message' => $data['message'] ?? 'Error al registrar el trámite'
            ], 422);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => 'Error de conexión. Intente más tarde.'], 500);
        }
    }

    /**
     * Servicios
     */
    public function servicios(Request $request)
    {
        $query = Servicio::where('activo', true);
        
        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }
        
        $servicios = $query->get();
        return view('public.servicios', compact('servicios'));
    }

    /**
     * Documentos publicos
     */
    public function documentos(Request $request)
    {
        $categorias = CategoriaDocumento::activas()->get();
        $query = Documento::where('publico', true)->with(['categoria']);

        if ($request->filled('tipo')) {
            $query->where('categoria_id', $request->tipo);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        $documentos = $query->paginate(10);
        return view('public.documentos', compact('documentos', 'categorias'));
    }

    /**
     * Descargar documento
     */
    public function descargarDocumento($id)
    {
        $documento = Documento::find($id);

        if (!$documento || !$documento->publico) {
            abort(404);
        }

        if (!$documento->archivo || !\Storage::disk('public')->exists($documento->archivo)) {
            abort(404, 'Archivo no encontrado');
        }

        $path = \Storage::disk('public')->path($documento->archivo);

        return response()->file($path, [
            'Content-Disposition' => 'inline; filename="' . basename($documento->archivo) . '"'
        ]);
    }

    /**
     * Contacto
     */
    public function contacto()
    {
        return view('public.contacto');
    }

    /**
     * Enviar mensaje de contacto
     */
    public function enviarContacto(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'nullable|string|max:20',
            'asunto' => 'required|string|max:255',
            'mensaje' => 'required|string|max:1000',
        ]);

        $datos = $request->all();
        $datos['leido'] = false;
        $datos['respondido'] = false;

        Contacto::create($datos);

        return redirect()->back()->with('success', 'Mensaje enviado correctamente. Te contactaremos pronto.');
    }

    /**
     * Lista de noticias publicas
     */
    public function noticias(Request $request)
    {
        $query = Noticia::publicadas();

        if ($request->filled('categoria')) {
            $query->categoria($request->categoria);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                  ->orWhere('resumen', 'like', "%{$search}%")
                  ->orWhere('contenido', 'like', "%{$search}%");
            });
        }

        $noticias = $query->orderBy('fecha_publicacion', 'desc')
                         ->orderBy('orden')
                         ->paginate(12);

        $noticiasDestacadas = Noticia::publicadas()->destacadas()->take(3)->get();
        $categorias = Noticia::publicadas()->pluck('categoria')->unique()->filter();

        return view('public.noticias', compact('noticias', 'noticiasDestacadas', 'categorias'));
    }

    /**
     * Detalle de una noticia
     */
    public function noticia($slug)
    {
        $noticia = Noticia::where('slug', $slug)->publicadas()->firstOrFail();
        $noticia->incrementarVistas();

        $noticiasRelacionadas = Noticia::publicadas()
            ->where('id', '!=', $noticia->id)
            ->where('categoria', $noticia->categoria)
            ->take(3)
            ->get();

        return view('public.noticia', compact('noticia', 'noticiasRelacionadas'));
    }

    /**
     * Lista de proyectos publicos
     */
    public function proyectos(Request $request)
    {
        $query = Proyecto::publicados();

        if ($request->filled('estado')) {
            $query->estado($request->estado);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                  ->orWhere('descripcion_corta', 'like', "%{$search}%")
                  ->orWhere('descripcion_completa', 'like', "%{$search}%");
            });
        }

        $proyectos = $query->orderBy('fecha_inicio', 'desc')
                          ->orderBy('orden')
                          ->paginate(12);

        $proyectosDestacados = Proyecto::publicados()->destacados()->take(3)->get();
        $proyectosEnCurso = Proyecto::publicados()->enCurso()->count();

        return view('public.proyectos', compact('proyectos', 'proyectosDestacados', 'proyectosEnCurso'));
    }

    /**
     * Detalle de un proyecto
     */
    public function proyecto($slug)
    {
        $proyecto = Proyecto::where('slug', $slug)->publicados()->firstOrFail();

        $proyectosRelacionados = Proyecto::publicados()
            ->enCurso()
            ->where('id', '!=', $proyecto->id)
            ->take(3)
            ->get();

        return view('public.proyecto', compact('proyecto', 'proyectosRelacionados'));
    }

    /**
     * API para obtener fotos de aniversario (para modal)
     */
    public function fotosAniversario(Request $request)
    {
        $query = FotoAniversario::where('activo', true);

        if ($request->has('anuncio')) {
            $query->where('es_anuncio', true);
        } else {
            $query->where('es_anuncio', false);
        }

        $query->orderBy('orden', 'asc');

        if ($request->filled('anio')) {
            $query->where('anio', $request->anio);
        }

        $fotosActivas = $query->get();

        $fotos = $fotosActivas->filter(function($foto) {
            $hoy = now()->startOfDay();

            $tieneInicio = !empty($foto->fecha_inicio);
            $tieneFin = !empty($foto->fecha_fin);

            if (!$tieneInicio && !$tieneFin) {
                return true;
            }

            if ($tieneInicio && !$tieneFin) {
                return $hoy->gte($foto->fecha_inicio);
            }

            if (!$tieneInicio && $tieneFin) {
                return $hoy->lte($foto->fecha_fin);
            }

            return $hoy->between($foto->fecha_inicio, $foto->fecha_fin);
        })->values();

        $resultado = $fotos->map(function($foto) {
            return [
                'id' => $foto->id,
                'titulo' => $foto->titulo ?? 'Sin titulo',
                'nombre_actividad' => $foto->nombre_actividad,
                'descripcion' => $foto->descripcion ?? '',
                'imagen' => $foto->imagen_url,
                'thumbnail' => $foto->thumbnail_url,
                'anio' => $foto->anio,
                'fecha' => $foto->fecha?->format('d/m/Y'),
                'orden' => $foto->orden
            ];
        });

        return response()->json([
            'success' => true,
            'fotos' => $resultado,
            'total' => $resultado->count()
        ]);
    }

    /**
     * Bolsa de Trabajo - Lista de ofertas de empleo
     */
    public function bolsaTrabajo(Request $request)
    {
        $query = \App\Models\OfertaEmpleo::abiertas();

        if ($request->filled('modalidad')) {
            $query->where('modalidad', $request->modalidad);
        }

        if ($request->filled('tipo_contrato')) {
            $query->where('tipo_contrato', $request->tipo_contrato);
        }

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('titulo', 'like', "%{$buscar}%")
                  ->orWhere('descripcion', 'like', "%{$buscar}%");
            });
        }

        $ofertas = $query->orderBy('created_at', 'desc')
                         ->paginate(12);

        $ofertasDestacadas = collect([]);

        $modalidades = \App\Models\OfertaEmpleo::abiertas()
                    ->whereNotNull('modalidad')
                    ->pluck('modalidad')
                    ->unique()
                    ->filter()
                    ->values();

        return view('public.bolsa-trabajo', compact('ofertas', 'ofertasDestacadas', 'modalidades'));
    }

    /**
     * Detalle de una oferta de empleo
     */
    public function ofertaEmpleo($slug)
    {
        $oferta = \App\Models\OfertaEmpleo::where('slug', $slug)->abiertas()->firstOrFail();

        try {
            $oferta->incrementarVistas();
        } catch (\Exception $e) {
            // Method may not exist on current schema
        }

        $ofertasRelacionadas = \App\Models\OfertaEmpleo::abiertas()
            ->where('id', '!=', $oferta->id)
            ->where('modalidad', $oferta->modalidad)
            ->take(3)
            ->get();

        return view('public.oferta-empleo', compact('oferta', 'ofertasRelacionadas'));
    }

    /**
     * Agenda Municipal - Lista de eventos
     */
    public function eventos(Request $request)
    {
        $tema = Tema::obtenerPredeterminado();
        $eventos = Evento::orderBy('fecha_inicio', 'desc')->paginate(12);

        return view('public.eventos', compact('eventos', 'tema'));
    }

    /**
     * Galería de Fotos - Agrupada por actividad
     */
    public function galeria()
    {
        $tema = Tema::obtenerPredeterminado();
        $fotos = FotoAniversario::where('activo', true)
            ->orderBy('nombre_actividad')
            ->orderBy('orden')
            ->get()
            ->groupBy('nombre_actividad');
            
        return view('public.galeria', compact('fotos', 'tema'));
    }

    /**
     * Directorio de Notarios (Dinamico)
     */
    public function notarios(Request $request)
    {
        $tema = Tema::obtenerPredeterminado();
        
        $query = \App\Models\MiembroColegio::activos()->porTipo('notario');

        if ($request->filled('distrito')) {
            $query->where('distrito', $request->distrito);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%$search%")
                  ->orWhere('apellidos', 'like', "%$search%")
                  ->orWhere('notaria', 'like', "%$search%")
                  ->orWhere('direccion', 'like', "%$search%");
            });
        }

        $colaboradores = $query->orderBy('orden')->orderBy('nombre')->get();

        return view('public.notarios', compact('colaboradores', 'tema'));
    }

    /**
     * Extrae regidores del contenido HTML (gc_paginas.contenido) para mostrarlos en cards.
     */
    private static function extraerRegidoresDeContenido(?string $contenido): array
    {
        $defaults = [
            ['nombre' => 'Guillermo Fernando Aranda Hurtado', 'cargo' => 'Regidor', 'partido' => 'Avanza País', 'avatar' => 'primary'],
            ['nombre' => 'Danitza Yessica Perez Calizaya', 'cargo' => 'Regidora', 'partido' => 'Avanza País', 'avatar' => 'danger'],
            ['nombre' => 'Rolando Froilan Mamani Calizaya', 'cargo' => 'Regidor', 'partido' => 'Avanza País', 'avatar' => 'success'],
            ['nombre' => 'Evelia Yunca Yunca', 'cargo' => 'Regidora', 'partido' => 'Avanza País', 'avatar' => 'warning'],
            ['nombre' => 'Sandra Teresa Briceño Navarro', 'cargo' => 'Regidora', 'partido' => 'Acción Popular', 'avatar' => 'secondary'],
        ];

        if (empty($contenido)) return $defaults;

        $avatarColors = ['primary', 'danger', 'success', 'warning', 'secondary'];
        $regidores = [];

        $patrones = [
            '/<h5[^>]*>([^<]+)<\/h5>\s*<p[^>]*>([^<]+)<\/p>\s*<span[^>]*>([^<]+)<\/span>/s',
            '/class="[^"]*card-title[^"]*"[^>]*>([^<]+)<\/[^>]+>\s*<p[^>]*>([^<]+)<\/p>\s*<span[^>]*>([^<]+)<\/span>/s',
            '/<div[^>]*card-body[^>]*>([\s\S]*?)<\/div>/s',
        ];

        foreach ($patrones as $idx => $patron) {
            if ($idx <= 1 && preg_match_all($patron, $contenido, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $m) {
                    $nombre = trim(strip_tags($m[1]));
                    $cargo = trim(strip_tags($m[2]));
                    $partido = trim(strip_tags($m[3]));
                    if (strlen($nombre) > 2 && stripos($nombre, 'Funciones') === false
                        && (stripos($cargo, 'regidor') !== false || strlen($cargo) < 50)) {
                        $regidores[] = [
                            'nombre' => $nombre,
                            'cargo' => $cargo ?: 'Regidor',
                            'partido' => $partido ?: '—',
                            'avatar' => $avatarColors[count($regidores) % count($avatarColors)],
                        ];
                    }
                }
                if (!empty($regidores)) break;
            }
            if ($idx === 2 && empty($regidores) && preg_match_all($patron, $contenido, $cardBodies, PREG_SET_ORDER)) {
                foreach ($cardBodies as $body) {
                    $html = $body[1];
                    $nombre = $cargo = $partido = '';
                    if (preg_match('/<(?:h5|strong|b)[^>]*>([^<]+)<\/[^>]+>/', $html, $n)) $nombre = trim(strip_tags($n[1]));
                    if (preg_match('/<p[^>]*>([^<]*Regidor[^<]*)<\/p>/i', $html, $c)) $cargo = trim(strip_tags($c[1]));
                    if (preg_match('/<span[^>]*class="[^"]*badge[^"]*"[^>]*>([^<]+)<\/span>/', $html, $p)) $partido = trim(strip_tags($p[1]));
                    elseif (preg_match('/<span[^>]*>([^<]+)<\/span>/', $html, $p)) $partido = trim(strip_tags($p[1]));
                    if (strlen($nombre) > 2 && stripos($nombre, 'Funciones') === false && stripos($nombre, 'Concejo Municipal') === false) {
                        $regidores[] = [
                            'nombre' => $nombre,
                            'cargo' => $cargo ?: 'Regidor',
                            'partido' => $partido ?: '—',
                            'avatar' => $avatarColors[count($regidores) % count($avatarColors)],
                        ];
                    }
                }
            }
        }

        return !empty($regidores) ? $regidores : $defaults;
    }
}