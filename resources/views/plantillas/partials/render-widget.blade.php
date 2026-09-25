{{-- 
    Partial para renderizar un widget/componente
    Parámetros: $widget (array con tipo, config), $anchoCompleto (boolean)
--}}
@php
    $tipo = $widget['tipo'];
    $config = $widget['config'];
    $fondoClass = 'bg-' . ($config['fondo'] ?? 'white');
    $containerClass = $anchoCompleto ? 'container-fluid' : 'container';
@endphp

@if($tipo == 'banner')
    {{-- Banner Principal --}}
    @if(isset($banners) && $banners->count() > 0)
        @include('components.public.widget-hero-banner', ['tema' => $tema])
    @endif

@elseif($tipo == 'estadisticas')
    {{-- Estadísticas --}}
    @if(isset($estadisticas))
    <section class="stats-section py-5 {{ $fondoClass }}">
        <div class="{{ $containerClass }}">
            <div class="row mb-4 justify-content-center">
                <div class="col-md-9 text-center">
                    <h2 class="fw-bold text-uppercase text-dark" style="letter-spacing: 2px; font-size: 1.25rem;">Presencia Institucional</h2>
                    <div class="title-divider mx-auto mt-3" style="width: 45px; height: 3px; background-color: var(--secondary-color); border-radius: 2px;"></div>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="stat-item">
                        <div class="stat-number fs-1 text-primary fw-bold">{{ $estadisticas['proyectos'] ?? 0 }}</div>
                        <div class="stat-label text-muted">Proyectos Activos</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="stat-item">
                        <div class="stat-number fs-1 fw-bold" style="color: #334155;">{{ $estadisticas['servicios'] ?? 0 }}</div>
                        <div class="stat-label text-muted">Servicios</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="stat-item">
                        <div class="stat-number fs-1 fw-bold" style="color: var(--primary-color);">{{ $estadisticas['documentos'] ?? 0 }}</div>
                        <div class="stat-label text-muted">Documentos</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="stat-item">
                        <div class="stat-number fs-1 fw-bold" style="color: #334155;">{{ $estadisticas['anos_experiencia'] ?? 0 }}</div>
                        <div class="stat-label text-muted">Años de Veracidad</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

