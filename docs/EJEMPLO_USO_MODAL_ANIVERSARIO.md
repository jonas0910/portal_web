# Ejemplo de Uso - Modal de Fotos de Aniversario

## 📝 Caso 1: Agregar a todas las páginas públicas

Editar el layout principal público:

```blade
{{-- resources/views/layouts/public.blade.php --}}

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal de Notarios')</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    @include('public.partials.navbar')

    <!-- Contenido principal -->
    @yield('content')

    <!-- Footer -->
    @include('public.partials.footer')

    <!-- MODAL DE FOTOS DE ANIVERSARIO -->
    @include('public.components.modal-fotos-aniversario')

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>
```

---

## 📝 Caso 2: Agregar solo en la página de inicio

```blade
{{-- resources/views/public/index.blade.php --}}

@extends('layouts.public')

@section('title', 'Inicio')

@section('content')
    <div class="container">
        <h1>Bienvenidos</h1>
        <!-- Contenido de la página -->
    </div>

    <!-- Modal de fotos SOLO en esta página -->
    @include('public.components.modal-fotos-aniversario')
@endsection
```

---

## 📝 Caso 3: Botón personalizado en lugar del flotante

```blade
{{-- Ocultar el botón flotante predeterminado --}}
<style>
    #btn-abrir-galeria-aniversario {
        display: none;
    }
</style>

<!-- Incluir el modal -->
@include('public.components.modal-fotos-aniversario')

<!-- Tu propio botón personalizado -->
<div class="container my-5">
    <div class="text-center">
        <h2>Nuestra Historia</h2>
        <p>Conoce los momentos más importantes de nuestro aniversario</p>
        
        <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modalFotosAniversario">
            <i class="fas fa-birthday-cake"></i> Ver Galería de Aniversario
        </button>
    </div>
</div>
```

---

## 📝 Caso 4: Botón en el navbar

```blade
{{-- resources/views/public/partials/navbar.blade.php --}}

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="/">Portal de Notarios</a>
        
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="/">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/notarios">Notarios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/servicios">Servicios</a>
            </li>
            
            <!-- Botón de Aniversario en Navbar -->
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#modalFotosAniversario">
                    <i class="fas fa-birthday-cake"></i> Aniversario
                </a>
            </li>
        </ul>
    </div>
</nav>

<!-- No olvidar incluir el modal en el layout -->
```

---

## 📝 Caso 5: Sección dedicada con botón destacado

```blade
@extends('layouts.public')

@section('content')
<div class="container my-5">
    <!-- Sección Hero de Aniversario -->
    <section class="jumbotron text-center bg-gradient-primary text-white">
        <div class="container">
            <h1 class="display-4">
                <i class="fas fa-birthday-cake fa-3x mb-3"></i><br>
                50 Años de Historia
            </h1>
            <p class="lead">Celebramos cinco décadas sirviendo a la comunidad</p>
            <hr class="my-4">
            <p>Revive los momentos más importantes de nuestro aniversario</p>
            <button class="btn btn-warning btn-lg" data-toggle="modal" data-target="#modalFotosAniversario">
                <i class="fas fa-images"></i> Ver Galería Completa
            </button>
        </div>
    </section>

    <!-- Contenido adicional -->
    <section class="my-5">
        <h2>Nuestra Trayectoria</h2>
        <p>Lorem ipsum dolor sit amet...</p>
    </section>
</div>

<!-- Incluir el modal -->
@include('public.components.modal-fotos-aniversario')
@endsection
```

---

## 📝 Caso 6: Widget en el sidebar

```blade
<div class="sidebar">
    <!-- Otros widgets del sidebar -->
    
    <!-- Widget de Aniversario -->
    <div class="card mb-3">
        <div class="card-body text-center">
            <i class="fas fa-birthday-cake fa-3x text-primary mb-3"></i>
            <h5 class="card-title">Galería de Aniversario</h5>
            <p class="card-text small">Revive nuestros mejores momentos</p>
            <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalFotosAniversario">
                Ver Fotos
            </button>
        </div>
    </div>
</div>

<!-- Incluir el modal -->
@include('public.components.modal-fotos-aniversario')
```

---

## 📝 Caso 7: Carrusel de preview con botón "Ver más"

```blade
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4">Momentos Especiales</h2>
        
        <!-- Carrusel con algunas fotos de preview -->
        <div id="carouselAniversario" class="carousel slide mb-3" data-ride="carousel">
            <div class="carousel-inner">
                <!-- Aquí puedes poner manualmente 3-4 fotos como preview -->
                <div class="carousel-item active">
                    <img src="/images/preview1.jpg" class="d-block w-100" alt="Aniversario 1">
                </div>
                <div class="carousel-item">
                    <img src="/images/preview2.jpg" class="d-block w-100" alt="Aniversario 2">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselAniversario" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#carouselAniversario" role="button" data-slide="next">
                <span class="carousel-control-next-icon"></span>
            </a>
        </div>
        
        <!-- Botón para ver galería completa -->
        <div class="text-center">
            <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modalFotosAniversario">
                <i class="fas fa-images"></i> Ver Galería Completa ({{ $total_fotos ?? 0 }} fotos)
            </button>
        </div>
    </div>
</section>

@include('public.components.modal-fotos-aniversario')
```

---

## 🎨 Personalización del Estilo del Botón Flotante

Si quieres personalizar el botón flotante predeterminado:

```blade
@include('public.components.modal-fotos-aniversario')

@push('styles')
<style>
    /* Cambiar posición del botón flotante */
    #btn-abrir-galeria-aniversario {
        bottom: 80px;  /* Más arriba */
        right: 30px;   /* Más a la derecha */
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    /* Agregar animación de pulso */
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    
    #btn-abrir-galeria-aniversario {
        animation: pulse 2s infinite;
    }
</style>
@endpush
```

---

## 🚀 Cargar Fotos de un Año Específico

Si quieres que el modal abra con fotos filtradas de un año específico, puedes usar JavaScript:

```blade
@include('public.components.modal-fotos-aniversario')

@push('scripts')
<script>
    // Abrir modal con año 2024 pre-seleccionado
    $('#modalFotosAniversario').on('shown.bs.modal', function() {
        $('#filtro-anio').val('2024').trigger('change');
    });
</script>
@endpush
```

---

## ✅ Checklist de Implementación

- [ ] Incluir el componente en la vista deseada
- [ ] Verificar que jQuery y Bootstrap estén cargados
- [ ] Agregar fotos desde el panel de admin
- [ ] Probar en diferentes dispositivos (móvil, tablet, desktop)
- [ ] Verificar que las imágenes se carguen correctamente

---

¡Listo! Ahora tienes múltiples opciones para integrar la galería de fotos de aniversario en tu sitio. 🎉


