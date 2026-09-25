{{--
    Widget de Proyectos en Curso
    Muestra los proyectos activos con su progreso, estado y detalles
--}}

@props(['proyectos' => null, 'cantidad' => 4, 'columnas' => '2', 'titulo' => 'Proyectos en Curso', 'config' => []])

@php
    // Si no se pasan proyectos, obtenerlos aquí
    if (!$proyectos) {
        $proyectos = \App\Models\Proyecto::publicados()
            ->enCurso()
            ->orderBy('fecha_inicio', 'desc')
            ->take($cantidad)
            ->get();
    }
    
    // Determinar vista/estilo
    $vista = $config['vista'] ?? 'grid';
    
    // Determinar clase de columna basada en configuración (solo para vista grid)
    $columnasConfig = $config['columnas'] ?? $columnas;
    $colClass = match($columnasConfig) {
        '2' => 'col-md-6',
        '3' => 'col-md-6 col-lg-4',
        '4' => 'col-md-6 col-lg-3',
        default => 'col-md-6'
    };
@endphp

@if($proyectos && $proyectos->count() > 0)
<section class="proyectos-curso py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="display-5 fw-bold mb-4 text-dark">
                    {{ $titulo }}
                </h2>
                <div class="title-divider mx-auto mb-5"></div>
            </div>
        </div>

        @if($vista === 'carousel-list')
            {{-- Vista Carrusel + Lista --}}
            <div class="row">
                {{-- Columna Izquierda: Carrusel (destacado grande) --}}
                <div class="col-lg-8 mb-4">
                    <div id="proyectosCarousel" class="carousel slide shadow-lg" data-bs-ride="carousel" data-bs-interval="5000" data-bs-pause="hover">
                        <div class="carousel-indicators">
                            @foreach($proyectos->take(5) as $index => $proyecto)
                            <button type="button" data-bs-target="#proyectosCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"></button>
                            @endforeach
                        </div>
                        <div class="carousel-inner">
                            @foreach($proyectos->take(5) as $index => $proyecto)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <a href="{{ route('public.proyecto', $proyecto->slug) }}" class="d-block marco-img-carrusel">
                                    @if($proyecto->imagen_principal)
                                    <img src="{{ $proyecto->imagen_principal_url }}" alt="{{ $proyecto->titulo }}">
                                    @else
                                    <span class="d-flex align-items-center justify-content-center w-100 h-100 bg-success text-white"><i class="fas fa-project-diagram fa-5x"></i></span>
                                    @endif
                                    <div class="carousel-caption d-block bg-dark bg-opacity-75 p-3 rounded">
                                        <div class="mb-2">
                                            <span class="badge badge-{{ $proyecto->estado == 'en_curso' ? 'success' : ($proyecto->estado == 'planificacion' ? 'warning' : 'info') }}">
                                                {{ ucfirst(str_replace('_', ' ', $proyecto->estado)) }}
                                            </span>
                                        </div>
                                        <h5 class="text-white fw-bold">{{ Str::limit($proyecto->titulo, 50) }}</h5>
                                        <div class="progress mt-2" style="height: 6px;">
                                            <div class="progress-bar bg-light" 
                                                 role="progressbar" 
                                                 style="width: {{ $proyecto->progreso }}%" 
                                                 aria-valuenow="{{ $proyecto->progreso }}" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100">
                                            </div>
                                        </div>
                                        <p class="text-white-50 mb-0 small mt-1">{{ $proyecto->progreso }}% completado</p>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#proyectosCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#proyectosCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Siguiente</span>
                        </button>
                    </div>
                </div>

                {{-- Columna Derecha: Lista pequeña y legible --}}
                <div class="col-lg-4">
                    <div id="proyectosListaScroll" class="proyectos-lista" style="max-height: 400px; overflow: hidden; position: relative;">
                        @foreach($proyectos as $proyecto)
                        <div class="proyecto-item-horizontal mb-2 p-2 bg-white shadow-sm rounded hover-shadow d-flex align-items-center">
                            <div class="marco-img-lista flex-shrink-0">
                                <a href="{{ route('public.proyecto', $proyecto->slug) }}" class="d-block w-100 h-100">
                                    @if($proyecto->imagen_principal)
                                    <img src="{{ $proyecto->imagen_principal_url }}" alt="{{ $proyecto->titulo }}">
                                    @else
                                    <span class="d-flex align-items-center justify-content-center w-100 h-100 bg-light text-success"><i class="fas fa-project-diagram fa-2x"></i></span>
                                    @endif
                                </a>
                            </div>
                            <div class="contenido-lista ps-3 flex-grow-1 overflow-hidden">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="badge badge-{{ $proyecto->estado == 'en_curso' ? 'success' : ($proyecto->estado == 'planificacion' ? 'warning' : 'info') }} small" style="font-size: 0.65rem;">
                                        {{ ucfirst(str_replace('_', ' ', $proyecto->estado)) }}
                                    </span>
                                    <small class="text-muted font-weight-bold" style="font-size: 0.7rem;">{{ $proyecto->progreso }}%</small>
                                </div>
                                <h6 class="mb-1 text-truncate" style="line-height: 1.2;">
                                    <a href="{{ route('public.proyecto', $proyecto->slug) }}" class="text-decoration-none text-dark fw-bold">
                                        {{ $proyecto->titulo }}
                                    </a>
                                </h6>
                                <p class="text-muted small mb-1 text-truncate">{{ Str::limit($proyecto->descripcion_corta, 50) }}</p>
                                
                                <div class="progress" style="height: 4px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $proyecto->progreso }}%" aria-valuenow="{{ $proyecto->progreso }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            {{-- Vista Grid (tradicional) --}}
            <div class="row">
                @foreach($proyectos as $proyecto)
                <div class="{{ $colClass }} mb-4">
                    <div class="card h-100 shadow-sm proyecto-card">
                        <div class="card-img-top-wrapper marco-img-proyecto-card position-relative">
                            @if($proyecto->imagen_principal)
                            <img src="{{ $proyecto->imagen_principal_url }}" class="card-img-top" alt="{{ $proyecto->titulo }}">
                            @else
                            <span class="d-flex align-items-center justify-content-center w-100 h-100 bg-light text-success"><i class="fas fa-project-diagram fa-3x"></i></span>
                            @endif
                            <div class="estado-badge">
                                <span class="badge bg-white text-{{ $proyecto->estado == 'en_curso' ? 'success' : ($proyecto->estado == 'planificacion' ? 'warning' : 'info') }} shadow-sm rounded-pill fw-normal px-3 py-2 small">
                                    {{ ucfirst(str_replace('_', ' ', $proyecto->estado)) }}
                                </span>
                            </div>
                        </div>
                    
                    <div class="card-body p-4">
                        <div class="mb-2">
                             @if($proyecto->fecha_inicio)
                                <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">
                                    Iniciado: {{ $proyecto->fecha_inicio->format('d M, Y') }}
                                </small>
                            @endif
                        </div>

                        <h5 class="card-title mb-3">
                            <a href="{{ route('public.proyecto', $proyecto->slug) }}" class="text-decoration-none text-dark fw-bold hover-link">
                                {{ Str::limit($proyecto->titulo, 50) }}
                            </a>
                        </h5>
                        
                        <p class="card-text text-muted small mb-4" style="line-height: 1.6;">
                            {{ Str::limit($proyecto->descripcion_corta, 100) }}
                        </p>
                        
                        <!-- Barra de progreso Minimal -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <small class="text-muted fw-bold" style="font-size: 0.7rem;">AVANCE</small>
                                <small class="text-success fw-bold">{{ $proyecto->progreso }}%</small>
                            </div>
                            <div class="progress rounded-pill bg-light" style="height: 6px;">
                                <div class="progress-bar bg-success rounded-pill" 
                                     role="progressbar" 
                                     style="width: {{ $proyecto->progreso }}%" 
                                     aria-valuenow="{{ $proyecto->progreso }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Información adicional limpia -->
                        <div class="proyecto-info pb-3 border-bottom mb-3">                            
                            @if($proyecto->presupuesto)
                            <div class="info-item">
                                <i class="fas fa-coins text-secondary small"></i>
                                <small class="text-muted">Presupuesto: S/ {{ number_format($proyecto->presupuesto, 2) }}</small>
                            </div>
                            @endif
                        </div>
                        
                        <a href="{{ route('public.proyecto', $proyecto->slug) }}" 
                           class="btn-link-custom text-success">
                            Ver detalles del proyecto <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
                @endforeach
            </div>
        @endif

        <div class="row mt-4">
            <div class="col-12 text-center">
            <div class="col-12 text-center pt-3">
                <a href="{{ route('public.proyectos') }}" class="btn btn-outline-success rounded-pill px-5 py-2 fw-bold">
                    Ver Todos los Proyectos
                </a>
            </div>
            </div>
        </div>
    </div>
