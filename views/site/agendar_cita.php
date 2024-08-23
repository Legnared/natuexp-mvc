<!-- Sección de Agendar Cita -->
<section id="agendar_cita" class="agendar_cita section">
    <!-- Título de la Sección -->
    <div class="container section-title text-center" data-aos="fade-up">
        <h2><?php echo $titulo; ?></h2>
        <p>Agende su cita médica completando el siguiente formulario.</p>
    </div><!-- Fin del Título de la Sección -->
    <div class="container">
        <!-- Contenedor de Alertas -->
        <div class="alert-container text-center mx-auto" style="max-width: 400px;">
            <?php include_once __DIR__ . '/../template/alerta.php'; ?>
        </div>

        <form id="cita_form" method="POST" action="agendar_cita" class="needs-validation mx-auto" novalidate
            style="max-width: 600px;">
            <!-- Datos del Paciente -->
            <fieldset>
                <legend>Datos del Paciente</legend>

                

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre(s)</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre Completo"
                        required>
                    <div class="invalid-feedback">
                        El nombre es obligatorio.
                    </div>
                </div>

                <div class="mb-3">
                    <label for="apellidos" class="form-label">Apellido(s)</label>
                    <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellido(s)"
                        required>
                    <div class="invalid-feedback">
                        El Apellido(s) es/son obligatorio(s).
                    </div>
                </div>

                <div class="mb-3">
                    <label for="fecha_nacimiento" class="form-label"><span class="text-danger">*</span>Fecha de
                        Nacimiento</label>
                    <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required
                        value="<?php echo $paciente->fecha_nacimiento ?? ''; ?>" onblur="calcularEdad(); mostrarNota()">
                    <div class="invalid-feedback">
                        La fecha de nacimiento es obligatoria.
                    </div>
                </div>

                <div class="mb-3">
                    <label for="edad" class="form-label">Edad</label>
                    <input type="text" class="form-control" id="edad" name="edad" readonly
                        value="<?php echo $paciente->edad ?? ''; ?>">
                </div>

                <div id="notaEdad" class="alert alert-info" style="display:none; margin-top: 10px;">
                    La edad ha sido calculada.
                </div>

                <div class="mb-3">
                    <label for="sexo" class="form-label">Sexo</label>
                    <select class="form-control" id="sexo" name="sexo" required>
                        <option value="">Seleccione</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                    </select>
                    <div class="invalid-feedback">
                        El sexo es obligatorio.
                    </div>
                </div>

                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono de Contacto</label>
                    <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Teléfono"
                        required>
                    <div class="invalid-feedback">
                        El teléfono es obligatorio.
                    </div>
                </div>


                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                    <div class="invalid-feedback">
                        El email es obligatorio y debe ser válido.
                    </div>
                </div>

                <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección"
                        required>
                </div>
            </fieldset>

            <!-- Información de la Cita -->
            <fieldset>
                <legend>Información de la Cita</legend>

                <div class="mb-3">
                    <label for="fecha_hora" class="form-label">Fecha y Hora Preferida</label>
                    <input type="datetime-local" class="form-control" id="fecha_hora" name="fecha_hora" required>
                    <div class="invalid-feedback">
                        La fecha y hora de la cita son obligatorios.
                    </div>
                </div>

                <div class="mb-3">
                    <label for="motivo" class="form-label">Motivo de la Cita</label>
                    <textarea class="form-control" id="motivo" name="motivo" rows="4" placeholder="Motivo de la Cita"
                        required></textarea>
                    <div class="invalid-feedback">
                        El motivo de la cita es obligatorio.
                    </div>
                </div>

                <div class="mb-3">
                    <label for="tipo_consulta" class="form-label">Tipo de Consulta</label>
                    <select class="form-control" id="tipo_consulta" name="tipo_consulta" required>
                        <option value="">Seleccione</option>
                        <option value="General">Consulta General</option>
                        <option value="Especialista">Especialista</option>
                        <option value="Urgencias">Urgencias</option>
                    </select>
                    <div class="invalid-feedback">
                        El tipo de consulta es obligatorio.
                    </div>
                </div>

            </fieldset>

            <!-- Datos Adicionales -->
            <div class="mb-3">
                <input type="checkbox" id="aceptar_terminos" name="aceptar_terminos" required>
                <label for="aceptar_terminos">Acepto los términos y condiciones</label>
                <div class="invalid-feedback">
                    Debe aceptar los términos y condiciones.
                </div>
            </div>


            <div class="text-center">
                <button type="submit" class="btn btn-primary">Agendar Cita</button>
            </div>
        </form>
    </div>
</section>

<script>
// Validación de fecha y hora de cita
document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('cita_form');
    form.addEventListener('submit', function(event) {
        var fechaHoraInput = document.getElementById('fecha_hora').value;
        if (fechaHoraInput) {
            var appointmentDate = new Date(fechaHoraInput);
            var dayOfWeek = appointmentDate.getDay();
            var hour = appointmentDate.getHours();

            // Verificar si la cita está en un día de lunes a viernes
            if (dayOfWeek < 1 || dayOfWeek > 5) {
                alert('Las citas solo se pueden agendar de lunes a viernes.');
                event.preventDefault();
                event.stopPropagation();
                return;
            }

            // Verificar si la hora está dentro del rango permitido (9 AM a 6 PM)
            if (hour < 9 || hour >= 18) {
                alert('Las citas solo se pueden agendar entre las 9:00 AM y las 6:00 PM.');
                event.preventDefault();
                event.stopPropagation();
                return;
            }
        }

        // Validación de campos del formulario
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            // Resetear el formulario después de una presentación exitosa
            setTimeout(function() {
                form.reset();
            }, 1000); // Esperar 1 segundo para asegurar que la solicitud se procese
        }
        form.classList.add('was-validated');
    }, false);
});

function calcularEdad() {
        const fechaNacimiento = document.getElementById('fecha_nacimiento').value;
        const edadField = document.getElementById('edad');
        const notaEdad = document.getElementById('notaEdad');

        if (fechaNacimiento === '') {
            edadField.value = '';  // Limpiar el campo de edad
            return;
        }

        const fecha = new Date(fechaNacimiento);
        const hoy = new Date();
        let edad = hoy.getFullYear() - fecha.getFullYear();
        const m = hoy.getMonth() - fecha.getMonth();
        if (m < 0 || (m === 0 && hoy.getDate() < fecha.getDate())) {
            edad--;
        }
        edadField.value = edad;

        // Mostrar mensaje de éxito
        mostrarNota();
    }

    function mostrarNota() {
        const notaEdad = document.getElementById('notaEdad');
        notaEdad.style.display = 'block';
        setTimeout(() => {
            notaEdad.style.display = 'none';
        }, 3000);
    }
</script>

<style>
/* Estilo para centrar las alertas y hacer el contenedor más pequeño */
.alert-container {
    max-width: 400px;
    /* Ancho máximo para el contenedor de alertas */
    margin: 0 auto 20px;
    /* Centrar el contenedor y añadir margen inferior */
}
</style>