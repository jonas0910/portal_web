{{--
    Componente: Alerta Personalizada
    Uso: Para mostrar mensajes importantes
    Variables: $tipo (success, warning, danger, info), $titulo, $mensaje, $icono
--}}

@php
    $tipo = $tipo ?? 'info';
    $iconos = [
        'success' => 'fas fa-check-circle',
        'warning' => 'fas fa-exclamation-triangle',
        'danger' => 'fas fa-times-circle',
        'info' => 'fas fa-info-circle'
    ];
    $colores = [
        'success' => '#28a745',
        'warning' => '#ffc107',
        'danger' => '#dc3545',
        'info' => '#17a2b8'
    ];
@endphp

<div class="alerta-custom alert alert-{{ $tipo }} alert-dismissible fade show" role="alert">
    <div class="d-flex align-items-start">
        <div class="alerta-icono me-3">
            <i class="{{ $icono ?? $iconos[$tipo] }} fa-2x"></i>
        </div>
        <div class="flex-grow-1">
            @if(isset($titulo))
                <h5 class="alert-heading mb-2">{{ $titulo }}</h5>
            @endif
            <p class="mb-0">{{ $mensaje ?? 'Mensaje de alerta' }}</p>
        </div>
    </div>
    <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<style>
.alerta-custom {
    border-left: 5px solid {{ $colores[$tipo] }};
    border-radius: 8px;
}

.alerta-icono {
    color: {{ $colores[$tipo] }};
}
</style>

