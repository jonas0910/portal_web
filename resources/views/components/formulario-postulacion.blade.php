{{--
    ════════════════════════════════════════════════════════════
    COMPONENTE: FORMULARIO DE POSTULACIÓN
    ════════════════════════════════════════════════════════════
    
    Descripción:
    Formulario modal completo para postular a ofertas de empleo.
    Incluye validación frontend/backend, upload de CV, y envío AJAX.
    
    Variables:
    - $puesto (opcional) - Nombre del puesto al que postula
    - $modalId (opcional) - ID del modal (default: 'modalPostular')
    - $colorHeader (opcional) - Color del header del modal
    
    Uso Básico:
    @include('components.formulario-postulacion')
    
    Uso Personalizado:
    @include('components.formulario-postulacion', [
        'puesto' => 'Asistente Legal',
        'modalId' => 'modalPostularAsistente',
        'colorHeader' => '#007bff'
    ])
    
    Para abrir el modal:
    <button data-toggle="modal" data-target="#modalPostular" data-puesto="Nombre del Puesto">
        Postular Ahora
    </button>
    
    Características:
    - ✅ Formulario completo con 9 campos
    - ✅ Validación HTML5 y backend
    - ✅ Upload de CV (PDF, máx 5MB)
    - ✅ Envío AJAX con loading states
    - ✅ Mensajes de éxito/error
    - ✅ Auto-limpieza del formulario
    - ✅ Notificación flotante
    - ✅ Protección CSRF
    - ✅ Responsive design
    
    Creado: 2025-10-26
    Actualizado: 2025-10-26
    ════════════════════════════════════════════════════════════
--}}

@php
    $modalId = $modalId ?? 'modalPostular';
    $colorHeader = $colorHeader ?? 'var(--primary-color)';
    $tituloModal = $tituloModal ?? 'Formulario de Postulación';
@endphp

{{-- Modal de Postulación --}}
<div class="modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: {{ $colorHeader }}; color: white;">
                <h5 class="modal-title" id="{{ $modalId }}Label">
                    <i class="fas fa-paper-plane"></i> {{ $tituloModal }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form id="formPostulacion" action="{{ route('postulaciones.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div id="alert-container"></div>
                    <input type="hidden" name="puesto" id="puesto_input" value="{{ $puesto ?? '' }}">
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Postulando para: <strong id="puesto_display">{{ $puesto ?? 'Seleccionar puesto' }}</strong>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombres">Nombres <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nombres" name="nombres" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="apellidos">Apellidos <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telefono">Teléfono <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="ciudad">Ciudad / Ubicación <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="ciudad" name="ciudad" required>
                    </div>

                    <div class="form-group">
                        <label for="experiencia">Años de Experiencia</label>
                        <select class="form-control" id="experiencia" name="experiencia">
                            <option value="Sin experiencia">Sin experiencia</option>
                            <option value="Menos de 1 año">Menos de 1 año</option>
                            <option value="1-2 años">1-2 años</option>
                            <option value="3-5 años">3-5 años</option>
                            <option value="6-10 años">6-10 años</option>
                            <option value="Más de 10 años">Más de 10 años</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="formacion">Formación Académica <span class="text-danger">*</span></label>
                        <select class="form-control" id="formacion" name="formacion" required>
                            <option value="">Seleccionar...</option>
                            <option value="Secundaria">Secundaria Completa</option>
                            <option value="Técnico">Técnico</option>
                            <option value="Bachiller">Bachiller</option>
                            <option value="Titulado">Titulado</option>
                            <option value="Maestría">Maestría</option>
                            <option value="Doctorado">Doctorado</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="cv">Curriculum Vitae (PDF) <span class="text-danger">*</span></label>
                        <input type="file" class="form-control-file" id="cv" name="cv" accept=".pdf" required>
                        <small class="form-text text-muted">Máximo 5MB</small>
                    </div>

                    <div class="form-group">
                        <label for="carta_presentacion">Carta de Presentación (Opcional)</label>
                        <textarea class="form-control" id="carta_presentacion" name="carta_presentacion" rows="4" placeholder="Cuéntanos por qué eres el candidato ideal..."></textarea>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="acepto_terminos" name="acepto_terminos" required>
                            <label class="custom-control-label" for="acepto_terminos">
                                Acepto el tratamiento de mis datos personales según la <a href="/politica-privacidad" target="_blank">Política de Privacidad</a> <span class="text-danger">*</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Enviar Postulación
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Configurar CSRF token para todas las peticiones AJAX
    if (typeof $.ajaxSetup !== 'undefined') {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }

    // Al abrir modal, llenar el puesto
    $('#{{ $modalId }}').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var puesto = button.data('puesto');
        if (puesto) {
            $('#puesto_input').val(puesto);
            $('#puesto_display').text(puesto);
        }
        $('#alert-container').html('');
        
        // Limpiar el formulario al abrir
        $('#formPostulacion')[0].reset();
    });

    // Manejar envío del formulario
    $('#formPostulacion').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        var submitBtn = $(this).find('button[type="submit"]');
        var originalBtnText = submitBtn.html();
        
        // Deshabilitar botón y mostrar loading
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Enviando...');
        $('#alert-container').html('');
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    // Mostrar mensaje de éxito
                    $('#alert-container').html(
                        '<div class="alert alert-success alert-dismissible fade show">' +
                        '<i class="fas fa-check-circle"></i> ' + response.message +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                        '</div>'
                    );
                    
                    // Limpiar formulario
                    $('#formPostulacion')[0].reset();
                    
                    // Cerrar modal después de 2 segundos
                    setTimeout(function() {
                        // Bootstrap 5
                        var modalEl = document.getElementById('{{ $modalId }}');
                        var modal = bootstrap.Modal.getInstance(modalEl);
                        if (modal) {
                            modal.hide();
                        }
                        
                        // Mostrar alerta en la página principal
                        $('body').prepend(
                            '<div class="alert alert-success alert-dismissible fade show" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">' +
                            '<i class="fas fa-check-circle"></i> <strong>¡Postulación enviada!</strong><br>' +
                            'Nos pondremos en contacto contigo pronto.' +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                            '</div>'
                        );
                        
                        // Auto cerrar después de 5 segundos
                        setTimeout(function() {
                            $('.alert').fadeOut();
                        }, 5000);
                    }, 2000);
                }
            },
            error: function(xhr) {
                var errors = '';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        errors += '<li>' + value[0] + '</li>';
                    });
                    $('#alert-container').html(
                        '<div class="alert alert-danger alert-dismissible fade show">' +
                        '<i class="fas fa-exclamation-circle"></i> <strong>Errores en el formulario:</strong>' +
                        '<ul>' + errors + '</ul>' +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                        '</div>'
                    );
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    $('#alert-container').html(
                        '<div class="alert alert-danger alert-dismissible fade show">' +
                        '<i class="fas fa-exclamation-circle"></i> ' + xhr.responseJSON.message +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                        '</div>'
                    );
                } else {
                    $('#alert-container').html(
                        '<div class="alert alert-danger alert-dismissible fade show">' +
                        '<i class="fas fa-exclamation-circle"></i> Error al enviar la postulación. Intenta nuevamente.' +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                        '</div>'
                    );
                }
            },
            complete: function() {
                // Rehabilitar botón
                submitBtn.prop('disabled', false).html(originalBtnText);
            }
        });
    });
});
</script>
@endpush

