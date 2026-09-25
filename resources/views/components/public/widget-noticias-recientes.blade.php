{{--
Widget de Noticias Recientes
Muestra las últimas noticias publicadas con imagen, título, resumen y enlace
--}}

@props(['noticias' => null, 'cantidad' => 6, 'columnas' => '3', 'titulo' => 'Últimas Noticias', 'config' => []])

@php
    // Si no se pasan noticias, obtenerlas aquí
    if (!$noticias) {
        $noticias = \App\Models\Noticia::publicadas()
            ->destacadas()
            ->orderBy('fecha_publicacion', 'desc')
            ->take($cantidad)
            ->get();
    }

    // Determinar vista/estilo
    $vista = $config['vista'] ?? 'grid';

    // Determinar clase de columna basada en configuración (solo para vista grid)
    $columnasConfig = $config['columnas'] ?? $columnas;
    $colClass = match ($columnasConfig) {
        '2' => 'col-md-6',
        '3' => 'col-md-6 col-lg-4',
        '4' => 'col-md-6 col-lg-3',
        default => 'col-md-6 col-lg-4'
    };
@endphp

@if($noticias && $noticias->count() > 0)
    <section class="noticias-recientes py-3">
        <div class="container">
            <div class="row mb-5 justify-content-center">
                <div class="col-md-9 text-center">
                    <h2 class="fw-bold text-uppercase text-dark" style="letter-spacing: 2px; font-size: 1.25rem;">
                        {{ $titulo }}
                    </h2>
                    <div class="title-divider mx-auto mt-3"
                        style="width: 45px; height: 3px; background-color: var(--secondary); border-radius: 2px;"></div>
                </div>
            </div>

            @if($vista === 'carousel-list')
                {{-- Vista Carrusel + Lista --}}
                <div class="row p-1 p-md-3 rounded-4 shadow-sm"
                    style="background-color: #fcfcfc; border: 1px solid rgba(0,0,0,0.05);">
                    {{-- Columna Izquierda: Carrusel (destacado grande) --}}
                    <div class="col-lg-9">
                        <div id="noticiasCarousel" class="carousel slide shadow-lg" data-bs-ride="carousel"
                            data-bs-interval="5000" data-bs-pause="hover">
                            <div class="carousel-indicators">
                                @foreach($noticias->take(5) as $index => $noticia)
                                    <button type="button" data-bs-target="#noticiasCarousel" data-bs-slide-to="{{ $index }}"
                                        class="{{ $index === 0 ? 'active' : '' }}"
                                        aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                                        aria-label="Slide {{ $index + 1 }}"></button>
                                @endforeach
                            </div>
                            <div class="carousel-inner">
                                @foreach($noticias->take(5) as $index => $noticia)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <a href="{{ route('public.noticia', $noticia->slug) }}"
                                            class="d-block marco-img-carrusel position-relative">
                                            <div class="date-badge shadow">
                                                <span
                                                    class="month">{{ \Carbon\Carbon::parse($noticia->fecha_publicacion)->format('M') }}</span>
                                                <span
                                                    class="day">{{ \Carbon\Carbon::parse($noticia->fecha_publicacion)->format('d') }}</span>
                                            </div>
                                            @if($noticia->imagen_principal)
                                                <img src="{{ $noticia->imagen_principal_url }}" alt="{{ $noticia->titulo }}">
                                            @else
                                                <span
                                                    class="d-flex align-items-center justify-content-center w-100 h-100 bg-secondary text-white"><i
                                                        class="fas fa-newspaper fa-5x"></i></span>
                                            @endif
                                            <div class="carousel-caption">
                                                <div class="caption-content">
                                                    <h5 class="text-white fw-bold mb-1">{{ Str::limit($noticia->titulo, 70) }}</h5>
                                                    <p class="text-white-50 mb-0 small text-uppercase letter-spacing-1"
                                                        style="font-size: 0.75rem;">
                                                        <span class="text-warning me-2">Leer más</span> <i
                                                            class="fas fa-chevron-right text-white"></i>
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#noticiasCarousel"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Anterior</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#noticiasCarousel"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Siguiente</span>
                            </button>
                        </div>
                    </div>

                    {{-- Columna Derecha: Lista pequeña y legible --}}
                    <div class="col-lg-3">
                        <div id="noticiasListaScroll" class="noticias-lista"
                            style="height: 550px; max-height: 550px; overflow: hidden; position: relative;">
                            @foreach($noticias as $noticia)
                                <div
                                    class="noticia-item-horizontal mb-2 p-2 bg-white shadow-sm rounded hover-shadow d-flex align-items-center">
                                    <div class="marco-img-lista flex-shrink-0">
                                        <a href="{{ route('public.noticia', $noticia->slug) }}" class="d-block w-100 h-100">
                                            @if($noticia->imagen_miniatura || $noticia->imagen_principal)
                                                <img src="{{ $noticia->imagen_miniatura_url }}" alt="{{ $noticia->titulo }}">
                                            @else
                                                <span
                                                    class="d-flex align-items-center justify-content-center w-100 h-100 bg-light text-muted"><i
                                                        class="fas fa-newspaper fa-2x"></i></span>
                                            @endif
                                        </a>
                                    </div>
                                    <div class="contenido-lista ps-3 flex-grow-1 overflow-hidden">
                                        @if($noticia->categoria)
                                            <span class="badge mb-1 small py-1 px-2"
                                                style="font-size: 0.7rem; background-color: var(--primary); color: white;">{{ $noticia->categoria }}</span>
                                        @endif
                                        <h6 class="mb-1 text-truncate" style="line-height:1.2;">
                                            <a href="{{ route('public.noticia', $noticia->slug) }}"
                                                class="text-decoration-none text-dark fw-bold">
                                                {{ $noticia->titulo }}
                                            </a>
                                        </h6>
                                        <p class="text-muted small mb-1 text-truncate">{{ Str::limit($noticia->resumen, 60) }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted" style="font-size: 0.75rem;">
                                                <i
                                                    class="far fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($noticia->fecha_publicacion)->format('d/m/Y') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    @php
                        $featured = $noticias->first();
                        $others = $noticias->slice(1);
                    @endphp
                    @if($featured)
                        <div class="col-12 mb-4">
                            <div class="card shadow-sm hover-lift featured-noticia border-0">
                                <div class="row g-0 align-items-stretch">
                                    <div class="col-md-7">
                                        <a href="{{ route('public.noticia', $featured->slug) }}"
                                            class="d-block marco-img-featured position-relative">
                                            <div class="date-badge shadow">
                                                <span
                                                    class="month">{{ \Carbon\Carbon::parse($featured->fecha_publicacion)->format('M') }}</span>
                                                <span
                                                    class="day">{{ \Carbon\Carbon::parse($featured->fecha_publicacion)->format('d') }}</span>
                                            </div>
                                            @if($featured->imagen_principal || $featured->imagen_miniatura)
                                                <img src="{{ $featured->imagen_principal_url ?? $featured->imagen_miniatura_url }}"
                                                    alt="{{ $featured->titulo }}">
                                            @else
                                                <span class="d-flex align-items-center justify-content-center w-100 h-100 text-white"
                                                    style="background-color: var(--primary);"><i
                                                        class="fas fa-newspaper fa-4x"></i></span>
                                            @endif
                                        </a>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="p-4 h-100 d-flex flex-column">
                                            @if($featured->categoria)
                                                <span class="badge mb-2"
                                                    style="background-color: var(--primary); color: white;">{{ $featured->categoria }}</span>
                                            @endif
                                            <h3 class="mb-3">
                                                <a href="{{ route('public.noticia', $featured->slug) }}"
                                                    class="text-decoration-none text-dark">
                                                    {{ Str::limit($featured->titulo, 100) }}
                                                </a>
                                            </h3>
                                            <p class="text-muted flex-grow-1">{{ Str::limit($featured->resumen, 180) }}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">
                                                    <i class="far fa-calendar"></i>
                                                    {{ \Carbon\Carbon::parse($featured->fecha_publicacion)->format('d/m/Y') }}
                                                </small>
                                                @if($featured->vistas > 0)
                                                    <small class="text-muted"><i class="far fa-eye"></i> {{ $featured->vistas }}</small>
                                                @endif
                                            </div>
                                            <div class="mt-3">
                                                <a href="{{ route('public.noticia', $featured->slug) }}" class="btn btn-sm"
                                                    style="color: var(--primary); border-color: var(--primary);">Leer más</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="row">
                    @foreach($others as $noticia)
                        <div class="{{ $colClass }} mb-4">
                            <div class="card h-100 shadow-sm hover-lift border-0">
                                <div class="card-img-top-wrapper marco-img-card position-relative">
                                    @if($noticia->imagen_miniatura || $noticia->imagen_principal)
                                        <img src="{{ $noticia->imagen_miniatura_url }}" class="card-img-top"
                                            alt="{{ $noticia->titulo }}">
                                    @else
                                        <span
                                            class="d-flex align-items-center justify-content-center w-100 h-100 bg-light text-muted"><i
                                                class="fas fa-newspaper fa-3x"></i></span>
                                    @endif
                                    @if($noticia->categoria)
                                        <span
                                            class="badge position-absolute top-0 end-0 m-3 bg-white text-primary shadow-sm rounded-pill fw-normal px-3 py-2 small">
                                            {{ $noticia->categoria }}
                                        </span>
                                    @endif
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <div class="mb-2">
                                        <small class="text-muted text-uppercase fw-bold"
                                            style="font-size: 0.7rem; letter-spacing: 1px;">
                                            {{ \Carbon\Carbon::parse($noticia->fecha_publicacion)->format('d M, Y') }}
                                        </small>
                                    </div>
                                    <h5 class="card-title mb-3">
                                        <a href="{{ route('public.noticia', $noticia->slug) }}"
                                            class="text-decoration-none text-dark fw-bold hover-link">
                                            {{ Str::limit($noticia->titulo, 60) }}
                                        </a>
                                    </h5>
                                    <p class="card-text text-muted small flex-grow-1" style="line-height: 1.6;">
                                        {{ Str::limit($noticia->resumen, 110) }}
                                    </p>
                                    <a href="{{ route('public.noticia', $noticia->slug) }}" class="btn-link-custom mt-3">
                                        Leer nota completa <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="row mt-4">
                <div class="col-12 text-center pt-3">
                    <a href="{{ route('public.noticias') }}" class="btn rounded-pill px-5 py-2 fw-bold"
                        style="background-color: transparent; border: 2px solid var(--primary); color: var(--primary);">
                        Ver Todas las Noticias
                    </a>
                </div>
            </div>
        </div>
    </section>

    <style>
        :root {
            --primary:
                {{ $tema->color_primario ?? '#0d2137' }}
            ;
            --secondary:
                {{ $tema->color_secundario ?? '#c5a059' }}
            ;
        }

        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
        }

        .hover-shadow {
            transition: box-shadow 0.3s ease;
        }

        .hover-shadow:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2) !important;
        }

        .title-divider {
            width: 80px;
            height: 3px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            margin-top: 1rem;
        }

        .card-title a:hover {
            color: var(--primary) !important;
        }

        /* Estilos para carrusel */
        .carousel-inner,
        .carousel-item {
            height: 100%;
            transition: transform 1.5s ease-in-out !important;
        }

        .carousel-item img {
            border-radius: 10px;
        }

        .marco-img-carrusel {
            aspect-ratio: auto;
            width: 100%;
            height: 550px;
            max-height: 550px;
            /* Padding creates the frame */
            padding: 4px;
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            /* Definition line */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .marco-img-carrusel img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            transition: transform 0.5s ease;
            border-radius: 8px;
            /* Inner radius matching the frame */
            background-color: #f8f9fa;
            /* Slight bg for transparent images */
        }

        .marco-img-carrusel:hover img {
            transform: scale(1.02);
        }

        .carousel-caption {
            bottom: 20px;
            left: 30px;
            /* Adjusted due to padding */
            right: 30px;
            padding: 0;
            text-align: left;
        }

        .caption-content {
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            padding: 1.25rem;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: transform 0.3s ease;
        }

        .carousel-item:hover .caption-content {
            transform: translateY(-2px);
            background: rgba(0, 0, 0, 0.85);
        }

        .date-badge {
            position: absolute;
            top: 20px;
            left: 20px;
            width: 50px;
            height: 60px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            text-align: center;
            z-index: 10;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .date-badge .month {
            background: var(--primary);
            color: white;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            padding: 3px 0;
            letter-spacing: 1px;
        }

        .date-badge .day {
            font-size: 1.5rem;
            font-weight: 800;
            color: #333;
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Estilos para lista horizontal */
        .noticias-lista {
            scrollbar-width: thin;
            scrollbar-color: rgba(0, 0, 0, 0.2) transparent;
        }

        .noticias-lista::-webkit-scrollbar {
            width: 6px;
        }

        .noticias-lista::-webkit-scrollbar-track {
            background: transparent;
        }

        .noticias-lista::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.2);
            border-radius: 3px;
        }

        .noticia-item-horizontal h6 a:hover {
            color: var(--primary) !important;
        }

        .marco-img-featured {
            aspect-ratio: 16 / 9;
            width: 100%;
            min-height: 400px;
            padding: 10px;
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            position: relative;
        }

        .marco-img-featured img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
            border-radius: 8px;
            background-color: #f8f9fa;
        }

        .marco-img-card {
            aspect-ratio: 16 / 9;
            width: 100%;
            overflow: hidden;
            border-radius: 12px 12px 0 0;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: inset 0 0 20px rgba(0, 0, 0, 0.05);
            /* Inner shadow for depth */
        }

        .marco-img-card img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
            transition: transform 0.5s ease;
        }

        .card:hover .marco-img-card img {
            transform: scale(1.05);
        }

        .letter-spacing-2 {
            letter-spacing: 2px;
        }

        .btn-link-custom {
            text-decoration: none;
            color: var(--primary);
            font-weight: 600;
            font-size: 0.9rem;
            transition: padding 0.3s ease;
        }

        .btn-link-custom:hover {
            padding-left: 5px;
            color: var(--secondary);
        }

        .card {
            border: none;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .noticia-item-horizontal {
            height: 105px;
            /* Ligeramente más alto para mejor balance */
            overflow: hidden;
        }

        .marco-img-lista {
            width: 84px;
            height: 84px;
            overflow: hidden;
            border-radius: 12px;
            background: #f8f9fa;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05), 0 0 0 2px #ffffff;
        }

        .marco-img-lista img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            transition: transform 0.3s ease;
        }

        .noticia-item-horizontal:hover .marco-img-lista img {
            transform: scale(1.1);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Lógica para el scroll automático de la lista de noticias
            const container = document.getElementById('noticiasListaScroll');
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