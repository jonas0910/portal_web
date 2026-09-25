{{-- Widget Hero Banner / Carrusel Principal --}}
@php
    // Obtener banners principales (usa obtenerPrincipales que acepta posicion 0 o 'principal')
    $heroBanners = isset($banners) && $banners->isNotEmpty() ? $banners : \App\Models\Banner::obtenerPrincipales();
    
    // Asegurar que $tema existe
    if (!isset($tema) || !$tema) {
        $tema = \App\Models\Tema::obtenerPredeterminado();
    }
    
    // Parámetros del gestor de contenidos (gc_temas: banner_alto, banner_alto_movil, banner_ajuste_imagen)
    $bannerAlturaDesktopRaw = $tema->banner_alto ?? $tema->banner_altura_desktop ?? 800;
    $bannerAlturaMovilRaw = $tema->banner_alto_movil ?? $tema->banner_altura_movil ?? 600;
    $bannerAlturaDesktop = is_numeric($bannerAlturaDesktopRaw) ? (int)$bannerAlturaDesktopRaw : ((int)preg_replace('/[^0-9]/', '', $bannerAlturaDesktopRaw) ?: 800);
    $bannerAlturaMovil = is_numeric($bannerAlturaMovilRaw) ? (int)$bannerAlturaMovilRaw : ((int)preg_replace('/[^0-9]/', '', $bannerAlturaMovilRaw) ?: 600);
    
    $bannerAnchoTipo = $tema->banner_ancho_tipo ?? 'container-fluid';
    $bannerPaddingLateral = $tema->banner_padding_lateral ?? '5%';
    
    // Ajuste de imagen: cover, contain, fill (fill = 100% 100% en CSS)
    $ajusteRaw = $tema->banner_ajuste_imagen ?? 'cover';
    $bannerAjusteImagen = ($ajusteRaw === 'fill') ? '100% 100%' : $ajusteRaw;
@endphp

