@extends('layouts.public')

@section('title', 'Bolsa de Trabajo - Colegio de Notarios de Tacna')
@section('meta_description', 'Únete al equipo del Colegio de Notarios de Tacna. Encuentra oportunidades laborales actuales.')

@section('styles')
<style>
    .jobs-header {
        background-color: var(--primary-color);
        color: white;
        padding: 40px 0;
        border-bottom: 4px solid var(--secondary-color);
    }
    
    .jobs-title {
        font-size: 1.5rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .jobs-subtitle {
        font-size: 0.9rem;
        opacity: 0.8;
    }

    /* Modern Table Styling */
    .jobs-container {
        margin-top: -20px;
    }

    .jobs-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border: 1px solid rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .table-jobs {
        margin-bottom: 0;
    }

    .table-jobs thead th {
        background: #f8f9fa;
        border-bottom: 2px solid #eee;
        color: var(--primary-color);
        font-size: 0.75rem;
        text-transform: uppercase;
        font-weight: 700;
        padding: 15px;
    }

    .table-jobs tbody tr {
        transition: all 0.2s ease;
    }

    .table-jobs tbody tr:hover {
        background-color: rgba(197, 160, 89, 0.03);
    }

    .job-name {
        font-weight: 600;
        color: #333;
        font-size: 0.95rem;
        display: block;
        margin-bottom: 4px;
    }

    .job-meta {
        font-size: 0.75rem;
        color: #777;
    }

    /* Buttons */
    .btn-action {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        font-size: 0.8rem;
        transition: all 0.2s;
        border: 1px solid #ddd;
        background: white;
        color: var(--primary-color);
    }

    .btn-action:hover {
        background: var(--primary-color);
        color: white;
    }

    .btn-apply {
        background-color: var(--secondary-color);
        color: white !important;
        border: none;
        padding: 8px 18px;
        font-size: 0.82rem;
        font-weight: 700;
        border-radius: 6px;
        text-transform: uppercase;
        transition: all 0.2s;
    }

    .btn-apply:hover {
        background-color: var(--primary-color);
        transform: translateY(-2px);
    }

    /* Filter Section */
    .filter-bar {
        background: white;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        margin-bottom: 30px;
        border: 1px solid #f0f0f0;
    }

    .search-input {
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 0.9rem;
    }

    .empty-state {
        padding: 60px 20px;
        text-align: center;
        color: #999;
    }
</style>
@endsection

@section('content')
<section class="jobs-header">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h1 class="jobs-title mb-1">Trabaja con nosotros</h1>
                <p class="jobs-subtitle mb-0 small opacity-75">Únete a la institución líder en seguridad jurídica de la región</p>
            </div>
            <div class="bg-white p-2 rounded-3 shadow-sm d-none d-md-block" style="opacity: 0.2">
                <i class="fas fa-briefcase fa-2x" style="color: var(--primary-color);"></i>
            </div>
        </div>
    </div>
</section>

<div class="container py-4">
    {{-- Filtro Minimalista --}}
    <div class="filter-bar">
        <form method="GET" action="{{ route('public.bolsa-trabajo') }}" class="row g-2 align-items-center">
            <div class="col-md-9">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-transparent border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="buscar" class="form-control border-start-0 search-input" placeholder="Buscar cargo o área..." value="{{ request('buscar') }}">
                </div>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-sm w-100 fw-bold text-white shadow-sm" style="background-color: var(--primary-color);">BUSCAR PLAZAS</button>
            </div>
        </form>
    </div>

    <div class="jobs-container">
        <div class="jobs-card">
            @if($ofertas->count() > 0)
            <div class="table-responsive">
                <table class="table table-jobs align-middle">
                    <thead>
                        <tr>
                            <th style="width: 45%">Posición / Convocatoria</th>
                            <th class="text-center" style="width: 15%">Cierre</th>
                            <th class="text-center" style="width: 15%">Bases</th>
                            <th class="text-center" style="width: 25%">Postular</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ofertas as $oferta)
                        <tr>
                            <td>
                                <a href="{{ route('public.oferta-empleo', $oferta->slug) }}" class="job-name text-decoration-none">
                                    {{ $oferta->titulo }}
                                </a>
                                <div class="job-meta">
                                    <span class="me-3"><i class="fas fa-map-marker-alt me-1"></i> Tacna</span>
                                    <span><i class="fas fa-bookmark me-1"></i> {{ $oferta->modalidad ?? 'Presencial' }}</span>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="small fw-bold" style="color: {{ $oferta->fecha_cierre && $oferta->fecha_cierre < now() ? '#e74a3b' : 'var(--primary-color)' }};">
                                    <i class="far fa-calendar-check me-1"></i> {{ $oferta->fecha_cierre ? $oferta->fecha_cierre->format('d/m/Y') : '--' }}
                                </div>
                                <div class="job-meta small">Fecha Límite</div>
                            </td>
                            <td class="text-center">
                                @if($oferta->pdf_bases)
                                    <a href="{{ route('media.proxy', ['path' => $oferta->pdf_bases]) }}" target="_blank" class="btn-action" title="Bases"><i class="fas fa-file-pdf"></i></a>
                                @else
                                    <span class="text-muted small">--</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn-apply shadow-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalPostulacion"
                                        data-titulo="{{ $oferta->titulo }}">
                                    POSTULAR AHORA
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="empty-state">
                <i class="fas fa-search fa-3x mb-3 opacity-25"></i>
                <h6 class="fw-bold">No hay vacantes vigentes</h6>
                <p class="small text-muted">Intente con otros términos o vuelva más tarde.</p>
            </div>
            @endif
        </div>
        
        @if($ofertas->hasPages())
        <div class="mt-4 d-flex justify-content-center">
            {{ $ofertas->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>

@endsection

@section('modals')
{{-- MODAL DE POSTULACIÓN INTEGRADO --}}
<div class="modal fade" id="modalPostulacion" tabindex="-1" aria-labelledby="modalPostulacionLabel" aria-hidden="true" style="z-index: 9999;">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header text-white px-4" style="background-color: var(--primary-color);">
                <h5 class="modal-title fw-bold" id="modalPostulacionLabel" style="font-size: 1rem;">
                    <i class="fas fa-user-plus me-2"></i>POSTULACIÓN: <span id="modalJobTitle" class="text-uppercase" style="color: var(--secondary-color);"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form id="formPostulacion" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="puesto" id="modalInputPuesto" value="">
                
                <div class="modal-body p-4">
                    <div id="alertPostulacion" class="alert d-none py-2 small"></div>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nombres <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" name="nombres" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Apellidos <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" name="apellidos" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control form-control-sm" name="email" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Teléfono <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control form-control-sm" name="telefono" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold">CV en PDF <span class="text-danger">*</span></label>
                            <input type="file" class="form-control form-control-sm" name="cv" accept=".pdf" required>
                            <div class="form-text mt-1" style="font-size: 0.7rem;">Solo archivos .PDF menores a 5MB.</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Breve Comentario (Opcional)</label>
                            <textarea class="form-control form-control-sm" name="carta_presentacion" rows="3"></textarea>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="acepto_terminos" id="acepto_terminos" required>
                                <label class="form-check-label small text-muted" for="acepto_terminos">
                                    Declaro que la información proporcionada es verídica <span class="text-danger">*</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light px-4 py-3">
                    <button type="button" class="btn btn-sm btn-outline-secondary px-4 fw-bold" data-bs-dismiss="modal">CANCELAR</button>
                    <button type="submit" class="btn btn-sm px-5 fw-bold text-white shadow-sm" id="btnEnviarPostulacion" style="background-color: var(--primary-color);">
                        ENVIAR POSTULACIÓN <i class="fas fa-paper-plane ms-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('modalPostulacion');
    if (modal) {
        modal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const titulo = button.getAttribute('data-titulo');
            modal.querySelector('#modalJobTitle').textContent = titulo;
            modal.querySelector('#modalInputPuesto').value = titulo;
        });
    }

    const form = document.getElementById('formPostulacion');
    const btn = document.getElementById('btnEnviarPostulacion');
    const alertBox = document.getElementById('alertPostulacion');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>ENVIANDO...';
        alertBox.classList.add('d-none');
        
        const formData = new FormData(form);
        
        fetch('{{ route("postulaciones.store") }}', {
            method: 'POST',
            body: formData,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertBox.classList.remove('d-none', 'alert-danger');
                alertBox.classList.add('alert-success');
                alertBox.textContent = '¡Postulación enviada con éxito!';
                form.reset();
                setTimeout(() => bootstrap.Modal.getInstance(modal).hide(), 2000);
            } else {
                alertBox.classList.remove('d-none', 'alert-success');
                alertBox.classList.add('alert-danger');
                alertBox.textContent = data.message || 'Error al enviar.';
            }
        })
        .catch(() => {
            alertBox.classList.remove('d-none');
            alertBox.classList.add('alert-danger');
            alertBox.textContent = 'Error de conexión.';
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = 'ENVIAR POSTULACIÓN <i class="fas fa-paper-plane ms-2"></i>';
        });
    });
});
</script>
@endsection
