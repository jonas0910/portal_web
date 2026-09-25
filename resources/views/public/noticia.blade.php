@extends('layouts.public')

@section('title', $noticia->meta_titulo ?? $noticia->titulo)
@section('meta_description', $noticia->meta_descripcion ?? $noticia->resumen)
@section('meta_keywords', $noticia->meta_keywords ?? '')

@section('content')
<div class="noticia-detalle">
    {{-- Breadcrumbs --}}
    <nav aria-label="breadcrumb" class="bg-light py-3">
        <div class="container">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('public.index') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('public.noticias') }}">Noticias</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($noticia->titulo, 50) }}</li>
            </ol>
        </div>
    </nav>

    {{-- Contenido Principal --}}
    <section class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <article class="noticia-content bg-white p-4 p-md-5 rounded shadow-sm border">
                        
                        {{-- Cabecera con Categoría y Fecha --}}
                        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
                            <div class="d-flex align-items-center gap-2">
                                @if($noticia->categoria)
                                <span class="badge bg-success bg-opacity-10 text-success border-success border-opacity-25 px-3 py-2 fw-semibold">
                                    {{ $noticia->categoria }}
                                </span>
                                @endif
                                @if($noticia->destacada)
                                <span class="badge bg-warning bg-opacity-10 text-dark border-warning border-opacity-25 px-3 py-2 fw-semibold">
                                    <i class="fas fa-star me-1"></i> Destacada
                                </span>
                                @endif
                            </div>
                            <div class="text-muted small">
                                <i class="far fa-calendar-alt me-1"></i> 
                                {{ $noticia->fecha_publicacion->format('d \d\e F, Y') }}
                            </div>
                        </div>

                        {{-- Título --}}
                        <h1 class="noticia-main-title mb-4">{{ $noticia->titulo }}</h1>

                        {{-- Metadata Secundaria --}}
                        <div class="noticia-meta-bar d-flex align-items-center gap-4 mb-4 py-3 border-top border-bottom">
                            <div class="meta-item">
                                <i class="far fa-user text-success me-2"></i>
                                <span class="text-muted small">Publicado por</span>
                                <div class="fw-semibold text-dark">{{ $noticia->usuario->name ?? 'Administración' }}</div>
                            </div>
                            <div class="meta-item border-start ps-4">
                                <i class="far fa-eye text-success me-2"></i>
                                <span class="text-muted small">Lecturas</span>
                                <div class="fw-semibold text-dark">{{ $noticia->vistas }} visitas</div>
                            </div>
                        </div>

                        {{-- Imagen Principal --}}
                        @if($noticia->imagen_principal)
                        <div class="noticia-imagen mb-4 rounded-lg overflow-hidden position-relative shadow-sm" style="max-height: 450px;">
                            <img src="{{ $noticia->imagen_principal_url }}" 
                                 alt="{{ $noticia->titulo }}" 
                                 class="img-fluid w-100 h-100 clickable-image" 
                                 style="object-fit: cover; cursor: zoom-in;"
                                 data-bs-toggle="modal" 
                                 data-bs-target="#imageMagnifierModal"
                                 onclick="document.getElementById('magnifiedImage').src = this.src">
                            
                            <div class="position-absolute top-0 end-0 m-3 image-magnify-hint">
                                <span class="bg-white bg-opacity-75 text-dark rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px;">
                                    <i class="fas fa-search-plus"></i>
                                </span>
                            </div>
                        </div>
                        @endif

                        {{-- Resumen/Bajada --}}
                        @if($noticia->resumen)
                        <div class="noticia-lead-text mb-4">
                            {{ $noticia->resumen }}
                        </div>
                        @endif

                        {{-- Contenido con tipografía mejorada --}}
                        <div class="noticia-body-text">
                            {!! $noticia->contenido !!}
                        </div>

                        {{-- Archivo Adjunto --}}
                        @if($noticia->archivo_adjunto)
                        <div class="mt-4 p-4 rounded-3 text-center" style="background-color: #f8f9fa; border: 1px dashed #ced4da;">
                            <h6 class="fw-bold mb-3">Documento de Interés</h6>
                            <a href="{{ $noticia->archivo_adjunto_url }}" target="_blank" class="btn btn-success px-4 py-2 fw-semibold shadow-sm rounded-pill">
                                <i class="fas fa-file-pdf me-2"></i>Ver / Descargar Documento
                            </a>
                        </div>
                        @endif

                        {{-- Galería de fotos --}}
                        @php $galeriaUrls = $noticia->galeria_urls ?? []; @endphp
                        @if(count($galeriaUrls) > 0)
                        <div class="noticia-galeria-section mt-5 pt-4 border-top">
                            <h5 class="section-subtitle mb-4">Galería Multimedia</h5>
                            <div class="row g-3">
                                @foreach($galeriaUrls as $url)
                                <div class="col-6 col-md-4">
                                    <a href="{{ $url }}" target="_blank" class="galeria-thumb rounded shadow-sm">
                                        <img src="{{ $url }}" alt="Galería Noticia">
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        {{-- Footer del Artículo: Tags y Compartir --}}
                        <div class="noticia-footer mt-5 pt-4 border-top d-flex flex-wrap justify-content-between align-items-center gap-4">
                            <div class="footer-tags">
                                @if($noticia->tags && count($noticia->tags) > 0)
                                @foreach($noticia->tags as $tag)
                                <a href="{{ route('public.noticias') }}?tag={{ $tag }}" class="text-decoration-none me-2">
                                    <span class="badge bg-light text-dark border fw-normal px-2 py-1">#{{ $tag }}</span>
                                </a>
                                @endforeach
                                @endif
                            </div>
                            
                            <div class="footer-share d-flex align-items-center gap-3">
                                <span class="small text-muted fw-semibold">COMPARTIR:</span>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                                   target="_blank" class="share-btn fb-share" title="Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://api.whatsapp.com/send?text={{ urlencode($noticia->titulo . ' ' . request()->url()) }}" 
                                   target="_blank" class="share-btn ws-share" title="WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                </div>

                {{-- Sidebar --}}
                <div class="col-lg-4">
                    {{-- Noticias Relacionadas --}}
                    @if(isset($noticiasRelacionadas) && $noticiasRelacionadas->count() > 0)
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                            <h5 class="mb-0 fw-bold border-start border-primary border-4 ps-3" style="font-size: 1.1rem;">RELACIONADAS</h5>
                        </div>
                        <div class="list-group list-group-flush p-3">
                            @foreach($noticiasRelacionadas as $relacionada)
                            <a href="{{ route('public.noticia', $relacionada->slug) }}" class="list-group-item list-group-item-action border-0 rounded-3 mb-1">
                                <h6 class="mb-1 fw-bold" style="font-size: 0.95rem;">{{ Str::limit($relacionada->titulo, 60) }}</h6>
                                <div class="text-muted small">
                                    <i class="far fa-calendar-alt me-1"></i> {{ $relacionada->fecha_publicacion->format('d/m/Y') }}
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Últimas Noticias --}}
                    @php
                        $ultimasNoticias = \App\Models\Noticia::publicadas()
                            ->where('id', '!=', $noticia->id)
                            ->take(5)
                            ->get();
                    @endphp
                    
                    @if($ultimasNoticias->count() > 0)
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                            <h5 class="mb-0 fw-bold border-start border-success border-4 ps-3" style="font-size: 1.1rem;">ÚLTIMAS PUBLICACIONES</h5>
                        </div>
                        <div class="list-group list-group-flush p-3">
                            @foreach($ultimasNoticias as $ultima)
                            <a href="{{ route('public.noticia', $ultima->slug) }}" class="list-group-item list-group-item-action border-0 rounded-3 mb-1">
                                <small class="d-block mb-1 fw-semibold text-dark">{{ Str::limit($ultima->titulo, 50) }}</small>
                                <small class="text-muted small" style="font-size: 0.75rem;">{{ $ultima->fecha_publicacion->format('d/m/Y') }}</small>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .noticia-main-title {
        font-size: 2rem;
        font-weight: 800;
        line-height: 1.25;
        color: #0f172a;
        font-family: 'Montserrat', sans-serif;
    }

    .noticia-lead-text {
        font-size: 1.2rem;
        color: #475569;
        line-height: 1.6;
        font-weight: 500;
        border-left: 4px solid var(--primary-color);
        padding-left: 1.25rem;
        margin-bottom: 2rem;
    }
    
    .noticia-body-text {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #334155;
    }
    
    .noticia-body-text p {
        margin-bottom: 1.25rem;
    }
    
    .noticia-body-text img {
        max-width: 100%;
        height: auto;
        margin: 1.5rem 0;
        border-radius: 8px;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    }

    .galeria-thumb {
        display: block;
        height: 120px;
        overflow: hidden;
        border-radius: 8px;
    }
    
    .galeria-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .galeria-thumb:hover img {
        transform: scale(1.08);
    }
    
    .share-btn {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        transition: all 0.2s ease;
    }
    
    .fb-share { background-color: #0866ff; }
    .ws-share { background-color: #25d366; }
    
    .share-btn:hover {
        transform: translateY(-2px);
        filter: contrast(1.1);
        color: white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .list-group-item-action {
        transition: all 0.2s ease;
    }
    
    .list-group-item-action:hover {
        background-color: #f8fafc;
        padding-left: 1.25rem;
    }

    .image-magnify-hint {
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
    }
    
    .noticia-imagen:hover .image-magnify-hint {
        opacity: 1;
    }
</style>
@endsection

@section('modals')
<!-- Modal de Agrandado (Lightbox Profesional) -->
<div class="modal fade" id="imageMagnifierModal" tabindex="-1" aria-hidden="true" style="z-index: 9999;">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 shadow-lg" style="background: none;">
            <div class="modal-body p-0 position-relative text-center">
                <button type="button" class="btn-primary position-absolute top-0 end-0 m-3 shadow-lg d-flex align-items-center justify-content-center" 
                        data-bs-dismiss="modal" 
                        style="width: 45px; height: 45px; border-radius: 50%; border: 2px solid white; z-index: 100;">
                    <i class="fas fa-times"></i>
                </button>
                <img id="magnifiedImage" src="" class="img-fluid rounded shadow-lg" 
                     style="max-height: 92vh; border: 6px solid white; background-color: white;">
            </div>
        </div>
    </div>
</div>
@endsection

