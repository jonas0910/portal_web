{{--
    Widget Sidebar: Facebook
--}}

@props(['config' => []])

@php
    $altura = $config['altura'] ?? 400;
    $pageFacebookUrl = $config['page_url'] ?? \App\Models\ConfiguracionSitio::obtener('facebook_page_url', 'https://www.facebook.com/facebook');
@endphp

<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            <i class="fab fa-facebook"></i> Síguenos en Facebook
        </h5>
    </div>
    <div class="card-body p-0">
        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v12.0"></script>
        
        <div class="fb-page" 
             data-href="{{ $pageFacebookUrl }}" 
             data-tabs="timeline" 
             data-width="340" 
             data-height="{{ $altura }}" 
             data-small-header="false" 
             data-adapt-container-width="true" 
             data-hide-cover="false" 
             data-show-facepile="true">
            <blockquote cite="{{ $pageFacebookUrl }}" class="fb-xfbml-parse-ignore">
                <a href="{{ $pageFacebookUrl }}">Cargando Facebook...</a>
            </blockquote>
        </div>
    </div>
</div>



