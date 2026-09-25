{{-- Widget de Servicios Destacados --}}
<section class="servicios-destacados py-5">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h5 class="text-uppercase text-primary fw-bold letter-spacing-2 mb-2">Soluciones Profesionales</h5>
            <h2 class="display-5 fw-bold mb-4 text-dark">
                Nuestros Servicios
            </h2>
            <div class="title-divider mx-auto mb-5"></div>
        </div>
        
        <div class="row">
            @foreach($serviciosDestacados as $servicio)
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="card servicio-card h-100 border-0 shadow-sm p-3">
                    <div class="card-body text-center">
                        <div class="icon-wrapper mb-4 mx-auto shadow-sm">
                            <i class="fas {{ $servicio->icono ?? 'fa-file-contract' }} fa-2x"></i>
                        </div>
                        
                        <h5 class="card-title fw-bold mb-3">{{ $servicio->nombre }}</h5>
                        <p class="card-text text-muted small mb-4">{{ Str::limit($servicio->descripcion, 100) }}</p>
                        
                        @if($servicio->precio > 0)
                            <div class="precio mb-3">
                                <span class="h5 fw-bold text-primary">
                                    S/ {{ number_format($servicio->precio, 2) }}
                                </span>
                            </div>
                        @endif
                        
                        @if($servicio->duracion)
                            <p class="small text-muted mb-4">
                                <i class="far fa-clock me-1"></i> {{ $servicio->duracion }} días aprox.
                            </p>
                        @endif

                        <a href="{{ route('public.servicios') }}" class="btn-link-custom">
                            Más Información <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-4 pt-2">
            <a href="{{ route('public.servicios') }}" class="btn btn-outline-primary rounded-pill px-5 py-2 fw-bold">
                Ver Todos los Servicios
            </a>
        </div>
    </div>
</section>

<style>
.servicio-card {
    border-radius: 12px;
    background: #fff;
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
}
.servicio-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
}
.icon-wrapper {
    width: 80px;
    height: 80px;
    background: #f8f9fa;
    color: var(--primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}
.servicio-card:hover .icon-wrapper {
    background: var(--primary);
    color: #fff;
    transform: scale(1.1);
}
.title-divider {
    width: 60px;
    height: 3px;
    background: var(--primary);
    border-radius: 3px;
}
.letter-spacing-2 {
    letter-spacing: 2px;
}
.btn-link-custom {
    text-decoration: none;
    font-weight: 600;
    color: var(--primary);
    transition: padding 0.3s ease;
}
.btn-link-custom:hover {
    padding-left: 5px;
    color: var(--secondary);
}
</style>

