@if(isset($miembros) && $miembros->count() > 0)
<div class="row g-4 justify-content-center">
    @foreach($miembros as $miembro)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm text-center p-3" style="border-radius: 15px; transition: transform 0.3s;">
                <div class="mt-3">
                    <div class="rounded-circle d-inline-block p-1" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); width: 130px; height: 130px;">
                        @if($miembro->foto)
                            <img src="{{ $miembro->foto_url }}" alt="{{ $miembro->nombre }}" class="rounded-circle img-fluid w-100 h-100" style="object-fit: cover; border: 4px solid white;">
                        @else
                            <div class="rounded-circle bg-white d-flex align-items-center justify-content-center w-100 h-100" style="border: 4px solid white;">
                                <i class="fas fa-user-tie fa-4x text-muted"></i>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="fw-bold mb-1" style="color: var(--primary-color);">{{ $miembro->nombre }} {{ $miembro->apellidos }}</h5>
                    
                    @if($miembro->tipo === 'decano_historico')
                        <div class="text-uppercase small fw-bold mb-2" style="color: #b8860b; letter-spacing: 1px;">
                            <i class="fas fa-medal me-1"></i> EX-DECANO
                        </div>
                    @elseif($miembro->cargo)
                        <div class="badge bg-light text-dark border mb-2 px-3 py-2 fw-bold" style="font-size: 0.8rem; color: var(--secondary-color) !important;">
                            {{ strtoupper($miembro->cargo) }}
                        </div>
                    @endif

                    @if($miembro->periodo)
                        <p class="small text-muted mb-0"><i class="far fa-calendar-alt me-1"></i> {{ $miembro->tipo === 'decano_historico' ? 'Gestión' : 'Periodo' }}: {{ $miembro->periodo }}</p>
                    @endif
                    
                    @if($miembro->tipo === 'notario')
                        <hr class="my-3 opacity-25">
                        <div class="text-start small">
                            @if($miembro->notaria)
                                <p class="mb-1"><i class="fas fa-stamp me-2 opacity-50 text-primary"></i><strong>Notaría:</strong> {{ $miembro->notaria }}</p>
                            @endif
                            @if($miembro->direccion)
                                <p class="mb-1 d-flex align-items-start"><i class="fas fa-map-marker-alt me-2 mt-1 opacity-50 text-danger"></i> <span>{{ $miembro->direccion }}</span></p>
                            @endif
                            @if($miembro->distrito)
                                <p class="mb-1 text-muted ms-4">{{ $miembro->distrito }}</p>
                            @endif
                            @if($miembro->telefono)
                                <p class="mb-0 text-success fw-bold ms-4"><i class="fas fa-phone-alt me-2 opacity-50"></i>{{ $miembro->telefono }}</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>

<style>
    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }
    .text-uppercase { letter-spacing: 0.5px; }
</style>
@endif

