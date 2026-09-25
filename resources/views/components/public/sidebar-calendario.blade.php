{{--
    Widget Sidebar: Calendario de Eventos
--}}

@props(['config' => []])

@php
    $cantidad = $config['cantidad'] ?? 5;
    $eventos = \App\Models\Evento::orderBy('fecha_inicio', 'desc')
        ->take($cantidad)
        ->get();
@endphp

@if($eventos->count() > 0)
<div class="card shadow-sm border-0 mb-4" style="border-radius: 20px; overflow: hidden;">
    <div class="card-header border-0 py-3" style="background: linear-gradient(45deg, var(--bs-primary), #4dabff);">
        <h6 class="mb-0 text-white fw-bold d-flex align-items-center">
            <i class="fas fa-calendar-alt me-2"></i> Próximos Eventos
        </h6>
    </div>
    <div class="card-body p-0">
        <div class="list-group list-group-flush">
            @foreach($eventos as $evento)
            <a href="{{ route('public.eventos') }}#{{ $evento->id }}" class="list-group-item list-group-item-action border-0 p-3 transition-all sidebar-event-item">
                <div class="d-flex align-items-start">
                    <div class="date-box-mini me-3 text-center" style="min-width: 50px; background: #f0f4f8; border-radius: 12px; padding: 8px 5px;">
                        <div class="fw-bold text-primary" style="font-size: 1.1rem; line-height: 1;">{{ \Carbon\Carbon::parse($evento->fecha_inicio)->format('d') }}</div>
                        <div class="small text-muted text-uppercase" style="font-size: 0.6rem; font-weight: 700;">{{ \Carbon\Carbon::parse($evento->fecha_inicio)->translatedFormat('M') }}</div>
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <h6 class="mb-1 fw-bold text-dark text-truncate" style="font-size: 0.85rem;">{{ $evento->titulo }}</h6>
                        <div class="text-muted" style="font-size: 0.75rem;">
                            <i class="far fa-clock me-1"></i> {{ \Carbon\Carbon::parse($evento->fecha_inicio)->format('H:i') }}
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    <div class="card-footer bg-white border-0 text-center pb-3">
        <a href="{{ route('public.eventos') }}" class="btn btn-sm btn-light rounded-pill px-4 fw-bold text-primary" style="font-size: 0.75rem;">
            Ver toda la agenda <i class="fas fa-arrow-right ms-1"></i>
        </a>
    </div>
</div>

<style>
    .sidebar-event-item:hover {
        background-color: #f8f9fa;
        transform: translateX(3px);
    }
    .sidebar-event-item:hover .date-box-mini {
        background: var(--bs-primary);
        color: white !important;
    }
    .sidebar-event-item:hover .date-box-mini div {
        color: white !important;
    }
</style>
@endif