@elseif($tipo == 'servicios')
    {{-- Servicios Destacados --}}
    @if(isset($serviciosDestacados) && $serviciosDestacados->count() > 0)
    @php
        $cantidadServicios = $config['cantidad'] ?? 6;
        $columnasServicios = $config['columnas'] ?? '3';
        $colClass = $columnasServicios == '2' ? 'col-md-6' : ($columnasServicios == '4' ? 'col-md-3' : 'col-md-4');
        $mostrarPrecio = $config['mostrar_precio'] ?? true;
        
        // Paleta de colores basada en el tema (con variaciones de opacidad para profesionalismo)
        $primaryColor = $tema->color_primario ?? '#0d2137';
        $colors = [
            $primaryColor,
            $tema->color_secundario ?? '#c5a059',
            $primaryColor . 'aa', // con opacidad
            ($tema->color_secundario ?? '#c5a059') . 'aa',
            $primaryColor . 'dd',
            ($tema->color_secundario ?? '#c5a059') . 'dd',
        ];
    @endphp
    <section class="py-5 {{ $fondoClass ?? 'bg-light' }}">
        <div class="{{ $containerClass ?? 'container' }}">
            <!-- Encabezado de Sección -->
            <div class="row mb-5 justify-content-center">
                <div class="col-md-8 text-center">
                    <span class="badge bg-success bg-opacity-10 text-success fw-semibold px-3 py-2 rounded-pill mb-2">
                        <i class="fas fa-balance-scale me-1"></i> Servicios Notariales
                    </span>
                    <h2 class="fw-bold text-dark mb-2" style="letter-spacing: -0.5px; font-size: 1.8rem;">Atención Legal y Protocolar</h2>
                    <p class="text-muted small mb-3">Formalización de actos jurídicos, trámites corporativos y asuntos no contenciosos con la máxima seguridad jurídica.</p>
                    <div class="mx-auto" style="width: 50px; height: 3px; background-color: var(--primary-color, #198754); border-radius: 2px;"></div>
                </div>
            </div>
    
            @php
                // Definición estructurada de servicios notariales según jerarquía principal
                $categoriasServicios = [
                    [
                        'titulo' => 'Escrituras Públicas e Inmuebles',
                        'icono' => 'fas fa-file-contract',
                        'descripcion' => 'Transferencias de propiedad, poderes protocolares, donaciones y garantías reales sobre bienes prediales.',
                        'url' => 'compra-venta-anticipo-donacion-inmuebles',
                        'destacados' => ['Compra Venta / Donación', 'Poderes por Escritura', 'Garantía Hipotecaria']
                    ],
                    [
                        'titulo' => 'Derecho Empresarial y Sociedades',
                        'icono' => 'fas fa-building-user',
                        'descripcion' => 'Constitución e inscripción de E.I.R.L., S.A.C., S.R.L. y Asociaciones Sin Fines de Lucro ante SUNARP.',
                        'url' => 'constitucion-empresa-eirl',
                        'destacados' => ['Constitución de E.I.R.L.', 'Sociedades (S.A.C. / S.R.L.)', 'Asociaciones']
                    ],
                    [
                        'titulo' => 'Asuntos No Contenciosos',
                        'icono' => 'fas fa-scale-balanced',
                        'descripcion' => 'Sucesión intestada, divorcio notarial, matrimonios civiles, rectificaciones y prescripciones adquisitivas.',
                        'url' => 'sucesion-intestada',
                        'destacados' => ['Sucesión Intestada', 'Divorcio Notarial', 'Unión de Hecho']
                    ],
                    [
                        'titulo' => 'Trámites Vehiculares y Certificaciones',
                        'icono' => 'fas fa-car-side',
                        'descripcion' => 'Transferencias de dominio vehicular, permisos de viaje para menores, legalizaciones de firma y apertura de libros.',
                        'url' => 'transferencia-vehicular',
                        'destacados' => ['Transferencia Vehicular', 'Permisos de Viaje', 'Legalización de Libros']
                    ],
                ];
            @endphp
    
            <!-- Grilla Principal de Servicios Categorizados -->
            <div class="row g-4 justify-content-center">
                @foreach($categoriasServicios as $index => $cat)
                @php
                    $colorAccent = $colors[$index % count($colors)] ?? '#198754';
                @endphp
                <div class="col-lg-6 col-md-12">
                    <div class="card h-100 border-light-subtle shadow-sm rounded-3 p-4 bg-white position-relative overflow-hidden elegant-service-card">
                        
                        <!-- Ícono Marca de Agua de Fondo -->
                        <i class="{{ $cat['icono'] }} position-absolute" style="font-size: 8rem; color: #f8fafc; bottom: -15px; right: -15px; z-index: 0; transform: rotate(-10deg); pointer-events: none;"></i>
    
                        <div class="position-relative" style="z-index: 1;">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 me-3 card-icon-wrapper" 
                                     style="width: 55px; height: 55px; background-color: #f8fafc; border: 1px solid #e2e8f0; color: {{ $colorAccent }};">
                                    <i class="{{ $cat['icono'] }} fa-lg"></i>
                                </div>
                                <h5 class="fw-bold mb-0 text-dark" style="letter-spacing: -0.3px;">
                                    {{ $cat['titulo'] }}
                                </h5>
                            </div>
    
                            <p class="text-muted small mb-3" style="line-height: 1.6;">
                                {{ $cat['descripcion'] }}
                            </p>
    
                            <!-- Sub-etiquetas destacadas -->
                            <div class="d-flex flex-wrap gap-2 mb-4">
                                @foreach($cat['destacados'] as $tag)
                                    <span class="badge bg-light text-secondary border border-light-subtle fw-normal px-2 py-1 small">
                                        &bull; {{ $tag }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
    
                        <!-- Enlace de Ingreso -->
                        <div class="position-relative mt-auto pt-3 border-top border-light-subtle d-flex justify-content-end" style="z-index: 1;">
                            <a href="{{ url($cat['url']) }}" class="text-decoration-none fw-semibold small d-inline-flex align-items-center elegant-link" style="color: {{ $colorAccent }};">
                                Consultar requisitos <i class="fas fa-arrow-right ms-2 link-arrow" style="font-size: 0.8rem; transition: transform 0.3s ease;"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
    
        </div>
    </section>
    
    <style>
        /* Transiciones y efectos elevados */
        .elegant-service-card {
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        .elegant-service-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.06) !important;
            border-color: #cbd5e1 !important;
        }
        .elegant-service-card:hover .card-icon-wrapper {
            background-color: var(--primary-color, #198754) !important;
            color: #ffffff !important;
            border-color: var(--primary-color, #198754) !important;
        }
        .card-icon-wrapper {
            transition: all 0.3s ease;
        }
        .elegant-link:hover .link-arrow {
            transform: translateX(4px);
        }
    </style>
    @endif

@elseif($tipo == 'noticias')
    {{-- Noticias Recientes con movimiento elegante --}}
    @if(isset($noticiasRecientes) && $noticiasRecientes->count() > 0)
    <div class="{{ $fondoClass }} py-3">
        <div class="container-fluid px-md-5">
            @include('components.public.widget-noticias-recientes', [
                'noticias' => $noticiasRecientes->take(10),
                'config' => array_merge($config, ['vista' => 'carousel-list'])
            ])
        </div>
    </div>
    @endif

@elseif($tipo == 'proyectos')
    {{-- Proyectos en Curso --}}
    @if(isset($proyectosEnCurso) && $proyectosEnCurso->count() > 0)
    @php
        $cantidadProyectos = $config['cantidad'] ?? 4;
        $columnasProyectos = $config['columnas'] ?? '2';
        $vistaProyectos = $config['vista'] ?? 'grid';
    @endphp
    <div class="{{ $fondoClass }} py-3">
        <div class="{{ $containerClass }}">
            @include('components.public.widget-proyectos-curso', [
                'proyectos' => $proyectosEnCurso->take($cantidadProyectos),
                'columnas' => $columnasProyectos,
                'config' => $config
            ])
        </div>
    </div>
    @endif

@elseif($tipo == 'notarios')
    {{-- Notarios Destacados --}}
    @if(isset($notariosDestacados) && $notariosDestacados->count() > 0)
    @php
        $cantidadNotarios = $config['cantidad'] ?? 4;
        $columnasNotarios = $config['columnas'] ?? '4';
        $colClassNotarios = $columnasNotarios == '2' ? 'col-md-6' : ($columnasNotarios == '3' ? 'col-md-4' : 'col-md-3');
    @endphp
    <section class="py-4 {{ $fondoClass }}">
        <div class="{{ $containerClass }}">
            <div class="row mb-4 justify-content-center">
                <div class="col-md-9 text-center">
                    <h2 class="fw-bold text-uppercase text-dark" style="letter-spacing: 1px; font-size: 1.25rem;">Notarios Destacados</h2>
                    <div class="title-divider mx-auto mt-3" style="width: 45px; height: 3px; background-color: var(--secondary-color); border-radius: 2px;"></div>
                </div>
            </div>
            <div class="row">
                @foreach($notariosDestacados->take($cantidadNotarios) as $notario)
                <div class="{{ $colClassNotarios }} mb-4">
                    <div class="card h-100 text-center shadow-sm border-0 hover-card">
                        @if($notario->foto)
                        <div class="p-3">
                            <img src="{{ asset('storage/' . $notario->foto) }}" 
                                 class="rounded-circle mx-auto d-block" 
                                 alt="{{ $notario->nombre_completo }}"
                                 style="width: 120px; height: 120px; object-fit: cover;">
                        </div>
                        @else
                        <div class="p-3">
                            <i class="fas fa-user-circle fa-5x text-muted"></i>
                        </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $notario->nombre_completo }}</h5>
                            @if($notario->especialidad)
                            <p class="card-text"><small class="text-muted">{{ $notario->especialidad }}</small></p>
                            @endif
                            <a href="{{ route('public.notario', $notario->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye"></i> Ver Perfil
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

