@extends('layouts.public')

@section('title', $oferta->titulo . ' - Bolsa de Trabajo')
@section('meta_description', Str::limit(strip_tags($oferta->descripcion), 160))

@section('styles')
<style>
    .oferta-header {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 50px 0;
    }
    
    .oferta-titulo-header {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 15px;
    }
    
    .oferta-meta-header {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        opacity: 0.9;
    }
    
    .oferta-meta-header span {
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .oferta-content {
        padding: 40px 0;
    }
    
    .oferta-section {
        margin-bottom: 35px;
    }
    
    .oferta-section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--primary-color);
    }
    
    .oferta-section-content {
        color: #555;
        line-height: 1.8;
    }
    
    .oferta-section-content ul {
        padding-left: 20px;
    }
    
    .oferta-section-content li {
        margin-bottom: 8px;
    }
    
    .oferta-sidebar {
        position: sticky;
        top: 100px;
    }
    
    .info-card {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 20px;
    }
    
    .info-card h4 {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 20px;
        color: #333;
    }
    
    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 15px;
    }
    
    .info-item i {
        color: var(--primary-color);
        width: 20px;
        text-align: center;
        margin-top: 3px;
    }
    
    .info-item-content {
        flex: 1;
    }
    
    .info-item-label {
        font-size: 0.8rem;
        color: #999;
        margin-bottom: 2px;
    }
    
    .info-item-value {
        font-weight: 500;
        color: #333;
    }
    
    .postular-card {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        border-radius: 12px;
        padding: 25px;
        text-align: center;
    }
    
    .postular-card h4 {
        margin-bottom: 15px;
    }
    
    .postular-card p {
        opacity: 0.9;
        margin-bottom: 20px;
        font-size: 0.9rem;
    }
    
    .btn-postular {
        background: white;
        color: var(--primary-color);
        padding: 12px 30px;
        border-radius: 25px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
    }
    
    .btn-postular:hover {
        transform: scale(1.05);
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
    }
    
    .relacionadas-section {
        background: #f8f9fa;
        padding: 50px 0;
    }
    
    .relacionada-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        height: 100%;
        transition: all 0.3s ease;
    }
    
    .relacionada-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.12);
    }
    
    .relacionada-titulo {
        font-weight: 600;
        margin-bottom: 10px;
    }
    
    .relacionada-titulo a {
        color: #333;
        text-decoration: none;
    }
    
    .relacionada-titulo a:hover {
        color: var(--primary-color);
    }
    
    .breadcrumb-container {
        background: rgba(255,255,255,0.1);
        padding: 10px 0;
    }
    
    .breadcrumb {
        margin: 0;
        background: transparent;
    }
    
    .breadcrumb-item a {
        color: rgba(255,255,255,0.8);
    }
    
    .breadcrumb-item.active {
        color: white;
    }
    
    @media (max-width: 768px) {
        .oferta-titulo-header {
            font-size: 1.5rem;
        }
        
        .oferta-meta-header {
            flex-direction: column;
            gap: 10px;
        }
    }
</style>
@endsection

