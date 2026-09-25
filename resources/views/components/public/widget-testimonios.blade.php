{{-- Widget de Testimonios para el sitio público --}}
@php
    // Obtener testimonios destacados de la BD
    $testimonios = \App\Models\Testimonio::destacados()
        ->orderBy('orden')
        ->take(6)
        ->get();
    
    // Si no hay testimonios, obtener los últimos activos
    if ($testimonios->isEmpty()) {
        $testimonios = \App\Models\Testimonio::activos()
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
    }
@endphp

@if($testimonios->isNotEmpty())
<section class="testimonios-section py-5 bg-light">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="section-title" style="color: {{ $tema->color_primario ?? '#007bff' }}">
                💬 Testimonios
            </h2>
            <p class="section-subtitle text-muted">
                Lo que nuestros clientes dicen sobre nosotros
            </p>
        </div>
        
        <div class="row">
            @foreach($testimonios as $testimonio)
            <div class="col-md-4 mb-4">
                <div class="card testimonio-card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="testimonio-header mb-3 text-center">
                            @if($testimonio->foto_url_final)
                                <img src="{{ $testimonio->foto_url_final }}" 
                                     class="rounded-circle mb-2" 
                                     style="width: 80px; height: 80px; object-fit: cover;" 
                                     alt="{{ $testimonio->nombre }}">
                            @else
                                <div class="avatar-placeholder rounded-circle d-inline-flex align-items-center justify-content-center mb-2" 
                                     style="width: 80px; height: 80px; background-color: {{ $testimonio->color_avatar }}; color: white; font-size: 1.8rem; font-weight: bold;">
                                    {{ $testimonio->iniciales }}
                                </div>
                            @endif
                            
                            <h5 class="mb-0">{{ $testimonio->nombre }}</h5>
                            <p class="text-muted small mb-1">{{ $testimonio->cargo }}</p>
                            @if($testimonio->empresa)
                            <p class="text-muted small mb-2"><em>{{ $testimonio->empresa }}</em></p>
                            @endif
                            
                            <div class="rating mb-3">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $testimonio->calificacion ? 'text-warning' : 'text-muted' }}"></i>
                                @endfor
                            </div>
                        </div>
                        
                        <div class="testimonio-content text-center">
                            <i class="fas fa-quote-left text-muted mb-2"></i>
                            <p class="card-text">{{ $testimonio->testimonio }}</p>
                            <i class="fas fa-quote-right text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-4">
            <p class="text-muted">
                <i class="fas fa-heart" style="color: {{ $tema->color_primario ?? '#007bff' }}"></i> 
                Más de {{ \App\Models\Testimonio::activos()->count() * 50 }} clientes satisfechos
            </p>
        </div>
    </div>
</section>
@else
<section class="py-5 bg-light">
    <div class="container">
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i>
            No hay testimonios disponibles. <a href="/admin/testimonios">Agregar testimonios</a>
        </div>
    </div>
</section>
@endif

<style>
.testimonio-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: none;
}
.testimonio-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.15) !important;
}
.avatar-placeholder {
    transition: transform 0.3s ease;
}
.testimonio-card:hover .avatar-placeholder {
    transform: scale(1.05);
}
.testimonio-content {
    position: relative;
    font-style: italic;
}
</style>

