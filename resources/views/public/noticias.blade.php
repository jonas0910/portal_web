@extends('layouts.public')

@section('title', 'Noticias y Comunicados - Colegio de Notarios de Tacna')

@section('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, #1b5e20, #2e7d32);
        color: white;
        padding: 60px 0;
        margin-bottom: 0;
    }
    .page-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }
    .page-subtitle {
        font-size: 1.15rem;
        opacity: 0.9;
    }
    .breadcrumb-container {
        background: #f8f9fa;
        padding: 15px 0;
        border-bottom: 1px solid #e9ecef;
    }
    .breadcrumb {
        background: transparent;
        padding: 0;
        margin-bottom: 0;
    }
    .breadcrumb-item a {
        color: #1b5e20;
        text-decoration: none;
    }
    .breadcrumb-item.active {
        color: #2e7d32;
    }
    .noticia-card {
        border: none;
        border-radius: 12px;
        transition: all 0.3s ease;
        background: #fff;
        border: 1px solid #eee;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    .noticia-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.08);
    }
    .noticia-title {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 3em; /* Fixed height for 2 lines */
        margin-bottom: 0.75rem;
    }
    .noticia-resumen {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        font-size: 0.875rem;
        height: 4.5em; /* Fixed height for 3 lines */
        color: #6c757d;
    }
</style>
@endsection

@section('content')
{{-- Breadcrumb --}}
<div class="breadcrumb-container">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('public.index') }}">
                        <i class="fas fa-home me-1"></i>Inicio
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Noticias</li>
            </ol>
        </nav>
    </div>
</div>

<div class="noticias-page">
    {{-- Page Header --}}
    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="page-title">Noticias y Comunicados</h1>
                    <p class="page-subtitle">Manténgase informado sobre las actividades y pronunciamientos oficiales de nuestra institución</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Noticias --}}
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row g-4">
                @forelse($noticias as $noticia)
                <div class="col-md-6 col-lg-4">
                    <div class="noticia-card d-flex flex-column shadow-sm overflow-hidden">
                        {{-- Imagen de la Noticia --}}
                        <div class="noticia-img-container d-flex align-items-center justify-content-center" style="height: 180px; overflow: hidden; background: #f1f8f1;">
                            @if($noticia->imagen_principal)
                                <img src="{{ $noticia->imagen_principal_url }}" class="img-fluid w-100 h-100" style="object-fit: cover;">
                            @else
                                <div class="text-center">
                                    <i class="fas fa-newspaper fa-4x" style="color: #c8e6c9;"></i>
                                </div>
                            @endif
                        </div>

                        <div class="p-4 flex-grow-1">
                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <span class="badge rounded-pill bg-light text-success border px-3 py-2 fw-normal" style="font-size: 0.75rem;">
                                    {{ $noticia->categoria ?? 'General' }}
                                </span>
                                <span class="small text-muted">
                                    <i class="far fa-calendar-alt me-1"></i> {{ $noticia->fecha_publicacion ? $noticia->fecha_publicacion->format('d/m/Y') : 'Reciente' }}
                                </span>
                            </div>
                            
                            <h5 class="fw-bold noticia-title" style="color: #1b5e20; font-family: 'Montserrat', sans-serif; line-height: 1.4;">
                                <a href="{{ route('public.noticia', $noticia->slug) }}" class="text-decoration-none text-inherit">
                                    {{ $noticia->titulo }}
                                </a>
                            </h5>
                        
                            <p class="noticia-resumen">
                                {{ strip_tags($noticia->resumen) }}
                            </p>
                        
                            <div class="mt-4 pt-3 border-top">
                                <a href="{{ route('public.noticia', $noticia->slug) }}" class="text-success fw-bold text-decoration-none small">
                                    LEER MÁS <i class="fas fa-chevron-right ms-2" style="font-size: 0.7rem;"></i>
                                </a>
                            </div>
                        </div> {{-- Fin p-4 --}}
                    </div> {{-- Fin noticia-card --}}
                </div> {{-- Fin col-md-6 --}}
                @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-newspaper fa-4x text-muted opacity-20 mb-3"></i>
                    <h5 class="text-muted">No se encontraron noticias registradas.</h5>
                </div>
                @endforelse
            </div>

            {{-- Paginación --}}
            <div class="mt-5 d-flex justify-content-center noticia-pagination">
                {{ $noticias->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </section>
</div>

<style>
    .noticia-pagination .page-link {
        color: #1b5e20;
        border-color: #dee2e6;
    }
    .noticia-pagination .page-item.active .page-link {
        background-color: #1b5e20;
        border-color: #1b5e20;
        color: white;
    }
    .noticia-pagination .page-link:hover {
        background-color: #f1f8f1;
        color: #1b5e20;
    }
    .noticia-pagination .page-link:focus {
        box-shadow: 0 0 0 0.25rem rgba(27, 94, 32, 0.25);
    }
    /* Estilos adicionales para asegurar que no haya azul */
    .noticia-card a {
        color: #1b5e20;
    }
    .noticia-card a:hover {
        color: #2e7d32;
    }
</style>
@endsection

