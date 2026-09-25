@extends('layouts.public')

@section('title', 'Consultar Expediente - Mesa de Partes')
@section('meta_description', 'Verifique el estado y seguimiento de sus trámites')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('public.mesa-partes') }}">Mesa de Partes</a></li>
            <li class="breadcrumb-item active">Consultar Expediente</li>
        </ol>
    </nav>

    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('public.mesa-partes') }}" class="btn btn-outline-secondary me-3">
            <i class="fas fa-arrow-left me-1"></i>Volver
        </a>
        <h2 class="mb-0"><i class="fas fa-search text-success me-2"></i>Consultar Expediente</h2>
    </div>

    <div class="card shadow-sm mb-5">
        <div class="card-header bg-light">
            <h4 class="mb-0"><i class="fas fa-search me-2"></i>Ingrese el número de expediente o código</h4>
        </div>
        <div class="card-body">
            <form id="form-consulta-expediente" class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Número de Expediente o Código de Verificación</label>
                    <input type="text" name="codigo" id="consulta-codigo" class="form-control form-control-lg" 
                           placeholder="Ej: EXP-2026-000001 o 2026-000001" 
                           value="{{ request('codigo') }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary btn-lg w-100" id="btn-consulta">
                        <i class="fas fa-search me-2"></i>Consultar
                    </button>
                </div>
            </form>
            <div id="consulta-error" class="alert alert-danger mt-3 mb-0 {{ $errorConsulta ? '' : 'd-none' }}">
                @if($errorConsulta)<i class="fas fa-exclamation-triangle me-2"></i>{{ $errorConsulta }}@endif
            </div>
        </div>
    </div>

    {{-- Resultado de consulta --}}
    <div id="resultado-consulta-container">
    @if($resultadoConsulta && isset($resultadoConsulta['data']))
        @php $exp = $resultadoConsulta['data']['expediente'] ?? []; $linea = $resultadoConsulta['data']['linea_tiempo'] ?? []; @endphp
        <div class="card border-success mb-5">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0"><i class="fas fa-check-circle me-2"></i>Expediente Encontrado</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <dl class="row mb-0">
                            <dt class="col-sm-4">N° Expediente</dt>
                            <dd class="col-sm-8"><strong class="text-primary">{{ $exp['numero_expediente'] ?? '—' }}</strong></dd>
                            <dt class="col-sm-4">Asunto</dt>
                            <dd class="col-sm-8">{{ $exp['asunto'] ?? '—' }}</dd>
                            <dt class="col-sm-4">Tipo</dt>
                            <dd class="col-sm-8">{{ $exp['tipo_nombre'] ?? '—' }}</dd>
                            <dt class="col-sm-4">Código Verificación</dt>
                            <dd class="col-sm-8"><code>{{ $exp['codigo_verificacion'] ?? '—' }}</code></dd>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl class="row mb-0">
                            <dt class="col-sm-4">Estado</dt>
                            <dd class="col-sm-8"><span class="badge bg-info">{{ $exp['estado'] ?? '—' }}</span></dd>
                            <dt class="col-sm-4">Fecha Ingreso</dt>
                            <dd class="col-sm-8">{{ $exp['fecha_ingreso'] ?? '—' }}</dd>
                            <dt class="col-sm-4">Fecha Límite</dt>
                            <dd class="col-sm-8">{{ $exp['fecha_limite'] ?? '—' }}</dd>
                            <dt class="col-sm-4">Área Actual</dt>
                            <dd class="col-sm-8">{{ $exp['area_actual_nombre'] ?? '—' }}</dd>
                        </dl>
                    </div>
                </div>
                @if(!empty($linea))
                    <hr>
                    <h5><i class="fas fa-route me-2"></i>Trazabilidad</h5>
                    <div class="timeline">
                        @foreach($linea as $ev)
                            <div class="mb-3">
                                <small class="text-muted"><i class="fas fa-clock me-1"></i>{{ $ev['fecha'] ?? '' }}</small>
                                <h6 class="mb-1">{{ $ev['titulo'] ?? '' }}</h6>
                                @if(!empty($ev['detalle']))<p class="mb-1 small">{{ $ev['detalle'] }}</p>@endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endif
    </div>
</div>

@push('scripts')
<script>
(function() {
    document.getElementById('form-consulta-expediente')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        const codigo = document.getElementById('consulta-codigo').value.trim();
        const btn = document.getElementById('btn-consulta');
        const errDiv = document.getElementById('consulta-error');
        const container = document.getElementById('resultado-consulta-container');

        errDiv.classList.add('d-none');
        if (!codigo) {
            errDiv.textContent = 'Ingrese el número de expediente o código';
            errDiv.classList.remove('d-none');
            return;
        }

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Consultando...';

        try {
            const r = await fetch('{{ url("/api/mesa-partes/consultar") }}?codigo=' + encodeURIComponent(codigo));
            const json = await r.json();
            if (json.success && json.data) {
                const d = json.data;
                const exp = d.expediente || {};
                const linea = d.linea_tiempo || [];
                let html = '<div class="card border-success mb-5"><div class="card-header bg-success text-white"><h4 class="mb-0"><i class="fas fa-check-circle me-2"></i>Expediente Encontrado</h4></div><div class="card-body">';
                html += '<div class="row"><div class="col-md-6"><dl class="row mb-0"><dt class="col-sm-4">N° Expediente</dt><dd class="col-sm-8"><strong class="text-primary">' + (exp.numero_expediente || '—') + '</strong></dd><dt class="col-sm-4">Asunto</dt><dd class="col-sm-8">' + (exp.asunto || '—') + '</dd><dt class="col-sm-4">Tipo</dt><dd class="col-sm-8">' + (exp.tipo_nombre || '—') + '</dd><dt class="col-sm-4">Código Verificación</dt><dd class="col-sm-8"><code>' + (exp.codigo_verificacion || '—') + '</code></dd></dl></div>';
                html += '<div class="col-md-6"><dl class="row mb-0"><dt class="col-sm-4">Estado</dt><dd class="col-sm-8"><span class="badge bg-info">' + (exp.estado || '—') + '</span></dd><dt class="col-sm-4">Fecha Ingreso</dt><dd class="col-sm-8">' + (exp.fecha_ingreso || '—') + '</dd><dt class="col-sm-4">Fecha Límite</dt><dd class="col-sm-8">' + (exp.fecha_limite || '—') + '</dd><dt class="col-sm-4">Área Actual</dt><dd class="col-sm-8">' + (exp.area_actual_nombre || '—') + '</dd></dl></div></div>';
                if (linea.length) {
                    html += '<hr><h5><i class="fas fa-route me-2"></i>Trazabilidad</h5><div class="timeline">';
                    linea.forEach(function(ev) {
                        html += '<div class="mb-3"><small class="text-muted"><i class="fas fa-clock me-1"></i>' + (ev.fecha || '') + '</small><h6 class="mb-1">' + (ev.titulo || '') + '</h6>' + (ev.detalle ? '<p class="mb-1 small">' + ev.detalle + '</p>' : '') + '</div>';
                    });
                    html += '</div>';
                }
                html += '</div></div></div>';
                container.innerHTML = html;
                container.scrollIntoView({ behavior: 'smooth' });
            } else {
                errDiv.textContent = json.message || 'Expediente no encontrado';
                errDiv.classList.remove('d-none');
                container.innerHTML = '';
            }
        } catch (err) {
            errDiv.textContent = 'Error al consultar. Verifique su conexión.';
            errDiv.classList.remove('d-none');
            container.innerHTML = '';
        }
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-search me-2"></i>Consultar';
    });
})();
</script>
@endpush
@endsection
