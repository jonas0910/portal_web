{{-- Plantilla por defecto para páginas (Quiénes Somos, etc.) - equivalente a public.pagina --}}
@extends('layouts.public')

@section('title', $pagina->meta_titulo ?? $pagina->titulo)
@section('meta_description', $pagina->meta_descripcion ?? $pagina->descripcion)
@section('meta_keywords', $pagina->meta_keywords ?? 'municipalidad, peru, servicios')

@section('styles')
@if($pagina->slug === 'regidores')
<style>
    .card-regidor, .regidores-contenido .card { border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); transition: box-shadow 0.3s, transform 0.2s; }
    .card-regidor:hover, .regidores-contenido .card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.1); transform: translateY(-2px); }
    .avatar-regidor, .regidores-contenido .rounded-circle { min-width: 80px; min-height: 80px; }
    .badge-partido, .regidores-contenido .badge { border-radius: 50px; padding: 0.35em 0.85em; font-weight: 500; }
    .funciones-concejo { border-radius: 12px; }
</style>
@endif
<style>
    .page-header {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
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
    
    .content-section {
        padding: 60px 0;
    }
    
    .content h1, .content h2, .content h3, .content h4, .content h5, .content h6 {
        color: var(--primary-color);
        margin-top: 2rem;
        margin-bottom: 1rem;
    }
    
    .content h1:first-child, .content h2:first-child, .content h3:first-child {
        margin-top: 0;
    }
    
    .content p {
        margin-bottom: 1.5rem;
    }
    
    .content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin: 2rem 0;
    }
    
    .content ul, .content ol {
        margin-bottom: 1.5rem;
        padding-left: 2rem;
    }
    
    .content li {
        margin-bottom: 0.5rem;
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
        color: var(--primary-color);
        text-decoration: none;
    }
    
    .breadcrumb-item.active {
        color: var(--secondary-color);
    }
    
    @media (max-width: 768px) {
        .page-title {
            font-size: 2rem;
        }
        
        .page-subtitle {
            font-size: 1rem;
        }
        
        .page-header {
            padding: 40px 0;
        }
        
        .content-section {
            padding: 40px 0;
        }
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
                    <li class="breadcrumb-item active" aria-current="page">{{ $pagina->titulo }}</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Page Header --}}
    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="page-title">{{ $pagina->titulo }}</h1>
                    @if($pagina->descripcion)
                        <p class="page-subtitle">{{ $pagina->descripcion }}</p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- Content Section --}}
    <section class="content-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    {{-- Imagen Principal --}}
                    @if($pagina->imagen_principal)
                        <div class="text-center mb-5">
                            <img src="{{ $pagina->imagen_principal_url }}" alt="{{ $pagina->titulo }}" 
                                 class="img-fluid rounded shadow">
                        </div>
                    @endif

                    {{-- Regidores: cards con datos extraídos del contenido en BD --}}
                    @if(isset($regidores) && $pagina->slug === 'regidores')
                        @include('public.partials.regidores-cards')
                    @else
                    {{-- Contenido Principal --}}
                    @if($pagina->contenido)
                        <div class="content">
                            {!! $pagina->contenido !!}
                        </div>
                    @endif
                    @endif

                    {{-- Imágenes Adicionales --}}
                    @if($pagina->imagenes_adicionales && is_array($pagina->imagenes_adicionales) && !empty($pagina->imagenes_adicionales))
                        <div class="row mt-5">
                            @foreach($pagina->imagenes_adicionales_urls as $imagen)
                                <div class="col-md-6 mb-4">
                                    <img src="{{ $imagen }}" alt="{{ $pagina->titulo }}" 
                                         class="img-fluid rounded shadow">
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Contenido Específico por Tipo --}}
                    @if(isset($datosAdicionales))
                        @switch($pagina->tipo)
                            @case('servicios')
                                @if(isset($datosAdicionales['servicios']))
                                    <div class="row mt-5">
                                        @foreach($datosAdicionales['servicios'] as $servicio)
                                            <div class="col-md-6 mb-4">
                                                <div class="card h-100 shadow-sm">
                                                    <div class="card-body">
                                                        <div class="mb-3">
                                                            <i class="fas fa-file-contract fa-3x text-primary"></i>
                                                        </div>
                                                        <h5 class="card-title">{{ $servicio->nombre }}</h5>
                                                        <p class="card-text">{{ Str::limit($servicio->descripcion, 150) }}</p>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <span class="text-primary fw-bold">S/. {{ number_format($servicio->precio_base, 2) }}</span>
                                                            <a href="{{ route('public.servicios') }}" class="btn btn-sm btn-outline-primary">
                                                                Ver Detalles
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                @break

                            @case('notarios')
                                @if(isset($datosAdicionales['notarios']))
                                    <div class="row mt-5">
                                        @foreach($datosAdicionales['notarios'] as $notario)
                                            <div class="col-md-6 mb-4">
                                                <div class="card h-100 shadow-sm">
                                                    <div class="card-body text-center">
                                                        <div class="mb-3">
                                                            <i class="fas fa-user-circle fa-4x text-primary"></i>
                                                        </div>
                                                        <h5 class="card-title">{{ $notario->nombre }} {{ $notario->apellidos }}</h5>
                                                        <p class="card-text text-muted">{{ $notario->especialidad }}</p>
                                                        <p class="card-text">{{ $notario->distrito }}</p>
                                                        <a href="{{ route('public.pagina', 'funcionarios') }}" class="btn btn-primary">
                                                            Ver Perfil
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    @if($datosAdicionales['notarios']->hasPages())
                                        <div class="d-flex justify-content-center mt-4">
                                            {{ $datosAdicionales['notarios']->links() }}
                                        </div>
                                    @endif
                                @endif
                                @break

                            @case('documentos')
                                @if(isset($datosAdicionales['documentos']))
                                    <div class="row mt-5">
                                        @foreach($datosAdicionales['documentos'] as $documento)
                                            <div class="col-md-6 mb-4">
                                                <div class="card h-100 shadow-sm">
                                                    <div class="card-body">
                                                        <div class="mb-3">
                                                            <i class="fas fa-file-alt fa-3x text-primary"></i>
                                                        </div>
                                                        <h5 class="card-title">{{ $documento->titulo }}</h5>
                                                        <p class="card-text">{{ Str::limit($documento->descripcion, 150) }}</p>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <small class="text-muted">
                                                                {{ $documento->categoria->nombre ?? 'Documento' }}
                                                            </small>
                                                            <a href="{{ route('public.documentos.descargar', $documento->id) }}" 
                                                               class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-download me-1"></i>Descargar
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    @if($datosAdicionales['documentos']->hasPages())
                                        <div class="d-flex justify-content-center mt-4">
                                            {{ $datosAdicionales['documentos']->links() }}
                                        </div>
                                    @endif
                                @endif
                                @break
                        @endswitch
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
