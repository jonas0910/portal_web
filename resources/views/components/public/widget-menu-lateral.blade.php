{{-- Widget de Menú Lateral/Accesos Rápidos --}}
<section class="menu-lateral-section py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4 mb-4">
                <div class="card shadow-sm sticky-top" style="top: 100px;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, {{ $tema->color_primario ?? '#007bff' }} 0%, {{ $tema->color_secundario ?? '#6c757d' }} 100%);">
                        <h5 class="mb-0">
                            <i class="fas fa-bars"></i> Accesos Rápidos
                        </h5>
                    </div>
                    <div class="list-group list-group-flush">
                        @php
                            $menusLaterales = \App\Models\Menu::where('ubicacion', 'lateral')
                                ->where('activo', true)
                                ->orderBy('orden')
                                ->get();
                        @endphp
                        
                        @forelse($menusLaterales as $menuLateral)
                            <a href="{{ $menuLateral->url_final }}" 
                               class="list-group-item list-group-item-action d-flex align-items-center menu-lateral-item">
                                @if($menuLateral->icono)
                                    <div class="icon-box me-3 d-flex align-items-center justify-content-center rounded-circle" 
                                         style="width: 40px; height: 40px; background-color: {{ $tema->color_primario ?? '#007bff' }}20;">
                                        <i class="{{ $menuLateral->icono }}" style="color: {{ $tema->color_primario ?? '#007bff' }}"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-bold">{{ $menuLateral->nombre }}</div>
                                    @if($menuLateral->descripcion)
                                        <small class="text-muted">{{ $menuLateral->descripcion }}</small>
                                    @endif
                                </div>
                            </a>
                        @empty
                            <div class="list-group-item text-center text-muted">
                                <i class="fas fa-info-circle"></i>
                                <p class="mb-0 small mt-2">No hay accesos rápidos configurados</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                
                {{-- Widget Adicional: Información de Contacto Rápido --}}
                <div class="card shadow-sm mt-4">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-phone-alt fa-3x" style="color: {{ $tema->color_primario ?? '#007bff' }}"></i>
                        </div>
                        <h6 class="fw-bold">¿Necesitas ayuda?</h6>
                        <p class="small text-muted mb-3">Contáctanos directamente</p>
                        <a href="tel:{{ \App\Models\ConfiguracionSitio::obtener('telefono_contacto', '+51 1 234 5678') }}" 
                           class="btn btn-sm btn-block mb-2" 
                           style="background-color: {{ $tema->color_primario ?? '#007bff' }}; color: white;">
                            <i class="fas fa-phone"></i> Llamar Ahora
                        </a>
                        <a href="mailto:{{ \App\Models\ConfiguracionSitio::obtener('email_contacto', 'contacto@notarios.org.pe') }}" 
                           class="btn btn-sm btn-outline-secondary btn-block">
                            <i class="fas fa-envelope"></i> Enviar Email
                        </a>
                    </div>
                </div>

                {{-- Widget: Horarios --}}
                <div class="card shadow-sm mt-4">
                    <div class="card-header" style="background-color: {{ $tema->color_primario ?? '#007bff' }}15;">
                        <h6 class="mb-0" style="color: {{ $tema->color_primario ?? '#007bff' }}">
                            <i class="fas fa-clock"></i> Horarios de Atención
                        </h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0 small">
                            <li class="mb-2">
                                <i class="fas fa-calendar-week me-2" style="color: {{ $tema->color_primario ?? '#007bff' }}"></i>
                                <strong>Lunes - Viernes</strong><br>
                                <span class="ms-4">9:00 AM - 6:00 PM</span>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-calendar-day me-2" style="color: {{ $tema->color_acento ?? '#28a745' }}"></i>
                                <strong>Sábados</strong><br>
                                <span class="ms-4">9:00 AM - 1:00 PM</span>
                            </li>
                            <li class="text-muted">
                                <i class="fas fa-times-circle me-2"></i>
                                <strong>Domingos</strong><br>
                                <span class="ms-4">Cerrado</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-9 col-md-8">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Panel de Accesos Rápidos</strong>
                    <p class="mb-0">
                        Este menú lateral te permite acceder rápidamente a las secciones más importantes del portal.
                        Puedes configurarlo desde el <a href="{{ route('admin.contenido.menus.builder') }}" class="alert-link">gestor de menús</a>.
                    </p>
                </div>
                
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 style="color: {{ $tema->color_primario ?? '#007bff' }}">
                            <i class="fas fa-balance-scale"></i> Bienvenido al Portal de Notarios
                        </h4>
                        <p>
                            Utiliza el menú lateral para navegar rápidamente a las diferentes secciones del portal.
                            Encuentra información sobre nuestros servicios, notarios certificados, documentos públicos y más.
                        </p>
                        
                        <div class="row mt-4">
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="icon-box me-3">
                                        <i class="fas fa-check-circle fa-2x" style="color: {{ $tema->color_primario ?? '#007bff' }}"></i>
                                    </div>
                                    <div>
                                        <h6>Servicios Certificados</h6>
                                        <p class="small text-muted">Más de 25 años de experiencia brindando servicios notariales de calidad.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-start">
                                    <div class="icon-box me-3">
                                        <i class="fas fa-shield-alt fa-2x" style="color: {{ $tema->color_acento ?? '#28a745' }}"></i>
                                    </div>
                                    <div>
                                        <h6>Seguridad Jurídica</h6>
                                        <p class="small text-muted">Garantizamos la validez legal de todos tus documentos.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.menu-lateral-item {
    border-left: 3px solid transparent;
    transition: all 0.3s ease;
}

.menu-lateral-item:hover {
    border-left-color: {{ $tema->color_primario ?? '#007bff' }};
    background-color: {{ $tema->color_primario ?? '#007bff' }}05;
    transform: translateX(5px);
}

.icon-box {
    transition: transform 0.3s ease;
}

.menu-lateral-item:hover .icon-box {
    transform: scale(1.1);
}

.sticky-top {
    position: sticky;
}

@media (max-width: 768px) {
    .sticky-top {
        position: relative;
    }
}
</style>

