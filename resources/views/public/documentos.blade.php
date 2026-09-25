@extends('layouts.public')

@section('title', 'Marco Normativo Notarial - Documentos Públicos')

@section('content')
<!-- Hero Section -->
<section class="hero-section text-white py-5" style="background-color: #1b5e20;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="hero-title fw-bold" style="font-size: 2.5rem;">Legislacion</h1>
                <p class="hero-subtitle mb-0 opacity-90">
                    Consulta y descarga las leyes, decretos y resoluciones vigentes aplicables a la función notarial y PLAFT.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Filtros de Búsqueda -->
<section class="py-4 bg-light border-bottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">
                        <form method="GET" action="{{ route('public.documentos') }}">
                            <div class="row g-3 align-items-end">
                               

                                <div class="col-md-5">
                                    <label for="search" class="form-label fw-semibold text-secondary small">Buscar Documento</label>
                                    <input type="text" class="form-control" id="search" name="search" 
                                           value="{{ request('search') }}" placeholder="Título, decreto o descripción...">
                                </div>

                                <div class="col-md-2 d-flex gap-2">
                                    <button type="submit" class="btn btn-success w-100 fw-semibold" style="background-color: #1b5e20; border: none;">
                                        <i class="fas fa-search me-1"></i> Buscar
                                    </button>
                                    @if(request()->hasAny(['tipo', 'search']))
                                        <a href="{{ route('public.documentos') }}" class="btn btn-outline-secondary" title="Limpiar filtros">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Lista de Documentos DInámicos -->
<section class="py-5 bg-white">
    <div class="container">
        
        <!-- Banner Informativo Contextual -->
        <div class="p-4 rounded-3 shadow-sm border border-light-subtle mb-4" style="background-color: #f8faf8;">
            <div class="d-flex align-items-start gap-3">
                <div class="display-6 lh-1" style="color: #1b5e20;">
                    <i class="fas fa-shield-halved"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1" style="color: #1b5e20;">Cuerpo Normativo Notarial y UIF/PLAFT</h5>
                    <p class="text-muted small mb-0" style="line-height: 1.6;">
                        Repositorio de normas legales, decretos legislativos y disposiciones aplicables en materia notarial y prevención del lavado de activos.
                    </p>
                </div>
            </div>
        </div>

        <!-- Listado de Documentos -->
        <div class="row g-3">
            @forelse($documentos as $documento)
                @php
                    // Identificamos si es la Norma Matriz o destacar si aplica
                    $esNormaMatriz = Str::contains(Str::lower($documento->titulo), ['1049', 'ley del notariado']);
                @endphp

                @if($esNormaMatriz)
                    <!-- Destacado Principal: Ley del Notariado / Norma Matriz -->
                    <div class="col-12 mb-3">
                        <div class="card border-0 shadow-sm rounded-3 overflow-hidden" style="border-left: 5px solid #1b5e20 !important; background-color: #f8faf8;">
                            <div class="card-body p-4">
                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle p-3 me-3 text-white shadow-sm d-flex align-items-center justify-content-center" style="background-color: #1b5e20; width: 56px; height: 56px; flex-shrink: 0;">
                                            <i class="fas fa-book-journal-whills fs-4"></i>
                                        </div>
                                        <div>
                                            <span class="badge bg-success bg-opacity-20 text-success fw-bold text-uppercase px-2 py-1 mb-1" style="font-size: 0.75rem;">Norma Matriz</span>
                                            <h4 class="fw-bold mb-1" style="color: #1b5e20;">{{ $documento->titulo }}</h4>
                                            @if($documento->descripcion)
                                                <p class="text-muted small mb-0">{{ Str::limit($documento->descripcion, 150) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-md-end flex-shrink-0">
                                        <a href="{{ route('public.documentos.descargar', $documento->id) }}" target="_blank" class="btn btn-success px-4 py-2 fw-semibold rounded-2 shadow-sm d-inline-flex align-items-center gap-2" style="background-color: #1b5e20; border: none;">
                                            <i class="fas fa-file-pdf fs-5"></i> Descargar PDF
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Tarjeta Estándar estilo Fila / Banner -->
                    <div class="col-12">
                        <div class="card border border-light-subtle shadow-sm rounded-3 hover-shadow transition">
                            <div class="card-body p-3 p-md-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                                <div class="d-flex align-items-start gap-3">
                                    <i class="fas fa-file-pdf text-danger fs-2 mt-1 flex-shrink-0"></i>
                                    <div>
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <h6 class="fw-bold text-dark mb-0">{{ $documento->titulo }}</h6>
                                            @if($documento->categoria)
                                                <span class="badge bg-light text-secondary border small">{{ $documento->categoria->nombre }}</span>
                                            @endif
                                        </div>
                                        @if($documento->descripcion)
                                            <p class="text-muted small mb-0" style="line-height: 1.5;">{{ $documento->descripcion }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="align-self-start align-self-md-center flex-shrink-0">
                                    <a href="{{ route('public.documentos.descargar', $documento->id) }}" target="_blank" class="btn btn-outline-success btn-sm px-3 rounded-2 fw-semibold d-inline-flex align-items-center gap-1">
                                        <i class="fas fa-download"></i> PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <div class="col-12">
                    <div class="text-center py-5 bg-light rounded-3 border">
                        <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                        <h5 class="fw-bold text-secondary">No se encontraron documentos</h5>
                        <p class="text-muted small mb-0">Intenta cambiar los filtros o el término de búsqueda.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Paginación -->
        @if($documentos->hasPages())
            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-center">
                    {{ $documentos->appends(request()->query())->links() }}
                </div>
            </div>
        @endif

    </div>
</section>
@endsection