{{--
    ════════════════════════════════════════════════════════════
    COMPONENTE: TIMELINE DEL PROCESO
    ════════════════════════════════════════════════════════════
    
    Descripción:
    Muestra el proceso de selección de personal como una línea de tiempo
    con pasos numerados y descripciones.
    
    Variables:
    - $pasos (opcional) - Array de pasos del proceso
    - $tema (opcional) - Objeto del tema activo
    
    Uso Básico:
    @include('components.timeline_proceso')
    
    Uso Personalizado:
    @include('components.timeline_proceso', [
        'pasos' => [
            ['numero' => '1', 'titulo' => 'Postulación', 'descripcion' => 'Envía tu CV'],
            ['numero' => '2', 'titulo' => 'Revisión', 'descripcion' => 'Evaluamos tu perfil'],
        ]
    ])
    
    Creado: 2025-10-26
    ════════════════════════════════════════════════════════════
--}}

@php
    $tema = $tema ?? \App\Models\Tema::obtenerPredeterminado();
    $pasos = $pasos ?? [
        [
            'numero' => '1',
            'titulo' => 'Postulación',
            'descripcion' => 'Envía tu CV y carta de presentación a través de nuestro formulario en línea.',
            'icono' => 'fas fa-paper-plane'
        ],
        [
            'numero' => '2',
            'titulo' => 'Revisión de CV',
            'descripcion' => 'Nuestro equipo de recursos humanos revisará tu perfil profesional.',
            'icono' => 'fas fa-file-alt'
        ],
        [
            'numero' => '3',
            'titulo' => 'Entrevista Inicial',
            'descripcion' => 'Si tu perfil es preseleccionado, te contactaremos para una entrevista.',
            'icono' => 'fas fa-comments'
        ],
        [
            'numero' => '4',
            'titulo' => 'Evaluación Técnica',
            'descripcion' => 'Realizarás pruebas técnicas y/o psicológicas según el puesto.',
            'icono' => 'fas fa-tasks'
        ],
        [
            'numero' => '5',
            'titulo' => 'Entrevista Final',
            'descripcion' => 'Entrevista con el área correspondiente y recursos humanos.',
            'icono' => 'fas fa-user-tie'
        ],
        [
            'numero' => '6',
            'titulo' => 'Oferta Laboral',
            'descripcion' => 'Si todo sale bien, recibirás nuestra oferta laboral formal.',
            'icono' => 'fas fa-handshake'
        ]
    ];
@endphp

<div class="timeline-proceso-section mb-5">
    <h3 class="text-center mb-5">
        <i class="fas fa-route"></i> Proceso de Selección
    </h3>
    
    <div class="proceso-timeline">
        @foreach($pasos as $index => $paso)
        <div class="proceso-paso {{ $index % 2 == 0 ? 'paso-left' : 'paso-right' }}">
            <div class="paso-numero" style="background: linear-gradient(135deg, {{ $tema->color_primario ?? '#007bff' }} 0%, {{ $tema->color_secundario ?? '#6c757d' }} 100%);">
                {{ $paso['numero'] }}
            </div>
            <div class="paso-contenido">
                <div class="paso-icono">
                    <i class="{{ $paso['icono'] ?? 'fas fa-check' }}"></i>
                </div>
                <h5 class="paso-titulo">{{ $paso['titulo'] }}</h5>
                <p class="paso-descripcion">{{ $paso['descripcion'] }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
.proceso-timeline {
    position: relative;
    padding: 40px 0;
}

.proceso-timeline::before {
    content: '';
    position: absolute;
    left: 50%;
    top: 0;
    bottom: 0;
    width: 4px;
    background: linear-gradient(to bottom, 
        {{ $tema->color_primario ?? '#007bff' }} 0%, 
        {{ $tema->color_acento ?? '#28a745' }} 100%);
    transform: translateX(-50%);
}

.proceso-paso {
    position: relative;
    margin-bottom: 60px;
    display: flex;
    align-items: center;
}

.proceso-paso.paso-left {
    justify-content: flex-end;
    padding-right: calc(50% + 40px);
}

.proceso-paso.paso-right {
    justify-content: flex-start;
    padding-left: calc(50% + 40px);
}

.paso-numero {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 60px;
    border-radius: 50%;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: bold;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    z-index: 2;
}

.paso-contenido {
    background: white;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 400px;
    transition: all 0.3s ease;
}

.paso-contenido:hover {
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    transform: translateY(-5px);
}

.paso-icono {
    display: inline-block;
    width: 40px;
    height: 40px;
    background: {{ $tema->color_primario ?? '#007bff' }};
    color: white;
    border-radius: 50%;
    text-align: center;
    line-height: 40px;
    margin-bottom: 15px;
}

.paso-titulo {
    color: {{ $tema->color_primario ?? '#007bff' }};
    font-weight: 600;
    margin-bottom: 10px;
}

.paso-descripcion {
    color: #666;
    margin: 0;
    font-size: 0.95rem;
}

/* Responsive */
@media (max-width: 768px) {
    .proceso-timeline::before {
        left: 30px;
    }
    
    .proceso-paso,
    .proceso-paso.paso-left,
    .proceso-paso.paso-right {
        padding-left: 80px;
        padding-right: 0;
        justify-content: flex-start;
    }
    
    .paso-numero {
        left: 30px;
        transform: translateX(0);
    }
    
    .paso-contenido {
        max-width: 100%;
    }
}
</style>

