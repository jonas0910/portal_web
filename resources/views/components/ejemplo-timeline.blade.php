{{--
    Componente: Timeline / Línea de Tiempo
    Uso: Para mostrar eventos en secuencia
    Variables: $eventos (array de eventos)
--}}

@php
    // Eventos de ejemplo si no se pasan
    $eventos = $eventos ?? [
        [
            'fecha' => '2025',
            'titulo' => 'Evento 1',
            'descripcion' => 'Descripción del primer evento',
            'icono' => 'fas fa-flag'
        ],
        [
            'fecha' => '2024',
            'titulo' => 'Evento 2',
            'descripcion' => 'Descripción del segundo evento',
            'icono' => 'fas fa-star'
        ]
    ];
@endphp

<div class="timeline-container">
    @foreach($eventos as $index => $evento)
        <div class="timeline-item {{ $index % 2 == 0 ? 'left' : 'right' }}">
            <div class="timeline-icon">
                <i class="{{ $evento['icono'] ?? 'fas fa-circle' }}"></i>
            </div>
            <div class="timeline-content">
                <div class="timeline-fecha">{{ $evento['fecha'] ?? '' }}</div>
                <h5 class="timeline-titulo">{{ $evento['titulo'] ?? 'Título' }}</h5>
                <p class="timeline-descripcion">{{ $evento['descripcion'] ?? '' }}</p>
            </div>
        </div>
    @endforeach
</div>

<style>
.timeline-container {
    position: relative;
    padding: 20px 0;
}

.timeline-container::before {
    content: '';
    position: absolute;
    left: 50%;
    top: 0;
    bottom: 0;
    width: 2px;
    background: var(--primary-color, #007bff);
    transform: translateX(-50%);
}

.timeline-item {
    position: relative;
    margin-bottom: 40px;
    width: 45%;
}

.timeline-item.left {
    left: 0;
    text-align: right;
}

.timeline-item.right {
    left: 55%;
    text-align: left;
}

.timeline-icon {
    position: absolute;
    width: 40px;
    height: 40px;
    background: var(--primary-color, #007bff);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    z-index: 1;
}

.timeline-item.left .timeline-icon {
    right: -65px;
}

.timeline-item.right .timeline-icon {
    left: -65px;
}

.timeline-content {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

.timeline-fecha {
    font-weight: bold;
    color: var(--primary-color, #007bff);
    margin-bottom: 10px;
}

.timeline-titulo {
    margin-bottom: 10px;
}

.timeline-descripcion {
    color: #666;
    margin: 0;
}

@media (max-width: 768px) {
    .timeline-container::before {
        left: 20px;
    }
    
    .timeline-item,
    .timeline-item.left,
    .timeline-item.right {
        width: 100%;
        left: 0 !important;
        text-align: left;
        padding-left: 60px;
    }
    
    .timeline-item .timeline-icon,
    .timeline-item.left .timeline-icon,
    .timeline-item.right .timeline-icon {
        left: 0;
        right: auto;
    }
}
</style>

