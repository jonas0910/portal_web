@extends('layouts.public')

@section('title', 'Agendar Cita - Portal Municipal')
@section('meta_description', 'Reserva tu cita de forma rápida y segura con la municipalidad')

@section('content')
<section class="hero-section" style="padding: 60px 0;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="hero-title" style="font-size: 2.5rem;">
                    <i class="fas fa-calendar-check text-primary me-2"></i>Agendar Cita
                </h1>
                <p class="hero-subtitle">
                    Reserva tu cita de forma rápida y segura. Selecciona la fecha, hora y completa tus datos.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0 fw-bold text-primary">
                            <i class="fas fa-calendar-alt me-2"></i>Solicitar Cita
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif

                        @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif

                        <form action="{{ route('public.citas.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="titulo" class="form-label text-muted small fw-bold">Motivo de la cita *</label>
                                    <input type="text" class="form-control" id="titulo" name="titulo" value="{{ old('titulo') }}" placeholder="Ej: Consulta sobre licencia de construcción" required>
                                    @error('titulo')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tipo" class="form-label text-muted small fw-bold">Tipo de cita *</label>
                                    <select class="form-select" id="tipo" name="tipo" required>
                                        <option value="">Seleccionar</option>
                                        <option value="consulta" {{ old('tipo') == 'consulta' ? 'selected' : '' }}>Consulta</option>
                                        <option value="tramite" {{ old('tipo') == 'tramite' ? 'selected' : '' }}>Trámite</option>
                                        <option value="audiencia" {{ old('tipo') == 'audiencia' ? 'selected' : '' }}>Audiencia</option>
                                        <option value="otro" {{ old('tipo') == 'otro' ? 'selected' : '' }}>Otro</option>
                                    </select>
                                    @error('tipo')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            @if($servicios->count() > 0)
                            <div class="mb-3">
                                <label for="area" class="form-label text-muted small fw-bold">Área / Servicio</label>
                                <select class="form-select" id="area" name="area">
                                    <option value="">Seleccionar (opcional)</option>
                                    @foreach($servicios as $s)
                                    <option value="{{ $s->nombre }}" {{ old('area') == $s->nombre ? 'selected' : '' }}>{{ $s->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('area')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fecha" class="form-label text-muted small fw-bold">Fecha *</label>
                                    <input type="date" class="form-control" id="fecha" name="fecha" value="{{ old('fecha') }}" min="{{ date('Y-m-d') }}" required>
                                    @error('fecha')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="hora" class="form-label text-muted small fw-bold">Hora *</label>
                                    <select class="form-select" id="hora" name="hora" required>
                                        <option value="">Seleccionar</option>
                                        @for($h = 8; $h <= 17; $h++)
                                            @foreach(['00', '30'] as $m)
                                                @if($h < 17 || $m == '00')
                                                <option value="{{ sprintf('%02d:%s', $h, $m) }}" {{ old('hora') == sprintf('%02d:%s', $h, $m) ? 'selected' : '' }}>
                                                    {{ sprintf('%02d:%s', $h, $m) }}
                                                </option>
                                                @endif
                                            @endforeach
                                        @endfor
                                    </select>
                                    @error('hora')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr class="my-4">

                            <h6 class="fw-bold text-muted mb-3">Datos de contacto</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="cliente_nombre" class="form-label text-muted small fw-bold">Nombre completo *</label>
                                    <input type="text" class="form-control" id="cliente_nombre" name="cliente_nombre" value="{{ old('cliente_nombre') }}" required>
                                    @error('cliente_nombre')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="cliente_dni" class="form-label text-muted small fw-bold">DNI</label>
                                    <input type="text" class="form-control" id="cliente_dni" name="cliente_dni" value="{{ old('cliente_dni') }}" placeholder="Opcional" maxlength="15">
                                    @error('cliente_dni')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="cliente_email" class="form-label text-muted small fw-bold">Email *</label>
                                    <input type="email" class="form-control" id="cliente_email" name="cliente_email" value="{{ old('cliente_email') }}" required>
                                    @error('cliente_email')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="cliente_telefono" class="form-label text-muted small fw-bold">Teléfono *</label>
                                    <input type="tel" class="form-control" id="cliente_telefono" name="cliente_telefono" value="{{ old('cliente_telefono') }}" required>
                                    @error('cliente_telefono')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="descripcion" class="form-label text-muted small fw-bold">Detalles adicionales</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Indique cualquier información relevante para su cita">{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-calendar-check me-2"></i>Agendar Cita
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
