{{-- Partial para cards de Junta Directiva --}}
<h2 class="text-primary text-center mb-5">
    <i class="fas fa-users me-2"></i>Junta Directiva Institucional
</h2>

<div class="row d-flex justify-content-center">
    @foreach($regidores as $regidor)
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card card-regidor h-100 shadow-sm border-0" style="border-radius: 12px; border-bottom: 4px solid var(--primary-color);">
            <div class="card-body text-center p-4">
                <div class="avatar-regidor bg-{{ $regidor['avatar'] }} text-white d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 80px; height: 80px; font-size: 2rem;">
                    <i class="fas fa-user-tie"></i>
                </div>
                <h5 class="card-title fw-bold mt-3">{{ $regidor['nombre'] }}</h5>
                <p class="text-primary fw-bold mb-2">{{ $regidor['cargo'] }}</p>
                <span class="badge rounded-pill bg-light text-muted border px-3 py-2">
                    Periodo 2025 - 2027
                </span>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row mt-5">
    <div class="col-12">
        <div class="card bg-white shadow-sm border-0" style="border-radius: 15px;">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4"><i class="fas fa-gavel me-2 text-primary"></i>Funciones de la Junta Directiva</h5>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Representar a los notarios de la región Tacna.</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Velar por el cumplimiento del Código de Ética del Notariado Perunao.</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Organizar actividades académicas y de capacitación constante.</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Administrar los recursos institucionales con transparencia.</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Promover la seguridad jurídica y la fe pública.</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Coordinar con la Junta de Decanos de los Colegios de Notarios del Perú.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
