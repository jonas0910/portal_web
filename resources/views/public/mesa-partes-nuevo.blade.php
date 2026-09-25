@extends('layouts.public')

@section('title', 'Registro de Nuevo Trámite - Mesa de Partes')
@section('meta_description', 'Registre un nuevo documento o solicitud para ser procesado por la municipalidad')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('public.mesa-partes') }}">Mesa de Partes</a></li>
            <li class="breadcrumb-item active">Registro de Nuevo Trámite</li>
        </ol>
    </nav>

    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('public.mesa-partes') }}" class="btn btn-outline-secondary me-3">
            <i class="fas fa-arrow-left me-1"></i>Volver
        </a>
        <h2 class="mb-0"><i class="fas fa-plus text-primary me-2"></i>Registro de Nuevo Trámite</h2>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div id="registro-exito" class="alert alert-success d-none" role="alert"></div>
            <div id="registro-error" class="alert alert-danger d-none" role="alert"></div>
            <form id="form-registro-tramite" enctype="multipart/form-data">
                @csrf

                {{-- 1. Datos del Solicitante --}}
                <h5 class="border-bottom pb-2 mb-3"><strong>1 Datos del Solicitante</strong></h5>
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label class="form-label">Tipo de Documento <span class="text-danger">*</span></label>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo_documento" id="td_dni" value="DNI" checked>
                                <label class="form-check-label" for="td_dni">DNI</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo_documento" id="td_ce" value="CE">
                                <label class="form-check-label" for="td_ce">Carnet Extranjería</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo_documento" id="td_ruc" value="RUC">
                                <label class="form-check-label" for="td_ruc">RUC</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo_documento" id="td_pasaporte" value="PASAPORTE">
                                <label class="form-check-label" for="td_pasaporte">Pasaporte</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Número de Documento <span class="text-danger">*</span></label>
                        <input type="text" name="numero_documento" class="form-control" maxlength="30" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nombres <span class="text-danger">*</span></label>
                        <input type="text" name="nombres" class="form-control" maxlength="200" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Apellidos</label>
                        <input type="text" name="apellidos" class="form-control" maxlength="200">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Razón Social (si aplica)</label>
                        <input type="text" name="razon_social" class="form-control" maxlength="200">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">RUC</label>
                        <input type="text" name="ruc" class="form-control" maxlength="15">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" required>
                        <small class="text-muted">Recibirá notificaciones en este correo</small>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" maxlength="30">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Celular</label>
                        <input type="text" name="celular" class="form-control" maxlength="30">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Dirección</label>
                        <input type="text" name="direccion" class="form-control" maxlength="500">
                    </div>
                    <input type="hidden" name="folios" value="1">
                </div>

                {{-- 2. Documento que Presenta --}}
                <h5 class="border-bottom pb-2 mb-3"><strong>2 Documento que Presenta</strong></h5>
                <p class="text-muted small mb-3">Indique el tipo y número del documento que presenta (Solicitud, Carta, FUT, etc.)</p>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Tipo de Documento <span class="text-danger">*</span></label>
                        <select name="tipo_documento_presenta" class="form-select" required>
                            <option value="">Seleccione...</option>
                            <option value="Solicitud">Solicitud</option>
                            <option value="Carta">Carta</option>
                            <option value="Formulario Único de Trámite (FUT)">Formulario Único de Trámite (FUT)</option>
                            <option value="Oficio">Oficio</option>
                            <option value="Memorial">Memorial</option>
                            <option value="Recurso">Recurso</option>
                            <option value="Queja">Queja</option>
                            <option value="Denuncia">Denuncia</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Número del Documento</label>
                        <input type="text" name="numero_documento_externo" class="form-control" maxlength="80">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Fecha del Documento</label>
                        <input type="date" name="fecha_documento_externo" class="form-control">
                    </div>
                </div>

                {{-- 3. Detalle del Trámite --}}
                <h5 class="border-bottom pb-2 mb-3"><strong>3 Detalle del Trámite</strong></h5>
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label class="form-label">Asunto <span class="text-danger">*</span></label>
                        <input type="text" name="asunto" class="form-control" maxlength="500" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Descripción adicional</label>
                        <textarea name="descripcion" class="form-control" rows="3" maxlength="2000"></textarea>
                    </div>
                </div>

                {{-- 4. Documentos Adjuntos --}}
                <h5 class="border-bottom pb-2 mb-3"><strong>4 Documentos Adjuntos</strong></h5>
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label class="form-label">Adjuntar documentos</label>
                        <input type="file" name="archivos[]" class="form-control" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        <small class="text-muted">Puede seleccionar múltiples archivos. Formatos: PDF, Word, JPG, PNG. Máximo 5MB cada uno.</small>
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="acepto_terminos" id="acepto_terminos" required>
                            <label class="form-check-label" for="acepto_terminos">Declaro que la información proporcionada es verídica y acepto los términos y condiciones</label>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-outline-secondary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#modalTerminos">
                    <i class="fas fa-file-contract me-1"></i>Ver Términos y Condiciones
                </button>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary btn-lg" id="btn-registro">
                        <i class="fas fa-paper-plane me-2"></i>Registrar Trámite
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Términos y Condiciones --}}
    <div class="modal fade" id="modalTerminos" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Términos y Condiciones</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Al utilizar el sistema de trámite documentario virtual, usted acepta:</p>
                    <ul>
                        <li>Proporcionar información veraz y actualizada.</li>
                        <li>Que los documentos adjuntos son auténticos.</li>
                        <li>Recibir notificaciones por correo electrónico.</li>
                        <li>Que la municipalidad procese sus datos personales para el trámite solicitado.</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Entendido</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function() {
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

    document.getElementById('form-registro-tramite')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn = document.getElementById('btn-registro');
        const exito = document.getElementById('registro-exito');
        const error = document.getElementById('registro-error');
        exito.classList.add('d-none');
        error.classList.add('d-none');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Enviando...';

        const formData = new FormData(this);

        try {
            const r = await fetch('{{ route("public.mesa-partes.registrar") }}', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            });
            const json = await r.json().catch(() => ({}));
            if (json.success) {
                exito.innerHTML = '<i class="fas fa-check-circle me-2"></i><strong>Trámite registrado correctamente.</strong> N° Expediente: <code>' + (json.data?.numero_expediente || '') + '</code>. Código de verificación: <code>' + (json.data?.codigo_verificacion || '') + '</code>. Guarde estos datos para consultar el estado.';
                exito.classList.remove('d-none');
                this.reset();
            } else {
                let msg = json.message || 'Error al registrar';
                if (json.errors && typeof json.errors === 'object') {
                    msg = Object.values(json.errors).flat().join(' ');
                }
                error.textContent = msg;
                error.classList.remove('d-none');
            }
        } catch (err) {
            error.textContent = 'Error de conexión. Intente más tarde.';
            error.classList.remove('d-none');
        }
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Registrar Trámite';
    });
})();
</script>
@endpush
@endsection
