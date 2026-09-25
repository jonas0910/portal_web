<div class="card">
    <div class="card-header bg-warning">
        <h3 class="card-title"><i class="fas fa-file-alt"></i> Documentos Pendientes</h3>
        <div class="card-tools">
            <span class="badge badge-light">{{ $documentosPendientes ?? 0 }}</span>
        </div>
    </div>
    <div class="card-body p-0">
        @php
            $documentos = \App\Models\Documento::whereNull('deleted_at')->latest()->take(5)->get();
        @endphp
        
        @if(isset($documentos) && is_object($documentos) && $documentos->count() > 0)
            <ul class="list-group list-group-flush">
                @foreach($documentos as $doc)
                <li class="list-group-item">
                    <div class="d-flex justify-content-between">
                        <div>
                            <i class="fas fa-file-pdf text-danger"></i>
                            <strong>{{ Str::limit($doc->titulo, 40) }}</strong>
                            <br>
                            <small class="text-muted">{{ $doc->tipo }}</small>
                        </div>
                        <small class="text-muted">{{ $doc->created_at->diffForHumans() }}</small>
                    </div>
                </li>
                @endforeach
            </ul>
        @else
            <div class="text-center p-4 text-muted">
                <i class="fas fa-check-circle fa-3x mb-3 text-success"></i>
                <p>No hay documentos pendientes</p>
            </div>
        @endif
    </div>
    <div class="card-footer text-center">
        <a href="{{ route('admin.documentos.index') }}" class="btn btn-sm btn-warning">Ver Todos</a>
    </div>
</div>

