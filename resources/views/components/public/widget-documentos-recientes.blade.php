{{-- Widget de Documentos Recientes para el sitio público --}}
<section class="documentos-recientes py-5">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h5 class="text-uppercase text-secondary fw-bold letter-spacing-2 mb-2">Transparencia y Acceso</h5>
            <h2 class="display-5 fw-bold mb-4 text-dark">
                Documentos Recientes
            </h2>
            <div class="title-divider mx-auto mb-5"></div>
        </div>
        
        @php
            try {
                $documentosRecientes = \App\Models\Documento::where('publico', true)
                    ->with(['notario', 'categoria'])
                    ->orderBy('created_at', 'desc')
                    ->take(6)
                    ->get();
            } catch (\Exception $e) {
                $documentosRecientes = collect([]);
            }
        @endphp
        
        @php
            $documentosList = [];
            if (isset($documentosRecientes)) {
                if (is_array($documentosRecientes)) {
                    $documentosList = $documentosRecientes;
                } else if (is_object($documentosRecientes) && method_exists($documentosRecientes, 'all')) {
                    $documentosList = $documentosRecientes->all();
                }
            }
        @endphp
        
        @if(!empty($documentosList))
            <div class="row">
                @foreach($documentosList as $documento)
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="card documento-card h-100 border-0 shadow-sm p-3">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <div class="file-icon-wrapper me-3">
                                    <i class="fas fa-file-pdf fa-2x text-danger"></i>
                                </div>
                                <div class="flex-grow-1">
                                    @if($documento->categoria)
                                        <span class="badge bg-light text-dark border mb-1" style="font-size: 0.7rem;">{{ $documento->categoria->nombre }}</span>
                                    @endif
                                    <div class="small text-muted">{{ $documento->created_at->format('d/m/Y') }}</div>
                                </div>
                            </div>
                            
                            <h6 class="card-title fw-bold mb-2">
                                <a href="{{ route('public.documentos.descargar', $documento->id) }}" class="text-decoration-none text-dark hover-primary">
                                    {{ Str::limit($documento->titulo, 50) }}
                                </a>
                            </h6>
                            
                            <p class="card-text text-muted small flex-grow-1 mb-3">
                                {{ Str::limit($documento->descripcion, 80) }}
                            </p>
                            
                            <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-auto">
                                <small class="text-muted fw-bold">
                                    @if($documento->tamano_archivo)
                                        <i class="fas fa-hdd me-1"></i> {{ number_format($documento->tamano_archivo / 1024, 2) }} KB
                                    @endif
                                </small>
                                <a href="{{ route('public.documentos.descargar', $documento->id) }}" 
                                   class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                    <i class="fas fa-download me-1"></i> Descargar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="text-center mt-4 pt-2">
                <a href="{{ route('public.documentos') }}" class="btn btn-outline-dark rounded-pill px-5 py-2 fw-bold">
                    Ver Todos los Documentos
                </a>
            </div>
        @else
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> 
                No hay documentos públicos disponibles en este momento.
            </div>
        @endif
    </div>
</section>

<style>
.documento-card {
    border-radius: 12px;
    background: #fff;
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
}
.documento-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
}
.file-icon-wrapper {
    width: 48px;
    height: 48px;
    background: #fff5f5;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.title-divider {
    width: 60px;
    height: 3px;
    background: var(--secondary);
    border-radius: 3px;
}
.letter-spacing-2 {
    letter-spacing: 2px;
}
.hover-primary:hover {
    color: var(--primary) !important;
}
</style>

