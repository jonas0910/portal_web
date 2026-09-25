{{--
    Widget Sidebar: Documentos Recientes
--}}

@props(['config' => []])

@php
    $cantidad = $config['cantidad'] ?? 5;
    $documentos = \App\Models\Documento::where('publico', true)
        ->orderBy('created_at', 'desc')
        ->take($cantidad)
        ->get();
@endphp

@if($documentos->count() > 0)
<div class="card shadow-sm mb-4">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">
            <i class="fas fa-file-download"></i> Documentos Recientes
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="list-group list-group-flush">
            @foreach($documentos as $documento)
            <a href="{{ route('public.documentos.descargar', $documento->id) }}" 
               class="list-group-item list-group-item-action p-3"
               target="_blank">
                <div class="d-flex align-items-center">
                    <div class="mr-3">
                        <i class="fas fa-file-pdf fa-2x text-danger"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0 small">{{ Str::limit($documento->titulo, 35) }}</h6>
                        <small class="text-muted">
                            <i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($documento->created_at)->format('d/m/Y') }}
                        </small>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    <div class="card-footer bg-light text-center">
        <a href="{{ route('public.documentos') }}" class="btn btn-sm btn-outline-success">
            Ver todos <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>
</div>
@endif

