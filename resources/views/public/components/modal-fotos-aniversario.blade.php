{{-- Modal de Galería de Fotos de Aniversario --}}
{{-- SIEMPRE se muestra para garantizar funcionamiento --}}

@php
    // Forzar valores por defecto si no hay configuración
    $titulo = 'Galería de Aniversario';
    $delay = 1500;
    
    try {
        $tituloConfig = \App\Models\ConfiguracionSitio::obtenerValor('modal_aniversario_titulo', 'Galería de Aniversario');
        if ($tituloConfig) $titulo = $tituloConfig;
        
        $delayConfig = \App\Models\ConfiguracionSitio::obtenerValor('modal_aniversario_delay', '1500');
        if ($delayConfig) $delay = intval($delayConfig);
    } catch (\Exception $e) {
        // Si hay error, usar valores por defecto
    }
@endphp

<!-- DEBUG Modal Aniversario: Este comentario confirma que el archivo se está cargando -->

{{-- Modal Principal --}}
<div class="modal fade" id="modalFotosAniversario" tabindex="-1" aria-labelledby="modalFotosAniversarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalFotosAniversarioLabel">
                    <i class="fas fa-birthday-cake"></i> {{ $titulo }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body p-0">
                {{-- Filtros --}}
                <div class="bg-light p-3 border-bottom">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="form-group mb-0">
                                <label for="filtro-anio" class="mb-1"><small><strong>Filtrar por año:</strong></small></label>
                                <select id="filtro-anio" class="form-control form-control-sm">
                                    <option value="">Todos los años</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <small class="text-muted">
                                <span id="contador-fotos">0</span> fotos
                            </small>
                        </div>
                    </div>
                </div>

                {{-- Galería --}}
                <div id="galeria-aniversario" class="p-3" style="max-height: 70vh; overflow-y: auto;">
                    <div id="loading-galeria" class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <p class="mt-3 text-muted">Cargando fotos de aniversario...</p>
                    </div>
                    
                    <div id="contenido-galeria" class="row" style="display: none;">
                    </div>

                    <div id="sin-fotos" class="text-center py-5" style="display: none;">
                        <i class="fas fa-images fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No hay fotos disponibles</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal de imagen ampliada --}}
<div class="modal fade" id="modalImagenAmpliada" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0 position-relative">
                <button type="button" class="btn-close btn-close-white position-absolute" style="top: 10px; right: 25px; z-index: 1050;" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                <img id="imagen-ampliada" src="" alt="" class="img-fluid w-100 rounded">
                <div class="bg-dark bg-opacity-75 text-white p-3 rounded-bottom">
                    <h5 id="titulo-imagen-ampliada" class="mb-1"></h5>
                    <p id="descripcion-imagen-ampliada" class="mb-0 small"></p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Botón flotante SIEMPRE visible --}}
<button type="button" class="btn btn-primary" id="btn-abrir-galeria-aniversario" 
        data-bs-toggle="modal" data-bs-target="#modalFotosAniversario"
        style="position: fixed; bottom: 20px; right: 20px; z-index: 9999; border-radius: 50%; width: 60px; height: 60px; box-shadow: 0 4px 15px rgba(0,0,0,0.4); transition: all 0.3s ease;">
    <i class="fas fa-birthday-cake fa-lg"></i>
</button>

<style>
#btn-abrir-galeria-aniversario:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(0,0,0,0.5) !important;
}

.foto-aniversario-item {
    cursor: pointer;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden;
}

.foto-aniversario-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.2);
}

.foto-aniversario-item img {
    transition: transform 0.3s ease;
}

.foto-aniversario-item:hover img {
    transform: scale(1.05);
}

#galeria-aniversario::-webkit-scrollbar {
    width: 8px;
}

#galeria-aniversario::-webkit-scrollbar-track {
    background: #f1f1f1;
}

#galeria-aniversario::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}
</style>

