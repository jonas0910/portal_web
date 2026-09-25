{{--
    Componente: Lista de Requisitos
    Descripción: Muestra una lista de requisitos con checkmarks
    Variables: $requisitos (array), $titulo (opcional)
    Uso: @include('components.requisitos', ['requisitos' => ['Req 1', 'Req 2']])
    Creado: 2025-10-26
--}}

@php
    $requisitos = $requisitos ?? [
        'Requisito de ejemplo 1',
        'Requisito de ejemplo 2',
        'Requisito de ejemplo 3'
    ];
@endphp

<div class="requisitos-section">
    <h4 class="mb-3">
        <i class="fas fa-list-check"></i> {{ $titulo ?? 'Requisitos' }}
    </h4>
    
    <ul class="lista-requisitos">
        @foreach($requisitos as $requisito)
        <li>
            <i class="fas fa-check-circle text-success"></i>
            <span>{{ $requisito }}</span>
        </li>
        @endforeach
    </ul>
</div>

<style>
.lista-requisitos {
    list-style: none;
    padding: 0;
}

.lista-requisitos li {
    padding: 10px 0;
    border-bottom: 1px solid #e9ecef;
    display: flex;
    align-items: start;
}

.lista-requisitos li:last-child {
    border-bottom: none;
}

.lista-requisitos li i {
    margin-right: 10px;
    margin-top: 3px;
    font-size: 1.1rem;
}

.lista-requisitos li span {
    flex: 1;
}
</style>

