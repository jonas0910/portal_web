{{--
    Componente: Contador Animado
    Uso: Para mostrar estadísticas con animación
    Variables: $numero, $texto, $icono, $color
--}}

<div class="contador-box text-center p-4">
    <div class="contador-icono mb-3">
        <i class="{{ $icono ?? 'fas fa-star' }} fa-3x" style="color: {{ $color ?? '#007bff' }};"></i>
    </div>
    <h2 class="contador-numero mb-2" data-target="{{ $numero ?? '100' }}">0</h2>
    <p class="contador-texto text-muted mb-0">{{ $texto ?? 'Descripción' }}</p>
</div>

<style>
.contador-box {
    transition: all 0.3s ease;
}

.contador-box:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.contador-numero {
    font-size: 3rem;
    font-weight: bold;
    color: {{ $color ?? '#007bff' }};
}
</style>

<script>
// Animación de contador (solo si jQuery está cargado)
if (typeof jQuery !== 'undefined') {
    $(document).ready(function() {
        $('.contador-numero').each(function() {
            var $this = $(this);
            var target = parseInt($this.data('target'));
            
            $({ countNum: 0 }).animate({
                countNum: target
            }, {
                duration: 2000,
                easing: 'swing',
                step: function() {
                    $this.text(Math.floor(this.countNum));
                },
                complete: function() {
                    $this.text(target);
                }
            });
        });
    });
}
</script>

