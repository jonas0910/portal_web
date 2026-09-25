@extends('layouts.public')

@section('title', 'Agenda Institucional - Eventos')

@section('content')
<div class="eventos-page">
    {{-- Header --}}
    <section class="page-header py-5 text-white" style="background: linear-gradient(135deg, {{ $tema->color_primario ?? '#1a437e' }}, #102a4d);">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-3">
                <i class="fas fa-calendar-alt"></i> Agenda Institucional
            </h1>
            <p class="lead">Calendario completo de actividades y eventos</p>
        </div>
    </section>

    {{-- Listado de Eventos --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-3">
                @forelse($eventos as $evento)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm border-0" id="{{ $evento->id }}" style="border-radius: 16px; transition: transform 0.3s ease;">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center mb-3">
                                <div class="date-badge-elegant text-center me-2" style="min-width: 54px; height: 54px; background: linear-gradient(135deg, #1e293b 0%, #334155 100%); color: white; border-radius: 12px; display: flex; flex-direction: column; justify-content: center; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                                    <div style="font-size: 1.1rem; font-weight: 800; line-height: 1;">{{ $evento->fecha_inicio->format('d') }}</div>
                                    <div style="font-size: 0.55rem; text-transform: uppercase; font-weight: 700; opacity: 0.9;">{{ $evento->fecha_inicio->translatedFormat('M') }}</div>
                                </div>
                                <div class="event-meta-compact flex-grow-1 min-width-0">
                                    <span class="badge rounded-pill px-2 py-1 mb-1" style="background-color: {{ $evento->color ?? '#007bff' }}12; color: {{ $evento->color ?? '#007bff' }}; font-size: 0.6rem; font-weight: 700; text-transform: uppercase; display: inline-block; max-width: 100%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        {{ $evento->tipo ?? 'Evento' }}
                                    </span>
                                    <div class="text-muted" style="font-size: 0.7rem;"><i class="far fa-clock me-1"></i> {{ $evento->fecha_inicio->format('H:i') }}</div>
                                </div>
                            </div>
                            
                            <h6 class="fw-bold mb-2 text-dark text-truncate" style="font-size: 0.9rem;" title="{{ $evento->titulo }}">{{ $evento->titulo }}</h6>
                            <p class="text-muted mb-3 small" style="font-size: 0.75rem; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ $evento->descripcion }}
                            </p>
                            
                            @if($evento->ubicacion)
                            <div class="mt-auto pt-2 border-top text-muted" style="font-size: 0.7rem;">
                                <i class="fas fa-map-marker-alt me-1 text-primary"></i> <span class="text-truncate">{{ $evento->ubicacion }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <div class="bg-white p-5 rounded-4 shadow-sm">
                        <i class="fas fa-calendar-times fa-5x text-muted mb-3 opacity-25"></i>
                        <h3 class="text-muted">No hay eventos registrados</h3>
                        <p class="text-muted">Vuelve pronto para ver las nuevas actividades programadas.</p>
                    </div>
                </div>
                @endforelse
            </div>

            {{-- Paginación --}}
            @if($eventos->hasPages())
            <div class="row mt-5">
                <div class="col-12 d-flex justify-content-center">
                    {{ $eventos->links('pagination::bootstrap-5') }}
                </div>
            </div>
            @endif
        </div>
    </section>
</div>

<style>
    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }
    /* Estilos para el ancla cuando se navega desde el widget */
    :target {
        scroll-margin-top: 100px;
        border: 2px solid {{ $tema->color_primario ?? '#007bff' }} !important;
        animation: highlight 2s ease-out;
    }
    @keyframes highlight {
        from { background-color: {{ $tema->color_primario ?? '#007bff' }}10; }
        to { background-color: transparent; }
    }
</style>
@endsection
