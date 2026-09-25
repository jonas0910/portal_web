{{-- Widget YouTube Channel/Playlist --}}
@php
    $youtubeChannelId = \App\Models\ConfiguracionSitio::obtener('youtube_channel_id', 'UC_x5XG1OV2P6uZZ5FSM9Ttw');
    $youtubePlaylistId = \App\Models\ConfiguracionSitio::obtener('youtube_playlist_id', '');
    $tipoVideo = $config['tipo'] ?? 'channel'; // channel, playlist, video
    $videoId = $config['video_id'] ?? '';
    $cantidad = $config['cantidad'] ?? 6;
    $columnas = $config['columnas'] ?? 3;
    $mostrarUltimos = $config['mostrar_ultimos'] ?? true;
@endphp

<div class="youtube-widget-section">
    <div class="text-center mb-4">
        <h2 class="section-title">
            <i class="fab fa-youtube text-danger"></i> 
            Nuestro Canal de YouTube
        </h2>
        <p class="text-muted">Videos informativos y educativos</p>
    </div>
    
    <div class="container">
        @if($tipoVideo === 'video' && $videoId)
            {{-- Video único destacado --}}
            <div class="row justify-content-center mb-4">
                <div class="col-lg-8 col-md-10">
                    <div class="ratio ratio-16x9 shadow-lg rounded overflow-hidden">
                        <iframe src="https://www.youtube.com/embed/{{ $videoId }}" 
                                title="YouTube video player" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                allowfullscreen
                                class="rounded"></iframe>
                    </div>
                </div>
            </div>
        @endif
        
        @if($tipoVideo === 'playlist' && $youtubePlaylistId)
            {{-- Playlist embed --}}
            <div class="row justify-content-center mb-4">
                <div class="col-lg-8 col-md-10">
                    <div class="ratio ratio-16x9 shadow-lg rounded overflow-hidden">
                        <iframe src="https://www.youtube.com/embed/videoseries?list={{ $youtubePlaylistId }}" 
                                title="YouTube playlist" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                allowfullscreen
                                class="rounded"></iframe>
                    </div>
                </div>
            </div>
        @endif
        
        @if($mostrarUltimos && $tipoVideo === 'channel')
            {{-- Grid de últimos videos --}}
            <div class="row justify-content-center mb-4">
                <div class="col-lg-10">
                    <h4 class="text-center mb-4">Últimos Videos</h4>
                    <div class="row g-4">
                        {{-- Videos de ejemplo (en producción esto vendría de la API de YouTube) --}}
                        @for($i = 1; $i <= $cantidad; $i++)
                        <div class="col-lg-{{ 12 / $columnas }} col-md-6">
                            <div class="youtube-video-card card h-100 shadow-sm">
                                <div class="ratio ratio-16x9">
                                    <img src="https://img.youtube.com/vi/dQw4w9WgXcQ/mqdefault.jpg" 
                                         class="card-img-top" 
                                         alt="Video {{ $i }}"
                                         style="object-fit: cover;">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title text-truncate">
                                        <i class="fab fa-youtube text-danger me-2"></i>
                                        Título del Video {{ $i }}
                                    </h5>
                                    <p class="card-text text-muted small">
                                        <i class="fas fa-eye me-1"></i> 1,234 vistas
                                        <span class="mx-2">•</span>
                                        <i class="far fa-clock me-1"></i> Hace {{ $i }} días
                                    </p>
                                    <a href="https://www.youtube.com/channel/{{ $youtubeChannelId }}" 
                                       target="_blank" 
                                       class="btn btn-sm btn-outline-danger w-100">
                                        <i class="fas fa-play me-2"></i>Ver Video
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>
        @endif
        
        {{-- Botón para suscribirse al canal --}}
        <div class="text-center mt-4">
            <a href="https://www.youtube.com/channel/{{ $youtubeChannelId }}?sub_confirmation=1" 
               target="_blank" 
               class="btn btn-danger btn-lg">
                <i class="fab fa-youtube me-2"></i>
                Suscríbete a nuestro canal
            </a>
            
            {{-- Botón de suscripción oficial de YouTube --}}
            <div class="mt-3">
                <script src="https://apis.google.com/js/platform.js"></script>
                <div class="g-ytsubscribe" 
                     data-channelid="{{ $youtubeChannelId }}" 
                     data-layout="full" 
                     data-count="default"></div>
            </div>
        </div>
    </div>
</div>

<style>
    .youtube-widget-section {
        padding: 60px 0;
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
    
    .youtube-video-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
        overflow: hidden;
    }
    
    .youtube-video-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important;
    }
    
    .youtube-video-card .card-img-top {
        transition: transform 0.3s ease;
    }
    
    .youtube-video-card:hover .card-img-top {
        transform: scale(1.05);
    }
    
    .youtube-video-card .card-title {
        font-size: 1rem;
        font-weight: 600;
        color: #212529;
    }
    
    .g-ytsubscribe {
        display: inline-block;
    }
    
    @media (max-width: 768px) {
        .section-title {
            font-size: 1.5rem;
        }
        
        .youtube-video-card .card-title {
            font-size: 0.9rem;
        }
    }
</style>



