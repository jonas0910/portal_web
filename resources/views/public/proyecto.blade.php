@extends('layouts.public')

@section('title', $proyecto->meta_titulo ?? $proyecto->titulo)
@section('meta_description', $proyecto->meta_descripcion ?? $proyecto->descripcion_corta)
@section('meta_keywords', $proyecto->meta_keywords ?? '')

@section('content')
<div class="proyecto-detalle">
    {{-- Breadcrumbs --}}
    <nav aria-label="breadcrumb" class="bg-light py-3">
        <div class="container">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('public.index') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('public.proyectos') }}">Proyectos</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($proyecto->titulo, 50) }}</li>
            </ol>
        </div>
    </nav>

    {{-- Contenido Principal --}}
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <article class="proyecto-content">
                        {{-- Imagen Principal --}}
                        @if($proyecto->imagen_principal)
                        <div class="proyecto-imagen mb-4 marco-img-detalle rounded shadow-lg">
                            <img src="{{ $proyecto->imagen_principal_url }}" alt="{{ $proyecto->titulo }}">
                        </div>
                        @endif

                        {{-- Cabecera --}}
                        <div class="proyecto-header mb-4">
                            <div class="mb-3">
                                <span class="badge badge-{{ $proyecto->estado == 'en_curso' ? 'success' : ($proyecto->estado == 'completado' ? 'primary' : 'warning') }} badge-lg">
                                    <i class="fas fa-circle"></i> {{ ucfirst(str_replace('_', ' ', $proyecto->estado)) }}
                                </span>
                                <span class="badge badge-{{ $proyecto->prioridad == 'urgente' ? 'danger' : ($proyecto->prioridad == 'alta' ? 'warning' : 'secondary') }} badge-lg">
                                    Prioridad: {{ ucfirst($proyecto->prioridad) }}
                                </span>
                                @if($proyecto->destacado)
                                <span class="badge badge-warning badge-lg">
                                    <i class="fas fa-star"></i> Destacado
                                </span>
                                @endif
                            </div>
                            
                            <h1 class="display-4 mb-3">{{ $proyecto->titulo }}</h1>
                            
                            <p class="lead text-muted">{{ $proyecto->descripcion_corta }}</p>
                        </div>

                        {{-- Progreso --}}
                        <div class="card mb-4 border-success">
                            <div class="card-body">
                                <h5 class="card-title text-success">
                                    <i class="fas fa-tasks"></i> Progreso del Proyecto
                                </h5>
                                <div class="progress" style="height: 30px;">
                                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" 
                                         role="progressbar" 
                                         style="width: {{ $proyecto->progreso }}%; font-size: 1.2rem;"
                                         aria-valuenow="{{ $proyecto->progreso }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                        {{ $proyecto->progreso }}%
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Información General --}}
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Información General</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @if($proyecto->fecha_inicio)
                                    <div class="col-md-6 mb-3">
                                        <strong><i class="far fa-calendar-alt text-primary"></i> Fecha de Inicio:</strong><br>
                                        {{ $proyecto->fecha_inicio->format('d \d\e F, Y') }}
                                    </div>
                                    @endif
                                    
                                    @if($proyecto->fecha_fin_estimada)
                                    <div class="col-md-6 mb-3">
                                        <strong><i class="far fa-calendar-check text-success"></i> Fecha Fin Estimada:</strong><br>
                                        {{ $proyecto->fecha_fin_estimada->format('d \d\e F, Y') }}
                                    </div>
                                    @endif
                                    
                                    @if($proyecto->fecha_fin_real)
                                    <div class="col-md-6 mb-3">
                                        <strong><i class="fas fa-flag-checkered text-success"></i> Fecha Fin Real:</strong><br>
                                        {{ $proyecto->fecha_fin_real->format('d \d\e F, Y') }}
                                    </div>
                                    @endif
                                    
                                    @if($proyecto->presupuesto)
                                    <div class="col-md-6 mb-3">
                                        <strong><i class="fas fa-dollar-sign text-warning"></i> Presupuesto:</strong><br>
                                        S/ {{ number_format($proyecto->presupuesto, 2) }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Descripción Completa --}}
                        <div class="proyecto-descripcion mb-4">
                            <h3 class="mb-3"><i class="fas fa-align-left"></i> Descripción del Proyecto</h3>
                            <div class="content-wrapper">
                                {!! $proyecto->descripcion_completa !!}
                            </div>
                        </div>

                        {{-- Objetivos --}}
                        @if($proyecto->objetivos && count($proyecto->objetivos) > 0)
                        <div class="card mb-4 border-primary">
                            <div class="card-header bg-light">
                                <h5 class="mb-0"><i class="fas fa-bullseye text-primary"></i> Objetivos</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-objetivos">
                                    @foreach($proyecto->objetivos as $objetivo)
                                    <li><i class="fas fa-check-circle text-success"></i> {{ $objetivo }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif

                        {{-- Hitos --}}
                        @if($proyecto->hitos && count($proyecto->hitos) > 0)
                        <div class="card mb-4 border-info">
                            <div class="card-header bg-light">
                                <h5 class="mb-0"><i class="fas fa-flag text-info"></i> Hitos</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-hitos">
                                    @foreach($proyecto->hitos as $hito)
                                    <li><i class="fas fa-flag-checkered text-info"></i> {{ $hito }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif

                        {{-- Equipo --}}
                        @if($proyecto->equipo && count($proyecto->equipo) > 0)
                        <div class="card mb-4 border-success">
                            <div class="card-header bg-light">
                                <h5 class="mb-0"><i class="fas fa-users text-success"></i> Equipo del Proyecto</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($proyecto->equipo as $miembro)
                                    <div class="col-md-6 mb-2">
                                        <i class="fas fa-user-tie text-success"></i> {{ $miembro }}
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif
                    </article>
                </div>

                {{-- Sidebar --}}
                <div class="col-lg-4">
                    {{-- Estado y Progreso --}}
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">Estado del Proyecto</h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <div class="progreso-circular">
                                    <h2 class="text-success">{{ $proyecto->progreso }}%</h2>
                                    <p class="text-muted">Completado</p>
                                </div>
                            </div>
                            <div class="progress mb-2" style="height: 20px;">
                                <div class="progress-bar bg-success" 
                                     style="width: {{ $proyecto->progreso }}%">
                                </div>
                            </div>
                            <p class="text-center mb-0">
                                <span class="badge badge-{{ $proyecto->estado == 'en_curso' ? 'success' : ($proyecto->estado == 'completado' ? 'primary' : 'warning') }}">
                                    {{ ucfirst(str_replace('_', ' ', $proyecto->estado)) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    {{-- Proyectos Relacionados --}}
                    @php
                        $proyectosRelacionados = \App\Models\Proyecto::publicados()
                            ->where('id', '!=', $proyecto->id)
                            ->where('estado', $proyecto->estado)
                            ->take(3)
                            ->get();
                    @endphp
                    
                    @if($proyectosRelacionados->count() > 0)
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0">Proyectos Similares</h5>
                        </div>
                        <div class="list-group list-group-flush">
                            @foreach($proyectosRelacionados as $relacionado)
                            <a href="{{ route('public.proyecto', $relacionado->slug) }}" class="list-group-item list-group-item-action">
                                <h6 class="mb-1">{{ Str::limit($relacionado->titulo, 60) }}</h6>
                                <small class="text-muted">
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar bg-success" style="width: {{ $relacionado->progreso }}%"></div>
                                    </div>
                                    {{ $relacionado->progreso }}% completado
                                </small>
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
    .content-wrapper {
        font-size: 1.1rem;
        line-height: 1.8;
    }
    
    .content-wrapper p {
        margin-bottom: 1.5rem;
    }
    
    .content-wrapper img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1rem 0;
    }
    
    .list-objetivos, .list-hitos {
        list-style: none;
        padding: 0;
    }
    
    .list-objetivos li, .list-hitos li {
        padding: 0.5rem 0;
        border-bottom: 1px solid #eee;
    }
    
    .list-objetivos li:last-child, .list-hitos li:last-child {
        border-bottom: none;
    }
    
    .badge-lg {
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
    }
    
    .progreso-circular {
        padding: 2rem;
        background: linear-gradient(135deg, #d4edda, #c3e6cb);
        border-radius: 50%;
        width: 150px;
        height: 150px;
        display: inline-flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }
</style>
@endsection

