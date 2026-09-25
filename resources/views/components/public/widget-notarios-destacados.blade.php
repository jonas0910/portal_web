{{-- Widget de Funcionarios Destacados para el sitio público --}}
<section class="funcionarios-destacados py-5 bg-light">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="section-title" style="color: {{ $tema->color_primario ?? '#007bff' }}">
                Nuestros Funcionarios
            </h2>
            <p class="section-subtitle text-muted">
                Equipo de servidores públicos al servicio de la comunidad
            </p>
        </div>
        
        <div class="row">
            @foreach($notariosDestacados as $notario)
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="card notario-card h-100 shadow-sm">
                    <div class="card-body text-center">
                        @php
                            // Generar avatar con iniciales o usar foto si existe
                            $iniciales = strtoupper(substr($notario->nombre, 0, 1) . substr($notario->apellidos, 0, 1));
                            $colores = ['#3b82f6', '#8b5cf6', '#ec4899', '#f59e0b', '#10b981', '#06b6d4'];
                            $colorAvatar = $colores[$notario->id % count($colores)];
                        @endphp
                        
                        @if($notario->foto && file_exists(public_path('storage/' . $notario->foto)))
                            <img src="{{ asset('storage/' . $notario->foto) }}" 
                                 class="rounded-circle mb-3" 
                                 style="width: 120px; height: 120px; object-fit: cover; border: 3px solid {{ $tema->color_primario ?? '#007bff' }};" 
                                 alt="{{ $notario->nombre }}">
                        @else
                            {{-- Avatar con iniciales estilo moderno --}}
                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3 notario-avatar" 
                                 style="width: 120px; height: 120px; background: linear-gradient(135deg, {{ $colorAvatar }} 0%, {{ $tema->color_primario ?? '#007bff' }} 100%); border: 3px solid white; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                                <span style="color: white; font-size: 2.5rem; font-weight: bold;">{{ $iniciales }}</span>
                            </div>
                        @endif
                        
                        <h5 class="card-title mb-1">{{ $notario->nombre }} {{ $notario->apellidos }}</h5>
                        <p class="text-muted small mb-2">
                            <i class="fas fa-certificate"></i> {{ $notario->numero_colegiatura }}
                        </p>
                        
                        @if($notario->especialidad)
                            <p class="badge badge-primary mb-3">{{ $notario->especialidad }}</p>
                        @endif
                        
                        <div class="notario-info">
                            @if($notario->telefono)
                                <p class="small mb-1"><i class="fas fa-phone"></i> {{ $notario->telefono }}</p>
                            @endif
                            @if($notario->email)
                                <p class="small mb-1"><i class="fas fa-envelope"></i> {{ $notario->email }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-4">
            <a href="/notarios" class="btn btn-lg" style="background-color: {{ $tema->color_primario ?? '#007bff' }}; color: white;">
                Ver Todos los Notarios <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>

<style>
.notario-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.notario-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
}
</style>

