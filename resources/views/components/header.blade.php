{{--
    Componente: Header / Encabezado
    Descripción: Encabezado principal de página con título y breadcrumbs
    Variables: $titulo, $descripcion (opcional), $breadcrumbs (opcional - array)
    Uso: @include('components.header', ['titulo' => 'Mi Página'])
    Creado: 2025-10-26
--}}

<div class="page-header mb-4">
    @if(isset($breadcrumbs) && is_array($breadcrumbs))
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('public.index') }}">Inicio</a></li>
            @foreach($breadcrumbs as $breadcrumb)
                @if(isset($breadcrumb['url']))
                    <li class="breadcrumb-item"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['nombre'] }}</a></li>
                @else
                    <li class="breadcrumb-item active">{{ $breadcrumb['nombre'] }}</li>
                @endif
            @endforeach
        </ol>
    </nav>
    @endif
    
    <h1 class="display-4 mb-3" style="color: var(--primary-color);">
        {{ $titulo ?? 'Título de la Página' }}
    </h1>
    
    @if(isset($descripcion))
    <p class="lead text-muted">{{ $descripcion }}</p>
    @endif
</div>

<style>
.page-header {
    padding: 20px 0;
    border-bottom: 2px solid #e9ecef;
}

.page-header h1 {
    font-weight: 700;
}

.breadcrumb {
    background: transparent;
    padding: 0;
}
</style>

