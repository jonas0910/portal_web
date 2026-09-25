@extends('layouts.public')

@section('title', 'Contacto - Colegio de Notarios de Tacna')

@section('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, #1b5e20, #2e7d32);
        color: white;
        padding: 60px 0;
        margin-bottom: 0;
    }
    .page-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }
    .page-subtitle {
        font-size: 1.15rem;
        opacity: 0.9;
    }
    .breadcrumb-container {
        background: #f8f9fa;
        padding: 15px 0;
        border-bottom: 1px solid #e9ecef;
    }
    .breadcrumb {
        background: transparent;
        padding: 0;
        margin-bottom: 0;
    }
    .breadcrumb-item a {
        color: #1b5e20;
        text-decoration: none;
    }
    .breadcrumb-item.active {
        color: #2e7d32;
    }
    .contact-info-item {
        margin-bottom: 2rem;
        padding-left: 20px;
        border-left: 3px solid #1b5e20;
    }
    .table-consultas {
        border-radius: 8px;
        overflow: hidden;
    }
    .table-consultas thead {
        background-color: #1b5e20;
        color: white;
    }
    .whatsapp-btn {
        color: #25d366;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: color 0.2s ease;
    }
    .whatsapp-btn:hover {
        color: #128c7e;
    }
</style>
@endsection

@section('content')
{{-- Breadcrumb --}}
<div class="breadcrumb-container">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('public.index') }}">
                        <i class="fas fa-home me-1"></i>Inicio
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Contacto</li>
            </ol>
        </nav>
    </div>
</div>

