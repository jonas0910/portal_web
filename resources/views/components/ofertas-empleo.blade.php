{{--
    Componente: Ofertas de Empleo
    Descripción: Muestra tarjetas de ofertas de trabajo disponibles
    Variables: $ofertas (array de ofertas - opcional, usa ejemplos si no se pasa)
    Uso: @include('components.ofertas-empleo', ['ofertas' => $ofertas])
    Creado: 2025-10-26
--}}

@php
    // Cargar ofertas de la BD si no se pasan
    if (!isset($ofertas)) {
        $ofertas = \App\Models\OfertaEmpleo::abiertas()
            ->orderBy('destacado', 'desc')
            ->orderBy('orden')
            ->get()
            ->map(function($oferta) {
                return [
                    'titulo' => $oferta->titulo,
                    'estado' => ucfirst($oferta->estado),
                    'ubicacion' => $oferta->ubicacion . ($oferta->departamento ? ', ' . $oferta->departamento : ''),
                    'jornada' => $oferta->jornada_text,
                    'fecha' => $oferta->created_at->format('d/m/Y'),
                    'descripcion' => $oferta->descripcion,
                    'requisitos' => $oferta->requisitos ?? []
                ];
            })->toArray();
    }
    
    // Si la BD está vacía, mostrar mensaje
    if (empty($ofertas)) {
        $ofertas = [];
    }
    
    /* DATOS MOCK ELIMINADOS - TODO DESDE BD
    if (empty($ofertas)) {
        $ofertas = [
        [
            'titulo' => 'Asistente Legal (MOCK)',
            'estado' => 'Abierto',
            'ubicacion' => 'Lima, Perú',
            'jornada' => 'Tiempo Completo',
            'fecha' => '20/10/2025',
            'descripcion' => 'Buscamos un asistente legal con experiencia en derecho notarial para unirse a nuestro equipo.',
            'requisitos' => [
                'Título universitario en Derecho',
                'Mínimo 2 años de experiencia',
                'Conocimiento de procedimientos notariales',
                'Manejo de Office avanzado'
            ]
        ],
        [
            'titulo' => 'Notario Asociado',
            'estado' => 'Abierto',
            'ubicacion' => 'Arequipa, Perú',
            'jornada' => 'Tiempo Completo',
            'fecha' => '18/10/2025',
            'descripcion' => 'Oportunidad para notario con título registrado que desee formar parte de nuestra red nacional.',
            'requisitos' => [
                'Título de Notario Público registrado',
                'Mínimo 5 años de experiencia',
                'Disponibilidad para viajar',
                'Excelentes habilidades interpersonales'
            ]
        ],
        [
            'titulo' => 'Secretaria Ejecutiva',
            'estado' => 'Abierto',
            'ubicacion' => 'Cusco, Perú',
            'jornada' => 'Tiempo Completo',
            'fecha' => '15/10/2025',
            'descripcion' => 'Buscamos secretaria ejecutiva con experiencia en atención al cliente y gestión de documentos.',
            'requisitos' => [
                'Técnico en Secretariado o afines',
                'Experiencia mínima 3 años',
                'Manejo de agenda y citas',
                'Excelente presentación'
            ]
        ],
        [
            'titulo' => 'Practicante de Derecho',
            'estado' => 'Por cerrar',
            'ubicacion' => 'Lima, Perú',
            'jornada' => 'Medio Tiempo',
            'fecha' => '10/10/2025',
            'descripcion' => 'Oportunidad de prácticas pre-profesionales para estudiantes de derecho en últimos ciclos.',
            'requisitos' => [
                'Estar cursando 8vo ciclo o superior',
                'Promedio ponderado mínimo 14',
                'Disponibilidad 4 horas diarias',
                'Proactividad y ganas de aprender'
            ]
        ]
        ];
    }
    FIN DATOS MOCK */
@endphp

<div class="row ofertas-empleo">
    @if(empty($ofertas))
    <div class="col-12">
        <div class="alert alert-info text-center py-5">
            <i class="fas fa-briefcase fa-3x mb-3 d-block"></i>
            <h4>No hay ofertas disponibles actualmente</h4>
            <p>Las nuevas convocatorias aparecerán aquí cuando estén disponibles.</p>
        </div>
    </div>
    @else
    @foreach($ofertas as $oferta)
    <div class="col-md-6 mb-4">
        <div class="card h-100 shadow-sm hover-shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h4 class="card-title mb-0">{{ $oferta['titulo'] }}</h4>
                    <span class="badge badge-{{ $oferta['estado'] == 'Abierto' ? 'success' : 'warning' }}">
                        {{ $oferta['estado'] }}
                    </span>
                </div>
                
                <p class="text-muted mb-3">
                    <i class="fas fa-map-marker-alt"></i> {{ $oferta['ubicacion'] }}<br>
                    <i class="fas fa-clock"></i> {{ $oferta['jornada'] }}<br>
                    <i class="fas fa-calendar"></i> Publicado: {{ $oferta['fecha'] }}
                </p>
                
                <p class="card-text">{{ $oferta['descripcion'] }}</p>
                
                <hr>
                
                <h6>Requisitos:</h6>
                <ul class="small">
                    @foreach($oferta['requisitos'] as $requisito)
                        <li>{{ $requisito }}</li>
                    @endforeach
                </ul>
                
                <button type="button" 
                        class="btn btn-primary btn-block" 
                        data-toggle="modal" 
                        data-target="#modalPostular" 
                        data-puesto="{{ $oferta['titulo'] }}">
                    <i class="fas fa-paper-plane"></i> Postular Ahora
                </button>
            </div>
        </div>
    </div>
    @endforeach
    @endif
</div>

<style>
.hover-shadow {
    transition: all 0.3s ease;
}

.hover-shadow:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important;
}

.ofertas-empleo .card {
    border-top: 3px solid var(--primary-color);
}
</style>

