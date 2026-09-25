{{--
    Componente: Card de Información
    Uso: Para mostrar información destacada en un cuadro
    Variables: $titulo, $icono, $descripcion, $color (opcional)
--}}

@php
    $color = $color ?? 'primary'; // Color por defecto
@endphp

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="d-flex align-items-center mb-3">
            <div class="icon-box me-3" style="background-color: var(--{{ $color }}-color, #007bff); width: 60px; height: 60px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                <i class="{{ $icono ?? 'fas fa-info-circle' }} fa-2x text-white"></i>
            </div>
            <h4 class="mb-0">{{ $titulo ?? 'Título' }}</h4>
        </div>
        <p class="text-muted mb-0">
            {{ $descripcion ?? 'Descripción del componente' }}
        </p>
    </div>
</div>

<style>
.icon-box {
    transition: transform 0.3s ease;
}

.icon-box:hover {
    transform: scale(1.1);
}
</style>