@if($heroBanners->isNotEmpty())
<section class="hero-banner-section">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="6000">
        {{-- Indicadores Elegantes --}}
        @if($heroBanners->count() > 1)
        <div class="carousel-indicators elegant-indicators">
            @foreach($heroBanners as $index => $banner)
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $index }}" 
                    class="{{ $index === 0 ? 'active' : '' }}" 
                    aria-current="{{ $index === 0 ? 'true' : 'false' }}" 
                    aria-label="Slide {{ $index + 1 }}"></button>
            @endforeach
        </div>
        @endif

        {{-- Slides --}}
        <div class="carousel-inner">
            @foreach($heroBanners as $index => $banner)
            @php
                $config = is_string($banner->configuracion) ? json_decode($banner->configuracion, true) : ($banner->configuracion ?? []);
                $overlayOpacity = $config['overlay_opacity'] ?? 0.3; 
                $textoColor = $config['texto_color'] ?? '#ffffff';
            @endphp
            
            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                {{-- Lógica de medios --}}
                @php
                    $storageUrl = function ($path) {
                        if (!$path) return null;
                        if (filter_var($path, FILTER_VALIDATE_URL)) return $path;
                        $cleanPath = ltrim($path, '/');
                        if (str_starts_with($cleanPath, 'storage/')) {
                            return asset($cleanPath);
                        }
                        return url('/media/' . $cleanPath);
                    };
                    $imagenUrl = null;
                    $imagenRaw = $banner->imagen ?? $banner->imagen_url;
                    if ($imagenRaw) {
                        $imagenUrl = $storageUrl($imagenRaw);
                    }
                    $videoUrl = null;
                    if ($banner->tipo_media === 'video') {
                        if ($banner->video) {
                            $videoUrl = $storageUrl($banner->video);
                        } elseif ($banner->video_url) {
                            $videoUrl = $banner->video_url;
                        }
                    }
                    $posterUrl = $banner->video_poster ? $storageUrl($banner->video_poster) : null;
                @endphp
                
                <div class="hero-image" style="position: relative; height: {{ $bannerAlturaDesktop }}px; min-height: {{ $bannerAlturaDesktop }}px; overflow: hidden;">
                    @if($banner->tipo_media === 'video' && $videoUrl)
                        <video autoplay muted loop playsinline class="banner-desktop zoom-effect"
                               @if($posterUrl) poster="{{ $posterUrl }}" @endif
                               style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: {{ $bannerAjusteImagen }}; object-position: center top;">
                            <source src="{{ $videoUrl }}" type="video/mp4">
                        </video>
                        @php
                            $videoMovilUrl = $banner->video_movil ? $storageUrl($banner->video_movil) : ($banner->video_movil_url ?? null);
                        @endphp
                        @if($videoMovilUrl)
                        <video autoplay muted loop playsinline class="banner-mobile"
                               @if($posterUrl) poster="{{ $posterUrl }}" @endif
                               style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: {{ $bannerAjusteImagen }}; object-position: center top; display: none;">
                            <source src="{{ $videoMovilUrl }}" type="video/mp4">
                        </video>
                        @endif
                    @elseif($imagenUrl)
                        <div class="banner-desktop zoom-effect" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: url('{{ $imagenUrl }}'); background-size: {{ $bannerAjusteImagen }}; background-position: center center; background-repeat: no-repeat;"></div>
                        
                        <div class="banner-mobile" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: url('{{ $imagenUrl }}'); background-size: {{ $bannerAjusteImagen }}; background-position: center center; background-repeat: no-repeat; display: none;"></div>
                        
                    @endif
                    
                    {{-- Overlay oscuro elegante --}}
                    <div class="hero-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to bottom, rgba(17, 24, 39, {{ $overlayOpacity }}), rgba(17, 24, 39, {{ $overlayOpacity + 0.3 }}));"></div>
                    
                    {{-- Contenido y alineación --}}
                    @php
                        $posicion = $banner->posicion_contenido ?? 'centro';
                        $justifyClass = 'justify-content-center';
                        $alignClass = 'align-items-center';
                        $contentStyle = '';
                        $textAlign = 'center';
                        $botonesAlign = 'justify-content-center';

                        switch($posicion) {
                            case 'izquierda': 
                            case 'superior-izquierda':
                            case 'inferior-izquierda':
                                $justifyClass = 'justify-content-start'; 
                                $textAlign = 'left';
                                $botonesAlign = 'justify-content-start';
                                break;
                            case 'derecha': 
                            case 'superior-derecha':
                            case 'inferior-derecha':
                                $justifyClass = 'justify-content-end'; 
                                $textAlign = 'right';
                                $botonesAlign = 'justify-content-end';
                                break;
                        }

                        if (str_contains($posicion, 'superior')) {
                            $alignClass = 'align-items-start'; 
                            $contentStyle = 'padding-top: 5rem;';
                        } elseif (str_contains($posicion, 'inferior')) {
                            $alignClass = 'align-items-end'; 
                            $contentStyle = 'padding-bottom: 5rem;';
                        } else {
                            $alignClass = 'align-items-center';
                        }
                    @endphp
                    
                    <div class="{{ $bannerAnchoTipo }} position-relative" style="z-index: 2; height: 100%; min-height: {{ $bannerAlturaDesktop }}px; display: flex; {{ $contentStyle }} padding-left: {{ $bannerPaddingLateral }}; padding-right: {{ $bannerPaddingLateral }};">
                        <div class="row {{ $alignClass }} w-100 {{ $justifyClass }}">
                            <div class="col-xl-8 col-lg-9 col-md-10">
                                
                                {{-- Contenedor sin fondo (Texto Libre) --}}
                                <div class="hero-content" data-aos="fade-up" data-aos-duration="1200" style="text-align: {{ $textAlign }}; 
                                                                     @if(in_array($posicion, ['izquierda', 'superior-izquierda', 'inferior-izquierda'])) margin-left: 0; margin-right: auto; @endif
                                                                     @if(in_array($posicion, ['derecha', 'superior-derecha', 'inferior-derecha'])) margin-right: 0; margin-left: auto; @endif
                                                                     @if(in_array($posicion, ['centro'])) margin: 0 auto; @endif">
                                    
                                    @if($banner->descripcion)
                                    <div class="hero-badge mb-3">
                                        <span class="elegant-badge" style="color: {{ $tema->color_acento ?? '#3b82f6' }};">
                                            {{ $banner->descripcion }}
                                        </span>
                                    </div>
                                    @endif
                                    
                                    <h1 class="hero-title fw-bold mb-3" style="color: {{ $textoColor }};">
                                        {{ $banner->titulo }}
                                    </h1>
                                    
                                    <div class="elegant-divider" style="background-color: var(--primary-color, {{ $tema->color_primario ?? '#ffffff' }}); 
                                        @if($textAlign === 'center') margin: 0 auto 1.5rem auto; 
                                        @elseif($textAlign === 'right') margin: 0 0 1.5rem auto; 
                                        @else margin: 0 auto 1.5rem 0; @endif">
                                    </div>
                                    
                                    @if($banner->subtitulo)
                                    <p class="hero-subtitle mb-4" style="color: rgba(255, 255, 255, 0.95);">
                                        {{ $banner->subtitulo }}
                                    </p>
                                    @endif
                                    
                                    @if($banner->boton_texto && $banner->boton_url)
                                    <div class="hero-actions mt-5 d-flex gap-3 {{ $botonesAlign }}">
                                        <a href="{{ url($banner->boton_url) }}" 
                                           class="btn elegant-btn-primary" 
                                           style="background-color: var(--primary-color, {{ $tema->color_primario ?? '#007bff' }}); border-color: var(--primary-color, {{ $tema->color_primario ?? '#007bff' }});"
                                           target="{{ $banner->target ?? '_self' }}">
                                            {{ $banner->boton_texto }}
                                        </a>
                                        
                                        <a href="{{ route('public.contacto') }}" 
                                           class="btn elegant-btn-outline">
                                            Contactar
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Controles Elegantes --}}
        @if($heroBanners->count() > 1)
        <button class="carousel-control-prev elegant-control" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="elegant-control-icon"><i class="fas fa-chevron-left"></i></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next elegant-control" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="elegant-control-icon"><i class="fas fa-chevron-right"></i></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
        @endif
    </div>