{{-- Script del Modal --}}
<script>
(function() {
    'use strict';
    
    // Mensaje inmediato para confirmar que el script se ejecuta
    console.log('🎂 Modal Aniversario: Script cargado');
    
    const DELAY_AUTO_ABRIR = {{ $delay }};
    const STORAGE_KEY = 'modal_aniversario_visto';
    let fotosData = [];
    let aniosDisponibles = new Set();
    
    // Verificar si ya se mostró el modal en esta sesión
    function yaFueMostrado() {
        try {
            return sessionStorage.getItem(STORAGE_KEY) === 'true';
        } catch (e) {
            return false;
        }
    }
    
    // Marcar que el modal ya fue mostrado
    function marcarComoMostrado() {
        try {
            sessionStorage.setItem(STORAGE_KEY, 'true');
        } catch (e) {
            console.warn('No se pudo guardar en sessionStorage');
        }
    }
    
    // Función principal que se ejecuta cuando todo está listo
    function inicializarModal() {
        console.log('🎂 Modal Aniversario: Inicializando...');
        
        const modalEl = document.getElementById('modalFotosAniversario');
        
        if (!modalEl) {
            console.error('❌ Modal Aniversario: No se encontró el elemento #modalFotosAniversario');
            return;
        }
        
        console.log('✅ Modal Aniversario: Elemento encontrado');
        
        // Verificar si Bootstrap está disponible
        if (typeof bootstrap === 'undefined') {
            console.error('❌ Modal Aniversario: Bootstrap no está definido');
            return;
        }
        
        if (!bootstrap.Modal) {
            console.error('❌ Modal Aniversario: bootstrap.Modal no está disponible');
            return;
        }
        
        console.log('✅ Modal Aniversario: Bootstrap disponible');
        
        // Solo AUTO-ABRIR si NO se ha mostrado antes en esta sesión
        if (yaFueMostrado()) {
            console.log('ℹ️ Modal Aniversario: Ya fue mostrado en esta sesión, no se abrirá automáticamente');
        } else {
            console.log('⏱️ Modal Aniversario: Primera visita, se abrirá en', DELAY_AUTO_ABRIR, 'ms');
            
            setTimeout(function() {
                try {
                    console.log('🚀 Modal Aniversario: Abriendo modal ahora...');
                    const modal = new bootstrap.Modal(modalEl);
                    modal.show();
                    marcarComoMostrado();
                    console.log('✅ Modal Aniversario: ¡Modal abierto exitosamente!');
                } catch (error) {
                    console.error('❌ Modal Aniversario: Error al abrir:', error);
                }
            }, DELAY_AUTO_ABRIR);
        }
        
        // Event listener para cargar fotos cuando se abre el modal
        modalEl.addEventListener('show.bs.modal', cargarFotos);
        
        // Filtro por año
        const filtroAnio = document.getElementById('filtro-anio');
        if (filtroAnio) {
            filtroAnio.addEventListener('change', function() {
                mostrarFotos(this.value ? parseInt(this.value) : null);
            });
        }
        
        console.log('✅ Modal Aniversario: Inicialización completada');
    }
    
    // Cargar fotos desde la API
    function cargarFotos() {
        console.log('📷 Modal Aniversario: Cargando fotos...');
        
        const loadingEl = document.getElementById('loading-galeria');
        const contenidoEl = document.getElementById('contenido-galeria');
        const sinFotosEl = document.getElementById('sin-fotos');
        
        if (loadingEl) loadingEl.style.display = 'block';
        if (contenidoEl) contenidoEl.style.display = 'none';
        if (sinFotosEl) sinFotosEl.style.display = 'none';
        
        fetch('{{ route("public.fotos-aniversario") }}')
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                console.log('📷 Modal Aniversario: Respuesta API:', data);
                if (data.success && data.fotos) {
                    fotosData = data.fotos;
                    procesarFotos();
                    mostrarFotos();
                } else {
                    mostrarError('No se pudieron cargar las fotos');
                }
            })
            .catch(function(error) {
                console.error('❌ Modal Aniversario: Error API:', error);
                mostrarError('Error de conexión');
            })
            .finally(function() {
                if (loadingEl) loadingEl.style.display = 'none';
            });
    }
    
    // Procesar fotos
    function procesarFotos() {
        aniosDisponibles.clear();
        fotosData.forEach(function(foto) {
            if (foto.anio) aniosDisponibles.add(foto.anio);
        });
        
        const selectEl = document.getElementById('filtro-anio');
        if (selectEl) {
            while (selectEl.options.length > 1) selectEl.remove(1);
            Array.from(aniosDisponibles).sort(function(a, b) { return b - a; }).forEach(function(anio) {
                const option = document.createElement('option');
                option.value = anio;
                option.textContent = anio;
                selectEl.appendChild(option);
            });
        }
    }
    
    // Mostrar fotos
    function mostrarFotos(anioFiltro) {
        const fotosFiltradas = anioFiltro 
            ? fotosData.filter(function(f) { return f.anio === anioFiltro; })
            : fotosData;
        
        const contadorEl = document.getElementById('contador-fotos');
        const contenidoEl = document.getElementById('contenido-galeria');
        const sinFotosEl = document.getElementById('sin-fotos');
        
        if (contadorEl) contadorEl.textContent = fotosFiltradas.length;
        
        if (fotosFiltradas.length === 0) {
            if (contenidoEl) contenidoEl.style.display = 'none';
            if (sinFotosEl) sinFotosEl.style.display = 'block';
            return;
        }
        
        if (contenidoEl) {
            contenidoEl.innerHTML = '';
            fotosFiltradas.forEach(function(foto) {
                const html = '<div class="col-md-4 col-sm-6 mb-4">' +
                    '<div class="card foto-aniversario-item" data-foto-id="' + foto.id + '">' +
                    '<img src="' + foto.thumbnail_url + '" class="card-img-top" alt="' + foto.titulo + '" style="height: 250px; object-fit: cover;">' +
                    '<div class="card-body">' +
                    '<h6 class="card-title mb-2">' + foto.titulo + '</h6>' +
                    '<p class="card-text small text-muted mb-2">' + (foto.descripcion || '') + '</p>' +
                    '</div></div></div>';
                contenidoEl.insertAdjacentHTML('beforeend', html);
            });
            
            contenidoEl.querySelectorAll('.foto-aniversario-item').forEach(function(item) {
                item.addEventListener('click', function() {
                    const foto = fotosData.find(function(f) { return f.id === parseInt(item.dataset.fotoId); });
                    if (foto) ampliarImagen(foto);
                });
            });
            
            contenidoEl.style.display = 'flex';
            contenidoEl.classList.add('flex-wrap');
        }
        
        if (sinFotosEl) sinFotosEl.style.display = 'none';
    }
    
    // Ampliar imagen
    function ampliarImagen(foto) {
        const imgEl = document.getElementById('imagen-ampliada');
        const tituloEl = document.getElementById('titulo-imagen-ampliada');
        const descEl = document.getElementById('descripcion-imagen-ampliada');
        const modalEl = document.getElementById('modalImagenAmpliada');
        
        if (imgEl) { imgEl.src = foto.imagen_url; imgEl.alt = foto.titulo; }
        if (tituloEl) tituloEl.textContent = foto.titulo;
        if (descEl) descEl.textContent = foto.descripcion || '';
        
        if (modalEl && bootstrap.Modal) {
            new bootstrap.Modal(modalEl).show();
        }
    }
    
    // Mostrar error
    function mostrarError(mensaje) {
        const contenidoEl = document.getElementById('contenido-galeria');
        if (contenidoEl) {
            contenidoEl.innerHTML = '<div class="col-12 text-center py-5">' +
                '<i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>' +
                '<p class="text-muted">' + mensaje + '</p></div>';
            contenidoEl.style.display = 'flex';
        }
    }
    
    // Ejecutar cuando el DOM esté listo
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', inicializarModal);
    } else {
        // DOM ya está listo, ejecutar inmediatamente
        inicializarModal();
    }
})();
</script>
