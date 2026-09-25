{{-- Widget de Estadísticas para el sitio público --}}
<section class="estadisticas-section py-5 bg-dark text-white position-relative overflow-hidden">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 100%);"></div>
    <div class="container position-relative">
        <div class="row text-center">
            <div class="col-md-3 col-6 mb-4">
                <div class="estadistica-item p-4">
                    <div class="estadistica-icon mb-3 text-white-50">
                        <i class="fas fa-user-tie fa-3x"></i>
                    </div>
                    <h2 class="estadistica-numero mb-2 fw-bold">{{ $estadisticas['notarios'] ?? 0 }}</h2>
                    <p class="estadistica-texto mb-0 text-white-50 text-uppercase letter-spacing-2 small">Notarios</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="estadistica-item p-4">
                    <div class="estadistica-icon mb-3 text-white-50">
                        <i class="fas fa-briefcase fa-3x"></i>
                    </div>
                    <h2 class="estadistica-numero mb-2 fw-bold">{{ $estadisticas['servicios'] ?? 0 }}</h2>
                    <p class="estadistica-texto mb-0 text-white-50 text-uppercase letter-spacing-2 small">Servicios</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="estadistica-item p-4">
                    <div class="estadistica-icon mb-3 text-white-50">
                        <i class="fas fa-file-contract fa-3x"></i>
                    </div>
                    <h2 class="estadistica-numero mb-2 fw-bold">{{ $estadisticas['documentos'] ?? 0 }}</h2>
                    <p class="estadistica-texto mb-0 text-white-50 text-uppercase letter-spacing-2 small">Documentos</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="estadistica-item p-4">
                    <div class="estadistica-icon mb-3 text-warning">
                        <i class="fas fa-award fa-3x"></i>
                    </div>
                    <h2 class="estadistica-numero mb-2 fw-bold">{{ $estadisticas['anos_experiencia'] ?? 0 }}</h2>
                    <p class="estadistica-texto mb-0 text-white-50 text-uppercase letter-spacing-2 small">Años</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.estadistica-item {
    transition: transform 0.3s ease;
    border-radius: 12px;
}
.estadistica-item:hover {
    transform: translateY(-5px);
    background: rgba(255,255,255,0.05);
}
.estadistica-numero {
    font-size: 3rem;
}
.letter-spacing-2 {
    letter-spacing: 2px;
}
</style>

