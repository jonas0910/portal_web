{{-- Widget Facebook Feed --}}
@php
    $nombreSitio = \App\Models\ConfiguracionSitio::obtener('nombre_sitio', 'Municipalidad');
    $facebookPageUrl = \App\Models\ConfiguracionSitio::obtener('facebook_page_url', 'https://www.facebook.com/facebook');
    $altura = $config['altura'] ?? 500;
    $mostrarTimeline = $config['mostrar_timeline'] ?? true;
    $mostrarEventos = $config['mostrar_eventos'] ?? false;
    $mostrarMensajes = $config['mostrar_mensajes'] ?? false;
    $ancho = $config['ancho'] ?? 340;
@endphp

<div class="facebook-widget-section">
    <div class="text-center mb-4">
        <h2 class="section-title">
            <i class="fab fa-facebook text-primary"></i> 
            Síguenos en Facebook
        </h2>
        <p class="text-muted">Mantente informado con nuestras últimas publicaciones</p>
    </div>
    
    <div class="row justify-content-center">
        <div class="col-lg-{{ $config['columnas'] ?? '8' }} col-md-10">
            <div class="facebook-embed-container">
                {{-- Facebook Page Plugin --}}
                <div id="fb-root"></div>
                <script async defer crossorigin="anonymous" 
                        src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v18.0" 
                        nonce="random123"></script>
                
                <div class="fb-page card shadow-sm" 
                     data-href="{{ $facebookPageUrl }}" 
                     data-tabs="{{ $mostrarTimeline ? 'timeline' : '' }}{{ $mostrarEventos ? ',events' : '' }}{{ $mostrarMensajes ? ',messages' : '' }}" 
                     data-width="{{ $ancho }}" 
                     data-height="{{ $altura }}" 
                     data-small-header="false" 
                     data-adapt-container-width="true" 
                     data-hide-cover="false" 
                     data-show-facepile="true">
                    <blockquote cite="{{ $facebookPageUrl }}" class="fb-xfbml-parse-ignore">
                        <a href="{{ $facebookPageUrl }}" target="_blank">
                            Cargando Facebook...
                        </a>
                    </blockquote>
                </div>
            </div>
            
            <div class="text-center mt-3">
                <a href="{{ $facebookPageUrl }}" target="_blank" class="btn btn-primary">
                    <i class="fab fa-facebook-f me-2"></i>
                    Visitar nuestra página
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .facebook-widget-section {
        padding: 60px 0;
    }
    
    .facebook-embed-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: {{ $altura }}px;
    }
    
    .fb-page {
        background: white;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        width: 100%;
        max-width: {{ $ancho }}px;
        margin: 0 auto;
    }
    
    .section-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }
    
    .section-title i {
        font-size: 2.5rem;
        vertical-align: middle;
    }
    
    @media (max-width: 768px) {
        .facebook-embed-container {
            min-height: 400px;
        }
        
        .section-title {
            font-size: 1.5rem;
        }
    }
</style>



