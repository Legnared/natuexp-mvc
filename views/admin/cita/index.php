<!-- index.php -->
<div class="block">
    <div class="block-header block-header-default">
        <h2 class="content-heading "><?php echo $titulo ?></h2>
        <a href="/admin/cita/crear" class="btn btn-alt-primary">
            Nueva Cita <i class="si si-calendar ml-5"></i>
        </a>
    </div>
    <div class="block-content block-content-full">
        <?php if (!empty($alertas)): ?>
            <div class="alertas">
                <?php foreach ($alertas as $alerta): ?>
                    <div class="alerta <?php echo $alerta['tipo']; ?>">
                        <?php echo $alerta['mensaje']; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div id="calendar"></div> <!-- Contenedor para el calendario -->
        <?php if (empty($citas)): ?>
            <p class="text-center alert-warning">No hay citas agendadas.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Modal para mostrar detalles de la cita -->
<div class="modal fade" id="citaModal" tabindex="-1" role="dialog" aria-labelledby="citaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="citaModalLabel">Detalles de la Cita</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="citaModalBody">
                <!-- Aquí se mostrarán los detalles de la cita -->
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        // Obtener las citas desde PHP y convertirlas a formato JSON
        var citas = <?php echo json_encode($citas); ?>;
        var events = citas.map(function(cita) {
            return {
                title: cita.descripcion + ' - ' + cita.nombre_paciente + ' ' + cita.apellidos_paciente,
                start: cita.fecha + 'T' + cita.hora, // Formato ISO8601
                cita: cita // Incluir toda la cita como dato adicional
            };
        });

        // Inicializar el calendario si hay citas, o mostrar mensaje si no hay citas
        if (citas.length > 0) {
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es', // Para español
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: events, // Pasar los eventos al calendario
                eventClick: function(info) {
                    mostrarDetallesCita(info.event.extendedProps.cita);
                }
            });

            calendar.render();
        }

        // Función para mostrar detalles de la cita en el modal
        function mostrarDetallesCita(cita) {
            var modalBody = document.getElementById('citaModalBody');
            modalBody.innerHTML = `
                <p><strong>Fecha:</strong> ${cita.fecha}</p>
                <p><strong>Hora:</strong> ${cita.hora}</p>
                <p><strong>Descripción:</strong> ${cita.descripcion}</p>
                <p><strong>Paciente:</strong> ${cita.nombre_paciente} ${cita.apellidos_paciente}</p>
                <!-- Puedes agregar más detalles según necesites -->
            `;

            $('#citaModal').modal('show'); // Mostrar el modal
        }
    });
</script>
