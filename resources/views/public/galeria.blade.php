@extends('layouts.public')

@section('title', 'Galería Institucional - Colegio de Notarios de Tacna')

@php
    $tema = $tema ?? \App\Models\Tema::obtenerPredeterminado();
    $primaryColor = '#0d2137';
    $secondaryColor = '#c5a059';
@endphp

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
                <li class="breadcrumb-item active" aria-current="page">Galería Institucional</li>
            </ol>
        </nav>
    </div>
</div>

<div class="galeria-page">
    {{-- Page Header --}}
    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="page-title">Galería Institucional</h1>
                    <p class="page-subtitle">Registro visual de las actividades y eventos del Colegio de Notarios de Tacna</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Contenido de la Galería --}}
    <section class="py-5 bg-light">
        <div class="container">
            @foreach($fotos as $actividad => $imagenes)
            <div class="mb-5 animate__animated animate__fadeInUp">
                <div class="d-flex align-items-center mb-4">
                    <div style="width: 5px; height: 35px; background-color: {{ $secondaryColor }}; margin-right: 15px; border-radius: 5px;"></div>
                    <h2 class="h3 fw-bold mb-0 text-dark" style="font-family: 'Montserrat', sans-serif; text-transform: uppercase; letter-spacing: 1px;">{{ $actividad }}</h2>
                    <span class="ms-3 badge bg-white text-muted border px-3 py-2 rounded-pill">{{ count($imagenes) }} Fotos</span>
                </div>
                
                <div class="row g-4">
                    @foreach($imagenes as $foto)
                    <div class="col-md-4 col-lg-3">
                        <div class="galeria-card shadow-sm" onclick="openLightbox('{{ $foto->imagen_url }}', '{{ $foto->titulo }}', '{{ $foto->descripcion }}')">
                            <div class="galeria-img-container">
                                <img src="{{ $foto->imagen_url }}" alt="{{ $foto->titulo }}" class="img-fluid galeria-img">
                                <div class="galeria-overlay">
                                    <i class="fas fa-search-plus fa-2x text-white"></i>
                                </div>
                            </div>
                            <div class="p-3 bg-white">
                                <h6 class="fw-bold mb-1 text-truncate">{{ $foto->titulo }}</h6>
                                <p class="small text-muted mb-0"><i class="far fa-calendar-alt me-1"></i> {{ $foto->anio }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </section>
</div>

{{-- Lightbox Modal Mejorado --}}
<div class="modal fade" id="lightboxModal" tabindex="-1" aria-hidden="true" style="background-color: rgba(0,0,0,0.9);">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content bg-transparent border-0 position-relative">
            {{-- Botón Cerrar Flotante --}}
            <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-4" 
                    data-bs-dismiss="modal" aria-label="Close" 
                    style="z-index: 9999; width: 30px; height: 30px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5));"></button>
            
            <div class="modal-body p-0 text-center d-flex flex-column align-items-center">
                <img src="" id="lightboxImg" class="img-fluid rounded shadow-lg" style="max-height: 80vh; border: 4px solid white;">
                <div class="mt-4 text-white w-100 px-3">
                    <h3 id="lightboxTitle" class="fw-bold mb-2"></h3>
                    <p id="lightboxDesc" class="opacity-90 lead"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .galeria-card {
        cursor: pointer;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
        background: white;
    }
    .galeria-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    }
    .galeria-img-container {
        position: relative;
        height: 200px;
        overflow: hidden;
    }
    .galeria-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .galeria-card:hover .galeria-img {
        transform: scale(1.08);
    }
    .galeria-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(27, 94, 32, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .galeria-card:hover .galeria-overlay {
        opacity: 1;
    }
    
    /* Fix para evitar que el fondo oscurezca la imagen en el modal */
    #lightboxModal .modal-dialog {
        z-index: 1060;
    }
    .modal-backdrop {
        display: none !important; /* Usamos el background del modal mismo */
    }
    #lightboxImg {
        object-fit: contain;
        background-color: transparent;
    }
</style>

<script>
    function openLightbox(src, title, desc) {
        document.getElementById('lightboxImg').src = src;
        document.getElementById('lightboxTitle').textContent = title;
        document.getElementById('lightboxDesc').textContent = desc;
        var myModal = new bootstrap.Modal(document.getElementById('lightboxModal'));
        myModal.show();
    }
</script>
@endsection
