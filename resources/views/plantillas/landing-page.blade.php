@extends('layouts.public')

@section('title', $paginaInicio->titulo ?? 'Inicio')

@section('content')
<div class="landing-page">
    {{-- Hero Banner Dinámico --}}
    @include('components.public.widget-hero-banner', ['tema' => $tema])

    {{-- Contenido Principal de la Página --}}
    @if($paginaInicio->contenido)
    <section class="py-5">
        <div class="container">
            <div class="content-wrapper">
                {!! $paginaInicio->contenido !!}
            </div>
        </div>
    </section>
    @endif

    {{-- Componentes Dinámicos según Configuración de Plantilla --}}
    @if(!empty($plantillaComponentes) && is_array($plantillaComponentes))
        {{-- DEBUG: Mostrar componentes configurados --}}
        <div class="container my-4 p-3 bg-info text-white">
            <h5>🔧 DEBUG - Componentes de Plantilla:</h5>
            <ul>
                @foreach($plantillaComponentes as $index => $comp)
                    <li><strong>{{ $index + 1 }}.</strong> {{ $comp }}</li>
                @endforeach
            </ul>
        </div>
        
        @foreach($plantillaComponentes as $componente)
            @php
                // Limpiar nombre del componente
                $componenteNombre = str_replace('.blade.php', '', $componente);
                $componenteNombre = trim($componenteNombre);
                
                // Mapeo de nombres de componentes a rutas
                $mapeo = [
                    'testimonios' => 'components.public.widget-testimonios',
                    'widget-testimonios' => 'components.public.widget-testimonios',
                    'mapa' => 'components.public.widget-mapa-ubicacion',
                    'mapa-ubicacion' => 'components.public.widget-mapa-ubicacion',
                    'mapa de ubicacion' => 'components.public.widget-mapa-ubicacion',
                    'widget-mapa-ubicacion' => 'components.public.widget-mapa-ubicacion',
                    'estadisticas' => 'components.public.widget-estadisticas',
                    'widget-estadisticas' => 'components.public.widget-estadisticas',
                    'notarios' => 'components.public.widget-notarios-destacados',
                    'notarios-destacados' => 'components.public.widget-notarios-destacados',
                    'widget-notarios-destacados' => 'components.public.widget-notarios-destacados',
                    'servicios' => 'components.public.widget-servicios-destacados',
                    'servicios-destacados' => 'components.public.widget-servicios-destacados',
                    'widget-servicios-destacados' => 'components.public.widget-servicios-destacados',
                    'documentos' => 'components.public.widget-documentos-recientes',
                    'documentos-recientes' => 'components.public.widget-documentos-recientes',
                    'widget-documentos-recientes' => 'components.public.widget-documentos-recientes',
                    'formulario-contacto' => 'components.public.widget-formulario-contacto',
                    'widget-formulario-contacto' => 'components.public.widget-formulario-contacto',
                    'calendario' => 'components.public.widget-calendario-audiencias',
                    'calendario-audiencias' => 'components.public.widget-calendario-audiencias',
                    'widget-calendario-audiencias' => 'components.public.widget-calendario-audiencias',
                    'hero' => 'components.public.widget-hero-banner',
                    'hero-banner' => 'components.public.widget-hero-banner',
                    'widget-hero-banner' => 'components.public.widget-hero-banner',
                ];
                
                // Buscar en el mapeo (case insensitive)
                $componenteKey = strtolower($componenteNombre);
                $componenteRuta = $mapeo[$componenteKey] ?? 'components.public.widget-' . strtolower(str_replace([' ', '_'], '-', $componenteNombre));
            @endphp
            
            {{-- DEBUG: Mostrar qué se intenta incluir --}}
            <div class="container my-2 p-2 bg-warning">
                <small>Intentando incluir: <strong>{{ $componenteRuta }}</strong> 
                    - Existe: {{ view()->exists($componenteRuta) ? '✓ SÍ' : '✗ NO' }}</small>
            </div>
            
            @if(view()->exists($componenteRuta))
                @include($componenteRuta, ['tema' => $tema, 'estadisticas' => $estadisticas ?? [], 'notariosDestacados' => $notariosDestacados ?? [], 'serviciosDestacados' => $serviciosDestacados ?? []])
            @else
                <div class="container my-2 p-3 bg-danger text-white">
                    <strong>⚠️ Componente no encontrado:</strong> {{ $componenteRuta }}
                </div>
            @endif
        @endforeach
    @else
        {{-- DEBUG: Sin componentes --}}
        <div class="container my-4 p-3 bg-secondary text-white">
            <h5>⚠️ No hay componentes configurados en la plantilla</h5>
            <p>Variable $plantillaComponentes está vacía o no es array</p>
        </div>
    @endif

    {{-- Widgets Dinámicos según Tema (Fallback si no hay componentes de plantilla) --}}
    
    {{-- Widget Calendario de Audiencias --}}
    @if(!empty($widgets['widget_calendario_audiencias']))
        @include('components.public.widget-calendario-audiencias', ['tema' => $tema])
    @endif
    
    {{-- Widget Estadísticas --}}
    @if(!empty($widgets['widget_estadisticas']))
        @include('components.public.widget-estadisticas', ['estadisticas' => $estadisticas, 'tema' => $tema])
    @endif

    {{-- Widget Notarios Destacados --}}
    @if(!empty($widgets['widget_notarios_destacados']))
        @include('components.public.widget-notarios-destacados', ['notariosDestacados' => $notariosDestacados, 'tema' => $tema])
    @endif

    {{-- Widget Servicios Destacados --}}
    @if(!empty($widgets['widget_servicios_destacados']))
        @include('components.public.widget-servicios-destacados', ['serviciosDestacados' => $serviciosDestacados, 'tema' => $tema])
    @endif

    {{-- Widget Documentos Recientes --}}
    @if(!empty($widgets['widget_documentos_recientes']))
        @include('components.public.widget-documentos-recientes', ['tema' => $tema])
    @endif

    {{-- Widget Testimonios --}}
    @if(!empty($widgets['widget_testimonios']))
        @include('components.public.widget-testimonios', ['tema' => $tema])
    @endif

    {{-- Call to Action (CTA) - Siempre visible --}}
    @include('components.public.widget-cta', ['tema' => $tema])

    {{-- Widget Formulario de Contacto --}}
    @if(!empty($widgets['widget_formulario_contacto']))
        @include('components.public.widget-formulario-contacto', ['tema' => $tema])
    @endif

    {{-- Widget Mapa de Ubicación --}}
    @if(!empty($widgets['widget_mapa_ubicacion']))
        @include('components.public.widget-mapa-ubicacion', ['tema' => $tema])
    @endif

    {{-- Widget Menu Lateral / Accesos Rápidos --}}
    @if(!empty($widgets['menu_lateral']))
        @include('components.public.widget-menu-lateral', ['tema' => $tema])
    @endif
</div>

<style>
    .hero-section {
        padding: 80px 0;
        color: white;
    }
    
    .min-vh-50 {
        min-height: 50vh;
        display: flex;
        align-items: center;
    }
    
    .content-wrapper {
        font-size: 1.1rem;
        line-height: 1.8;
    }
    
    .content-wrapper h1 {
        color: {{ $tema->color_primario ?? '#007bff' }};
        margin-bottom: 1.5rem;
    }
    
    .content-wrapper h2 {
        color: {{ $tema->color_secundario ?? '#6c757d' }};
        margin-top: 2rem;
        margin-bottom: 1rem;
    }
</style>
@endsection

