@extends('layouts.public')

@section('title', $pagina->meta_titulo ?? $pagina->titulo)
@section('meta_description', $pagina->meta_descripcion ?? $pagina->descripcion)
@section('meta_keywords', $pagina->meta_keywords ?? 'municipalidad, regidores, concejo municipal')

@section('styles')
<style>
    .regidores-page {
        background: #fff;
        min-height: 100vh;
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
        color: #6c757d;
    }
    
    .regidores-content {
        padding: 40px 0 60px;
        background: #fff;
    }
    
    /* Cards estilo La Yarada - blanco, sombra sutil, bordes redondeados */
    .regidores-page .card-regidor {
        border: 1px solid #e9ecef;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        transition: box-shadow 0.3s ease, transform 0.2s ease;
        height: 100%;
    }
    
    .regidores-page .card-regidor:hover {
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }
    
    .regidores-page .avatar-regidor {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }
    
    .regidores-page .badge-partido {
        border-radius: 50px;
        padding: 0.35em 0.85em;
        font-weight: 500;
    }
    
    .regidores-page .funciones-concejo {
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        padding: 1.5rem 2rem;
    }
    
    .regidores-page .funciones-concejo h5 {
        color: var(--primary-color);
        font-weight: 600;
        margin-bottom: 1rem;
    }
    
    .regidores-page .funciones-concejo ul {
        margin-bottom: 0;
        padding-left: 1.5rem;
    }
    
    .regidores-page .funciones-concejo li {
        margin-bottom: 0.5rem;
        line-height: 1.6;
    }
    
    @media (max-width: 768px) {
        .regidores-content {
            padding: 30px 0 40px;
        }
        
        .regidores-page .avatar-regidor {
            width: 70px;
            height: 70px;
        }
    }
</style>
@endsection

@section('content')
<div class="regidores-page">
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

    {{-- Contenido principal --}}
    <section class="regidores-content">
        <div class="container">
            {{-- Título principal --}}
            <div class="text-center mb-4">
                <h1 class="h2 mb-2" style="color: var(--primary-color); font-weight: 700;">
                    <i class="fas fa-users me-2"></i>{{ $pagina->titulo }}
                </h1>
                @if($pagina->descripcion)
                    <p class="lead text-muted mb-0">{{ $pagina->descripcion }}</p>
                @endif
            </div>
            
            {{-- Título sección Junta Directiva --}}
            <h2 class="text-primary text-center mb-5">
                <i class="fas fa-gavel me-2"></i>Junta Directiva
            </h2>
            
            {{-- Grid de Junta Directiva --}}
            <div class="row justify-content-center mb-5">
                @php
                    $junta = [
                        ['nombre' => 'DR. VICENTE GUIDO QUISPE CHATA', 'cargo' => 'Decano', 'avatar' => 'primary'],
                        ['nombre' => 'DRA. ROSARIO CATHERINE BOHÓRQUEZ VEGA', 'cargo' => 'Fiscal', 'avatar' => 'info'],
                        ['nombre' => 'DRA. ÁNGELA MARÍA DÍAZ JARA ALMONTE', 'cargo' => 'Secretaria', 'avatar' => 'success'],
                        ['nombre' => 'DR. KARIM ISRAEL SARABIA PALZA', 'cargo' => 'Tesorero', 'avatar' => 'warning'],
                    ];
                @endphp
                @foreach($junta as $miembro)
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card card-regidor text-center">
                        <div class="card-body">
                            <div class="avatar-regidor bg-{{ $miembro['avatar'] }} text-white d-inline-flex align-items-center justify-content-center">
                                <i class="fas fa-user-tie fa-2x"></i>
                            </div>
                            <h5 class="card-title fw-bold mt-2" style="font-size: 0.95rem;">{{ $miembro['nombre'] }}</h5>
                            <p class="text-primary fw-bold mb-0 small">{{ $miembro['cargo'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Título sección Tribunal de Honor --}}
            <h2 class="text-primary text-center mb-5">
                <i class="fas fa-balance-scale me-2"></i>Tribunal de Honor
            </h2>

            {{-- Grid de Tribunal de Honor --}}
            <div class="row justify-content-center">
                @php
                    $tribunal = [
                        ['nombre' => 'DRA. ROSA MARÍA MÁLAGA CUTIPÉ', 'cargo' => 'Presidenta', 'avatar' => 'secondary'],
                        ['nombre' => 'DRA. PRESCILA MÉNDEZ PAYEHUANCA', 'cargo' => 'Secretaria', 'avatar' => 'dark'],
                        ['nombre' => 'DR. OSCAR ABEL CAPARACHIN RIVERA', 'cargo' => 'Vocal', 'avatar' => 'info'],
                        ['nombre' => 'DR. EDGARD PINEDA GAMARRA', 'cargo' => 'Suplente', 'avatar' => 'light text-dark'],
                    ];
                @endphp
                @foreach($tribunal as $miembro)
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card card-regidor text-center">
                        <div class="card-body">
                            <div class="avatar-regidor bg-{{ $miembro['avatar'] }} text-white d-inline-flex align-items-center justify-content-center">
                                <i class="fas fa-user-shield fa-2x"></i>
                            </div>
                            <h5 class="card-title fw-bold mt-2" style="font-size: 0.95rem;">{{ $miembro['nombre'] }}</h5>
                            <p class="text-primary fw-bold mb-0 small">{{ $miembro['cargo'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            {{-- Funciones del Concejo Municipal --}}
            <div class="row mt-4">
                <div class="col-12">
                    <div class="funciones-concejo">
                        <h5><i class="fas fa-gavel me-2 text-primary"></i>Funciones del Concejo Municipal</h5>
                        <ul>
                            <li>Aprobar, modificar o derogar las ordenanzas y dejar sin efecto los acuerdos</li>
                            <li>Aprobar el Plan de Desarrollo Municipal Concertado</li>
                            <li>Aprobar el régimen de organización interior y funcionamiento del gobierno local</li>
                            <li>Aprobar el Plan de Desarrollo Urbano y Plan de Desarrollo Rural</li>
                            <li>Fiscalizar la gestión de los funcionarios de la municipalidad</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
