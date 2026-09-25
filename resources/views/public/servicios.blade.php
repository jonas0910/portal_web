@extends('layouts.public')

@section('title', 'Servicios Notariales')

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="padding: 60px 0;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                @php
                    $categoriaActual = request('categoria');
                    $titulos = [
                        'notarial' => 'Trámites Notariales',
                        'registral' => 'Registro de Actas y Documentos',
                        'legal' => 'Asesoría y Consultas Legales',
                        'administrativo' => 'Servicios Administrativos',
                        'otros' => 'Otros Servicios'
                    ];
                    $tituloPagina = $titulos[$categoriaActual] ?? 'Nuestros Servicios Notariales';
                @endphp
                <h1 class="hero-title" style="font-size: 2.5rem;">{{ $tituloPagina }}</h1>
                <p class="hero-subtitle">
                    {{ $categoriaActual ? 'Especializados en el área de ' . $categoriaActual : 'Servicios notariales de calidad para nuestra comunidad' }}
                </p>
            </div>
        </div>
    </div>
</section<!-- Servicios por Categoría -->
<section class="py-5" style="background-color: #fcfdfe;">
    <div class="container">
        @php
            $categorias = $servicios->groupBy('categoria');
        @endphp
        
        @foreach($categorias as $categoria => $serviciosCategoria)
        <div class="mb-5">
            <h2 class="section-title mb-4 ps-3 border-start border-primary border-4 fw-bold text-uppercase" style="letter-spacing: 1px; font-size: 1.25rem;">
                {{ $categoria ?: 'Servicios Institucionales' }}
            </h2>
            
            <div class="row g-4">
                @php
                    $colors = ['var(--primary-color)', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'];
                @endphp
                @foreach($serviciosCategoria as $servicio)
                @php
                    $color = $colors[$loop->index % count($colors)];
                @endphp
                <div class="col-12">
                    <div class="service-row-item card border-0 shadow-sm rounded-4 overflow-hidden mb-4 transition-all hover-lift" style="background: #fff;">
                        <div class="row g-0">
                            <!-- Columna de Icono -->
                            <div class="col-md-2 d-flex align-items-center justify-content-center p-4 bg-light bg-opacity-50">
                                <div class="icon-circle shadow-sm d-flex align-items-center justify-content-center" 
                                     style="width: 100px; height: 100px; background: linear-gradient(135deg, {{ $color }}, {{ $color }}dd); border-radius: 24px; color: white;">
                                    <i class="{{ $servicio->icono ?? 'fas fa-file-contract' }} fa-3x"></i>
                                </div>
                            </div>
                            
                            <!-- Columna de Contenido -->
                            <div class="col-md-7 p-4 p-md-5">
                                <div class="mb-2">
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2 rounded-pill small fw-bold">
                                        {{ strtoupper($servicio->categoria ?: 'ADMINISTRATIVO') }}
                                    </span>
                                </div>
                                <h3 class="fw-bold text-dark mb-3" style="font-family: 'Montserrat', sans-serif;">{{ $servicio->nombre }}</h3>
                                <p class="text-muted mb-4 lead" style="font-size: 1rem; line-height: 1.6;">
                                    {{ $servicio->descripcion }}
                                </p>
                                
                                @if($servicio->requisitos && is_array($servicio->requisitos) && !empty($servicio->requisitos))
                                <div class="service-requisites bg-light bg-opacity-50 p-3 rounded-3 border">
                                    <h6 class="small fw-bold text-dark mb-2"><i class="fas fa-check-circle text-success me-2"></i>Requisitos para el trámite:</h6>
                                    <div class="row g-2">
                                        @foreach(array_slice($servicio->requisitos, 0, 3) as $requisito)
                                        <div class="col-md-6 small text-muted d-flex align-items-center">
                                            <i class="fas fa-dot-circle me-2 x-small opacity-50"></i> {{ $requisito }}
                                        </div>
                                        @endforeach
                                        @if(count($servicio->requisitos) > 3)
                                        <div class="col-12 small mt-1 text-primary fst-italic">+{{ count($servicio->requisitos) - 3 }} requisitos adicionales detallados.</div>
                                        @endif
                                    </div>
                                </div>
                                @endif
                            </div>
                            
                            <!-- Columna de Acción/Costo -->
                            <div class="col-md-3 p-4 bg-light bg-opacity-25 d-flex flex-column align-items-center justify-content-center border-start">
                                @if($servicio->precio)
                                <div class="text-center mb-4">
                                    <div class="text-muted small fw-bold text-uppercase mb-1" style="letter-spacing: 1px;">Derecho de trámite</div>
                                    <div class="h2 fw-bold text-primary mb-0">S/ {{ number_format($servicio->precio, 2) }}</div>
                                    <div class="badge bg-success bg-opacity-10 text-success border-success border-opacity-25 mt-2">
                                        <i class="fas fa-clock me-1"></i> Trámite en 24h
                                    </div>
                                </div>
                                @endif
                                
                                <div class="w-100 px-3">
                                    @if($servicio->url)
                                        <a href="{{ $servicio->url }}" class="btn btn-primary btn-lg w-100 rounded-pill shadow-sm fw-bold">
                                            MÁS INFORMACIÓN <i class="fas fa-arrow-right ms-2 small"></i>
                                        </a>
                                    @else
                                        <button class="btn btn-primary btn-lg w-100 rounded-pill shadow-sm fw-bold" 
                                                data-bs-toggle="modal" data-bs-target="#servicioModal{{ $servicio->id }}">
                                            VER DETALLES <i class="fas fa-search-plus ms-2 small"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
    
    <style>
        .service-row-item {
            border-left: 6px solid var(--primary-color) !important;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        .service-row-item:hover {
            transform: scale(1.01);
            box-shadow: 0 20px 40px rgba(0,0,0,0.08) !important;
        }
        .x-small { font-size: 0.6rem; }
    </style>
</section>

<!-- Modales de Detalles -->
@foreach($servicios as $servicio)
<div class="modal fade" id="servicioModal{{ $servicio->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $servicio->nombre }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <h6>Descripción</h6>
                        <p>{{ $servicio->descripcion }}</p>
                        
                        @if($servicio->requisitos && is_array($servicio->requisitos) && !empty($servicio->requisitos))
                        <h6>Requisitos</h6>
                        <ul>
                            @foreach($servicio->requisitos as $requisito)
                            <li>{{ $requisito }}</li>
                            @endforeach
                        </ul>
                        @endif
                        
                        @if($servicio->procedimiento && is_array($servicio->procedimiento) && !empty($servicio->procedimiento))
                        <h6>Procedimiento</h6>
                        <ol>
                            @foreach($servicio->procedimiento as $paso)
                            <li>{{ $paso }}</li>
                            @endforeach
                        </ol>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h5 class="text-primary">{{ $servicio->precio_formateado }}</h5>
                                <p class="text-muted mb-3">
                                    <i class="fas fa-clock me-1"></i>{{ $servicio->duracion_formateada }}
                                </p>
                                <a href="{{ route('public.contacto') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-users me-1"></i>Contactar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- CTA Section -->
<!-- <section class="py-5" style="background: linear-gradient(135deg, var(--primary-color) 0%, #3b82f6 100%);">
    <div class="container text-center text-white">
        <h2 class="mb-4">¿Necesitas un servicio personalizado?</h2>
        <p class="lead mb-4">Nuestros notarios están listos para ayudarte con cualquier necesidad institucional</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('public.contacto') }}" class="btn btn-light btn-lg">
                <i class="fas fa-users me-2"></i>Contactar
            </a>
            <a href="{{ route('public.contacto') }}" class="btn btn-outline-light btn-lg">
                <i class="fas fa-phone me-2"></i>Contactar
            </a>
        </div>
    </div>
</section> -->
@endsection