</section>

<style>
    .hero-banner-section {
        margin: 0;
        padding: 0;
        width: 100%;
        overflow: hidden;
        position: relative;
        z-index: 1;
        margin-top: -1px;
        font-family: 'Inter', 'Helvetica Neue', sans-serif;
    }
    
    #heroCarousel {
        height: {{ $bannerAlturaDesktop }}px;
        min-height: {{ $bannerAlturaDesktop }}px;
    }
    #heroCarousel .carousel-inner,
    #heroCarousel .carousel-item {
        height: {{ $bannerAlturaDesktop }}px;
    }

    /* Animación sutil de zoom en el fondo */
    .carousel-item.active .zoom-effect {
        animation: subtleZoom 15s linear forwards;
    }
    
    @keyframes subtleZoom {
        from { transform: scale(1); }
        to { transform: scale(1.08); }
    }
    
    .hero-badge .elegant-badge {
        font-size: 0.9rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        display: inline-block;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5); /* Sombra para resaltar */
    }
    
    .hero-title {
        font-size: 4rem;
        line-height: 1.1;
        letter-spacing: -1px;
        text-shadow: 0 4px 12px rgba(0, 0, 0, 0.4); /* Sombra fuerte para legibilidad */
    }
    
    .elegant-divider {
        width: 60px;
        height: 3px;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }
    
    .hero-subtitle {
        font-size: 1.25rem;
        font-weight: 400;
        line-height: 1.6;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.5); /* Sombra para legibilidad */
    }

    /* Botones Formales */
    .hero-actions .btn {
        padding: 0.8rem 2.5rem;
        font-size: 0.95rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-radius: 4px; 
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .elegant-btn-primary {
        color: #ffffff;
    }
    
    .elegant-btn-primary:hover {
        background-color: transparent !important;
        color: #ffffff;
        box-shadow: inset 0 0 0 2px var(--primary-color, {{ $tema->color_primario ?? '#007bff' }}), 0 6px 20px rgba(0,0,0,0.3);
    }

    .elegant-btn-outline {
        color: #ffffff;
        background: rgba(0,0,0,0.2);
        border: 2px solid #ffffff;
    }

    .elegant-btn-outline:hover {
        background: #ffffff;
        color: #111827;
        border-color: #ffffff;
    }
    
    /* Indicadores Estilizados */
    .elegant-indicators {
        bottom: 30px;
    }
    
    .elegant-indicators button {
        width: 30px !important;
        height: 3px !important;
        margin: 0 6px !important;
        background-color: rgba(255, 255, 255, 0.4) !important;
        border: none !important;
        transition: all 0.4s ease !important;
    }
    
    .elegant-indicators button.active {
        width: 60px !important;
        background-color: #ffffff !important;
    }
    
    /* Controles Laterales */
    .elegant-control {
        width: 8%;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    #heroCarousel:hover .elegant-control {
        opacity: 1;
    }
    
    .elegant-control-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        background: rgba(0,0,0,0.2);
        backdrop-filter: blur(4px);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 50%;
        color: white;
        font-size: 1.2rem;
        transition: all 0.3s ease;
    }
    
    .elegant-control:hover .elegant-control-icon {
        background: white;
        color: #111827;
        transform: scale(1.1);
    }
    
    /* Responsive para móvil */
    @media (max-width: 991px) {
        .hero-title { font-size: 3rem; }
    }

    @media (max-width: 768px) {
        #heroCarousel, .hero-image {
            min-height: {{ $bannerAlturaMovil }}px !important;
        }
        .banner-desktop { display: none !important; }
        .banner-mobile { display: block !important; }
        
        .hero-content {
            padding: 1rem 0;
        }
        .hero-title { font-size: 2.2rem; }
        .hero-subtitle { font-size: 1.1rem; }
        
        .hero-actions {
            flex-direction: column;
            gap: 10px;
        }
        .hero-actions .btn {
            width: 100%;
        }
        
        #heroCarousel:hover .elegant-control { display: none; }
    }
    
    @media (min-width: 769px) {
        .banner-desktop { display: block !important; }
        .banner-mobile { display: none !important; }
    }
</style>
@else
<div class="alert alert-info m-4">
    <i class="fas fa-info-circle"></i>
    No hay banners configurados para el Hero. Agrégalos en <a href="{{ url('/admin/contenido/banners') }}">Gestión de Banners</a>.
</div>
@endif








