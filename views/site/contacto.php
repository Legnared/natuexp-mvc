<!-- Sección de Ubicación -->
<section id="contact" class="contact section">
    <!-- Título de la Sección -->
    <div class="container section-title text-center" data-aos="fade-up">
        <h2><?php echo $titulo; ?></h2>
        <p>Ponte en contacto con nosotros para más información o para agendar una cita.</p>
    </div><!-- Fin del Título de la Sección -->

    <div class="container">
        <!-- Contenedor de Alertas -->
        <div class="alert-container text-center mx-auto" style="max-width: 400px;">
            <?php include_once __DIR__ . '/../template/alerta.php'; ?>
        </div>
        
        <form id="contacto_form" method="POST" action="contacto" class="needs-validation mx-auto" novalidate style="max-width: 600px;">
            <div class="mb-3">
                <label for="nombre" class="form-label">Tu Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Tu Nombre" required>
                <div class="invalid-feedback">
                    El nombre es obligatorio.
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Tu Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Tu Email" required>
                <div class="invalid-feedback">
                    El email es obligatorio y debe ser válido.
                </div>
            </div>

            <div class="mb-3">
                <label for="asunto" class="form-label">Asunto</label>
                <input type="text" class="form-control" id="asunto" name="asunto" placeholder="Asunto" required>
                <div class="invalid-feedback">
                    El asunto es obligatorio.
                </div>
            </div>

            <div class="mb-3">
                <label for="mensaje" class="form-label">Mensaje</label>
                <textarea class="form-control" id="mensaje" name="mensaje" rows="4" placeholder="Mensaje" required></textarea>
                <div class="invalid-feedback">
                    El mensaje es obligatorio.
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Enviar Mensaje</button>
            </div>
        </form>
    </div>
</section>

<script>
// JavaScript para deshabilitar el envío del formulario si hay campos no válidos
document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('contacto_form');
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            // Resetear el formulario después de una presentación exitosa
            form.reset(); // Resetea el formulario inmediatamente
        }
        form.classList.add('was-validated');
    }, false);
});
</script>

<style>
/* Estilo para centrar las alertas y hacer el contenedor más pequeño */
.alert-container {
    max-width: 400px; /* Ancho máximo para el contenedor de alertas */
    margin: 0 auto 20px; /* Centrar el contenedor y añadir margen inferior */
}
</style>
