{{-- Widget Call to Action --}}
@php
    // Obtener CTA de la BD
    $ctaBD = \App\Models\CallToAction::obtenerGlobal();
    
    // Usar datos de BD o valores por defecto
    if ($ctaBD) {
        $ctaTitulo = $ctaBD->titulo;
        $ctaSubtitulo = $ctaBD->subtitulo;
        $ctaBotonTexto = $ctaBD->boton_principal_texto;
        $ctaBotonUrl = $ctaBD->boton_principal_url;
        $ctaBotonSecundario = $ctaBD->boton_secundario_texto;
        $ctaBotonSecundarioUrl = $ctaBD->boton_secundario_url;
        $ctaCaracteristicas = $ctaBD->caracteristicas ?? [];
    } else {
        // Fallback si no hay CTA en BD
        $ctaTitulo = $titulo ?? '¿Necesitas Servicios Notariales?';
        $ctaSubtitulo = $subtitulo ?? 'Estamos aquí para ayudarte con todos tus trámites legales y notariales';
        $ctaBotonTexto = $botonTexto ?? 'Contáctanos Ahora';
        $ctaBotonUrl = $botonUrl ?? '/contacto';
        $ctaBotonSecundario = $botonSecundario ?? 'Ver Servicios';
        $ctaBotonSecundarioUrl = $botonSecundarioUrl ?? '/servicios';
        $ctaCaracteristicas = [
            ['icono' => 'fa-check-circle', 'titulo' => 'Certificados', 'descripcion' => 'Notarios oficiales'],
            ['icono' => 'fa-clock', 'titulo' => 'Rápido', 'descripcion' => 'Atención inmediata'],
            ['icono' => 'fa-shield-alt', 'titulo' => 'Seguro', 'descripcion' => 'Total confidencialidad'],
            ['icono' => 'fa-user-tie', 'titulo' => 'Profesional', 'descripcion' => 'Expertos legales'],
        ];
    }
@endphp

<section class="cta-section py-5" style="background: linear-gradient(135deg, {{ $tema->color_primario ?? '#007bff' }} 0%, {{ $tema->color_secundario ?? '#6c757d' }} 100%); position: relative; overflow: hidden;">
    {{-- Patrón de fondo --}}
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.1; background-image: 
        repeating-linear-gradient(45deg, transparent, transparent 35px, rgba(255,255,255,.1) 35px, rgba(255,255,255,.1) 70px);"></div>
    
    <div class="container position-relative" style="z-index: 1;">
        <div class="row align-items-center">
            <div class="col-lg-8 text-white mb-4 mb-lg-0">
                <h2 class="display-5 fw-bold mb-3">
                    {{ $ctaTitulo }}
                </h2>
                <p class="lead mb-0" style="opacity: 0.95;">
                    {{ $ctaSubtitulo }}
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ $ctaBotonUrl }}" class="btn btn-light btn-lg mb-2 me-2" style="box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                    <i class="fas fa-phone-alt"></i> {{ $ctaBotonTexto }}
                </a>
                <a href="{{ $ctaBotonSecundarioUrl }}" class="btn btn-outline-light btn-lg mb-2" style="border-width: 2px;">
                    <i class="fas fa-briefcase"></i> {{ $ctaBotonSecundario }}
                </a>
            </div>
        </div>
        
        {{-- Características rápidas (Dinámicas desde BD) --}}
        @if(!empty($ctaCaracteristicas) && is_array($ctaCaracteristicas))
        <div class="row mt-5 text-white">
            @foreach($ctaCaracteristicas as $caracteristica)
            <div class="col-md-{{ 12 / min(count($ctaCaracteristicas), 4) }} col-6 mb-3 text-center">
                <div class="feature-icon mb-2">
                    <i class="fas {{ $caracteristica['icono'] ?? 'fa-check' }} fa-2x"></i>
                </div>
                <h5 class="mb-0">{{ $caracteristica['titulo'] ?? 'Beneficio' }}</h5>
                <small style="opacity: 0.9;">{{ $caracteristica['descripcion'] ?? '' }}</small>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>

<style>
    .cta-section .btn {
        transition: all 0.3s ease;
    }
    .cta-section .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.3) !important;
    }
    .feature-icon {
        transition: transform 0.3s ease;
    }
    .feature-icon:hover {
        transform: scale(1.1);
    }
</style>

