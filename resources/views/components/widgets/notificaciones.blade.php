<div class="card">
    <div class="card-header bg-danger text-white">
        <h3 class="card-title"><i class="fas fa-bell"></i> Notificaciones</h3>
        <div class="card-tools">
            <span class="badge badge-light">{{ $notificacionesCount ?? 0 }}</span>
        </div>
    </div>
    <div class="card-body p-0" style="max-height: 300px; overflow-y: auto;">
        @php
            $notificaciones = \App\Models\Notificacion::where('user_id', auth()->id())->noLeidas()->recientes()->get();
        @endphp
        
        @if(isset($notificaciones) && is_object($notificaciones) && $notificaciones->count() > 0)
            <ul class="list-group list-group-flush">
                @foreach($notificaciones as $notif)
                <li class="list-group-item">
                    <div class="d-flex">
                        <div class="mr-3">
                            <i class="fas {{ $notif->icono ?? 'fa-info-circle' }} text-{{ $notif->tipo == 'warning' ? 'warning' : ($notif->tipo == 'danger' ? 'danger' : 'info') }}"></i>
                        </div>
                        <div class="flex-grow-1">
                            <strong>{{ $notif->titulo }}</strong>
                            <p class="mb-1 small">{{ $notif->mensaje }}</p>
                            <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        @else
            <div class="text-center p-4 text-muted">
                <i class="fas fa-check-circle fa-3x mb-3 text-success"></i>
                <p>No hay notificaciones nuevas</p>
            </div>
        @endif
    </div>
</div>

