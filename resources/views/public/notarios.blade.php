@extends('layouts.public')

@section('title', 'Nuestro Equipo - Colaboradores')

@php
    $tema = $tema ?? \App\Models\Tema::obtenerPredeterminado();
    $primaryColor = '#0d2137';
    $secondaryColor = '#c5a059';
@endphp

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

        .filter-section {
            background: #fff;
            padding: 2rem 0;
            border-bottom: 1px solid #eee;
        }

        /* Estilos específicos para las tarjetas de Colaboradores */
        .colaborador-card {
            background: #fff;
            border: 1px solid #eaeaea;
            border-radius: 10px;
            padding: 25px;
            height: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
            display: flex;
            flex-direction: column;
        }

        .colaborador-card:hover {
            box-shadow: 0 10px 20px rgba(0,0,0,0.08);
            transform: translateY(-5px);
            border-color: #2e7d32;
        }

        .colaborador-icon {
            width: 60px;
            height: 60px;
            background: #f1f8f3;
            color: #2e7d32;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        .colaborador-name {
            font-size: 1.2rem;
            font-weight: 700;
            color: #0d2137;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .colaborador-cargo {
            font-size: 0.85rem;
            color: #555;
            line-height: 1.5;
            padding-left: 12px;
            border-left: 3px solid #c5a059;
            margin-bottom: 20px;
            flex-grow: 1; /* Permite que este contenedor crezca si el texto es muy largo */
        }

        .colaborador-contact {
            margin-top: auto; /* Empuja el contacto hacia abajo */
            padding-top: 15px;
            border-top: 1px solid #eee;
            font-size: 0.9rem;
        }

        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            color: #444;
        }

        .contact-item i {
            width: 20px;
            color: #1b5e20;
            margin-right: 8px;
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
                    <li class="breadcrumb-item active" aria-current="page">Nuestro Equipo</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Page Header --}}
    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="page-title">Nuestro Equipo</h1>
                    <p class="page-subtitle">Conozca a los profesionales y especialistas listos para brindarle la mejor asesoría y atención.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Filtros --}}
    <section class="filter-section">
        <div class="container">
            {{-- Asegúrate de que esta ruta coincida con el nombre que le diste en web.php --}}
            <form action="{{ route('public.colaboradores') }}" method="GET" class="row justify-content-center g-3">
                <div class="col-md-8 col-lg-6">
                    <label class="small fw-bold text-muted mb-2">BUSCAR POR NOMBRE O ÁREA DE ATENCIÓN</label>
                    <div class="input-group shadow-sm">
                        <span class="input-group-text bg-white border-end-0 text-success">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="form-control border-start-0 ps-0" placeholder="Ej: Viviana, Sucesiones, Vehicular...">
                        <button type="submit" class="btn btn-success fw-bold px-4" style="background-color: #1b5e20; border: none;">
                            BUSCAR
                        </button>
                    </div>
                </div>
                @if(request('search'))
                <div class="col-md-2 col-lg-2 d-flex align-items-end">
                    <a href="{{ route('public.colaboradores') }}" class="btn btn-outline-secondary w-100 py-2">LIMPIAR</a>
                </div>
                @endif
            </form>
        </div>
    </section>

    {{-- Listado de Colaboradores --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between mb-4 border-bottom border-secondary pb-3">
                <h3 class="fw-bold mb-0" style="color: #1b5e20;">
                    <i class="fas fa-users-cog me-2"></i>Áreas y Especialistas
                </h3>
                <span class="badge bg-white text-muted border px-3 py-2 shadow-sm">
                    {{ $colaboradores->count() }} colaboradores
                </span>
            </div>

            <div class="row g-4">
                @forelse($colaboradores as $colaborador)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="colaborador-card">
                            <div class="colaborador-icon">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <h4 class="colaborador-name">{{ $colaborador->nombre }} {{ $colaborador->apellidos }}</h4>
                            
                            {{-- Aquí se maneja elegantemente el cargo, sin importar lo largo que sea --}}
                            <div class="colaborador-cargo">
                                <strong>Área encargada:</strong><br>
                                {{ $colaborador->cargo ?? 'Atención al Cliente' }}
                            </div>

                            <div class="colaborador-contact">
                                @if($colaborador->email)
                                    <div class="contact-item">
                                        <i class="fas fa-envelope"></i>
                                        <a href="mailto:{{ $colaborador->email }}" class="text-decoration-none text-muted" style="word-break: break-all;">
                                            {{ $colaborador->email }}
                                        </a>
                                    </div>
                                @endif
                                
                                @if($colaborador->telefono)
                                    <div class="contact-item">
                                        <i class="fas fa-phone-alt"></i>
                                        <span>{{ $colaborador->telefono }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-search fa-4x opacity-25 text-muted"></i>
                        </div>
                        <h4 class="text-muted">No se encontraron resultados</h4>
                        <p class="text-muted">Pruebe con otros criterios de búsqueda o limpie los filtros.</p>
                        <a href="{{ route('public.colaboradores') }}" class="btn btn-success px-4">VER TODOS</a>
                    </div>
                @endforelse
            </div>

            <div class="mt-5 pt-4 border-top">
                <p class="small text-muted text-center fst-italic">
                    Nota: Nuestro equipo se encuentra en constante capacitación para ofrecerle un servicio rápido y seguro. 
                    Si tiene dudas sobre a qué área dirigirse, puede consultar en nuestra recepción.
                </p>
            </div>
        </div>
    </section>
@endsection