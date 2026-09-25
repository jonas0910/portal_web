<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Portal Notarios del Perú - Servicios Notariales Profesionales</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #1e40af;
            --secondary-color: #3b82f6;
            --accent-color: #f59e0b;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --bg-light: #f8fafc;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background-color: #ffffff;
        }
        
        /* Header */
        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }
        
        .navbar-brand {
            font-size: 1.8rem;
            font-weight: 700;
            color: white !important;
            text-decoration: none;
        }
        
        .navbar-nav .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500;
            margin: 0 0.5rem;
            transition: all 0.3s ease;
        }
        
        .navbar-nav .nav-link:hover {
            color: white !important;
            transform: translateY(-2px);
        }
        
        .btn-login {
            background: rgba(255,255,255,0.2);
            border: 2px solid rgba(255,255,255,0.3);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            background: white;
            color: var(--primary-color);
            transform: translateY(-2px);
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }
        
        .hero-subtitle {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .btn-primary-custom {
            background: var(--accent-color);
            border: none;
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            color: white;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        }
        
        .btn-primary-custom:hover {
            background: #d97706;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
            color: white;
        }
        
        /* Section Titles */
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 3rem;
            color: var(--text-dark);
            position: relative;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            border-radius: 2px;
        }
        
        /* Cards */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }
        
        .notario-card {
            text-align: center;
            padding: 2rem;
        }
        
        .notario-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: white;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .notario-name {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
        }
        
        .notario-specialty {
            color: var(--text-light);
            font-size: 0.95rem;
            margin-bottom: 1rem;
        }
        
        .notario-info {
            font-size: 0.9rem;
            color: var(--text-light);
            margin-bottom: 1rem;
        }
        
        /* Services */
        .service-card {
            padding: 2rem;
            text-align: center;
            height: 100%;
        }
        
        .service-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--accent-color), #fbbf24);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
        }
        
        .service-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--text-dark);
        }
        
        .service-description {
            color: var(--text-light);
            font-size: 0.95rem;
            line-height: 1.6;
        }
        
        /* Stats Section */
        .stats-section {
            background: var(--bg-light);
            padding: 80px 0;
        }
        
        .stat-item {
            text-align: center;
            padding: 2rem;
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            font-size: 1.1rem;
            color: var(--text-light);
            font-weight: 500;
        }
        
        /* Footer */
        .footer {
            background: var(--text-dark);
            color: white;
            padding: 60px 0 30px;
        }
        
        .footer-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        
        .footer-link {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
            transition: color 0.3s ease;
        }
        
        .footer-link:hover {
            color: var(--accent-color);
        }
        
        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .social-link {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .social-link:hover {
            background: var(--accent-color);
            transform: translateY(-3px);
            color: white;
        }
        
        /* Contact Info */
        .contact-info {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .contact-icon {
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-right: 1rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .notario-card {
                margin-bottom: 2rem;
            }
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
        
        /* Map Container */
        .map-container {
            height: 300px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-balance-scale me-2"></i>
                Portal Notarios
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#inicio">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#notarios">Notarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#servicios">Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#documentos">Documentos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contacto">Contacto</a>
                    </li>
                    <li class="nav-item ms-3">
                        <a href="/login" class="btn btn-login">
                            <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="inicio" class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content fade-in-up">
                        <h1 class="hero-title">
                            Servicios Notariales<br>
                            <span style="color: var(--accent-color);">Profesionales</span>
                        </h1>
                        <p class="hero-subtitle">
                            Encuentra notarios certificados y accede a servicios notariales de calidad 
                            en todo el Perú. Tu confianza es nuestra prioridad.
                        </p>
                        <div class="d-flex gap-3 flex-wrap">
                            <a href="#notarios" class="btn-primary-custom">
                                <i class="fas fa-search me-2"></i>Buscar Notarios
                            </a>
                            <a href="#servicios" class="btn-primary-custom" style="background: rgba(255,255,255,0.2); border: 2px solid rgba(255,255,255,0.3);">
                                <i class="fas fa-list me-2"></i>Ver Servicios
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-center">
                        <i class="fas fa-balance-scale" style="font-size: 15rem; opacity: 0.1;"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number">150+</div>
                        <div class="stat-label">Notarios Certificados</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number">25</div>
                        <div class="stat-label">Distritos</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number">5000+</div>
                        <div class="stat-label">Documentos Procesados</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number">98%</div>
                        <div class="stat-label">Satisfacción</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Notarios Section -->
    <section id="notarios" class="py-5">
        <div class="container">
            <h2 class="section-title">Notarios Destacados</h2>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card notario-card">
                        <div class="notario-avatar">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <h4 class="notario-name">Dr. Carlos Mendoza</h4>
                        <p class="notario-specialty">Especialista en Derecho Civil</p>
                        <p class="notario-info">
                            <i class="fas fa-map-marker-alt me-2"></i>Miraflores, Lima<br>
                            <i class="fas fa-certificate me-2"></i>Colegiatura: 12345
                        </p>
                        <a href="/notarios/1" class="btn btn-outline-primary">Ver Perfil</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card notario-card">
                        <div class="notario-avatar">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <h4 class="notario-name">Dra. María Rodríguez</h4>
                        <p class="notario-specialty">Especialista en Derecho Comercial</p>
                        <p class="notario-info">
                            <i class="fas fa-map-marker-alt me-2"></i>San Isidro, Lima<br>
                            <i class="fas fa-certificate me-2"></i>Colegiatura: 12346
                        </p>
                        <a href="/notarios/2" class="btn btn-outline-primary">Ver Perfil</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card notario-card">
                        <div class="notario-avatar">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <h4 class="notario-name">Dr. José Fernández</h4>
                        <p class="notario-specialty">Especialista en Derecho Inmobiliario</p>
                        <p class="notario-info">
                            <i class="fas fa-map-marker-alt me-2"></i>La Molina, Lima<br>
                            <i class="fas fa-certificate me-2"></i>Colegiatura: 12347
                        </p>
                        <a href="/notarios/3" class="btn btn-outline-primary">Ver Perfil</a>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="/notarios" class="btn btn-primary btn-lg">
                    <i class="fas fa-users me-2"></i>Ver Todos los Notarios
                </a>
            </div>
        </div>
    </section>

    <!-- Servicios Section -->
    <section id="servicios" class="py-5" style="background: var(--bg-light);">
        <div class="container">
            <h2 class="section-title">asd Nuestros Servicios</h2>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card service-card">
                        <div class="service-icon">
                            <i class="fas fa-file-contract"></i>
                        </div>
                        <h4 class="service-title">Escrituras Públicas</h4>
                        <p class="service-description">
                            Formalización de contratos, compraventas, donaciones y otros actos jurídicos 
                            con validez legal completa.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card service-card">
                        <div class="service-icon">
                            <i class="fas fa-signature"></i>
                        </div>
                        <h4 class="service-title">Reconocimiento de Firmas</h4>
                        <p class="service-description">
                            Autenticación de firmas en documentos privados para darles validez legal 
                            ante instituciones públicas y privadas.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card service-card">
                        <div class="service-icon">
                            <i class="fas fa-copy"></i>
                        </div>
                        <h4 class="service-title">Copia de Documentos</h4>
                        <p class="service-description">
                            Certificación de copias de documentos originales para uso oficial 
                            y trámites administrativos.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card service-card">
                        <div class="service-icon">
                            <i class="fas fa-home"></i>
                        </div>
                        <h4 class="service-title">Derecho Inmobiliario</h4>
                        <p class="service-description">
                            Asesoría especializada en transacciones inmobiliarias, escrituras 
                            de propiedad y contratos de arrendamiento.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card service-card">
                        <div class="service-icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <h4 class="service-title">Derecho Comercial</h4>
                        <p class="service-description">
                            Constitución de empresas, poderes, contratos comerciales y 
                            asesoría en derecho empresarial.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card service-card">
                        <div class="service-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h4 class="service-title">Derecho de Familia</h4>
                        <p class="service-description">
                            Capitulaciones matrimoniales, testamentos, poderes familiares 
                            y asesoría en derecho sucesorio.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Documentos Section -->
    <section id="documentos" class="py-5">
        <div class="container">
            <h2 class="section-title">Documentos Públicos</h2>
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-file-alt text-primary me-2"></i>
                                Escritura de Compraventa
                            </h5>
                            <p class="card-text">
                                Documento público que formaliza la transferencia de propiedad 
                                de un bien inmueble entre comprador y vendedor.
                            </p>
                            <a href="/documentos/1" class="btn btn-outline-primary">Ver Documento</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-file-alt text-primary me-2"></i>
                                Poder General
                            </h5>
                            <p class="card-text">
                                Documento que autoriza a una persona para actuar en nombre 
                                de otra en diversos asuntos legales y administrativos.
                            </p>
                            <a href="/documentos/2" class="btn btn-outline-primary">Ver Documento</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="/documentos" class="btn btn-primary btn-lg">
                    <i class="fas fa-folder-open me-2"></i>Ver Todos los Documentos
                </a>
            </div>
        </div>
    </section>

    <!-- Contacto Section -->
    <section id="contacto" class="py-5" style="background: var(--bg-light);">
        <div class="container">
            <h2 class="section-title">Contáctanos</h2>
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">
                                <i class="fas fa-envelope text-primary me-2"></i>
                                Envíanos un Mensaje
                            </h5>
                            <form action="/contacto" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nombre" class="form-label">Nombre Completo</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Correo Electrónico</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="asunto" class="form-label">Asunto</label>
                                    <input type="text" class="form-control" id="asunto" name="asunto" required>
                                </div>
                                <div class="mb-3">
                                    <label for="mensaje" class="form-label">Mensaje</label>
                                    <textarea class="form-control" id="mensaje" name="mensaje" rows="5" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-2"></i>Enviar Mensaje
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="contact-info">
                        <h5 class="mb-4">
                            <i class="fas fa-info-circle text-primary me-2"></i>
                            Información de Contacto
                        </h5>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <strong>Dirección</strong><br>
                                Av. Principal 123, Lima, Perú
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div>
                                <strong>Teléfono</strong><br>
                                +51 1 234 5678
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <strong>Email</strong><br>
                                info@portalnotarios.pe
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <strong>Horario</strong><br>
                                Lun - Vie: 9:00 - 18:00
                            </div>
                        </div>
                    </div>
                    
                    <div class="map-container">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3901.3!2d-77.0282!3d-12.0464!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTLCsDAyJzQ3LjAiUyA3N8KwMDEnNDEuNSJX!5e0!3m2!1ses!2spe!4v1234567890"
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="footer-title">
                        <i class="fas fa-balance-scale me-2"></i>
                        Portal Notarios
                    </h5>
                    <p style="color: rgba(255,255,255,0.8);">
                        Tu plataforma confiable para servicios notariales profesionales 
                        en todo el Perú. Conectamos ciudadanos con notarios certificados.
                    </p>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="footer-title">Enlaces</h6>
                    <a href="#inicio" class="footer-link">Inicio</a>
                    <a href="#notarios" class="footer-link">Notarios</a>
                    <a href="#servicios" class="footer-link">Servicios</a>
                    <a href="#documentos" class="footer-link">Documentos</a>
                    <a href="#contacto" class="footer-link">Contacto</a>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="footer-title">Servicios</h6>
                    <a href="#" class="footer-link">Escrituras</a>
                    <a href="#" class="footer-link">Reconocimiento</a>
                    <a href="#" class="footer-link">Copias</a>
                    <a href="#" class="footer-link">Asesoría Legal</a>
                </div>
                <div class="col-lg-4 mb-4">
                    <h6 class="footer-title">Newsletter</h6>
                    <p style="color: rgba(255,255,255,0.8); margin-bottom: 1rem;">
                        Mantente informado sobre nuestros servicios y novedades.
                    </p>
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Tu correo electrónico">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
            <hr style="border-color: rgba(255,255,255,0.2); margin: 2rem 0 1rem;">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p style="color: rgba(255,255,255,0.8); margin: 0;">
                        © 2024 Portal Notarios. Todos los derechos reservados.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="footer-link me-3">Política de Privacidad</a>
                    <a href="#" class="footer-link">Términos de Uso</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Smooth Scrolling -->
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in-up');
                }
            });
        }, observerOptions);

        // Observe all cards and sections
        document.querySelectorAll('.card, .stat-item').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>
</html>