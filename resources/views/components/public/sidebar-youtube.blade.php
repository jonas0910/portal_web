{{--
    Widget Sidebar: YouTube
--}}

@props(['config' => []])

@php
    $channelId = $config['channel_id'] ?? 'UC_x5XG1OV2P6uZZ5FSM9Ttw'; // Google Developers por defecto
    $cantidad = $config['cantidad'] ?? 3;
@endphp

<div class="card shadow-sm mb-4">
    <div class="card-header bg-danger text-white">
        <h5 class="mb-0">
            <i class="fab fa-youtube"></i> Canal de YouTube
        </h5>
    </div>
    <div class="card-body p-3">
        <!-- Botón de suscripción -->
        <div class="text-center mb-3">
            <script src="https://apis.google.com/js/platform.js"></script>
            <div class="g-ytsubscribe" data-channelid="{{ $channelId }}" data-layout="full" data-count="default"></div>
        </div>
        
        <!-- Video destacado (embed) -->
        <div class="ratio ratio-16x9 mb-3">
            <iframe src="https://www.youtube.com/embed?listType=user_uploads&list={{ $channelId }}" 
                    title="YouTube video player" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen>
            </iframe>
        </div>
        
        <div class="text-center">
            <a href="https://www.youtube.com/channel/{{ $channelId }}" 
               target="_blank" 
               class="btn btn-sm btn-danger">
                <i class="fab fa-youtube"></i> Ver Canal Completo
            </a>
        </div>
    </div>
</div>



