<div class="card">
    <div class="card-header bg-success text-white">
        <h3 class="card-title"><i class="fas fa-calendar-day"></i> Citas de Hoy</h3>
    </div>
    <div class="card-body p-0">
        @php
            $citasHoy = \App\Models\Cita::hoy()->orderBy('fecha_inicio')->get();
        @endphp
        
        @if(isset($citasHoy) && is_object($citasHoy) && $citasHoy->count() > 0)
            <div class="timeline timeline-inverse p-3">
                @foreach($citasHoy as $cita)
                <div class="time-label">
                    <span class="bg-success">{{ $cita->fecha_inicio->format('H:i') }}</span>
                </div>
                <div>
                    <i class="fas fa-user bg-primary"></i>
                    <div class="timeline-item">
                        <span class="time"><i class="fas fa-clock"></i> {{ $cita->fecha_inicio->format('H:i') }}</span>
                        <h3 class="timeline-header">{{ $cita->titulo }}</h3>
                        <div class="timeline-body">
                            <strong>Cliente:</strong> {{ $cita->cliente_nombre }}<br>
                            @if($cita->cliente_telefono)
                                <strong>Tel:</strong> {{ $cita->cliente_telefono }}<br>
                            @endif
                            <strong>Tipo:</strong> {{ ucfirst($cita->tipo) }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center p-4 text-muted">
                <i class="fas fa-calendar-check fa-3x mb-3"></i>
                <p>No hay citas programadas para hoy</p>
            </div>
        @endif
    </div>
</div>

