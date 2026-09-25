{{-- 
    Plantilla Landing Dinámica con Soporte para Ancho Completo
    Lee la configuración de componentes desde la base de datos
--}}
@extends('layouts.public')

@section('title', $paginaInicio->titulo ?? 'Inicio')

@section('content')
<div class="landing-page-dinamica">
    @php
        // Obtener la plantilla actual (desde la página o fallback a landing)
        $plantillaActual = $paginaInicio->plantilla ?? \App\Models\Plantilla::where('slug', 'landing')->first();
        
        // Obtener componentes y configuración (valores por defecto si no hay plantilla)
        $componentesActivos = $plantillaActual ? (is_array($plantillaActual->componentes) ? $plantillaActual->componentes : (json_decode($plantillaActual->componentes ?? '[]', true) ?? [])) : [];
        $configuracionComponentes = $plantillaActual ? (is_array($plantillaActual->configuracion) ? $plantillaActual->configuracion : (json_decode($plantillaActual->configuracion ?? '{}', true) ?? [])) : [];
        
        // Si no hay componentes configurados, usar orden por defecto: banner, estadísticas, servicios, noticias, proyectos
        if (empty($componentesActivos)) {
            $componentesActivos = ['banner', 'estadisticas', 'servicios', 'noticias', 'proyectos'];
        }
        
        // Sidebar: leer de columnas sidebar_habilitado y sidebar_widgets (gestor) o de configuracion (legacy)
        $sidebarActivo = $plantillaActual && ($plantillaActual->sidebar_habilitado ?? false);
        if (!$sidebarActivo && isset($configuracionComponentes['sidebar']['activo'])) {
            $sidebarActivo = (bool) $configuracionComponentes['sidebar']['activo'];
        }
        $sidebarWidgets = [];
        if ($plantillaActual && $plantillaActual->sidebar_widgets) {
            $sidebarWidgets = is_array($plantillaActual->sidebar_widgets) ? $plantillaActual->sidebar_widgets : (json_decode($plantillaActual->sidebar_widgets ?? '{}', true) ?? []);
        }
        if (empty($sidebarWidgets) && !empty($configuracionComponentes['sidebar']['widgets'])) {
            $sidebarWidgets = $configuracionComponentes['sidebar']['widgets'];
        }
        
        // Crear array de componentes con su configuración y orden
        $widgetsOrdenados = [];
        foreach ($componentesActivos as $componente) {
            if ($componente === 'sidebar') continue; // Skip sidebar, se maneja aparte
            
            $config = $configuracionComponentes[$componente] ?? [];
            if ($config['activo'] ?? true) {
                $widgetsOrdenados[] = [
                    'tipo' => $componente,
                    'orden' => $config['orden'] ?? 999,
                    'config' => $config,
                    'ancho_completo' => $config['ancho_completo'] ?? false
                ];
            }
        }
        
        // Ordenar por orden
        usort($widgetsOrdenados, function($a, $b) {
            return $a['orden'] <=> $b['orden'];
        });
        
        // Agrupar componentes: Los de ancho completo van solos, los normales se agrupan
        $grupos = [];
        $grupoActual = [];
        
        foreach ($widgetsOrdenados as $widget) {
            if ($widget['ancho_completo']) {
                // Si hay grupo acumulado, guardarlo primero
                if (!empty($grupoActual)) {
                    $grupos[] = ['tipo' => 'normal', 'componentes' => $grupoActual];
                    $grupoActual = [];
                }
                // Agregar componente de ancho completo como grupo individual
                $grupos[] = ['tipo' => 'ancho_completo', 'componentes' => [$widget]];
            } else {
                // Acumular componentes normales
                $grupoActual[] = $widget;
            }
        }
        
        // Agregar último grupo si existe
        if (!empty($grupoActual)) {
            $grupos[] = ['tipo' => 'normal', 'componentes' => $grupoActual];
        }
        
        // Determinar columnas para el layout
        $colPrincipal = $sidebarActivo ? 'col-lg-9' : 'col-12';
        $colSidebar = 'col-lg-3';
        
        // Ordenar widgets del sidebar
        $sidebarWidgetsOrdenados = [];
        foreach ($sidebarWidgets as $widgetKey => $widgetConfig) {
            if ($widgetConfig['activo'] ?? false) {
                $sidebarWidgetsOrdenados[] = [
                    'key' => $widgetKey,
                    'orden' => $widgetConfig['orden'] ?? 999,
                    'config' => $widgetConfig
                ];
            }
        }
        usort($sidebarWidgetsOrdenados, function($a, $b) {
            return $a['orden'] <=> $b['orden'];
        });
    @endphp

    {{-- Renderizar grupos --}}
    @foreach($grupos as $grupoIndex => $grupo)
        @if($grupo['tipo'] === 'ancho_completo')
            {{-- Componentes de Ancho Completo (sin container, 100% de ancho) --}}
            @foreach($grupo['componentes'] as $widget)
                @include('plantillas.partials.render-widget', [
                    'widget' => $widget,
                    'anchoCompleto' => true
                ])
            @endforeach
        @else
            {{-- Componentes Normales (con layout de columnas) --}}
            <div class="container-fluid">
                <div class="row">
                    {{-- Columna Principal --}}
                    <div class="{{ $colPrincipal }}">
                        @foreach($grupo['componentes'] as $widget)
                            @include('plantillas.partials.render-widget', [
                                'widget' => $widget,
                                'anchoCompleto' => false
                            ])
                        @endforeach
                    </div>

                    {{-- Sidebar (solo en el primer grupo normal) --}}
                    @if($sidebarActivo && $sidebarWidgetsOrdenados)
                        @php
                            // Determinar si debemos mostrar el sidebar en este grupo
                            $mostrarSidebar = false;
                            
                            // Si es el primer grupo y es normal, mostrar sidebar
                            if ($grupoIndex === 0 && $grupo['tipo'] === 'normal') {
                                $mostrarSidebar = true;
                            }
                            // O si el grupo anterior era de ancho completo y este es normal
                            elseif ($grupoIndex > 0 && $grupos[$grupoIndex - 1]['tipo'] === 'ancho_completo' && $grupo['tipo'] === 'normal') {
                                $mostrarSidebar = true;
                            }
                            // O si NO hemos mostrado el sidebar aún y este es un grupo normal
                            static $sidebarMostrado = false;
                            if (!$sidebarMostrado && $grupo['tipo'] === 'normal') {
                                $mostrarSidebar = true;
                                $sidebarMostrado = true;
                            }
                        @endphp
                        
                        @if($mostrarSidebar)
                        <div class="{{ $colSidebar }}">
                            <aside class="sidebar-widgets sticky-top" style="top: 80px; max-height: calc(100vh - 100px); overflow-y: auto;">
                                @foreach($sidebarWidgetsOrdenados as $widget)
                                    @if($widget['key'] == 'calendario')
                                        @include('components.public.sidebar-calendario', ['config' => $widget['config']])
                                    @elseif($widget['key'] == 'enlaces')
                                        @include('components.public.sidebar-enlaces', ['config' => $widget['config']])
                                    @elseif($widget['key'] == 'facebook')
                                        @include('components.public.sidebar-facebook', ['config' => $widget['config']])
                                    @elseif($widget['key'] == 'youtube')
                                        @include('components.public.sidebar-youtube', ['config' => $widget['config']])
                                    @elseif($widget['key'] == 'documentos')
                                        @include('components.public.sidebar-documentos', ['config' => $widget['config']])
                                    @endif
                                @endforeach
                            </aside>
                        </div>
                        @endif
                    @endif
                </div>
            </div>
        @endif
    @endforeach
</div>

<style>
.hover-card {
    transition: all 0.3s ease;
}
.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
}

/* Sidebar sticky */
.sidebar-widgets {
    max-height: calc(100vh - 100px);
    overflow-y: auto;
}

.sidebar-widgets::-webkit-scrollbar {
    width: 6px;
}

.sidebar-widgets::-webkit-scrollbar-track {
    background: transparent;
}

.sidebar-widgets::-webkit-scrollbar-thumb {
    background-color: rgba(0,0,0,0.2);
    border-radius: 3px;
}
</style>
@endsection

