@extends('layouts.public')

@section('title', 'Mesa de Partes - Trámite Documentario')
@section('meta_description', 'Realice sus trámites de manera virtual y consulte el estado de sus expedientes')

@section('content')
<div class="container py-5">
    {{-- Título y subtítulo --}}
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold mb-2">
            <i class="fas fa-file-alt text-primary me-2"></i>Trámite Documentario
        </h1>
        <p class="lead text-muted">
            Realice sus trámites de manera virtual y consulte el estado de sus expedientes
        </p>
    </div>

    {{-- Dos tarjetas principales (enlaces a rutas separadas) --}}
    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center p-4">
                    <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width:80px;height:80px;">
                        <i class="fas fa-plus fa-2x text-primary"></i>
                    </div>
                    <h3 class="h5 fw-bold mb-2">Ingresar Nuevo Trámite</h3>
                    <p class="text-muted mb-4">
                        Registre un nuevo documento o solicitud para ser procesado por la municipalidad.
                    </p>
                    <a href="{{ route('public.mesa-partes.nuevo') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-arrow-right me-2"></i>Iniciar Trámite
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center p-4">
                    <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width:80px;height:80px;">
                        <i class="fas fa-search fa-2x text-success"></i>
                    </div>
                    <h3 class="h5 fw-bold mb-2">Consultar Estado</h3>
                    <p class="text-muted mb-4">
                        Verifique el estado y seguimiento de sus trámites ingresados anteriormente.
                    </p>
                    <a href="{{ route('public.mesa-partes.consulta') }}" class="btn btn-success btn-lg">
                        <i class="fas fa-search me-2"></i>Consultar Trámite
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Tipos de Trámites Disponibles --}}
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h4 class="mb-0"><i class="fas fa-list me-2"></i>Tipos de Trámites Disponibles</h4>
        </div>
        <div class="card-body">
            @if(count($tiposTramite) > 0)
                <div class="row g-3">
                    @foreach($tiposTramite as $tipo)
                        <div class="col-md-6 col-lg-4">
                            <div class="d-flex align-items-start p-3 border rounded">
                                <i class="fas fa-file-alt text-primary me-3 mt-1"></i>
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $tipo->nombre ?? $tipo['nombre'] ?? '—' }}</h6>
                                    <p class="small text-muted mb-0">{{ $tipo->descripcion ?? $tipo['descripcion'] ?? 'Sin descripción' }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    No hay tipos de trámite configurados o el servicio no está disponible. Contacte a la municipalidad.
                </p>
            @endif
        </div>
    </div>
</div>
@endsection
