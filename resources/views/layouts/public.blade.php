<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- SEO Dinámico --}}
    <title>@yield('title', \App\Models\ConfiguracionSitio::obtener('nombre_sitio', 'Colegio de Notarios'))</title>
    <meta name="description" content="@yield('meta_description', \App\Models\ConfiguracionSitio::obtener('descripcion_sitio', 'Portal oficial del Colegio de Notarios'))">
    <meta name="keywords" content="@yield('meta_keywords', 'notarios, peru, servicios notariales, tacna')">
    
    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    {{-- CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    {{-- Google Fonts - Carga dinÃ¡mica segÃºn tema --}}
    @php
        $tema = \App\Models\Tema::obtenerPredeterminado();
        if (!$tema) {
            $tema = (object)[
                'fuente_principal' => 'Inter', 'fuente_secundaria' => '', 'color_primario' => '#007bff',
                'color_secundario' => '#6c757d', 'color_acento' => '#28a745', 'color_fondo' => '#ffffff',
                'color_texto' => '#212529', 'tamano_fuente' => '16px', 'color_navbar' => '#e8f5e9',
                'color_top_bar' => '#212529', 'color_texto_top_bar' => '#ffffff', 'mostrar_header_accesos' => true,
                'mostrar_footer' => true, 'navbar_altura' => 70, 'estilo_navbar' => 'sticky',
                'color_barra_accesos' => '#ffffff', 'navbar_transparente' => false,
            ];
        }
        $fontePrincipal = $tema->fuente_principal ?? 'Inter';
        $fonteSecundaria = $tema->fuente_secundaria ?? '';
        $googleFonts = [];
        
        if (!in_array($fontePrincipal, ['Arial', 'Helvetica', 'Times New Roman', 'Georgia', 'Courier New', 'Verdana'])) {
            $googleFonts[] = str_replace(' ', '+', $fontePrincipal) . ':wght@300;400;500;600;700';
        }
        
        if ($fonteSecundaria && !in_array($fonteSecundaria, ['Arial', 'Helvetica', 'Times New Roman', 'Georgia', 'Courier New', 'Verdana'])) {
            $googleFonts[] = str_replace(' ', '+', $fonteSecundaria) . ':wght@300;400;500;600;700';
        }
        
        if (empty($googleFonts)) {
            $googleFonts[] = 'Inter:wght@300;400;500;600;700';
        }
    @endphp
    <link href="https://fonts.googleapis.com/css2?family={{ implode('&family=', $googleFonts) }}&display=swap" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body {
            margin: 0 !important;
            padding: 0 !important;
            width: 100%;
            position: relative;
            /* Eliminado overflow-x para permitir sticky navbar */
        }
        
        :root {
            --primary-color: {{ $tema->color_primario ?? '#0d2137' }};
            --secondary-color: {{ $tema->color_secundario ?? '#c5a059' }};
            --accent-color: {{ $tema->color_acento ?? '#b8860b' }};
            --background-color: {{ $tema->color_fondo ?? '#fcfcfc' }};
            --text-color: {{ $tema->color_texto ?? '#1a1a1a' }};
            --navbar-bg: {{ $tema->color_navbar ?? '#ffffff' }};
            --shadow-sm: 0 2px 4px rgba(0,0,0,.05);
            --shadow-md: 0 4px 12px rgba(0,0,0,.08);
            --shadow-lg: 0 10px 15px -3px rgba(0,0,0,.1);
            --border-radius-sm: 8px;
            --border-radius-lg: 16px;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            background-color: var(--background-color);
            color: var(--text-color);
            font-size: {{ $tema->tamano_fuente ?? '16px' }};
            margin: 0;
            padding: 0;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Montserrat', sans-serif;
            letter-spacing: -0.025em;
        }
        
        .navbar {
            background-color: var(--navbar-bg, var(--primary-color)) !important;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-md);
            padding: 0 !important;
        }

        .navbar-brand {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            color: var(--text-color) !important;
            letter-spacing: -1px;
        }
        
        .nav-link {
            font-weight: 600;
            color: rgba(0, 0, 0, 0.8) !important;
            padding: 0.8rem 1.5rem !important;
            transition: all 0.3s ease;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }
        
        .nav-link:hover, .nav-link:focus {
            background-color: rgba(0, 0, 0, 0.05);
            color: var(--primary-color) !important;
            border-bottom: 2px solid var(--secondary-color);
        }

        .navbar-nav .nav-item.active .nav-link,
        .navbar-nav .nav-item:hover .nav-link {
            background-color: rgba(0, 0, 0, 0.03);
            color: var(--secondary-color) !important;
        }

        .btn {
            border-radius: var(--border-radius-sm);
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            box-shadow: 0 4px 6px rgba(13, 33, 55, 0.2);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(13, 33, 55, 0.3);
        }
        
        .card {
            border: none;
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-md);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }
        
        .footer {
            background-color: #0a192f;
            color: #e2e8f0;
            padding: 50px 0 30px;
            margin-top: 0;
        }
        
        .footer h5 {
            color: var(--secondary-color);
            font-weight: 800;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 0.1em;
            margin-bottom: 1.5rem;
        }
        
        .footer a {
            color: #adb5bd;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer a:hover {
            color: var(--primary-color);
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            background-color: {{ $tema->color_navbar ?? '#e8f5e9' }};
        }
        
        .dropdown-item {
            padding: 10px 20px;
            transition: all 0.3s ease;
            color: rgba(0, 0, 0, 0.8);
        }
        
        .dropdown-item:hover, .dropdown-item:focus {
            background-color: rgba(0, 0, 0, 0.05);
            color: var(--secondary-color) !important;
            padding-left: 25px; /* Efecto sutil de desplazamiento */
        }
        
        .dropdown-item i {
            width: 20px;
            text-align: center;
        }
        
        .dropdown-menu .dropdown-item:active {
            background-color: var(--secondary-color);
            color: white;
        }
        
        .logo-header {
            background-color: var(--navbar-bg);
            padding: 10px 0;
            border-bottom: 2px solid var(--secondary-color);
        }
        
        .logo-header .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .logo-link {
            display: inline-flex;
            align-items: center;
            text-decoration: none;
            flex-shrink: 0;
        }
        
        .logo-header img.logo-colegio {
            max-height: 90px;
            width: auto;
            height: auto;
            object-fit: contain;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }
        
        .logo-fallback {
            display: none;
            align-items: center;
            color: var(--text-color);
            font-size: 1.1rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        
        /* Header Brand - Logo + TÃ­tulo */
        .header-brand {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-shrink: 0;
        }
        
        .header-titulo {
            font-weight: 700;
            letter-spacing: 0.5px;
            line-height: 1.2;
            text-transform: uppercase;
        }
        
        @media (max-width: 768px) {
            .header-brand {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }
            
            .header-titulo {
                font-size: 14px !important;
            }
        }
        
        /* Estilos para Accesos Directos en Header - DiseÃ±o Minimalista */
        .accesos-directos {
            display: flex;
            align-items: center;
            gap: 0;
        }
        
        .acceso-directo-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 8px 16px;
            text-decoration: none;
            color: var(--text-color);
            font-size: 0.7rem;
            font-weight: 500;
            text-align: center;
            transition: all 0.2s ease;
            position: relative;
            min-width: 70px;
        }
        
        .acceso-directo-item::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: var(--primary-color);
            transition: width 0.2s ease;
        }
        
        .acceso-directo-item:hover::after {
            width: 80%;
        }
        
        .acceso-directo-item:hover {
            color: var(--primary-color);
        }
        
        .acceso-directo-item i {
            margin-bottom: 4px;
            transition: transform 0.2s ease;
        }
        
        .acceso-directo-item:hover i {
            transform: scale(1.1);
        }
        
        .acceso-directo-item .acceso-directo-img {
            width: auto !important;
            max-width: none;
            max-height: none;
            margin-bottom: 4px;
            object-fit: contain;
            transition: transform 0.2s ease;
        }
        
        .acceso-directo-item:hover .acceso-directo-img {
            transform: scale(1.05);
        }
        
        .acceso-directo-item span {
            white-space: nowrap;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            font-size: 0.65rem;
            opacity: 0.85;
        }
        
        .acceso-directo-item:hover span {
            opacity: 1;
        }
        
        /* Separador visual entre accesos */
        .acceso-directo-item:not(:last-child)::before {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 30px;
            width: 1px;
            background: rgba(0,0,0,0.08);
        }
        
        @media (max-width: 991px) {
            .logo-header .container {
                flex-direction: column;
                gap: 12px;
            }
            
            .logo-header img.logo-colegio {
                max-height: 60px;
            }
            
            .accesos-directos {
                width: 100%;
                justify-content: center;
                flex-wrap: wrap;
                gap: 0;
                border-top: 1px solid rgba(0,0,0,0.05);
                padding-top: 10px;
                margin-top: 5px;
            }
            
            .acceso-directo-item {
                padding: 8px 14px;
                min-width: 65px;
            }
            
            .acceso-directo-item:not(:last-child)::before {
                display: none;
            }
            
            .acceso-directo-item span {
                font-size: 0.6rem;
            }
        }
        
        @media (max-width: 576px) {
            .logo-header {
                padding: 4px 0;
            }
            
            .logo-header img.logo-colegio {
                max-height: 50px;
            }
            
            .accesos-directos {
                gap: 0;
            }
            
            .acceso-directo-item {
                padding: 4px 8px;
                min-width: 55px;
            }
            
            .acceso-directo-item i,
            .acceso-directo-item .acceso-directo-img {
                transform: scale(0.85) !important;
            }
            
            .acceso-directo-item span {
                font-size: 0.55rem;
            }
        }
        
        /* Ocultar accesos en pantallas muy pequeÃ±as si hay muchos */
        @media (max-width: 400px) {
            .acceso-directo-item {
                padding: 5px 8px;
                min-width: 50px;
            }
            
            .acceso-directo-item span {
                font-size: 0.5rem;
            }
        }
        
        /* Estilos Navbar DinÃ¡micos */
        .navbar {
            transition: all 0.3s ease;
            z-index: 1000;
        }
        
        .navbar.fixed-top {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
        }
        
        .navbar.sticky-top {
            position: -webkit-sticky !important;
            position: sticky !important;
            top: 0 !important;
            z-index: 1020 !important;
            background-color: var(--navbar-bg, #ffffff) !important;
        }
        
        /* Ajuste de padding-top cuando navbar es fixed o sticky */
        @php
            $navbarAltura = $tema->navbar_altura ?? 70;
            $logoHeaderAltura = 110; // Altura aproximada del logo header
            $alturaTotal = $navbarAltura;
            
            // Si el logo header estÃ¡ activado y existe imagen, sumar su altura
            $mostrarLogoHeaderCss = \App\Models\ConfiguracionSitio::obtener('mostrar_logo_header', '1') == '1';
            $logoHeader = \App\Models\ConfiguracionSitio::obtener('logo_header');
            if ($mostrarLogoHeaderCss && $logoHeader) {
                $alturaTotal += $logoHeaderAltura;
            }
            
            // Aplicar padding-top para fixed navbar
            if ($tema->estilo_navbar === 'fixed') {
                echo "main, .landing-page, .landing-page-dinamica { padding-top: {$alturaTotal}px; }";
                echo ".hero-banner-section { margin-top: -1px !important; }";
            }
            // Para sticky, eliminar cualquier gap
            elseif ($tema->estilo_navbar === 'sticky') {
                echo "main, .landing-page, .landing-page-dinamica { margin-top: 0; padding-top: 0; }";
                echo ".hero-banner-section { margin-top: -1px !important; position: relative; }";
            }
            // Para static, el banner debe empezar normalmente
            else {
                echo ".hero-banner-section { margin-top: 0; }";
            }
        @endphp
        
        /* Navbar transparente con blur */
        .navbar[style*="transparent"] {
            background: rgba(232, 245, 233, 0.8) !important;
        }
        
        .navbar[style*="transparent"] .navbar-nav .nav-link {
            color: rgba(0, 0, 0, 0.9) !important;
            font-weight: 500;
        }
        
        .navbar[style*="transparent"] .navbar-brand {
            color: rgba(0, 0, 0, 0.9) !important;
        }
        
        /* Navbar con altura personalizada */
        .navbar .navbar-brand,
        .navbar .navbar-nav {
            display: flex;
            align-items: center;
        }
        
        /* Espaciado entre elementos del menÃº */
        .navbar-nav .nav-item {
            margin: 0 5px;
        }
        
        .navbar-nav .nav-link {
            padding: 0.5rem 0.8rem;
            white-space: nowrap;
        }
        
        /* Responsive: reducir espaciado en pantallas medianas */
        @media (max-width: 1200px) {
            .navbar-nav .nav-item {
                margin: 0 2px;
            }
            .navbar-nav .nav-link {
                padding: 0.5rem 0.5rem;
                font-size: 0.9rem;
            }
        }
        
        @media (max-width: 991px) {
            /* MenÃº colapsado en mÃ³vil */
            .navbar-nav {
                padding: 1rem 0;
            }
            .navbar-nav .nav-item {
                margin: 0;
                border-bottom: 1px solid rgba(0,0,0,0.05);
            }
            .navbar-nav .nav-link {
                padding: 0.75rem 1rem;
            }
            .navbar-nav .dropdown-menu {
                border: none;
                padding-left: 1rem;
                background: transparent;
                box-shadow: none;
            }
        }
        
        @media (max-width: 768px) {
            .logo-header img {
                max-height: 60px;
            }
            .logo-header {
                padding: 4px 0;
            }
            
            /* Eliminamos el padding-top que causaba el espacio en blanco */
            body { padding-top: 0 !important; margin-top: 0 !important; }
            
            /* Aseguramos que el navbar sticky no deje huecos */
            .sticky-top { top: 0; }
        }
        
        /* Barra Superior (Top Bar) - Diseño Integrado con Intranet */
        .top-bar {
            background-color: #212529; /* Color Carbón Profesional como en Intranet */
            color: #ffffff;
            font-size: 0.75rem;
            padding: 6px 0;
            border-bottom: 2px solid var(--secondary-color);
        }
        
        .top-bar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .top-bar-lema {
            font-weight: 500;
            letter-spacing: 0.025em;
            color: #ffffff;
            font-style: italic;
            display: flex;
            align-items: center;
        }
        
        .top-bar-lema::before {
            content: '';
            display: inline-block;
            width: 3px;
            height: 14px;
            background: var(--secondary-color);
            margin-right: 10px;
            border-radius: 2px;
        }
        
        .top-bar-links {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .top-bar-links a {
            color: #ffffff;
            text-decoration: none;
            padding: 4px 10px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 4px;
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            transition: all 0.2s ease;
        }
        
        .top-bar-links a:hover {
            background: var(--secondary-color);
            border-color: var(--secondary-color);
            color: #212529;
            transform: translateY(-1px);
        }
        
        .top-bar-links a i {
            margin-right: 5px;
        }
        
        .top-bar-links a .top-bar-img {
            width: auto !important;
            max-width: 100px;
            margin-right: 5px;
            vertical-align: middle;
            object-fit: contain;
        }
        

        /* Redes Sociales en Top Bar */
        .top-bar-right {
            display: flex;
            align-items: center;
        }

        .top-bar-social {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-left: 15px;
            padding-left: 15px;
            border-left: 1px solid rgba(255,255,255,0.2);
        }

        .top-bar-social a {
            color: rgba(255,255,255,0.8);
            transition: all 0.2s ease;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .top-bar-social a:hover {
            color: var(--secondary-color);
            transform: translateY(-1px);
        }
        
        @media (max-width: 1200px) {
            .top-bar-contact {
                display: none;
            }
            .top-bar-separator {
                display: none;
            }
        }
        
        @media (max-width: 991px) {
            .top-bar-content {
                flex-wrap: wrap;
                justify-content: center;
                gap: 8px;
                padding: 8px 0;
            }
            .top-bar-lema {
                width: 100%;
                justify-content: center;
                text-align: center;
                font-size: 12px !important;
            }
            .top-bar-right {
                width: 100%;
                justify-content: center;
            }
            .top-bar-links a {
                font-size: 11px;
                padding: 0 8px;
            }
        }
        
        @media (max-width: 768px) {
            .top-bar-content {
                gap: 4px;
                padding: 6px 0;
            }
            
            .top-bar-lema {
                font-size: 11px !important;
            }
            
            .top-bar-links a {
                padding: 0 6px;
                font-size: 10px;
            }
        }

        /* Marcos de imagen: noticias y proyectos con tamaÃ±os proporcionados */
        .marco-img-card {
            height: 160px;
            overflow: hidden;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .marco-img-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }
        .marco-img-proyecto-card {
            height: 160px;
            overflow: hidden;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .marco-img-proyecto-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }
        .marco-img-carrusel {
            height: 280px;
            overflow: hidden;
            background-color: #e9ecef;
        }
        .marco-img-carrusel img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }
        .marco-img-lista {
            height: 100px;
            overflow: hidden;
            background-color: #e9ecef;
        }
        .marco-img-lista img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }
        .marco-img-detalle {
            max-height: 320px;
            height: 320px;
            overflow: hidden;
            background-color: #e9ecef;
        }
        .marco-img-detalle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }
        .marco-img-galeria {
            height: 160px;
            overflow: hidden;
        }
        .marco-img-galeria img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }
        /* En mÃ³vil, imÃ¡genes un poco mÃ¡s bajas para mejor proporciÃ³n */
        @media (max-width: 576px) {
            .marco-img-card,
            .marco-img-proyecto-card {
                height: 140px;
            }
            .marco-img-carrusel {
                height: 220px;
            }
            .marco-img-lista {
                height: 88px;
            }
            .marco-img-detalle {
                height: 240px;
                max-height: 240px;
            }
            .marco-img-galeria {
                height: 140px;
            }
        }

        /* Barra Pre-Footer */
        .footer-bar-container {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 12px;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }
        .footer-bar-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 8px;
            transition: transform 0.3s ease, background-color 0.3s ease;
            border-radius: 8px;
            min-width: 80px;
        }
        .footer-bar-item:hover {
            transform: translateY(-5px);
            background-color: rgba(0,0,0,0.03);
        }
        .footer-bar-item img, .footer-bar-item i {
            transition: filter 0.3s ease;
        }
        .footer-bar-item:hover img, .footer-bar-item:hover i {
            filter: brightness(1.1);
        }
        /* =========================================
           DISEÑO ELEGANTE PARA EL TOP BAR
        ========================================= */
        .elegant-topbar {
            background-color: #111827; /* Fondo oscuro elegante */
            color: #d1d5db;
            border-bottom: 1px solid #374151; /* Borde inferior sutil */
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }
        
        .elegant-topbar .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }
        
        .elegant-topbar .top-bar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            min-height: 42px; /* Altura delgada y formal */
        }
        
        /* --- Lema --- */
        .elegant-topbar .top-bar-lema {
            font-style: italic; /* Le da un toque clásico */
            color: #9ca3af;
            letter-spacing: 0.5px;
        }
        
        /* --- Lado Derecho (Contenedor) --- */
        .elegant-topbar .top-bar-right {
            display: flex;
            align-items: center;
        }
        
        /* --- Enlaces --- */
        .elegant-topbar .top-bar-links {
            display: flex;
            align-items: center;
        }
        
        .elegant-topbar .top-bar-links a {
            display: flex;
            align-items: center;
            color: #e5e7eb;
            text-decoration: none;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase; /* Mayúsculas para más formalidad */
            letter-spacing: 1.2px;
            padding: 0 15px;
            position: relative;
            transition: color 0.3s ease;
        }
        
        /* Iconos e imágenes dentro de los enlaces */
        .elegant-topbar .top-bar-links i,
        .elegant-topbar .top-bar-img {
            margin-right: 8px;
            opacity: 0.85;
        }
        
        /* Separadores delicados entre enlaces */
        .elegant-topbar .top-bar-links a:not(:last-child)::after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 12px;
            width: 1px;
            background-color: #4b5563;
        }
        
        /* Hover de los enlaces (Color champán/dorado) */
        .elegant-topbar .top-bar-links a:hover,
        .elegant-topbar .top-bar-links a:hover i {
            color: #d4af37; 
            opacity: 1;
        }
        
        /* --- Redes Sociales --- */
        .elegant-topbar .top-bar-social {
            display: flex;
            align-items: center;
            gap: 15px;
            padding-left: 20px;
            margin-left: 5px;
            border-left: 1px solid #4b5563; /* Línea que separa links de redes sociales */
        }
        
        .elegant-topbar .top-bar-social a {
            color: #9ca3af;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        .elegant-topbar .top-bar-social a:hover {
            color: #d4af37; /* Color champán/dorado */
            transform: translateY(-2px); /* Pequeña elevación muy sutil al pasar el mouse */
        }
        
        /* --- Adaptación a móviles (Responsive) --- */
        @media (max-width: 768px) {
            .elegant-topbar .top-bar-content {
                flex-direction: column;
                justify-content: center;
                padding: 10px 0;
                gap: 10px;
            }
            
            .elegant-topbar .top-bar-links a {
                padding: 0 10px;
            }
            
            .elegant-topbar .top-bar-social {
                padding-left: 0;
                margin-left: 0;
                border-left: none;
            }
        }
        
        
        /* =========================================
           ESTILOS NAVBAR - CORPORATIVO Y ELEGANTE
           ========================================= */
        
        /* Contenedor Principal */
        .navbar-custom-elegant {
            background-color: #ffffff; 
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.04); 
            border-bottom: 3px solid var(--primary-color, #2563eb); /* Línea corporativa inferior del color de tu marca */
            font-family: 'Inter', 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }
        
        /* Enlaces Principales */
        .navbar-custom-elegant .nav-link {
            color: #4b5563 !important; /* Gris oscuro elegante */
            font-weight: 600;
            font-size: 13.5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 18px 22px !important;
            transition: all 0.3s ease;
        }
        
        /* 
           SEPARADORES VERTICALES entre menús principales 
           (Solo se ven en computadora)
        */
        @media (min-width: 992px) {
            .navbar-custom-elegant .navbar-nav .nav-item {
                position: relative;
            }
            
            /* Agrega la línea divisoria después de cada ítem (excepto el último) */
            .navbar-custom-elegant .navbar-nav .nav-item:not(:last-child)::after {
                content: '';
                position: absolute;
                right: 0;
                top: 10%;
                height: 80%;
                width: 2px;
                background-color: #e5e7eb; 
            }
        }
        
        /* Efecto Hover Enlaces Principales (Fondo muy sutil) */
        .navbar-custom-elegant .nav-link:hover,
        .navbar-custom-elegant .nav-item.show .nav-link {
            color: var(--primary-color, #2563eb) !important;
            background-color: rgba(0, 0, 0, 0.02);
        }
        
        /* =========================================
           ESTILOS DEL MENÚ DESPLEGABLE (Restaurado Bootstrap)
           ========================================= */
        
        .navbar-custom-elegant .dropdown-menu {
            border: 1px solid #f3f4f6;
            border-radius: 0 0 8px 8px; /* Cuadrado arriba, redondeado abajo */
            padding: 0; /* Sin padding para que las líneas divisorias cubran todo el ancho */
            margin-top: 0;
            min-width: 250px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important;
            background-color: #ffffff;
            
            /* Animación suave cuando Bootstrap le agrega la clase .show al hacer clic */
            animation: slideDownFade 0.3s ease forwards;
        }
        
        /* Animación personalizada */
        @keyframes slideDownFade {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Enlaces dentro del Desplegable */
        .navbar-custom-elegant .dropdown-item {
            font-weight: 500;
            font-size: 14px;
            color: #374151;
            padding: 12px 20px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #f3f4f6; /* SEPARADORES HORIZONTALES */
        }
        
        /* Quitar la línea al último elemento del submenú */
        .navbar-custom-elegant li:last-child > .dropdown-item {
            border-bottom: none;
        }
        
        /* Efecto hover en el ítem del dropdown (deslizamiento más notorio) */
        .navbar-custom-elegant .dropdown-item:hover,
        .navbar-custom-elegant .dropdown-item:focus {
            background-color: #f8fafc; 
            color: var(--primary-color, #2563eb);
            padding-left: 28px; /* Empuja el texto a la derecha con el mouse */
        }
        
        /* Personalización de los íconos dentro del desplegable */
        .navbar-custom-elegant .dropdown-item i {
            color: var(--primary-color, #2563eb) !important;
            font-size: 16px;
        }
        
        /* Diseño del botón menú hamburguesa (Móviles) */
        .navbar-custom-elegant .navbar-toggler {
            border: 1px solid #e5e7eb !important;
            padding: 8px 12px;
            border-radius: 6px;
        }
        
        .navbar-custom-elegant .navbar-toggler:focus {
            box-shadow: none; 
        }
        
        /* ===================================================
           DESKTOPS (Pantallas de 992px a más)
           =================================================== */
        @media (min-width: 992px) {
            .dropdown-submenu {
                position: relative;
            }
        
            .dropdown-submenu .dropdown-submenu-menu {
                top: 0;
                left: 100%;
                margin-top: -1px;
                display: none;
            }
        
            /* Hover en PC */
            .dropdown-submenu:hover > .dropdown-submenu-menu {
                display: block;
            }
        }
        
        /* ===================================================
           MÓVILES Y TABLETS (Pantallas menores a 992px)
           =================================================== */
        @media (max-width: 991.98px) {
            /* Muestra los submenús en cascada identados */
            .dropdown-submenu .dropdown-submenu-menu {
                position: static !important;
                float: none;
                display: none; /* Controlado por JS en mobile */
                margin-left: 1rem;
                margin-right: 0.5rem;
                border-left: 2px solid #1b5e20 !important; /* Línea guía verde visual */
                border-radius: 0;
                background-color: rgba(0, 0, 0, 0.02);
                box-shadow: none !important;
            }
        
            .dropdown-submenu .dropdown-submenu-menu.show {
                display: block !important;
            }
        
            .dropdown-submenu > a.dropdown-toggle::after {
                transition: transform 0.2s ease;
            }
        
            .dropdown-submenu.show > a.dropdown-toggle::after {
                transform: rotate(90deg); /* Rota la flechita cuando se abre */
            }
        }
    </style>
    
    @yield('styles')
</head>
    <body class="p-0 m-0">
@php
    $topBarActiva = \App\Models\ConfiguracionSitio::obtener('barra_superior_activa', '1');
    $topBarActiva = ($topBarActiva === '1' || $topBarActiva === 1 || $topBarActiva === true || $topBarActiva === 'true');
@endphp@if($topBarActiva)@php
    $topBarItems = \App\Models\AccesoDirecto::paraBarraSuperior();
    $topBarLema = $topBarItems->firstWhere('tipo', 'lema');
    $topBarEnlaces = $topBarItems->whereNotIn('tipo', ['lema', 'red_social']);
    $socialLinks = \App\Models\AccesoDirecto::where('tipo', 'red_social')->where('activo', true)->orderBy('orden')->get();
@endphp<div class="top-bar elegant-topbar">
    <div class="container">
        <div class="top-bar-content">
            
            {{-- Lema a la izquierda --}}
            @if($topBarLema)
            <div class="top-bar-lema" style="font-family: {{ $topBarLema->fuente_familia ?? 'inherit' }}; font-size: {{ $topBarLema->fuente_tamano ?? 13 }}px;">
                {{ $topBarLema->titulo }}
            </div>
            @endif
            
            {{-- Derecha: Enlaces + Redes Sociales --}}
            <div class="top-bar-right">
                <div class="top-bar-links">
                    @if($topBarEnlaces->count() > 0)
                        @foreach($topBarEnlaces as $enlace)
                        <a href="{{ $enlace->url_final }}" target="{{ $enlace->target }}">
                            @if($enlace->tieneImagen())
                                <img src="{{ $enlace->imagen_url }}" alt="{{ $enlace->titulo }}" class="top-bar-img" style="height: {{ $enlace->imagen_alto ?? 16 }}px !important;">
                            @elseif($enlace->icono)
                                <i class="{{ $enlace->icono }}" style="font-size: {{ $enlace->imagen_alto ?? 16 }}px !important;"></i>
                            @endif
                            <span>{{ $enlace->titulo }}</span>
                        </a>
                        @endforeach
                    @endif
                </div>
                
                <div class="top-bar-social">
                    @foreach($socialLinks->where('mostrar_en_barra_superior', true) as $social)
                        <a href="{{ $social->url_final }}" target="_blank" title="{{ $social->titulo }}">
                            <i class="{{ $social->icono }}"></i>
                        </a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>
    @endif

    {{-- Header con Logo (Configurable) --}}
    @php
        $mostrarLogoHeaderVal = \App\Models\ConfiguracionSitio::obtener('mostrar_logo_header', '1');
        $mostrarLogoHeader = ($mostrarLogoHeaderVal === '1' || $mostrarLogoHeaderVal === 1 || $mostrarLogoHeaderVal === true || $mostrarLogoHeaderVal === 'true');
        $mostrarHeaderAccesosTema = $tema->mostrar_header_accesos ?? true;
    @endphp
    
    @if($mostrarLogoHeader && $mostrarHeaderAccesosTema)
    <div class="logo-header">
        <div class="container">
            {{-- TÃ­tulo/Nombre del sitio --}}
            <div class="header-brand">
                @php
                    $logoHeader = \App\Models\ConfiguracionSitio::obtener('logo_header');
                    $accesosDirectos = \App\Models\AccesoDirecto::paraHeader();
                    $tituloHeader = $accesosDirectos->firstWhere('tipo', 'titulo');
                    $enlacesHeader = $accesosDirectos->whereNotIn('tipo', ['titulo', 'red_social']);
                @endphp
                
                @if($logoHeader)
                <a href="{{ route('public.index') }}" class="logo-link">
                    <img src="{{ asset(ltrim($logoHeader, '/')) }}" alt="{{ \App\Models\ConfiguracionSitio::obtener('nombre_sitio') }}" class="logo-colegio">
                </a>
                @endif

                @if($tituloHeader)
                <div class="header-titulo" style="font-size: {{ $tituloHeader->fuente_tamano ?? 18 }}px; font-family: {{ $tituloHeader->fuente_familia ?? 'inherit' }}; color: {{ $tituloHeader->color ?? 'inherit' }};">
                    {{ $tituloHeader->titulo }}
                </div>
                @endif
            </div>
            
            {{-- Accesos Directos (solo enlaces, sin tÃ­tulos) --}}
            @if($enlacesHeader->count() > 0)
            <nav class="accesos-directos">
                @foreach($enlacesHeader as $acceso)
                <a href="{{ $acceso->url_final }}" 
                   target="{{ $acceso->target }}" 
                   class="acceso-directo-item"
                   title="{{ $acceso->descripcion ?? $acceso->titulo }}">
                    @if($acceso->tieneImagen())
                        <img src="{{ $acceso->imagen_url }}" alt="{{ $acceso->titulo }}" class="acceso-directo-img" style="height: {{ $acceso->imagen_alto ?? 28 }}px !important;">
                    @elseif($acceso->icono)
                        <i class="{{ $acceso->icono }}" style="color: {{ $acceso->color }}; font-size: {{ $acceso->imagen_alto ?? 28 }}px !important;"></i>
                    @endif
                    <span>{{ $acceso->titulo }}</span>
                </a>
                @endforeach
            </nav>
            @endif
        </div>
    </div>
    @endif

    {{-- Navbar --}}
    @php
        $mostrarNavbarVal = \App\Models\ConfiguracionSitio::obtener('mostrar_navbar', '1');
        $mostrarNavbar = ($mostrarNavbarVal === '1' || $mostrarNavbarVal === 1 || $mostrarNavbarVal === true || $mostrarNavbarVal === 'true');
        
        // Determinar clase de posición - Siempre usamos sticky-top para que se mantenga arriba
        $navbarPositionClass = 'sticky-top'; 
        
        // Altura de navbar
        $navbarAltura = $tema->navbar_altura ?? 70;
        
        // Estilos de navbar
        $navbarStyles = [
            'background-color: ' . ($tema->color_navbar ?? '#ffffff'),
            'min-height: ' . $navbarAltura . 'px',
            'height: auto',
        ];
        
        $navbarStyleString = implode('; ', $navbarStyles);
    @endphp
    
    @if($mostrarNavbar)
    <nav id="mainNavbar" class="navbar navbar-expand-lg navbar-light navbar-custom-elegant {{ $navbarPositionClass }}" style="{{ $navbarStyleString }};">
        <div class="container" style="min-height: {{ $navbarAltura }}px; display: flex; align-items: center;">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('public.index') }}">
            @php
                $logoNavbar = \App\Models\ConfiguracionSitio::obtener('logo_navbar');
                $nombreSitio = \App\Models\ConfiguracionSitio::obtener('nombre_sitio', 'Colegio de Notarios');
                
                $logoNavbarUrl = null;
                if ($logoNavbar) {
                    if (filter_var($logoNavbar, FILTER_VALIDATE_URL)) {
                        $logoNavbarUrl = $logoNavbar;
                    } else {
                        $logoNavbarUrl = asset(ltrim($logoNavbar, '/'));
                    }
                }
            @endphp
            
            @if($logoNavbarUrl)
                <img src="{{ $logoNavbarUrl }}" 
                     alt="{{ $nombreSitio }}" 
                     class="navbar-logo me-2"
                     style="max-height: 48px; width: auto; object-fit: contain;"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-block';">
            @endif
            <i class="fas fa-balance-scale me-2" style="color: var(--primary-color); {{ $logoNavbarUrl ? 'display:none;' : '' }}"></i>
            <span class="d-none">{{ $nombreSitio }}</span>
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @foreach(\App\Models\Menu::where('ubicacion', 'principal')->where('activo', true)->whereNull('parent_id')->orderBy('orden')->orderBy('id')->get() as $menu)
                        @php
                            $hijos = \App\Models\Menu::where('parent_id', $menu->id)->where('activo', true)->orderBy('orden')->get();
                            $tieneHijos = $hijos->count() > 0;
                        @endphp
                        
                        <li class="nav-item {{ $tieneHijos ? 'dropdown' : '' }}">
                            @if($tieneHijos)
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown{{ $menu->id }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    @if($menu->icono) <i class="{{ $menu->icono }} me-1"></i> @endif
                                    {{ $menu->nombre }}
                                </a>
                                
                                <ul class="dropdown-menu border-0 shadow-lg" aria-labelledby="navbarDropdown{{ $menu->id }}">
                                    @foreach($hijos as $submenu)
                                        @php
                                            $nietos = \App\Models\Menu::where('parent_id', $submenu->id)->where('activo', true)->orderBy('orden')->get();
                                            $tieneNietos = $nietos->count() > 0;
                                        @endphp
                                        
                                        <li class="{{ $tieneNietos ? 'dropdown-submenu position-relative' : '' }}">
                                            <a class="dropdown-item {{ $tieneNietos ? 'dropdown-toggle d-flex justify-content-between align-items-center' : '' }}" 
                                               href="{{ $tieneNietos ? '#' : $submenu->url_final }}"
                                               @if($tieneNietos) data-bs-toggle="dropdown-submenu" role="button" aria-expanded="false" @endif>
                                                <span>
                                                    @if($submenu->icono) <i class="{{ $submenu->icono }} me-2 text-muted"></i> @endif
                                                    {{ $submenu->nombre }}
                                                </span>
                                            </a>
            
                                            {{-- TERCER NIVEL --}}
                                            @if($tieneNietos)
                                                <ul class="dropdown-menu dropdown-submenu-menu border-0 shadow-sm">
                                                    @foreach($nietos as $nieto)
                                                        <li>
                                                            <a class="dropdown-item" href="{{ $nieto->url_final }}">
                                                                @if($nieto->icono) <i class="{{ $nieto->icono }} me-2 text-muted"></i> @endif
                                                                {{ $nieto->nombre }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <a class="nav-link" href="{{ $menu->url_final }}">
                                    @if($menu->icono) <i class="{{ $menu->icono }} me-1"></i> @endif
                                    {{ $menu->nombre }}
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>
    @endif

    {{-- Contenido Principal --}}
    <main style="overflow-x: hidden;">
        @yield('content')
    </main>

    {{-- Footer --}}
    @php
        $mostrarFooterTema = $tema->mostrar_footer ?? true;
    @endphp
    
    @if($mostrarFooterTema)
        {{-- Barra Pre-Footer Premium (Iconos con enlaces) --}}
        @php
            $footerBarActiva = (bool) \App\Models\ConfiguracionSitio::obtener('mostrar_footer_bar', true);
            $footerBarItems = \App\Models\AccesoDirecto::paraFooter()->where('tipo', '!=', 'red_social');
            // Solo activar si no se ha renderizado ya como widget
            $yaRenderizado = isset($GLOBALS['prefooter_rendered']) && $GLOBALS['prefooter_rendered'];
        @endphp
    
        @if($footerBarActiva && $footerBarItems->count() > 0 && !$yaRenderizado)
        <div class="container position-relative" style="z-index: 10; margin-bottom: -40px;">
            <div class="row justify-content-center">
                <div class="col-11 col-lg-12">
                    <div class="elegant-prefooter shadow bg-white" style="border-radius: 16px; padding: 25px 30px; border: 1px solid #f3f4f6;">
                        <div class="d-flex flex-wrap justify-content-center align-items-center gap-4 gap-md-5">
                            @foreach($footerBarItems as $item)
                            <a href="{{ $item->url_final }}" 
                               target="{{ $item->target }}" 
                               class="elegant-partner-item text-decoration-none"
                               title="{{ $item->descripcion ?? $item->titulo }}">
                                @if($item->tieneImagen())
                                    <img src="{{ $item->imagen_url }}" alt="{{ $item->titulo }}" class="partner-img" style="height: {{ $item->imagen_alto ?? 50 }}px; width: auto; max-width: 180px; object-fit: contain;">
                                @elseif($item->icono)
                                    <i class="{{ $item->icono }} partner-icon" style="font-size: {{ $item->imagen_alto ?? 40 }}px; color: {{ $item->color ?? '#6b7280' }};"></i>
                                @endif
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    
        {{-- Footer Corporativo Oscuro --}}
        <footer class="elegant-footer position-relative" style="background-color: #111827; color: #9ca3af; {{ $footerBarActiva && $footerBarItems->count() > 0 ? 'padding-top: 80px;' : 'padding-top: 60px; margin-top: 2rem;' }}">
            
            {{-- Línea de gradiente superior --}}
            <div class="position-absolute top-0 start-0 w-100" style="height: 4px; background: linear-gradient(90deg, var(--primary-color, #2563eb), #60a5fa, var(--primary-color, #2563eb));"></div>
    
            <div class="container pb-5">
                <div class="row g-5">
                    {{-- Columna 1: Info --}}
                    <div class="col-lg-4 mb-4 mb-lg-0">
                        <h4 class="text-white fw-bold mb-3" style="letter-spacing: 0.5px;">
                            {{ \App\Models\ConfiguracionSitio::obtener('nombre_sitio', 'Colegio de Notarios') }}
                        </h4>
                        <p class="mb-4" style="line-height: 1.7; font-size: 0.95rem;">
                            {{ \App\Models\ConfiguracionSitio::obtener('descripcion_sitio', 'Portal oficial del Colegio de Notarios') }}
                        </p>
                        <div class="d-flex gap-2">
                            @foreach($socialLinks->where('mostrar_en_footer', true) as $social)
                                <a href="{{ $social->url_final }}" class="elegant-social-btn d-flex align-items-center justify-content-center" target="_blank" aria-label="Social Link">
                                    <i class="{{ $social->icono }}"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>
    
                    {{-- Columna 2: Enlaces Rápidos --}}
                    <div class="col-lg-2 col-md-6 mb-4 mb-md-0">
                        <h5 class="text-white fw-bold mb-4 position-relative footer-heading">Enlaces</h5>
                        <ul class="list-unstyled mb-0">
                            @foreach(\App\Models\Menu::where('ubicacion', 'footer')->where('activo', true)->orderBy('orden')->get() as $menu)
                                <li class="mb-3">
                                    <a href="{{ $menu->url_final }}" class="elegant-footer-link d-inline-flex align-items-center text-decoration-none">
                                        <i class="{{ $menu->icono ?? 'fas fa-chevron-right' }} me-2 footer-link-icon"></i>
                                        <span>{{ $menu->nombre }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
    
                    {{-- Columna 3: Contacto --}}
                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                        <h5 class="text-white fw-bold mb-4 position-relative footer-heading">Contacto</h5>
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex align-items-start mb-3">
                                <i class="fas fa-envelope mt-1 me-3 footer-accent-icon"></i>
                                <span style="font-size: 0.95rem;">{{ \App\Models\ConfiguracionSitio::obtener('email_contacto', 'contacto@cnotarios.org.pe') }}</span>
                            </li>
                            <li class="d-flex align-items-start mb-3">
                                <i class="fas fa-phone mt-1 me-3 footer-accent-icon"></i>
                                <span style="font-size: 0.95rem;">{{ \App\Models\ConfiguracionSitio::obtener('telefono_contacto', '+51 52 411030') }}</span>
                            </li>
                            <li class="d-flex align-items-start">
                                <i class="fas fa-map-marker-alt mt-1 me-3 footer-accent-icon"></i>
                                <span style="font-size: 0.95rem;">{{ \App\Models\ConfiguracionSitio::obtener('direccion_contacto', 'Av. Hipólito Unanue N° 543, Tacna, Perú') }}</span>
                            </li>
                        </ul>
                    </div>
    
                    {{-- Columna 4: Horario --}}
                    <div class="col-lg-3 col-md-12">
                        <h5 class="text-white fw-bold mb-4 position-relative footer-heading">Horario</h5>
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex align-items-start mb-3 rounded p-2" >
                                <i class="fas fa-clock mt-1 me-3 footer-accent-icon"></i>
                                <span style="font-size: 0.95rem;">{{ \App\Models\ConfiguracionSitio::obtener('horario_atencion', 'Lunes a Viernes: 8:00 AM - 5:00 PM') }}</span>
                            </li>
                            @if(\App\Models\ConfiguracionSitio::obtener('horario_sabados'))
                            <li class="d-flex align-items-start mb-3 rounded p-2" ">
                                <i class="fas fa-clock mt-1 me-3 footer-accent-icon"></i>
                                <span style="font-size: 0.95rem;">{{ \App\Models\ConfiguracionSitio::obtener('horario_sabados') }}</span>
                            </li>
                            @endif
                            <li class="d-flex align-items-start mt-3">
                                <i class="fas fa-door-closed mt-1 me-3 text-danger"></i>
                                <span class="text-muted" style="font-size: 0.85rem;">{{ \App\Models\ConfiguracionSitio::obtener('horario_cerrado', 'Sábados, domingos y feriados: Cerrado') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
    
            {{-- Barra de Copyright --}}
            <div class="footer-bottom py-4" style="background-color: #030712; border-top: 1px solid rgba(255,255,255,0.05);">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            <p class="mb-0" style="font-size: 0.9rem;">
                                &copy; {{ date('Y') }} <span class="text-white fw-medium">{{ \App\Models\ConfiguracionSitio::obtener('nombre_sitio', 'Colegio de Notarios') }}</span>. Todos los derechos reservados.
                            </p>
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <p class="mb-0 text-muted" style="font-size: 0.85rem;">
                                Diseñado con altos estándares de seguridad y confianza.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    
        <style>
            /* Estilos del Pre-footer (Marcas / Enlaces Rápidos) */
            .elegant-partner-item .partner-img,
            .elegant-partner-item .partner-icon {
                transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
                opacity: 0.6;
                filter: grayscale(100%);
            }
            
            .elegant-partner-item:hover .partner-img,
            .elegant-partner-item:hover .partner-icon {
                opacity: 1;
                filter: grayscale(0%);
                transform: scale(1.1);
            }
    
            /* Títulos del Footer */
            .footer-heading::after {
                content: '';
                position: absolute;
                left: 0;
                bottom: -10px;
                width: 30px;
                height: 2px;
                background-color: var(--primary-color, #2563eb);
                border-radius: 2px;
            }
    
            /* Enlaces del Footer */
            .elegant-footer-link {
                color: #9ca3af;
                transition: all 0.3s ease;
            }
            
            .elegant-footer-link .footer-link-icon {
                font-size: 0.7rem;
                color: var(--primary-color, #2563eb);
                transition: transform 0.3s ease;
            }
    
            .elegant-footer-link:hover {
                color: #ffffff;
                transform: translateX(5px);
            }
    
            .elegant-footer-link:hover .footer-link-icon {
                transform: translateX(3px);
            }
    
            /* Botones Sociales */
            .elegant-social-btn {
                width: 38px;
                height: 38px;
                border-radius: 50%;
                background-color: rgba(255, 255, 255, 0.05);
                color: #9ca3af;
                border: 1px solid rgba(255, 255, 255, 0.1);
                transition: all 0.3s ease;
            }
    
            .elegant-social-btn:hover {
                background-color: var(--primary-color, #2563eb);
                color: #ffffff;
                border-color: var(--primary-color, #2563eb);
                transform: translateY(-3px);
                box-shadow: 0 5px 15px rgba(37, 99, 235, 0.4);
            }
    
            /* Íconos de Acento (Contacto / Horario) */
            .footer-accent-icon {
                color: var(--primary-color, #3b82f6);
                font-size: 1.1rem;
            }
        </style>
    @endif

    {{-- Modales (para evitar problemas de backdrop) --}}
    @yield('modals')

    {{-- JavaScript --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    $(document).ready(function() {
        /**
         * Efecto de Scroll en el Navbar
         */
        const navbar = $('#mainNavbar');
        const scrollThreshold = 50;

        function handleScroll() {
            if ($(window).scrollTop() > scrollThreshold) {
                navbar.addClass('navbar-scrolled shadow-lg');
                navbar.css({
                    'padding': '0',
                    'background-color': 'rgba(255, 255, 255, 0.95)',
                    'backdrop-filter': 'blur(10px)',
                    '-webkit-backdrop-filter': 'blur(10px)'
                });
            } else {
                navbar.removeClass('navbar-scrolled shadow-lg');
                navbar.css({
                    'padding': '0',
                    'background-color': '{{ $tema->color_navbar ?? "#ffffff" }}',
                    'backdrop-filter': 'none',
                    '-webkit-backdrop-filter': 'none'
                });
            }
        }

        $(window).scroll(handleScroll);
        handleScroll(); // Ejecutar al inicio por si ya hay scroll

        // Limpieza de seguridad para backdrops huérfanos
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open').css('overflow', '');
    });
    
    
    document.addEventListener('DOMContentLoaded', function () {
        // Detectar toques en submenús de nivel 2 con subcategorías
        document.querySelectorAll('[data-bs-toggle="dropdown-submenu"]').forEach(function (element) {
            element.addEventListener('click', function (e) {
                // Solo actuar en pantallas móviles (menores a 992px)
                if (window.innerWidth < 992) {
                    e.preventDefault();
                    e.stopPropagation();
    
                    let parentLi = this.closest('.dropdown-submenu');
                    let subMenu = parentLi.querySelector('.dropdown-submenu-menu');
    
                    if (subMenu) {
                        // Cerrar otros submenús hermanos abiertos
                        let siblingSubmenus = parentLi.parentElement.querySelectorAll('.dropdown-submenu-menu');
                        siblingSubmenus.forEach(function (otherSub) {
                            if (otherSub !== subMenu) {
                                otherSub.classList.remove('show');
                                otherSub.closest('.dropdown-submenu').classList.remove('show');
                            }
                        });
    
                        // Alternar menú actual (Open/Close)
                        subMenu.classList.toggle('show');
                        parentLi.classList.toggle('show');
                    }
                }
            });
        });
    });
    </script>
    
    {{-- ============================================= --}}
    {{-- MODAL DE ANIVERSARIO - CARRUSEL CONFIGURABLE --}}
    {{-- ============================================= --}}
    
    <!-- MODAL_ANIVERSARIO_INICIO -->
    
    @php
        try {
            $modalActivo = \App\Models\ConfiguracionSitio::obtenerValor('modal_aniversario_activo', '1');
            $modalActivo = $modalActivo === true || $modalActivo === '1' || $modalActivo === 1;
            $modalMostrarBoton = \App\Models\ConfiguracionSitio::obtenerValor('modal_aniversario_mostrar_boton', '1');
            $modalMostrarBoton = $modalMostrarBoton === true || $modalMostrarBoton === '1' || $modalMostrarBoton === 1;
        } catch (\Throwable $e) {
            $modalActivo = true;
            $modalMostrarBoton = true;
        }
        $modalMostrarTextoRaw = \App\Models\ConfiguracionSitio::obtenerValor('modal_aniversario_mostrar_texto', '1');
        $modalMostrarTexto = $modalMostrarTextoRaw === true || $modalMostrarTextoRaw === '1' || $modalMostrarTextoRaw === 1;
        $modalBackdropOpacity = \App\Models\ConfiguracionSitio::obtenerValor('modal_aniversario_backdrop_opacity', '90');
        $modalBackdropOpacity = intval($modalBackdropOpacity) / 100;
        $modalIntervalo = \App\Models\ConfiguracionSitio::obtenerValor('modal_aniversario_intervalo', '3000');
        $modalIntervalo = intval($modalIntervalo);
        $modalTamano = \App\Models\ConfiguracionSitio::obtenerValor('modal_aniversario_tamano', '85');
        $modalTamano = max(50, min(95, intval($modalTamano)));
        $modalTransicion = \App\Models\ConfiguracionSitio::obtenerValor('modal_aniversario_transicion', '600');
        $modalTransicion = max(300, min(1200, intval($modalTransicion)));
    @endphp
    
    {{-- Modal de aniversario (siempre renderizado para evitar problemas de config/cache) --}}
    <div class="modal fade" id="modalFotosAniversario" tabindex="-1" aria-labelledby="modalAniversarioLabel" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f0f23 100%); border:none; border-radius:12px; overflow:hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.5);">
                
                {{-- Botones ocultos por defecto, visibles al pasar el mouse --}}
                <button type="button" class="modal-ctrl-hide position-absolute d-flex align-items-center justify-content-center" data-bs-dismiss="modal" aria-label="Cerrar" 
                        style="top:15px; right:15px; z-index:100; background-color:rgba(255,255,255,0.9); width:40px; height:40px; border-radius:50%; border:none; cursor:pointer; box-shadow: 0 2px 10px rgba(0,0,0,0.3);">
                    <i class="fas fa-times" style="color:#333; font-size:18px;"></i>
                </button>
                
                <div class="modal-ctrl-hide position-absolute top-0 start-0 m-3" style="z-index:100;">
                    <span class="badge bg-black bg-opacity-75 fs-6 px-3 py-2" id="contadorSlide">1 / 0</span>
                </div>

                @if($modalMostrarTexto)
                {{-- MODO CON TEXTO: Header visible al pasar mouse --}}
                <div class="modal-header modal-ctrl-hide border-0 py-3 position-absolute w-100" style="background:linear-gradient(to bottom, rgba(0,0,0,0.7), transparent); z-index:90; top:0;">
                    @php
                        $tituloModal = \App\Models\ConfiguracionSitio::obtenerValor('modal_aniversario_titulo', 'Actividad');
                    @endphp
                    <h5 class="modal-title text-white ps-5" id="modalAniversarioLabel">
                        <i class="fas fa-calendar-alt me-2 text-warning"></i> {{ $tituloModal }}
                    </h5>
                </div>
                @endif

                {{-- Body con Carrusel - TamaÃ±o dinÃ¡mico segÃºn imÃ¡genes --}}
                <div class="modal-body p-0 position-relative" id="modalBodyCarrusel" style="min-height:300px;">
                    {{-- Loading --}}
                    <div id="loadingCarrusel" class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column align-items-center justify-content-center text-white" style="z-index:50;">
                        <div class="spinner-border text-primary" style="width:3rem;height:3rem;" role="status"></div>
                        <p class="mt-3">Cargando fotos...</p>
                    </div>

                    {{-- Carrusel Bootstrap - Se inicializa por JS despuÃ©s de cargar fotos --}}
                    <div id="carruselAniversario" class="carousel slide">
                        <div class="carousel-inner" id="carruselItems"></div>

                        <button class="carousel-control-prev modal-ctrl-hide" type="button" data-bs-target="#carruselAniversario" data-bs-slide="prev" style="width:60px;">
                            <span class="bg-black bg-opacity-50 rounded-circle d-flex align-items-center justify-content-center" style="width:50px;height:50px;">
                                <i class="fas fa-chevron-left fa-lg text-white"></i>
                            </span>
                        </button>
                        <button class="carousel-control-next modal-ctrl-hide" type="button" data-bs-target="#carruselAniversario" data-bs-slide="next" style="width:60px;">
                            <span class="bg-black bg-opacity-50 rounded-circle d-flex align-items-center justify-content-center" style="width:50px;height:50px;">
                                <i class="fas fa-chevron-right fa-lg text-white"></i>
                            </span>
                        </button>

                        <div class="carousel-indicators mb-2 modal-ctrl-hide" id="carruselIndicadores"></div>
                    </div>

                    <div id="sinFotosCarrusel" class="position-absolute top-0 start-0 w-100 h-100 d-none flex-column align-items-center justify-content-center text-white" style="z-index:40;">
                        <i class="fas fa-images fa-4x mb-3 text-muted"></i>
                        <h5>No hay fotos disponibles</h5>
                    </div>
                </div>

                @if($modalMostrarTexto)
                {{-- Footer con info - visible al pasar mouse --}}
                <div class="modal-footer modal-ctrl-hide border-0 d-block py-3 position-absolute w-100" style="background:linear-gradient(to top, rgba(0,0,0,0.85), transparent); bottom:0; z-index:90;">
                    <div class="text-center text-white">
                        <h5 id="tituloFotoActual" class="mb-1 fw-bold text-shadow"></h5>
                        <p id="descripcionFotoActual" class="mb-1 text-light opacity-75 small"></p>
                        <small id="fechaFotoActual" class="text-muted"></small>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- BotÃ³n flotante para abrir modal (data-bs-toggle permite que Bootstrap lo abra sin JS custom) --}}
    <button type="button" id="btnFloatAniversario" class="btn btn-primary"
            data-bs-toggle="modal" data-bs-target="#modalFotosAniversario"
            style="position:fixed; bottom:25px; right:25px; z-index:99999; width:65px; height:65px; border-radius:50%; box-shadow:0 4px 20px rgba(0,0,0,0.4); font-size:1.5rem; display:flex; align-items:center; justify-content:center; animation: pulseBtn 2s infinite;">
        <i class="fas fa-images"></i>
    </button>

    <style>
    /* Modal aniversario: z-index alto para estar siempre visible sobre todo el contenido */
    #modalFotosAniversario.modal { z-index: 1060 !important; }
    body .modal-backdrop { z-index: 1055 !important; }
    
    /* Transiciones suaves - duración configurable desde gestor */
    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.5);
        transition: opacity {{ $modalTransicion }}ms ease-in-out;
    }
    .modal-backdrop.show {
        opacity: 0.15;
    }
    
    /* Clase especial para el modal de aniversario (oscurecimiento muy sutil) */
    .modal-backdrop.backdrop-dark.show {
        opacity: 0.3 !important;
        background-color: #000 !important;
    }

    .modal-backdrop.fade {
        opacity: 0;
    }
    
    /* Modal con transición suave y proporcional */
    #modalFotosAniversario.modal.fade {
        transition: opacity {{ $modalTransicion }}ms ease-in-out !important;
    }
    #modalFotosAniversario.modal.fade .modal-dialog {
        transition: transform {{ $modalTransicion }}ms ease-in-out !important;
        transform: scale(0.95) translateY(-10px);
    }
    #modalFotosAniversario.modal.show .modal-dialog {
        transform: scale(1) translateY(0);
    }
    
    /* Carrusel: transición en los items (Bootstrap aplica transform a cada item) */
    #modalFotosAniversario .carousel-item {
        transition: transform {{ $modalTransicion }}ms ease-in-out !important;
    }
    
    /* Asegurar opacidad correcta del modal */
    #modalFotosAniversario.modal.fade:not(.show) {
        opacity: 0;
        pointer-events: none;
    }
    #modalFotosAniversario.modal.show {
        opacity: 1;
    }
    
    @keyframes pulseBtn {
        0%, 100% { transform: scale(1); box-shadow: 0 4px 20px rgba(0,0,0,0.4); }
        50% { transform: scale(1.08); box-shadow: 0 6px 35px rgba(0,123,255,0.6); }
    }
    #btnFloatAniversario:hover { animation: none; transform: scale(1.15); }
    
    /* Modal centrado - asegurar que el cuadro sea visible sobre el backdrop */
    #modalFotosAniversario.modal.show {
        display: flex !important;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }
    
    #modalFotosAniversario .modal-dialog {
        margin: 0 auto;
        max-width: 95vw;
        width: auto;
        position: relative;
        z-index: 1;
    }
    
    #modalFotosAniversario .modal-content {
        width: auto;
        max-width: 95vw;
        max-height: 95vh;
        margin: 0 auto;
        padding: 0;
        border: none;
    }
    
    #modalFotosAniversario .modal-body {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }
    
    #modalFotosAniversario .carousel {
        display: flex;
        justify-content: center;
    }
    
    #modalFotosAniversario .carousel-inner {
        position: relative;
        overflow: hidden;
    }
    
    /* Estilos del carrusel - TAMAÃ‘O DINÃMICO segÃºn imÃ¡genes */
    #modalFotosAniversario .carousel {
        width: 100%;
    }
    
    #modalFotosAniversario .carousel-inner {
        width: 100%;
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f0f23 100%);
        /* Altura controlada por JS */
    }
    
    /* Items inactivos ocultos - solo active/next/prev visibles durante transición */
    #modalFotosAniversario .carousel-item {
        width: 100%;
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f0f23 100%);
        display: none;
    }
    #modalFotosAniversario .carousel-item.active,
    #modalFotosAniversario .carousel-item.carousel-item-start,
    #modalFotosAniversario .carousel-item.carousel-item-end,
    #modalFotosAniversario .carousel-item-next,
    #modalFotosAniversario .carousel-item-prev {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Imagen llena el espacio del modal - object-fit: contain mantiene proporción */
    #modalFotosAniversario .carousel-item img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        image-orientation: from-image;
        display: block;
    }
    
    /* Responsive para mÃ³viles */
    @media (max-width: 768px) {
        #modalFotosAniversario .modal-dialog {
            max-width: 100vw;
            margin: 0 auto;
        }
        #modalFotosAniversario .modal-content {
            max-width: 100vw;
            border-radius: 0 !important;
            margin: 0 auto;
        }
        #modalFotosAniversario .carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
    }
    
    #modalFotosAniversario .carousel-indicators {
        bottom: 15px;
        z-index: 95;
    }
    
    #modalFotosAniversario .carousel-indicators button {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin: 0 5px;
        opacity: 0.5;
        transition: all 0.3s;
    }
    #modalFotosAniversario .carousel-indicators button.active {
        opacity: 1;
        transform: scale(1.2);
    }
    #modalFotosAniversario .carousel-control-prev,
    #modalFotosAniversario .carousel-control-next {
        z-index: 95;
    }
    #modalFotosAniversario .carousel-control-prev:hover span,
    #modalFotosAniversario .carousel-control-next:hover span {
        background-color: rgba(0,123,255,0.8) !important;
        transform: scale(1.1);
    }
    
    /* Botones ocultos por defecto, visibles al pasar el mouse sobre el modal */
    #modalFotosAniversario .modal-ctrl-hide {
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
    }
    #modalFotosAniversario .modal-content:hover .modal-ctrl-hide {
        opacity: 1;
        pointer-events: auto;
    }
    /* En móviles/táctiles sin hover, mostrar controles siempre */
    @media (hover: none) {
        #modalFotosAniversario .modal-ctrl-hide {
            opacity: 1;
            pointer-events: auto;
        }
    }
    
    /* Ocultar loading */
    #loadingCarrusel.d-none {
        display: none !important;
    }
    
    /* Texto con sombra para legibilidad */
    .text-shadow {
        text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
    }
    </style>

    <script>
    (function(){
        var fotosData = [];
        var cargado = false;
        var cargando = false; // Nueva variable para prevenir llamadas simultÃ¡neas
        var mostrarTexto = {{ $modalMostrarTexto ? 'true' : 'false' }};
        var modalInstance = null;
        var STORAGE_KEY = 'modal_aniversario_visto';
        
        // Verificar si ya se mostrÃ³ en esta sesiÃ³n
        function yaFueMostrado() {
            try {
                return sessionStorage.getItem(STORAGE_KEY) === 'true';
            } catch (e) {
                return false;
            }
        }
        
        // Marcar como mostrado
        function marcarComoMostrado() {
            try {
                sessionStorage.setItem(STORAGE_KEY, 'true');
            } catch (e) {}
        }
        
        function init() {
            var modal = document.getElementById('modalFotosAniversario');
            var btn = document.getElementById('btnFloatAniversario');
            var carruselEl = document.getElementById('carruselAniversario');
            
            if (!modal || typeof bootstrap === 'undefined') return;
            
            modalInstance = new bootstrap.Modal(modal);
            if (btn) {
                btn.addEventListener('click', function() {
                    if (!cargado && !cargando) cargarFotos();
                });
            }

            // Aplicar fondo muy oscuro solo al modal de aniversario
            modal.addEventListener('show.bs.modal', function() {
                setTimeout(function() {
                    var backdrops = document.querySelectorAll('.modal-backdrop');
                    backdrops.forEach(function(b) { b.classList.add('backdrop-dark'); });
                }, 10);
            });
            
            // Auto-abrir desactivado para evitar conflictos de backdrop con el contenido
            if (!yaFueMostrado()) {
                setTimeout(function() {
                    try {
                        modalInstance.show();
                        marcarComoMostrado();
                        if (!cargado && !cargando) cargarFotos();
                    } catch (e) { console.warn('Modal aniversario:', e); }
                }, 2000);
            }
            
            // Limpiar backdrop y restaurar scroll al cerrar el modal
            modal.addEventListener('hidden.bs.modal', function() {
                // Esperar a que termine la transición (300ms) antes de limpiar
                setTimeout(function() {
                    var backdrops = document.querySelectorAll('.modal-backdrop');
                    backdrops.forEach(function(backdrop) {
                        backdrop.remove();
                    });
                    
                    // Restaurar el scroll del body
                    document.body.classList.remove('modal-open');
                    document.body.style.overflow = '';
                    document.body.style.paddingRight = '';
                    document.body.style.removeProperty('overflow');
                    document.body.style.removeProperty('padding-right');
                }, 50); // PequeÃ±o delay para asegurar limpieza despuÃ©s de la transiciÃ³n
            });
            
            // TambiÃ©n limpiar al hacer click en el backdrop
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modalInstance.hide();
                }
            });
            
            // Reiniciar el carrusel cada vez que se muestra el modal
            modal.addEventListener('shown.bs.modal', function() {
                var carruselEl = document.getElementById('carruselAniversario');
                if (carruselEl) {
                    var instance = bootstrap.Carousel.getInstance(carruselEl);
                    if (instance) {
                        instance.cycle();
                    }
                }
            });
        }
        
        function ocultarLoading() {
            var loading = document.getElementById('loadingCarrusel');
            if (loading) {
                loading.style.display = 'none';
                loading.style.visibility = 'hidden';
                loading.style.opacity = '0';
                loading.classList.add('d-none');
            }
        }
        
        function cargarFotos() {
            // Prevenir llamadas simultÃ¡neas
            if (cargando || cargado) return;
            cargando = true;
            
            var loading = document.getElementById('loadingCarrusel');
            var sinFotos = document.getElementById('sinFotosCarrusel');
            var items = document.getElementById('carruselItems');
            var indicadores = document.getElementById('carruselIndicadores');
            
            // Limpiar cualquier contenido previo
            items.innerHTML = '';
            indicadores.innerHTML = '';
            
            // Mostrar loading
            if (loading) {
                loading.style.display = 'flex';
                loading.style.visibility = 'visible';
                loading.style.opacity = '1';
                loading.classList.remove('d-none');
            }
            
            fetch("{{ route('public.fotos-aniversario') }}?anuncio=1")
                .then(function(r) {
                    if (!r.ok) throw new Error('API ' + r.status);
                    return r.text();
                })
                .then(function(text) {
                    var cleaned = text.replace(/\uFEFF/g, ''); // quitar BOM UTF-8
                    return JSON.parse(cleaned);
                })
                .then(function(data) {
                    if (data && data.success && data.fotos && data.fotos.length > 0) {
                        fotosData = data.fotos;
                        document.getElementById('contadorSlide').textContent = '1 / ' + data.fotos.length;
                        
                        // Precargar todas las imÃ¡genes para obtener sus dimensiones
                        var imagePromises = data.fotos.map(function(foto) {
                            return new Promise(function(resolve) {
                                var img = new Image();
                                img.onload = function() {
                                    resolve({ width: img.naturalWidth, height: img.naturalHeight, src: img.src });
                                };
                                img.onerror = function() {
                                    var placeholder = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='800' height='500'%3E%3Crect fill='%23333' width='800' height='500'/%3E%3Ctext fill='%23999' x='400' y='250' text-anchor='middle' dominant-baseline='middle' font-size='20'%3EImagen no disponible%3C/text%3E%3C/svg%3E";
                                    resolve({ width: 800, height: 500, src: placeholder });
                                };
                                img.src = foto.imagen || foto.thumbnail;
                            });
                        });
                        
                        // Esperar que todas las imÃ¡genes carguen
                        Promise.all(imagePromises).then(function(imageSizes) {
                            // Modal = ancho de la foto (mÃ¡ximo de todas), escalado si excede viewport
                            var maxW = 0, maxH = 0;
                            imageSizes.forEach(function(s) {
                                if (s.width > maxW) maxW = s.width;
                                if (s.height > maxH) maxH = s.height;
                            });
                            var tamanoPct = {{ $modalTamano }} / 100;
                            var maxVW = window.innerWidth * tamanoPct;
                            var maxVH = window.innerHeight * tamanoPct;
                            if (maxW > maxVW || maxH > maxVH) {
                                var r = Math.min(maxVW / maxW, maxVH / maxH);
                                maxW = Math.round(maxW * r);
                                maxH = Math.round(maxH * r);
                            }
                            var modalW = maxW;
                            var modalH = maxH;
                            
                            var carouselInner = document.getElementById('carruselItems');
                            var modalBody = document.getElementById('modalBodyCarrusel');
                            var modalContent = modalBody ? modalBody.closest('.modal-content') : null;
                            var modalDialog = modalBody ? modalBody.closest('.modal-dialog') : null;
                            
                            carouselInner.style.width = modalW + 'px';
                            carouselInner.style.height = modalH + 'px';
                            modalBody.style.width = modalW + 'px';
                            modalBody.style.height = modalH + 'px';
                            modalBody.style.minHeight = modalH + 'px';
                            if (modalContent) {
                                modalContent.style.width = modalW + 'px';
                                modalContent.style.maxWidth = '95vw';
                            }
                            if (modalDialog) {
                                modalDialog.style.width = modalW + 'px';
                                modalDialog.style.maxWidth = '95vw';
                            }
                            
                            // Crear los slides - mismo ancho que la foto (no usar display inline para que Bootstrap oculte inactivos)
                            data.fotos.forEach(function(foto, i) {
                                var div = document.createElement('div');
                                div.className = 'carousel-item' + (i === 0 ? ' active' : '');
                                div.style.width = modalW + 'px';
                                div.style.height = modalH + 'px';
                                
                                var img = document.createElement('img');
                                img.src = imageSizes[i].src;
                                img.alt = foto.titulo || 'Foto ' + (i+1);
                                img.style.width = '100%';
                                img.style.height = '100%';
                                img.style.objectFit = 'contain';
                                img.style.imageOrientation = 'from-image';
                                
                                div.appendChild(img);
                                items.appendChild(div);
                                
                                var ind = document.createElement('button');
                                ind.type = 'button';
                                ind.setAttribute('data-bs-target', '#carruselAniversario');
                                ind.setAttribute('data-bs-slide-to', i);
                                if (i === 0) ind.className = 'active';
                                indicadores.appendChild(ind);
                            });
                            
                            // Reinicializar el carrusel de Bootstrap despuÃ©s de crear los items
                            var carruselEl = document.getElementById('carruselAniversario');
                            if (carruselEl) {
                                // Destruir instancia anterior si existe
                                var oldCarousel = bootstrap.Carousel.getInstance(carruselEl);
                                if (oldCarousel) {
                                    oldCarousel.dispose();
                                }
                                // Crear nueva instancia con los items cargados
                                var carouselInstance = new bootstrap.Carousel(carruselEl, {
                                    interval: {{ $modalIntervalo > 0 ? $modalIntervalo : 3000 }},
                                    wrap: true,
                                    touch: true,
                                    ride: 'carousel'
                                });
                                
                                // Iniciar el ciclo automÃ¡tico
                                carouselInstance.cycle();
                                
                                // Registrar evento de cambio de slide
                                carruselEl.addEventListener('slid.bs.carousel', function(e) {
                                    actualizarInfo(e.to);
                                });
                                
                                console.log('âœ… Carrusel iniciado con intervalo:', {{ $modalIntervalo > 0 ? $modalIntervalo : 3000 }}, 'ms');
                            }
                            
                            // OCULTAR LOADING despuÃ©s de crear todo
                            ocultarLoading();
                            cargado = true;
                            cargando = false;
                            actualizarInfo(0);
                        });
                    } else {
                        ocultarLoading();
                        cargando = false;
                        sinFotos.classList.remove('d-none');
                        sinFotos.classList.add('d-flex');
                    }
                })
                .catch(function(err) {
                    cargando = false;
                    ocultarLoading();
                    sinFotos.classList.remove('d-none');
                    sinFotos.classList.add('d-flex');
                    if (typeof console !== 'undefined') console.warn('Modal aniversario:', err);
                });
        }
        
        function actualizarInfo(index) {
            if (!fotosData[index]) return;
            var f = fotosData[index];
            
            document.getElementById('contadorSlide').textContent = (index + 1) + ' / ' + fotosData.length;
            
            if (mostrarTexto) {
                document.getElementById('tituloFotoActual').textContent = f.titulo || 'Foto ' + (index + 1);
                document.getElementById('descripcionFotoActual').textContent = f.descripcion || '';
                var fecha = f.fecha || (f.anio ? 'AÃ±o ' + f.anio : '');
                document.getElementById('fechaFotoActual').innerHTML = fecha ? '<i class="far fa-calendar me-1"></i> ' + fecha : '';
            }
        }
        
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }
    })();
    </script>
    <!-- MODAL_ANIVERSARIO_FIN -->

    @stack('scripts')
</body>
</html>