</section>

<style>
    .proyecto-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
    }
    
    .proyecto-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
    }
    
    .estado-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 1;
    }
    
    .proyecto-info {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    
    .info-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .title-divider {
        width: 80px;
        height: 3px;
        background: linear-gradient(to right, #28a745, #20c997);
        margin-top: 1rem;
    }
    
    .card-title a:hover {
        color: #28a745 !important;
    }
    
    .progress-bar {
        transition: width 0.6s ease;
    }
    
    /* Estilos para vista carousel-list */
    .hover-shadow {
        transition: box-shadow 0.3s ease;
    }
    
    .hover-shadow:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.2) !important;
    }
    
    .hover-shadow:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.2) !important;
    }
    
    .carousel-item {
        transition: transform 1.5s ease-in-out !important;
    }

    .carousel-item img {
        border-radius: 10px;
    }
    
    .marco-img-carrusel {
        aspect-ratio: 16 / 9;
        width: 100%;
        max-height: 500px;
        min-height: 350px;
        padding: 10px;
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid rgba(0,0,0,0.08);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }
    
    .marco-img-carrusel img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
        transition: transform 0.5s ease;
        border-radius: 8px;
        background-color: #f8f9fa;
    }
    
    .marco-img-carrusel:hover img {
        transform: scale(1.02);
    }
    
    .carousel-caption {
        bottom: 20px;
        left: 20px;
        right: 20px;
    }
    
    /* Estilos para lista horizontal de proyectos */
    .proyectos-lista {
        scrollbar-width: thin;
        scrollbar-color: rgba(40, 167, 69, 0.3) transparent;
    }
    
    .proyectos-lista::-webkit-scrollbar {
        width: 6px;
    }
    
    .proyectos-lista::-webkit-scrollbar-track {
        background: transparent;
    }
    
    .proyectos-lista::-webkit-scrollbar-thumb {
        background-color: rgba(40, 167, 69, 0.3);
        border-radius: 3px;
    }
    
    .proyectos-lista::-webkit-scrollbar-thumb:hover {
        background-color: rgba(40, 167, 69, 0.5);
    }
    
    .proyecto-item-horizontal h6 a:hover {
        color: #28a745 !important;
    }
    
    .marco-img-proyecto-card {
        aspect-ratio: 16 / 9;
        width: 100%;
        max-height: 240px;
        overflow: hidden;
        border-radius: 12px 12px 0 0;
        background: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: inset 0 0 20px rgba(0,0,0,0.05);
    }
    
    .marco-img-proyecto-card img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
        transition: transform 0.5s ease;
    }
    
    .proyecto-card:hover .marco-img-proyecto-card img {
        transform: scale(1.05);
    }
    
    .proyecto-card {
        border: none;
        border-radius: 12px;
        background: #fff;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }
    
    .proyecto-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
    
    .letter-spacing-2 {
        letter-spacing: 2px;
    }

    .btn-link-custom {
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        transition: padding 0.3s ease;
        display: inline-flex;
        align-items: center;
    }
    
    .btn-link-custom:hover {
        padding-left: 5px;
    }
    
    .proyecto-item-horizontal {
        height: 100px;
        overflow: hidden;
    }

    .marco-img-lista {
        width: 84px;
        height: 84px;
        overflow: hidden;
        border-radius: 12px;
        background: #f8f9fa;
        box-shadow: 0 4px 8px rgba(0,0,0,0.05), 0 0 0 2px #ffffff;
    }
    
    .marco-img-lista img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        transition: transform 0.3s ease;
    }
    
    .proyecto-item-horizontal:hover .marco-img-lista img {
        transform: scale(1.1);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Lógica para el scroll automático de la lista de proyectos
        const container = document.getElementById('proyectosListaScroll');
        if (container) {
            // Duplicar contenido para scroll infinito
            const content = container.innerHTML;
            container.innerHTML = content + content;
            
            let scrollPos = 0;
            let isPaused = false;
            
            // Pausar al pasar el mouse
            container.addEventListener('mouseenter', () => isPaused = true);
            container.addEventListener('mouseleave', () => isPaused = false);
            container.addEventListener('touchstart', () => isPaused = true);
            container.addEventListener('touchend', () => isPaused = false);
            
            function autoScroll() {
                if (!isPaused) {
                    scrollPos += 0.5; // Velocidad del scroll (píxeles por frame)
                    if (scrollPos >= container.scrollHeight / 2) {
                        scrollPos = 0;
                    }
                    container.scrollTop = scrollPos;
                }
                requestAnimationFrame(autoScroll);
            }
            
            requestAnimationFrame(autoScroll);
        }
    });
</script>
@endif
