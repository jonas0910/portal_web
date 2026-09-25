{{-- Widget de Formulario de Contacto --}}
<section class="contacto-section py-5" style="background-color: {{ $tema->color_fondo ?? '#f8f9fa' }}">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-4">
                <h2 style="color: {{ $tema->color_primario ?? '#007bff' }}">
                    <i class="fas fa-envelope"></i> Contáctanos
                </h2>
                <p class="lead text-muted mb-4">
                    ¿Tienes alguna consulta? Estamos aquí para ayudarte
                </p>
                
                <div class="info-contacto">
                    <div class="info-item mb-3">
                        <i class="fas fa-map-marker-alt fa-2x" style="color: {{ $tema->color_acento ?? '#28a745' }}"></i>
                        <div class="ml-3">
                            <h6 class="mb-0">Dirección</h6>
                            <p class="text-muted mb-0">Av. Principal 123, Lima, Perú</p>
                        </div>
                    </div>
                    
                    <div class="info-item mb-3">
                        <i class="fas fa-phone fa-2x" style="color: {{ $tema->color_acento ?? '#28a745' }}"></i>
                        <div class="ml-3">
                            <h6 class="mb-0">Teléfono</h6>
                            <p class="text-muted mb-0">+51 1 234 5678</p>
                        </div>
                    </div>
                    
                    <div class="info-item mb-3">
                        <i class="fas fa-envelope fa-2x" style="color: {{ $tema->color_acento ?? '#28a745' }}"></i>
                        <div class="ml-3">
                            <h6 class="mb-0">Email</h6>
                            <p class="text-muted mb-0">info@notarios.org.pe</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <form action="/contacto" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Nombre Completo</label>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Teléfono</label>
                                <input type="tel" name="telefono" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <label>Asunto</label>
                                <input type="text" name="asunto" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Mensaje</label>
                                <textarea name="mensaje" class="form-control" rows="4" required></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-block btn-lg" style="background-color: {{ $tema->color_primario ?? '#007bff' }}; color: white;">
                                <i class="fas fa-paper-plane"></i> Enviar Mensaje
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.info-item {
    display: flex;
    align-items-center;
}
</style>

