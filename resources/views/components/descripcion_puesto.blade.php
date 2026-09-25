{{--
    ════════════════════════════════════════════════════════════
    COMPONENTE: DESCRIPCIÓN DE PUESTO
    ════════════════════════════════════════════════════════════
    
    Descripción:
    Muestra información detallada de un puesto de trabajo con 
    características, ubicación, modalidad y detalles.
    
    Variables:
    - $puesto (opcional) - Array con información del puesto
    - $tema (opcional) - Objeto del tema activo
    
    Uso Básico:
    @include('components.descripcion_puesto')
    
    Uso Personalizado:
    @include('components.descripcion_puesto', [
        'puesto' => [
            'titulo' => 'Asistente Legal',
            'ubicacion' => 'Lima, Perú',
            'modalidad' => 'Presencial',
            'jornada' => 'Tiempo Completo',
            'salario' => 'S/ 2,500 - S/ 3,500',
            'descripcion' => 'Descripción detallada...'
        ]
    ])
    
    Creado: 2025-10-26
    ════════════════════════════════════════════════════════════
--}}

@php
    $tema = $tema ?? \App\Models\Tema::obtenerPredeterminado();
    $puesto = $puesto ?? [
        'titulo' => 'Puesto de Ejemplo',
        'ubicacion' => 'Lima, Perú',
        'modalidad' => 'Presencial',
        'jornada' => 'Tiempo Completo',
        'salario' => 'A convenir',
        'descripcion' => 'Estamos buscando un profesional talentoso para unirse a nuestro equipo. Esta es una excelente oportunidad para desarrollar tu carrera en un ambiente profesional y dinámico.'
    ];
@endphp

<div class="descripcion-puesto-section mb-5">
    <div class="card shadow-lg border-0">
        <div class="card-header text-white" style="background: linear-gradient(135deg, {{ $tema->color_primario ?? '#007bff' }} 0%, {{ $tema->color_secundario ?? '#6c757d' }} 100%);">
            <h3 class="mb-0">
                <i class="fas fa-briefcase"></i> {{ $puesto['titulo'] ?? 'Puesto Disponible' }}
            </h3>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt fa-2x text-primary mb-2"></i>
                        <h6>Ubicación</h6>
                        <p class="text-muted mb-0">{{ $puesto['ubicacion'] ?? 'No especificado' }}</p>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="info-item">
                        <i class="fas fa-building fa-2x text-primary mb-2"></i>
                        <h6>Modalidad</h6>
                        <p class="text-muted mb-0">{{ $puesto['modalidad'] ?? 'Presencial' }}</p>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="info-item">
                        <i class="fas fa-clock fa-2x text-primary mb-2"></i>
                        <h6>Jornada</h6>
                        <p class="text-muted mb-0">{{ $puesto['jornada'] ?? 'Tiempo Completo' }}</p>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="info-item">
                        <i class="fas fa-dollar-sign fa-2x text-primary mb-2"></i>
                        <h6>Salario</h6>
                        <p class="text-muted mb-0">{{ $puesto['salario'] ?? 'A convenir' }}</p>
                    </div>
                </div>
            </div>
            
            <hr>
            
            <div class="descripcion-texto">
                <h5 class="mb-3"><i class="fas fa-align-left text-primary"></i> Descripción del Puesto</h5>
                <p class="lead">{{ $puesto['descripcion'] ?? 'Descripción no disponible' }}</p>
            </div>
            
            @if(isset($puesto['responsabilidades']) && is_array($puesto['responsabilidades']))
            <hr>
            <div class="mt-4">
                <h5 class="mb-3"><i class="fas fa-tasks text-primary"></i> Responsabilidades Principales</h5>
                <ul class="lista-responsabilidades">
                    @foreach($puesto['responsabilidades'] as $responsabilidad)
                        <li>{{ $responsabilidad }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.descripcion-puesto-section .info-item {
    text-align: center;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.descripcion-puesto-section .info-item:hover {
    background: #e9ecef;
    transform: translateY(-3px);
}

.descripcion-puesto-section .info-item i {
    display: block;
}

.descripcion-puesto-section .info-item h6 {
    font-weight: 600;
    margin-top: 10px;
    margin-bottom: 5px;
}

.lista-responsabilidades {
    list-style: none;
    padding: 0;
}

.lista-responsabilidades li {
    padding: 10px 0;
    padding-left: 30px;
    position: relative;
}

.lista-responsabilidades li::before {
    content: '✓';
    position: absolute;
    left: 0;
    color: {{ $tema->color_primario ?? '#007bff' }};
    font-weight: bold;
    font-size: 1.2rem;
}

.descripcion-texto .lead {
    line-height: 1.8;
    color: #495057;
}
</style>

