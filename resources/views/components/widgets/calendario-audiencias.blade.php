<div class="card">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title"><i class="fas fa-calendar-alt"></i> Calendario de Audiencias</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <div id="calendar-widget">
            @php
                $citas = \App\Models\Cita::proximas()->take(5)->get();
            @endphp
            
            @if(isset($citas) && is_object($citas) && $citas->count() > 0)
                <ul class="list-group list-group-flush">
                    @foreach($citas as $cita)
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge" style="background-color: {{ $cita->color }}">
                                    {{ ucfirst($cita->tipo) }}
                                </span>
                                <strong>{{ $cita->titulo }}</strong>
                                <br>
                                <small class="text-muted">
                                    <i class="far fa-clock"></i> {{ $cita->fecha_inicio->format('d/m/Y H:i') }}
                                </small>
                                <br>
                                <small><i class="fas fa-user"></i> {{ $cita->cliente_nombre }}</small>
                            </div>
                            <span class="badge badge-{{ $cita->estado == 'confirmada' ? 'success' : ($cita->estado == 'pendiente' ? 'warning' : 'secondary') }}">
                                {{ ucfirst($cita->estado) }}
                            </span>
                        </div>
                    </li>
                    @endforeach
                </ul>
            @else
                <div class="text-center p-4 text-muted">
                    <i class="fas fa-calendar-times fa-3x mb-3"></i>
                    <p>No hay citas programadas</p>
                </div>
            @endif
        </div>
    </div>
    <div class="card-footer text-center">
        <a href="#" class="btn btn-sm btn-primary">Ver Calendario Completo</a>
    </div>
</div>

