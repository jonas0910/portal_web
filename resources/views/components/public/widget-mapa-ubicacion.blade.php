{{-- Widget de Mapa de Ubicación para el sitio público --}}
<section class="mapa-ubicacion-section py-5">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="section-title" style="color: {{ $tema->color_primario ?? '#007bff' }}">
                🗺️ Nuestra Ubicación
            </h2>
            <p class="section-subtitle text-muted">
                Encuéntranos en nuestras oficinas
            </p>
        </div>
        
        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body p-0">
                        {{-- Mapa de Google Maps (ejemplo) --}}
                        @php
                            // Coordenadas de ejemplo (Lima, Perú - Centro)
                            $direccion = \App\Models\ConfiguracionSitio::obtener('direccion_contacto', 'Lima, Perú');
                            // Encode para URL
                            $direccionEncoded = urlencode($direccion);
                        @endphp
                        
                        <div class="map-container" style="height: 400px; position: relative;">
                            <iframe 
                                width="100%" 
                                height="400" 
                                frameborder="0" 
                                style="border:0" 
                                src="https://www.google.com/maps/embed/v1/place?key=YOUR_GOOGLE_MAPS_API_KEY&q={{ $direccionEncoded }}&zoom=15"
                                allowfullscreen>
                            </iframe>
                            
                            {{-- Fallback sin API key --}}
                            <div class="map-placeholder d-flex align-items-center justify-content-center" 
                                 style="height: 400px; background: linear-gradient(135deg, {{ $tema->color_primario ?? '#007bff' }} 0%, {{ $tema->color_secundario ?? '#6c757d' }} 100%);">
                                <div class="text-center text-white p-4">
                                    <i class="fas fa-map-marked-alt fa-4x mb-3"></i>
                                    <h4>{{ $direccion }}</h4>
                                    <p class="mb-3">Para ver el mapa interactivo, configura tu Google Maps API Key</p>
                                    <a href="https://www.google.com/maps/search/?api=1&query={{ $direccionEncoded }}" 
                                       target="_blank" 
                                       class="btn btn-light">
                                        <i class="fas fa-external-link-alt"></i> Abrir en Google Maps
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h4 class="mb-4" style="color: {{ $tema->color_primario ?? '#007bff' }}">
                            <i class="fas fa-info-circle"></i> Información de Contacto
                        </h4>
                        
                        <div class="contact-info">
                            <div class="info-item mb-3">
                                <div class="icon-box d-inline-flex align-items-center justify-content-center rounded-circle mb-2" 
                                     style="width: 40px; height: 40px; background-color: {{ $tema->color_primario ?? '#007bff' }}10;">
                                    <i class="fas fa-map-marker-alt" style="color: {{ $tema->color_primario ?? '#007bff' }}"></i>
                                </div>
                                <h6 class="mb-1">Dirección</h6>
                                <p class="text-muted mb-0">
                                    {{ \App\Models\ConfiguracionSitio::obtener('direccion_contacto', 'Av. Principal 123, Lima, Perú') }}
                                </p>
                            </div>
                            
                            <div class="info-item mb-3">
                                <div class="icon-box d-inline-flex align-items-center justify-content-center rounded-circle mb-2" 
                                     style="width: 40px; height: 40px; background-color: {{ $tema->color_primario ?? '#007bff' }}10;">
                                    <i class="fas fa-phone" style="color: {{ $tema->color_primario ?? '#007bff' }}"></i>
                                </div>
                                <h6 class="mb-1">Teléfono</h6>
                                <p class="text-muted mb-0">
                                    {{ \App\Models\ConfiguracionSitio::obtener('telefono_contacto', '+51 1 234 5678') }}
                                </p>
                            </div>
                            
                            <div class="info-item mb-3">
                                <div class="icon-box d-inline-flex align-items-center justify-content-center rounded-circle mb-2" 
                                     style="width: 40px; height: 40px; background-color: {{ $tema->color_primario ?? '#007bff' }}10;">
                                    <i class="fas fa-envelope" style="color: {{ $tema->color_primario ?? '#007bff' }}"></i>
                                </div>
                                <h6 class="mb-1">Email</h6>
                                <p class="text-muted mb-0">
                                    {{ \App\Models\ConfiguracionSitio::obtener('email_contacto', 'contacto@notarios.org.pe') }}
                                </p>
                            </div>
                            
                            <div class="info-item mb-3">
                                <div class="icon-box d-inline-flex align-items-center justify-content-center rounded-circle mb-2" 
                                     style="width: 40px; height: 40px; background-color: {{ $tema->color_primario ?? '#007bff' }}10;">
                                    <i class="fas fa-clock" style="color: {{ $tema->color_primario ?? '#007bff' }}"></i>
                                </div>
                                <h6 class="mb-1">Horario de Atención</h6>
                                <p class="text-muted mb-0">
                                    Lunes a Viernes: 9:00 AM - 6:00 PM<br>
                                    Sábados: 9:00 AM - 1:00 PM
                                </p>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <a href="{{ route('public.contacto') }}" 
                               class="btn btn-block" 
                               style="background-color: {{ $tema->color_primario ?? '#007bff' }}; color: white;">
                                <i class="fas fa-paper-plane"></i> Enviar Mensaje
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.map-container {
    overflow: hidden;
    border-radius: 8px;
}
.map-placeholder {
    border-radius: 8px;
}
.info-item {
    padding: 10px;
    border-left: 3px solid {{ $tema->color_primario ?? '#007bff' }};
    background: #f8f9fa;
    border-radius: 4px;
}
.icon-box {
    transition: transform 0.3s ease;
}
.info-item:hover .icon-box {
    transform: scale(1.1);
}
</style>

<script>
// Ocultar el iframe de Google Maps si no hay API key válida
document.addEventListener('DOMContentLoaded', function() {
    const iframes = document.querySelectorAll('.map-container iframe');
    iframes.forEach(function(iframe) {
        iframe.addEventListener('error', function() {
            // Si el iframe falla, mostrar el placeholder
            iframe.style.display = 'none';
            iframe.nextElementSibling.style.display = 'flex';
        });
        
        // Ocultar placeholder por defecto (se mostrará si el iframe falla)
        if (iframe.nextElementSibling) {
            iframe.nextElementSibling.style.display = 'none';
        }
    });
});
</script>

