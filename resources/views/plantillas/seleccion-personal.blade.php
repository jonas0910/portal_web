@extends('layouts.public')

@section('title', $pagina->meta_titulo ?? $pagina->titulo)
@section('meta_description', $pagina->meta_descripcion ?? $pagina->descripcion)

@section('content')
<div class="container py-5">
    {{-- Encabezado --}}
    <div class="row mb-5">
        <div class="col-12">
            <h1 class="display-4 mb-3" style="color: var(--primary-color);">
                <i class="fas fa-user-plus"></i> {{ $pagina->titulo }}
            </h1>
            @if($pagina->descripcion)
                <p class="lead text-muted">{{ $pagina->descripcion }}</p>
            @endif
        </div>
    </div>

    {{-- Contenido Principal --}}
    @if($pagina->contenido)
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    {!! $pagina->contenido !!}
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Ofertas de Empleo / Convocatorias (Componente Dinámico) --}}
    <div class="mb-5">
        <h2 class="mb-4">
            <i class="fas fa-briefcase"></i> Convocatorias Abiertas
        </h2>
        
        @include('components.ofertas-empleo')
    </div>

    {{-- COMENTADO: Código viejo de ofertas hardcodeadas
    <div class="row mb-5 d-none">
        <div class="col-12">
            <div class="row">
                {{-- Ejemplo de Oferta 1 --}}
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm hover-shadow">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h4 class="card-title mb-0">Asistente Legal</h4>
                                <span class="badge badge-success">Abierto</span>
                            </div>
                            
                            <p class="text-muted mb-3">
                                <i class="fas fa-map-marker-alt"></i> Lima, Perú<br>
                                <i class="fas fa-clock"></i> Tiempo Completo<br>
                                <i class="fas fa-calendar"></i> Publicado: 20/10/2025
                            </p>
                            
                            <p class="card-text">
                                Buscamos un asistente legal con experiencia en derecho notarial para unirse a nuestro equipo.
                            </p>
                            
                            <hr>
                            
                            <h6>Requisitos:</h6>
                            <ul class="small">
                                <li>Título universitario en Derecho</li>
                                <li>Mínimo 2 años de experiencia</li>
                                <li>Conocimiento de procedimientos notariales</li>
                                <li>Manejo de Office avanzado</li>
                            </ul>
                            
                            <button type="button" class="btn btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#modalPostular" data-puesto="Asistente Legal">
                                <i class="fas fa-paper-plane"></i> Postular Ahora
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Ejemplo de Oferta 2 --}}
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm hover-shadow">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h4 class="card-title mb-0">Notario Asociado</h4>
                                <span class="badge badge-success">Abierto</span>
                            </div>
                            
                            <p class="text-muted mb-3">
                                <i class="fas fa-map-marker-alt"></i> Arequipa, Perú<br>
                                <i class="fas fa-clock"></i> Tiempo Completo<br>
                                <i class="fas fa-calendar"></i> Publicado: 18/10/2025
                            </p>
                            
                            <p class="card-text">
                                Oportunidad para notario con título registrado que desee formar parte de nuestra red nacional.
                            </p>
                            
                            <hr>
                            
                            <h6>Requisitos:</h6>
                            <ul class="small">
                                <li>Título de Notario Público registrado</li>
                                <li>Mínimo 5 años de experiencia</li>
                                <li>Disponibilidad para viajar</li>
                                <li>Excelentes habilidades interpersonales</li>
                            </ul>
                            
                            <button type="button" class="btn btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#modalPostular" data-puesto="Notario Asociado">
                                <i class="fas fa-paper-plane"></i> Postular Ahora
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Ejemplo de Oferta 3 --}}
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm hover-shadow">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h4 class="card-title mb-0">Secretaria Ejecutiva</h4>
                                <span class="badge badge-success">Abierto</span>
                            </div>
                            
                            <p class="text-muted mb-3">
                                <i class="fas fa-map-marker-alt"></i> Cusco, Perú<br>
                                <i class="fas fa-clock"></i> Tiempo Completo<br>
                                <i class="fas fa-calendar"></i> Publicado: 15/10/2025
                            </p>
                            
                            <p class="card-text">
                                Buscamos secretaria ejecutiva con experiencia en atención al cliente y gestión de documentos.
                            </p>
                            
                            <hr>
                            
                            <h6>Requisitos:</h6>
                            <ul class="small">
                                <li>Técnico en Secretariado o afines</li>
                                <li>Experiencia mínima 3 años</li>
                                <li>Manejo de agenda y citas</li>
                                <li>Excelente presentación</li>
                            </ul>
                            
                            <button type="button" class="btn btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#modalPostular" data-puesto="Secretaria Ejecutiva">
                                <i class="fas fa-paper-plane"></i> Postular Ahora
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Ejemplo de Oferta 4 --}}
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm hover-shadow">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h4 class="card-title mb-0">Practicante de Derecho</h4>
                                <span class="badge badge-warning">Por cerrar</span>
                            </div>
                            
                            <p class="text-muted mb-3">
                                <i class="fas fa-map-marker-alt"></i> Lima, Perú<br>
                                <i class="fas fa-clock"></i> Medio Tiempo<br>
                                <i class="fas fa-calendar"></i> Publicado: 10/10/2025
                            </p>
                            
                            <p class="card-text">
                                Oportunidad de prácticas pre-profesionales para estudiantes de derecho en últimos ciclos.
                            </p>
                            
                            <hr>
                            
                            <h6>Requisitos:</h6>
                            <ul class="small">
                                <li>Estar cursando 8vo ciclo o superior</li>
                                <li>Promedio ponderado mínimo 14</li>
                                <li>Disponibilidad 4 horas diarias</li>
                                <li>Proactividad y ganas de aprender</li>
                            </ul>
                            
                            <button type="button" class="btn btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#modalPostular" data-puesto="Practicante de Derecho">
                                <i class="fas fa-paper-plane"></i> Postular Ahora
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    --}}

    {{-- Beneficios de Trabajar con Nosotros --}}
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-sm" style="background: linear-gradient(135deg, {{ $tema->color_primario ?? '#007bff' }} 0%, {{ $tema->color_secundario ?? '#6c757d' }} 100%); color: white;">
                <div class="card-body text-center py-5">
                    <h3 class="mb-4">¿Por qué trabajar con nosotros?</h3>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <i class="fas fa-award fa-3x mb-3"></i>
                            <h5>Excelencia Profesional</h5>
                            <p class="small">Formación continua y desarrollo profesional</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <i class="fas fa-users fa-3x mb-3"></i>
                            <h5>Gran Equipo</h5>
                            <p class="small">Ambiente colaborativo y de respeto</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <i class="fas fa-chart-line fa-3x mb-3"></i>
                            <h5>Crecimiento</h5>
                            <p class="small">Oportunidades de ascenso y desarrollo</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <i class="fas fa-hand-holding-usd fa-3x mb-3"></i>
                            <h5>Beneficios</h5>
                            <p class="small">Salarios competitivos y bonos</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Timeline del Proceso de Selección --}}
    @include('components.timeline_proceso')
</div>

{{-- Formulario de Postulación (Modal) --}}
@include('components.formulario-postulacion')

@endsection

@push('styles')
<style>
.hover-shadow {
    transition: all 0.3s ease;
}

.hover-shadow:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important;
}
</style>
@endpush


