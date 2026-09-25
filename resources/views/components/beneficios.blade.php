{{--
    Componente: Sección de Beneficios
    Descripción: Muestra beneficios con iconos en un diseño atractivo
    Variables: $beneficios (array - opcional), $tema (objeto - opcional)
    Uso: @include('components.beneficios')
    Creado: 2025-10-26
--}}

@php
    $tema = $tema ?? \App\Models\Tema::obtenerPredeterminado();
    $beneficios = $beneficios ?? [
        [
            'icono' => 'fas fa-award',
            'titulo' => 'Excelencia Profesional',
            'descripcion' => 'Formación continua y desarrollo profesional'
        ],
        [
            'icono' => 'fas fa-users',
            'titulo' => 'Gran Equipo',
            'descripcion' => 'Ambiente colaborativo y de respeto'
        ],
        [
            'icono' => 'fas fa-chart-line',
            'titulo' => 'Crecimiento',
            'descripcion' => 'Oportunidades de ascenso y desarrollo'
        ],
        [
            'icono' => 'fas fa-hand-holding-usd',
            'titulo' => 'Beneficios',
            'descripcion' => 'Salarios competitivos y bonos'
        ]
    ];
@endphp

<div class="beneficios-section">
    <div class="card shadow-sm" style="background: linear-gradient(135deg, {{ $tema->color_primario ?? '#007bff' }} 0%, {{ $tema->color_secundario ?? '#6c757d' }} 100%); color: white;">
        <div class="card-body text-center py-5">
            <h3 class="mb-4">¿Por qué trabajar con nosotros?</h3>
            <div class="row">
                @foreach($beneficios as $beneficio)
                <div class="col-md-{{ 12 / count($beneficios) }} mb-3">
                    <i class="{{ $beneficio['icono'] }} fa-3x mb-3"></i>
                    <h5>{{ $beneficio['titulo'] }}</h5>
                    <p class="small">{{ $beneficio['descripcion'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
.beneficios-section .card {
    border: none;
}

.beneficios-section i {
    opacity: 0.9;
}

.beneficios-section h5 {
    font-weight: 600;
}
</style>