<div class="contacto-page">
    {{-- Page Header --}}
    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="page-title">Contacto Institucional</h1>
                    <p class="page-subtitle">Estamos a su disposición para cualquier consulta o información sobre nuestros servicios notariales</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Formulario e Información Principal --}}
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row g-5">
                {{-- Formulario --}}
                <div class="col-lg-7">
                    <h3 class="fw-bold mb-4" style="color: #1b5e20; border-bottom: 2px solid #eee; padding-bottom: 10px;">Formulario de Consultas</h3>
                    
                    @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm mb-4">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    </div>
                    @endif

                    <form action="{{ route('public.contacto.enviar') }}" method="POST" class="mt-4">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="small fw-bold text-muted mb-2">NOMBRE COMPLETO</label>
                                <input type="text" name="nombre" class="form-control" style="height: 45px; border-radius: 5px;" required>
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold text-muted mb-2">CORREO ELECTRÓNICO</label>
                                <input type="email" name="email" class="form-control" style="height: 45px; border-radius: 5px;" required>
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold text-muted mb-2">TELÉFONO / CELULAR</label>
                                <input type="text" name="telefono" class="form-control" style="height: 45px; border-radius: 5px;" placeholder="Opcional">
                            </div>
                            <div class="col-12">
                                <label class="small fw-bold text-muted mb-2">ASUNTO</label>
                                <input type="text" name="asunto" class="form-control" style="height: 45px; border-radius: 5px;" required>
                            </div>
                            <div class="col-12">
                                <label class="small fw-bold text-muted mb-2">MENSAJE O CONSULTA</label>
                                <textarea name="mensaje" class="form-control" rows="6" style="border-radius: 5px;" required></textarea>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-success px-5 py-2 fw-bold shadow-sm" style="background-color: #1b5e20; border: none; border-radius: 5px;">
                                    ENVIAR CONSULTA
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Info de contacto --}}
                <div class="col-lg-5">
                    <h3 class="fw-bold mb-4" style="color: #1b5e20; border-bottom: 2px solid #eee; padding-bottom: 10px;">Información de Sede</h3>
                    
                    <div class="mt-4">
                        <div class="contact-info-item">
                            <h6 class="fw-bold text-dark mb-1">Dirección Institucional</h6>
                            <p class="text-muted mb-0">{{ \App\Models\ConfiguracionSitio::obtener('direccion_contacto', 'Calle Hipólito Unanue N° 336, Tacna, Perú') }}</p>
                        </div>

                        <div class="contact-info-item">
                            <h6 class="fw-bold text-dark mb-1">Teléfonos de Atención</h6>
                            <p class="text-muted mb-0">{{ \App\Models\ConfiguracionSitio::obtener('telefono_contacto', '(052) 630739') }}</p>
                        </div>

                        <div class="contact-info-item">
                            <h6 class="fw-bold text-dark mb-1">Correo Electrónico</h6>
                            <p class="text-muted mb-0">{{ \App\Models\ConfiguracionSitio::obtener('email_contacto', 'colegionotariostacna@gmail.com') }}</p>
                        </div>

                        <div class="contact-info-item">
                            <h6 class="fw-bold text-dark mb-1">Horario de Oficina</h6>
                            <p class="text-muted mb-0">{{ \App\Models\ConfiguracionSitio::obtener('horario_atencion', 'Lunes a Viernes: 08:30 AM - 01:00 PM / 04:00 PM - 07:00 PM') }}</p>
                            @if($horarioSabado = \App\Models\ConfiguracionSitio::obtener('horario_sabados'))
                                <p class="text-muted mb-0">{{ $horarioSabado }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="p-4 mt-5 rounded-3" style="background-color: #f8f9fa; border-left: 5px solid #c5a059;">
                        <h6 class="fw-bold" style="color: #1b5e20;">Atención al Ciudadano</h6>
                        <p class="small text-muted mb-0">Para consultas sobre legalizaciones, capacitación o trámites en trámite, puede acudir directamente a nuestra sede en los horarios establecidos.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Directorio de Consultas en Línea --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-4">
                <span class="badge bg-success bg-opacity-10 text-success fw-semibold px-3 py-2 rounded-pill mb-2">
                    <i class="fas fa-headset me-1"></i> Atención Directa
                </span>
                <h3 class="fw-bold text-dark mb-2">Consultas en Línea por Área</h3>
                <p class="text-muted small mb-0">Comuníquese directamente con el área correspondiente a su trámite o servicio notarial</p>
            </div>

            <div class="card border border-light-subtle shadow-sm rounded-3 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 table-consultas">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center py-3" style="width: 80px;">Nº</th>
                                <th scope="col" class="py-3">Área / Trámite</th>
                                <th scope="col" class="py-3 text-end pe-4" style="width: 220px;">Teléfono / Celular</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0 small">
                            <tr>
                                <td class="text-center fw-bold text-muted">1</td>
                                <td>Entrega de testimonios y partes</td>
                                <td class="text-end pe-4">
                                    <a href="https://wa.me/51910100727" target="_blank" class="whatsapp-btn">
                                        <i class="fab fa-whatsapp me-2"></i>910 100 727
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center fw-bold text-muted">2</td>
                                <td>Sociedades y Empresas</td>
                                <td class="text-end pe-4">
                                    <a href="https://wa.me/51987444398" target="_blank" class="whatsapp-btn">
                                        <i class="fab fa-whatsapp me-2"></i>987 444 398
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center fw-bold text-muted">3</td>
                                <td>Renta Joven</td>
                                <td class="text-end pe-4">
                                    <a href="https://wa.me/51944572513" target="_blank" class="whatsapp-btn">
                                        <i class="fab fa-whatsapp me-2"></i>944 572 513
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center fw-bold text-muted">4</td>
                                <td>Asociaciones, Cooperativas, Comunidades Campesinas</td>
                                <td class="text-end pe-4">
                                    <a href="https://wa.me/51992318580" target="_blank" class="whatsapp-btn">
                                        <i class="fab fa-whatsapp me-2"></i>992 318 580
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center fw-bold text-muted">5</td>
                                <td>Sucesiones intestadas, Unión de hecho, Divorcio, Separación de patrimonio</td>
                                <td class="text-end pe-4">
                                    <a href="https://wa.me/51932336498" target="_blank" class="whatsapp-btn">
                                        <i class="fab fa-whatsapp me-2"></i>932 336 498
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center fw-bold text-muted">6</td>
                                <td>Compraventa, Donación, Anticipo de legítima, Poderes, División y partición, Hipotecas</td>
                                <td class="text-end pe-4">
                                    <a href="https://wa.me/51944572554" target="_blank" class="whatsapp-btn">
                                        <i class="fab fa-whatsapp me-2"></i>944 572 554
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center fw-bold text-muted">7</td>
                                <td>Compraventa, Donación, Anticipo de legítima, Poderes, División y partición, Hipotecas</td>
                                <td class="text-end pe-4">
                                    <a href="https://wa.me/51967546815" target="_blank" class="whatsapp-btn">
                                        <i class="fab fa-whatsapp me-2"></i>967 546 815
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center fw-bold text-muted">8</td>
                                <td>Entrevistas y Matrimonio</td>
                                <td class="text-end pe-4">
                                    <a href="https://wa.me/51943310475" target="_blank" class="whatsapp-btn">
                                        <i class="fab fa-whatsapp me-2"></i>943 310 475
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center fw-bold text-muted">9</td>
                                <td>Poderes, Prescripción adquisitiva de dominio, Constataciones domiciliarias</td>
                                <td class="text-end pe-4">
                                    <a href="https://wa.me/51948525737" target="_blank" class="whatsapp-btn">
                                        <i class="fab fa-whatsapp me-2"></i>948 525 737
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center fw-bold text-muted">10</td>
                                <td>Transferencias vehiculares</td>
                                <td class="text-end pe-4">
                                    <a href="https://wa.me/51987444198" target="_blank" class="whatsapp-btn">
                                        <i class="fab fa-whatsapp me-2"></i>987 444 198
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center fw-bold text-muted">11</td>
                                <td>Legalizaciones, Autorizaciones de viaje, Cartas notariales, Transferencias vehiculares, Contratos privados</td>
                                <td class="text-end pe-4">
                                    <a href="https://wa.me/51989981242" target="_blank" class="whatsapp-btn">
                                        <i class="fab fa-whatsapp me-2"></i>989 981 242
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center fw-bold text-muted">12</td>
                                <td>Citas</td>
                                <td class="text-end pe-4">
                                    <a href="https://wa.me/51925133010" target="_blank" class="whatsapp-btn">
                                        <i class="fab fa-whatsapp me-2"></i>925 133 010
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center fw-bold text-muted">13</td>
                                <td>Área de contabilidad / Facturas electrónicas</td>
                                <td class="text-end pe-4">
                                    <a href="https://wa.me/51944571999" target="_blank" class="whatsapp-btn">
                                        <i class="fab fa-whatsapp me-2"></i>944 571 999
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    {{-- Mapa Real con Google Maps --}}
    <section class="py-5 bg-white">
        <div class="container">
            <div class="rounded-3 shadow-sm overflow-hidden" style="height: 450px; background-color: #e0e0e0;">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3794.6897320167923!2d-70.24478689743484!3d-17.99316651631979!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x915acf86cb5246a9%3A0x928921a9b1e8bd5e!2sAv.%20Pinto%201360%2C%20Tacna%2023002!5e0!3m2!1ses!2spe!4v1789278248613!5m2!1ses!2spe" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
            </div>
            <div class="text-center mt-3">
                <p class="text-muted mb-0">
                    <i class="fas fa-map-marker-alt me-2 text-success"></i>
                    {{ \App\Models\ConfiguracionSitio::obtener('direccion_contacto', 'Av. Pinto nro 1360 - Alto de la Alianza - Tacna ') }}
                </p>
            </div>
        </div>
    </section>
</div>
@endsection