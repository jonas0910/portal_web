{{--
    Widget Sidebar: Enlaces Rápidos
--}}

@props(['config' => []])

<div class="card shadow-sm mb-4">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">
            <i class="fas fa-link"></i> Enlaces Rápidos
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="list-group list-group-flush">
            <a href="{{ route('public.servicios') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-cogs text-primary"></i> Servicios Municipales
            </a>
            <a href="{{ route('public.pagina', 'funcionarios') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-user-tie text-success"></i> Directorio de Funcionarios
            </a>
            <a href="{{ route('public.documentos') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-file-alt text-info"></i> Documentos y Formularios
            </a>
            <a href="{{ route('public.noticias') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-newspaper text-warning"></i> Noticias
            </a>
            <a href="{{ route('public.proyectos') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-project-diagram text-danger"></i> Proyectos
            </a>
            <a href="{{ route('public.mesa-partes') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-inbox text-purple" style="color: #6f42c1;"></i> Mesa de Partes
            </a>
            <a href="{{ route('public.bolsa-trabajo') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-briefcase text-dark"></i> Bolsa de Trabajo
            </a>
            <a href="{{ route('public.contacto') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-envelope text-secondary"></i> Contáctanos
            </a>
        </div>
    </div>
</div>



