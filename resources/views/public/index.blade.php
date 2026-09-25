@extends('layouts.public')

@section('title', $paginaInicio->meta_titulo ?? $paginaInicio->titulo)
@section('meta_description', $paginaInicio->meta_description ?? $paginaInicio->descripcion)
@section('meta_keywords', $paginaInicio->meta_keywords ?? 'notarios, peru, servicios notariales')

@section('styles')
<style>
    .hero-section {
        background: linear-gradient(135deg, var(--primary-color) 0%, #2e7d32 100%);
        padding: 120px 0;
        position: relative;
        overflow: hidden;
    }

    .hero-section::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 50%;
        height: 100%;
        background: radial-gradient(circle at center, rgba(197, 160, 89, 0.1) 0%, transparent 70%);
        pointer-events: none;
    }
    
    .hero-title {
        font-size: 3.8rem;
        line-height: 1.1;
        margin-bottom: 1.5rem;
        text-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }
    
    .stat-number {
        font-size: 3.5rem;
        font-weight: 800;
        color: var(--primary-color);
        background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .banner-carousel, .banner-item {
        height: {{ $tema->banner_altura_desktop ?? 800 }}px;
    }

    @media (max-width: 768px) {
        .banner-carousel, .banner-item {
            height: {{ $tema->banner_altura_movil ?? 600 }}px !important;
        }
        .hero-title { font-size: 2.5rem; }
        .banner-title { font-size: 2rem; }
    }
</style>
@endsection

@section('content')
    {{-- Banner Carrusel --}}
    @php
        $bannersList = [];
        if (isset($banners)) {
            if (is_array($banners)) $bannersList = $banners;
            else if (is_object($banners) && method_exists($banners, 'all')) $bannersList = $banners->all();
        }
    @endphp
    
    @if(!empty($bannersList))
    <div id="bannerCarousel" class="carousel slide banner-carousel" data-bs-ride="carousel">
        <div class="carousel-indicators">
            @foreach($bannersList as $index => $banner)
                <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"></button>
            @endforeach
        </div>
        
        <div class="carousel-inner">
            @foreach($bannersList as $index => $banner)
                @php
                    $posicionContenido = $banner->posicion_contenido ?? 'centro';
                    $alignClass = 'text-center';
                    $justifyStyle = 'justify-content: center; align-items: center;';
                    
                    switch($posicionContenido) {
                        case 'izquierda': $alignClass = 'text-start'; $justifyStyle = 'justify-content: flex-start; align-items: center;'; break;
                        case 'derecha': $alignClass = 'text-end'; $justifyStyle = 'justify-content: flex-end; align-items: center;'; break;
                    }
                @endphp
                
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <div class="banner-item" style="background-image: url('{{ $banner->imagen_url ?? $banner->imagen ?? asset('images/placeholder-banner.svg') }}'); 
                                                   background-size: {{ $tema->banner_ajuste_imagen ?? 'cover' }};
                                                   background-position: center;
                                                   display: flex; {{ $justifyStyle }}">
                        <div class="container banner-content {{ $alignClass }}">
                            <h1 class="banner-title text-white">{{ $banner->titulo }}</h1>
                            <p class="banner-description text-white">{{ $banner->descripcion }}</p>
                            @if($banner->link_url)
                                <a href="{{ $banner->link_url }}" class="btn btn-primary">{{ $banner->link_texto ?? 'Más información' }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
    @endif

    {{-- Contenido dinámico por widgets --}}
    @if(isset($widgets) && !empty($widgets))
        @foreach($widgets as $widget)
            @include('widgets.' . ($widget['tipo'] ?? 'default'), ['config' => $widget['config'] ?? []])
        @endforeach
    @else
        {{-- Contenido por defecto si no hay widgets --}}
        <section class="py-5">
            <div class="container">
                {!! $paginaInicio->contenido !!}
            </div>
        </section>
    @endif
@endsection