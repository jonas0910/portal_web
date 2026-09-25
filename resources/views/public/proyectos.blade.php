@extends('layouts.public')

@section('title', 'Proyectos - Municipalidad')

@section('content')
<div class="proyectos-page">
    {{-- Header --}}
    <section class="page-header bg-success text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="display-4">
                        <i class="fas fa-project-diagram"></i> Proyectos
                    </h1>
                    <p class="lead">Conoce los proyectos que estamos desarrollando para mejorar nuestros servicios</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Filtros --}}
    <section class="py-4 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="btn-group" role="group">
                        <a href="{{ route('public.proyectos') }}" class="btn btn-outline-secondary {{ !request('estado') ? 'active' : '' }}">
                            Todos
                        </a>
                        <a href="{{ route('public.proyectos') }}?estado=planificacion" class="btn btn-outline-warning {{ request('estado') == 'planificacion' ? 'active' : '' }}">
                            Planificación
                        </a>
                        <a href="{{ route('public.proyectos') }}?estado=en_curso" class="btn btn-outline-success {{ request('estado') == 'en_curso' ? 'active' : '' }}">
                            En Curso
                        </a>
                        <a href="{{ route('public.proyectos') }}?estado=completado" class="btn btn-outline-primary {{ request('estado') == 'completado' ? 'active' : '' }}">
                            Completados
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Listado de Proyectos --}}
    <section class="py-5">
        <div class="container">
            <div class="row">
                @forelse($proyectos as $proyecto)
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm proyecto-card">
                        <div class="marco-img-proyecto-card position-relative">
                        @if($proyecto->imagen_principal)
                            <img src="{{ $proyecto->imagen_principal_url }}" class="card-img-top" alt="{{ $proyecto->titulo }}">
                        @else
                            <span class="d-flex align-items-center justify-content-center w-100 h-100 bg-success text-white"><i class="fas fa-project-diagram fa-4x"></i></span>
                        @endif
                            <div class="estado-badge-overlay">
                                <span class="badge badge-{{ $proyecto->estado == 'en_curso' ? 'success' : ($proyecto->estado == 'completado' ? 'primary' : 'warning') }} badge-lg">
                                    {{ ucfirst(str_replace('_', ' ', $proyecto->estado)) }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('public.proyecto', $proyecto->slug) }}" class="text-decoration-none text-dark">
                                    {{ $proyecto->titulo }}
                                </a>
                            </h5>
                            
                            <p class="card-text text-muted">
                                {{ Str::limit($proyecto->descripcion_corta, 150) }}
                            </p>
                            
                            {{-- Progreso --}}
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <small class="font-weight-bold">Progreso</small>
                                    <small class="text-success font-weight-bold">{{ $proyecto->progreso }}%</small>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-success" 
                                         style="width: {{ $proyecto->progreso }}%">
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Info --}}
                            <div class="proyecto-meta">
                                @if($proyecto->fecha_inicio)
                                <div class="mb-1">
                                    <i class="far fa-calendar-alt text-primary"></i>
                                    <small>Inicio: {{ $proyecto->fecha_inicio->format('d/m/Y') }}</small>
                                </div>
                                @endif
                                @if($proyecto->presupuesto)
                                <div class="mb-1">
                                    <i class="fas fa-dollar-sign text-warning"></i>
                                    <small>Presupuesto: S/ {{ number_format($proyecto->presupuesto, 0) }}</small>
                                </div>
                                @endif
                            </div>
                            
                            <a href="{{ route('public.proyecto', $proyecto->slug) }}" 
                               class="btn btn-outline-success btn-block mt-3">
                                Ver Detalles <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-project-diagram fa-5x text-muted mb-3"></i>
                    <h3 class="text-muted">No hay proyectos disponibles</h3>
                </div>
                @endforelse
            </div>

            {{-- Paginación --}}
            @if($proyectos->hasPages())
            <div class="row mt-4">
                <div class="col-12">
                    {{ $proyectos->links() }}
                </div>
            </div>
            @endif
        </div>
    </section>
</div>

<style>
    .proyecto-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
    }
    
    .proyecto-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
    }
    
    .estado-badge-overlay {
        position: absolute;
        top: 10px;
        right: 10px;
    }
    
    .badge-lg {
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
    }
    
    .page-header {
        background: linear-gradient(135deg, #28a745, #20c997);
    }
    
    .card-title a:hover {
        color: #28a745 !important;
    }
</style>
@endsection