@elseif($tipo == 'testimonios')
    {{-- Testimonios --}}
    @php
        $testimonios = \App\Models\Testimonio::where('activo', true)
            ->orderBy('orden', 'asc')
            ->orderBy('created_at', 'desc')
            ->take($config['cantidad'] ?? 3)
            ->get();
            
        // Determinar clase de columna basada en configuración
        $columnasTestimonios = $config['columnas'] ?? '3';
        $colClassTestimonios = match($columnasTestimonios) {
            '2' => 'col-md-6',
            '3' => 'col-md-6 col-lg-4',
            '4' => 'col-md-6 col-lg-3',
            default => 'col-md-6 col-lg-4'
        };
    @endphp
    @if($testimonios->count() > 0)
    <section class="py-4 {{ $fondoClass }}">
        <div class="{{ $containerClass }}">
            <div class="row mb-4 justify-content-center">
                <div class="col-md-9 text-center">
                    <h2 class="fw-bold text-uppercase text-dark" style="letter-spacing: 1px; font-size: 1.25rem;">Lo Que Dicen Nuestros Clientes</h2>
                    <div class="title-divider mx-auto mt-3" style="width: 45px; height: 3px; background-color: var(--secondary-color); border-radius: 2px;"></div>
                </div>
            </div>
            <div class="row">
                @foreach($testimonios as $testimonio)
                <div class="{{ $colClassTestimonios }} mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body">
                            <div class="text-warning mb-3">
                                @for($i = 0; $i < ($testimonio->calificacion ?? 5); $i++)
                                    <i class="fas fa-star"></i>
                                @endfor
                            </div>
                            <p class="card-text text-muted fst-italic">"{{ $testimonio->testimonio }}"</p>
                            <div class="mt-3">
                                <strong>{{ $testimonio->nombre_cliente }}</strong>
                                @if($testimonio->cargo)
                                <br><small class="text-muted">{{ $testimonio->cargo }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

@elseif($tipo == 'eventos')
    {{-- Eventos Próximos (Calendario Interactivo) --}}
    @include('components.public.widget-calendario-audiencias', ['tema' => $tema])

@elseif($tipo == 'facebook')
    {{-- Widget Facebook --}}
    <section class="py-4 {{ $fondoClass }}">
        <div class="{{ $containerClass }}">
            @include('components.public.widget-facebook', ['config' => $config])
        </div>
    </section>

@elseif($tipo == 'youtube')
    {{-- Widget YouTube --}}
    <section class="py-4 {{ $fondoClass }}">
        <div class="{{ $containerClass }}">
            @include('components.public.widget-youtube', ['config' => $config])
        </div>
    </section>
@elseif($tipo == 'prefooter_bar')
    {{-- Barra Pre-Footer como Widget --}}
    @php
        $footerBarItems = \App\Models\AccesoDirecto::paraFooter();
        // Marcar que ya se renderizó para evitar duplicados en el layout
        $GLOBALS['prefooter_rendered'] = true;
    @endphp
    @if($footerBarItems->count() > 0)
    <section class="py-3 {{ $fondoClass }}" id="prefooter-section">
        <div class="{{ $containerClass }}">
            <div class="row">
                <div class="col-12">
                    <div class="footer-bar-container text-center shadow-sm" 
                         style="background: {{ ($config['fondo'] ?? 'white') == 'white' ? '#fff' : '#f8f9fa' }}; 
                                border: 1px solid rgba(0,0,0,0.08); 
                                border-radius: 16px; 
                                padding: 15px 25px;
                                border-top: 3px solid var(--primary-color);">
                        <div class="d-flex flex-wrap justify-content-center align-items-center gap-md-5 gap-3">
                            @foreach($footerBarItems as $item)
                            <a href="{{ $item->url_final }}" 
                               target="{{ $item->target }}" 
                               class="footer-bar-item transition-all hover-lift"
                               title="{{ $item->descripcion ?? $item->titulo }}"
                               style="display: flex; align-items: center; justify-content: center;">
                                @if($item->tieneImagen())
                                    <img src="{{ $item->imagen_url }}" 
                                         alt="{{ $item->titulo }}" 
                                         style="height: {{ $item->imagen_alto ?? 60 }}px; width: auto; max-width: 200px; object-fit: contain; filter: grayscale(100%) opacity(0.7); transition: all 0.3s ease;">
                                @elseif($item->icono)
                                    <i class="{{ $item->icono }}" style="font-size: 40px; color: var(--primary-color); opacity: 0.8;"></i>
                                @endif
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .footer-bar-item:hover img {
                filter: grayscale(0%) opacity(1) !important;
                transform: scale(1.1);
            }
            .transition-all { transition: all 0.3s ease; }
        </style>
    </section>
    @endif

@elseif($tipo == 'bienvenida')
    {{-- Sección de Bienvenida Institucional Elegante --}}
    @php
        $bienvenidaTitulo = \App\Models\ConfiguracionSitio::obtener('bienvenida_titulo', 'Notaría Bohórquez Vega');
        $bienvenidaTexto = \App\Models\ConfiguracionSitio::obtener('bienvenida_texto', 'Notaría Bohórquez Vega, les da la bienvenida a nuestro portal web que ponemos a su disposición para dar a conocer nuestros servicios notariales, sus requisitos, absolver sus consultas e informar nuestros medios para contactarse con nosotros.');
    @endphp
    <section class="py-5 bg-light position-relative">
        <div class="{{ $containerClass }}">
            <div class="elegant-welcome-card bg-white shadow-sm p-5 text-center position-relative overflow-hidden" style="border-radius: 12px; border: 1px solid #f3f4f6;">
                
                {{-- Marca de agua sutil de fondo --}}
                <i class="fas fa-landmark position-absolute" style="font-size: 18rem; color: #f9fafb; top: -30px; right: -40px; z-index: 0; transform: rotate(-10deg);"></i>
                
                <div class="position-relative" style="z-index: 1;">
                    <h2 class="fw-bold text-dark mb-4" style="letter-spacing: 1px; font-size: 2.2rem; color: #1f2937 !important;">
                        {{ $bienvenidaTitulo }}
                    </h2>
                    
                    {{-- Divisor elegante --}}
                    <div class="mx-auto mb-4" style="width: 50px; height: 3px; background-color: var(--primary-color, #2563eb); border-radius: 2px;"></div>
                    
                    <p class="text-secondary mb-0 mx-auto" style="max-width: 800px; line-height: 1.9; font-size: 1.1rem; font-weight: 300; color: #4b5563 !important;">
                        {{ $bienvenidaTexto }}
                    </p>
                </div>
            </div>
        </div>
    </section>

@elseif($tipo == 'ley_notarial')
    {{-- Sección Ley 30908 Premium --}}
    @php
        $leyTitulo = \App\Models\ConfiguracionSitio::obtener('ley_notarial_titulo', 'Garantía de Libre Elección');
        $leyTexto = \App\Models\ConfiguracionSitio::obtener('ley_notarial_texto', 'Todo usuario tiene el derecho esencial de elegir al notario que le preste el servicio. Respetamos y defendemos su libertad de elección (Ley N° 30908), absteniéndonos de prácticas que limiten su decisión frente a entidades financieras o terceros.');
    @endphp
    <section class="py-4 {{ $fondoClass }}">
        <div class="{{ $containerClass }}">
            <div class="elegant-law-box bg-white p-4 p-md-5 shadow-sm d-flex flex-column flex-md-row align-items-center gap-4 position-relative overflow-hidden" style="border-radius: 12px; border: 1px solid #e5e7eb;">
                
                {{-- Línea lateral corporativa --}}
                <div class="position-absolute top-0 start-0 h-100" style="width: 5px; background-color: var(--primary-color, #2563eb);"></div>

                {{-- Ícono destacado --}}
                <div class="law-icon-wrapper rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" 
                     style="width: 75px; height: 75px; background-color: #f8fafc; border: 1px solid #e2e8f0; color: var(--primary-color, #2563eb);">
                    <i class="fas fa-balance-scale" style="font-size: 2rem;"></i>
                </div>

                {{-- Contenido del texto --}}
                <div class="text-center text-md-start">
                    <h5 class="fw-bold mb-3" style="letter-spacing: 0.5px; color: #111827;">
                        {{ $leyTitulo }}
                    </h5>
                    <p class="mb-0" style="font-size: 1rem; line-height: 1.7; color: #4b5563;">
                        {{ $leyTexto }}
                    </p>
                </div>
            </div>
        </div>
    </section>

@elseif($tipo == 'enlaces_interes')
    {{-- Enlaces de Interés Compactos --}}
    <section class="py-5 bg-light">
        <div class="{{ $containerClass }}">
            <div class="row mb-4 justify-content-center">
                <div class="col-md-9 text-center">
                    <h2 class="fw-bold text-uppercase text-dark" style="letter-spacing: 1px; font-size: 1.25rem;">Enlaces de Interés</h2>
                    <div class="title-divider mx-auto mt-3" style="width: 45px; height: 3px; background-color: var(--secondary-color); border-radius: 2px;"></div>
                </div>
            </div>
            <div class="row g-4 justify-content-center align-items-center text-center">
                @php
                    $enlacesItems = \App\Models\AccesoDirecto::where('tipo', 'interes')->activos()->ordenados()->get();
                @endphp
                @foreach($enlacesItems as $item)
                <div class="col-4 col-md-2">
                    <a href="{{ $item->url_final }}" target="_blank" class="d-block p-2 bg-white shadow-sm rounded-3 hover-lift transition-all text-decoration-none border" title="{{ $item->titulo }}">
                        <div class="logo-container" style="height: 40px; display: flex; align-items: center; justify-content: center;">
                            @if($item->imagen)
                            <img src="{{ $item->imagen_url }}" alt="{{ $item->titulo }}" class="img-fluid" style="max-height: 100%; object-fit: contain;">
                            @else
                            <i class="{{ $item->icono ?? 'fas fa-external-link-alt' }} text-muted"></i>
                            @endif
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <style>
        .hover-lift { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .hover-lift:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
    </style>
@endif