@section('content')
    {{-- Header --}}
    <section class="oferta-header">
        <div class="container">
            {{-- Breadcrumb --}}
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('public.index') }}"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('public.bolsa-trabajo') }}">Bolsa de Trabajo</a></li>
                    <li class="breadcrumb-item active">{{ Str::limit($oferta->titulo, 40) }}</li>
                </ol>
            </nav>
            
            <h1 class="oferta-titulo-header">{{ $oferta->titulo }}</h1>
            
            <div class="oferta-meta-header">
                @if($oferta->area)
                <span><i class="fas fa-building"></i> {{ $oferta->area }}</span>
                @endif
                @if($oferta->ubicacion)
                <span><i class="fas fa-map-marker-alt"></i> {{ $oferta->ubicacion }}</span>
                @endif
                <span><i class="fas fa-clock"></i> {{ $oferta->jornada_text }}</span>
                <span><i class="fas fa-laptop-house"></i> {{ $oferta->modalidad_text }}</span>
            </div>
        </div>
    </section>

    {{-- Contenido --}}
    <section class="oferta-content">
        <div class="container">
            <div class="row">
                {{-- Contenido Principal --}}
                <div class="col-lg-8">
                    @if($oferta->descripcion)
                    <div class="oferta-section">
                        <h2 class="oferta-section-title"><i class="fas fa-info-circle me-2"></i>Descripción del Puesto</h2>
                        <div class="oferta-section-content">
                            {!! $oferta->descripcion !!}
                        </div>
                    </div>
                    @endif

                    @if($oferta->requisitos && count($oferta->requisitos) > 0)
                    <div class="oferta-section">
                        <h2 class="oferta-section-title"><i class="fas fa-check-circle me-2"></i>Requisitos</h2>
                        <div class="oferta-section-content">
                            <ul>
                                @foreach($oferta->requisitos as $requisito)
                                <li>{{ $requisito }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    @if($oferta->responsabilidades && count($oferta->responsabilidades) > 0)
                    <div class="oferta-section">
                        <h2 class="oferta-section-title"><i class="fas fa-tasks me-2"></i>Responsabilidades</h2>
                        <div class="oferta-section-content">
                            <ul>
                                @foreach($oferta->responsabilidades as $responsabilidad)
                                <li>{{ $responsabilidad }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    @if($oferta->beneficios && count($oferta->beneficios) > 0)
                    <div class="oferta-section">
                        <h2 class="oferta-section-title"><i class="fas fa-gift me-2"></i>Beneficios</h2>
                        <div class="oferta-section-content">
                            <ul>
                                @foreach($oferta->beneficios as $beneficio)
                                <li>{{ $beneficio }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Sidebar --}}
                <div class="col-lg-4">
                    <div class="oferta-sidebar">
                        {{-- Info de la oferta --}}
                        <div class="info-card">
                            <h4><i class="fas fa-briefcase me-2"></i>Información del Puesto</h4>
                            
                            <div class="info-item">
                                <i class="fas fa-money-bill-wave"></i>
                                <div class="info-item-content">
                                    <div class="info-item-label">Salario</div>
                                    <div class="info-item-value">{{ $oferta->salario_rango }}</div>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <i class="fas fa-clock"></i>
                                <div class="info-item-content">
                                    <div class="info-item-label">Jornada</div>
                                    <div class="info-item-value">{{ $oferta->jornada_text }}</div>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <i class="fas fa-laptop-house"></i>
                                <div class="info-item-content">
                                    <div class="info-item-label">Modalidad</div>
                                    <div class="info-item-value">{{ $oferta->modalidad_text }}</div>
                                </div>
                            </div>
                            
                            @if($oferta->vacantes)
                            <div class="info-item">
                                <i class="fas fa-users"></i>
                                <div class="info-item-content">
                                    <div class="info-item-label">Vacantes</div>
                                    <div class="info-item-value">{{ $oferta->vacantes }}</div>
                                </div>
                            </div>
                            @endif
                            
                            @if($oferta->fecha_cierre)
                            <div class="info-item">
                                <i class="fas fa-calendar-times"></i>
                                <div class="info-item-content">
                                    <div class="info-item-label">Fecha Límite</div>
                                    <div class="info-item-value">{{ $oferta->fecha_cierre->format('d/m/Y') }}</div>
                                </div>
                            </div>
                            @endif
                        </div>

                        {{-- Bases del Concurso, Resultados de Evaluación, Ganadores del Concurso --}}
                        <div class="info-card mb-3">
                            <h4><i class="fas fa-file-pdf me-2 text-danger"></i>Documentos del Concurso</h4>
                            
                            <div class="mb-3">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                    <span class="fw-medium"><i class="fas fa-file-alt me-2 text-info"></i>Bases del Concurso</span>
                                    @if($oferta->pdf_bases)
                                    <a href="{{ $oferta->pdf_bases_url }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-download me-1"></i>Descargar
                                    </a>
                                    @else
                                    <span class="badge badge-secondary">No disponible</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                    <span class="fw-medium"><i class="fas fa-clipboard-check me-2 text-warning"></i>Resultados de Evaluación</span>
                                    @if($oferta->pdf_evaluacion)
                                    <a href="{{ $oferta->pdf_evaluacion_url }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-download me-1"></i>Descargar
                                    </a>
                                    @else
                                    <span class="badge badge-secondary">No disponible</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div>
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                    <span class="fw-medium"><i class="fas fa-trophy me-2 text-success"></i>Ganadores del Concurso</span>
                                    @if($oferta->pdf_ganadores)
                                    <a href="{{ $oferta->pdf_ganadores_url }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-download me-1"></i>Descargar
                                    </a>
                                    @else
                                    <span class="badge badge-secondary">No disponible</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Botón Postular --}}
                        <div class="postular-card">
                            <h4><i class="fas fa-paper-plane me-2"></i>¿Te interesa?</h4>
                            <p>Completa el formulario y postula a esta oportunidad</p>
                            
                            <button type="button" class="btn btn-postular" data-bs-toggle="modal" data-bs-target="#modalPostulacion">
                                <i class="fas fa-user-plus me-2"></i>Postular Ahora
                            </button>
                            
                            @if($oferta->contacto_email)
                            <p class="mt-3 mb-0" style="font-size: 0.8rem;">
                                <i class="fas fa-envelope me-1"></i> {{ $oferta->contacto_email }}
                            </p>
                            @endif
                            
                            @if($oferta->contacto_telefono)
                            <p class="mt-2 mb-0" style="font-size: 0.8rem;">
                                <i class="fas fa-phone me-1"></i> {{ $oferta->contacto_telefono }}
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Ofertas Relacionadas --}}
    @if($ofertasRelacionadas->count() > 0)
    <section class="relacionadas-section">
        <div class="container">
            <h2 class="section-title mb-4">
                <i class="fas fa-briefcase text-primary me-2"></i>Ofertas Relacionadas
            </h2>
            <div class="row g-4">
                @foreach($ofertasRelacionadas as $relacionada)
                <div class="col-md-4">
                    <div class="relacionada-card">
                        <h5 class="relacionada-titulo">
                            <a href="{{ route('public.oferta-empleo', $relacionada->slug) }}">{{ $relacionada->titulo }}</a>
                        </h5>
                        <p class="text-muted small mb-2">
                            <i class="fas fa-building me-1"></i> {{ $relacionada->area }}
                            <span class="mx-2">|</span>
                            <i class="fas fa-clock me-1"></i> {{ $relacionada->jornada_text }}
                        </p>
                        <p class="text-primary fw-bold mb-0">{{ $relacionada->salario_rango }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Modal de Postulación --}}
    <div class="modal fade" id="modalPostulacion" tabindex="-1" aria-labelledby="modalPostulacionLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalPostulacionLabel">
                        <i class="fas fa-user-plus me-2"></i>Postular a: {{ $oferta->titulo }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <form id="formPostulacion" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="puesto" value="{{ $oferta->titulo }}">
                    
                    <div class="modal-body">
                        <div id="alertPostulacion" class="alert d-none"></div>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nombres <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nombres" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Apellidos <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="apellidos" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Teléfono <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" name="telefono" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Ciudad <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="ciudad" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Años de Experiencia</label>
                                <select class="form-select" name="experiencia">
                                    <option value="">Seleccionar</option>
                                    <option value="Sin experiencia">Sin experiencia</option>
                                    <option value="Menos de 1 año">Menos de 1 año</option>
                                    <option value="1-2 años">1-2 años</option>
                                    <option value="3-5 años">3-5 años</option>
                                    <option value="Más de 5 años">Más de 5 años</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Formación Académica <span class="text-danger">*</span></label>
                                <select class="form-select" name="formacion" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Secundaria completa">Secundaria completa</option>
                                    <option value="Técnico en curso">Técnico en curso</option>
                                    <option value="Técnico completo">Técnico completo</option>
                                    <option value="Universitario en curso">Universitario en curso</option>
                                    <option value="Universitario completo">Universitario completo</option>
                                    <option value="Maestría">Maestría</option>
                                    <option value="Doctorado">Doctorado</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">CV (PDF) <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" name="cv" accept=".pdf" required>
                                <small class="text-muted">Máximo 5MB, solo PDF</small>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Carta de Presentación (opcional)</label>
                                <textarea class="form-control" name="carta_presentacion" rows="3" placeholder="Cuéntanos por qué te interesa este puesto..."></textarea>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="acepto_terminos" id="acepto_terminos" required>
                                    <label class="form-check-label" for="acepto_terminos">
                                        Acepto que mis datos sean utilizados para el proceso de selección <span class="text-danger">*</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="btnEnviarPostulacion">
                            <i class="fas fa-paper-plane me-2"></i>Enviar Postulación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('formPostulacion');
        const btn = document.getElementById('btnEnviarPostulacion');
        const alert = document.getElementById('alertPostulacion');
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Deshabilitar botón
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Enviando...';
            alert.classList.add('d-none');
            
            const formData = new FormData(form);
            
            fetch('{{ route("postulaciones.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert.classList.remove('d-none', 'alert-danger');
                    alert.classList.add('alert-success');
                    alert.innerHTML = '<i class="fas fa-check-circle me-2"></i>' + data.message;
                    form.reset();
                    
                    // Cerrar modal después de 3 segundos
                    setTimeout(function() {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('modalPostulacion'));
                        modal.hide();
                    }, 3000);
                } else {
                    let errorMsg = data.message || 'Error al enviar la postulación';
                    if (data.errors) {
                        errorMsg = '<ul class="mb-0">';
                        for (let field in data.errors) {
                            data.errors[field].forEach(function(err) {
                                errorMsg += '<li>' + err + '</li>';
                            });
                        }
                        errorMsg += '</ul>';
                    }
                    alert.classList.remove('d-none', 'alert-success');
                    alert.classList.add('alert-danger');
                    alert.innerHTML = errorMsg;
                }
            })
            .catch(error => {
                alert.classList.remove('d-none', 'alert-success');
                alert.classList.add('alert-danger');
                alert.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Error de conexión. Intente nuevamente.';
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Enviar Postulación';
            });
        });
    });
    </script>
@endsection
