{{-- Barra Pre-Footer (Iconos con enlaces) --}}
@php
    $footerBarActiva = (bool) \App\Models\ConfiguracionSitio::obtener('mostrar_footer_bar', true);
    $footerBarItems = \App\Models\AccesoDirecto::paraFooter();
    // Solo activar si no se ha renderizado ya como widget
    $yaRenderizado = isset($GLOBALS['prefooter_rendered']) && $GLOBALS['prefooter_rendered'];
@endphp

@if($footerBarActiva && $footerBarItems->count() > 0 && !$yaRenderizado)
<div class="container py-2">
    <div class="row">
        <div class="col-12">
            <div class="footer-bar-container text-center shadow-sm" style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 12px; padding: 10px 20px;">
                <div class="d-flex flex-wrap justify-content-center gap-md-4 gap-3">
                    @foreach($footerBarItems as $item)
                    <a href="{{ $item->url_final }}" 
                       target="{{ $item->target }}" 
                       class="footer-bar-item text-decoration-none"
                       title="{{ $item->descripcion ?? $item->titulo }}">
                        @if($item->tieneImagen())
                            <img src="{{ $item->imagen_url }}" alt="{{ $item->titulo }}" style="height: {{ $item->imagen_alto ?? 75 }}px; width: auto; max-width: 220px; object-fit: contain;">
                        @elseif($item->icono)
                            <i class="{{ $item->icono }}" style="font-size: {{ $item->imagen_alto ?? 75 }}px; color: {{ $item->color ?? '#333' }};"></i>
                        @endif
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<footer class="footer" style="{{ $footerBarActiva && $footerBarItems->count() > 0 ? 'margin-top: 0;' : '' }}">
<div class="container">
    <div class="row">
        <div class="col-lg-4 mb-4">
            <h5 class="fw-bold text-primary">{{ \App\Models\ConfiguracionSitio::obtener('nombre_sitio', 'Colegio de Notarios') }}</h5>
            <p class="text-muted">{{ \App\Models\ConfiguracionSitio::obtener('descripcion_sitio', 'Portal oficial del Colegio de Notarios') }}</p>
            <div class="social-links mt-3">
                @php $redes = ['facebook', 'twitter', 'instagram', 'linkedin', 'youtube']; @endphp
                @foreach($redes as $red)
                    @php $url = \App\Models\ConfiguracionSitio::obtener($red.'_url'); @endphp
                    @if($url)
                        <a href="{{ $url }}" class="me-3 btn btn-outline-primary btn-sm rounded-circle" target="_blank">
                            <i class="fab fa-{{ $red }}{{ $red=='facebook'?'-f':'' }}"></i>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="col-lg-2 col-md-6 mb-4">
            <h5 class="fw-bold">Enlaces</h5>
            <ul class="list-unstyled">
                @foreach(\App\Models\Menu::where('ubicacion', 'footer')->where('activo', true)->orderBy('orden')->get() as $menu)
                    <li class="mb-2">
                        <a href="{{ $menu->url_final }}" class="text-decoration-none text-dark hover-primary">
                            @if($menu->icono)
                                <i class="{{ $menu->icono }} me-1"></i>
                            @endif
                            {{ $menu->nombre }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <h5 class="fw-bold">Contacto</h5>
            <ul class="list-unstyled">
                <li class="mb-3 d-flex align-items-start">
                    <i class="fas fa-envelope me-3 mt-1 text-primary"></i>
                    <span>{{ \App\Models\ConfiguracionSitio::obtener('email_contacto', 'contacto@cnotarios.org.pe') }}</span>
                </li>
                <li class="mb-3 d-flex align-items-start">
                    <i class="fas fa-phone me-3 mt-1 text-primary"></i>
                    <span>{{ \App\Models\ConfiguracionSitio::obtener('telefono_contacto', '+51 52 411030') }}</span>
                </li>
                <li class="mb-3 d-flex align-items-start">
                    <i class="fas fa-map-marker-alt me-3 mt-1 text-primary"></i>
                    <span>{{ \App\Models\ConfiguracionSitio::obtener('direccion_contacto', 'Tacna, Perú') }}</span>
                </li>
            </ul>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <h5 class="fw-bold">Horario de Atención</h5>
            <ul class="list-unstyled">
                <li class="mb-2">
                    <i class="fas fa-clock me-2 text-primary"></i>
                    {{ \App\Models\ConfiguracionSitio::obtener('horario_atencion', 'Lun - Vie: 8:00 AM - 5:00 PM') }}
                </li>
                @php $sabado = \App\Models\ConfiguracionSitio::obtener('horario_sabados'); @endphp
                @if($sabado)
                <li class="mb-2">
                    <i class="fas fa-clock me-2 text-primary"></i>
                    {{ $sabado }}
                </li>
                @endif
            </ul>
        </div>
    </div>
    <hr class="my-4">
    <div class="row align-items-center">
        <div class="col-md-6 text-center text-md-start">
            <p class="mb-0 text-muted small">&copy; {{ date('Y') }} {{ \App\Models\ConfiguracionSitio::obtener('nombre_sitio') }}. Todos los derechos reservados.</p>
        </div>
        <div class="col-md-6 text-center text-md-end">
            <p class="mb-0 text-muted small">Desarrollado con <i class="fas fa-heart text-danger"></i> para el Colegio de Notarios</p>
        </div>
    </div>
</div>
</footer>

<style>
    .footer {
        background-color: #ffffff;
        padding: 50px 0 20px;
        border-top: 1px solid #eee;
        color: #333;
    }
    .footer h5 {
        font-size: 1.1rem;
        margin-bottom: 20px;
    }
    .hover-primary:hover {
        color: var(--primary-color) !important;
        padding-left: 5px;
        transition: all 0.3s ease;
    }
    .social-links a {
        transition: all 0.3s ease;
    }
    .social-links a:hover {
        transform: translateY(-3px);
        background-color: var(--primary-color);
        color: white;
    }
</style>
