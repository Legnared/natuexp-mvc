<!-- Contenido de tu página -->
<div class="block">
    <div class="block-header block-header-default">
        <h2 class="content-heading"><?php echo htmlspecialchars($titulo); ?></h2>
    </div>

    <!-- Mostrar alertas -->
    <div id="alertas">
        <?php if (!empty($alertas)): ?>
            <?php foreach ($alertas as $alerta): ?>
                <div class="alert alert-<?php echo htmlspecialchars($alerta['tipo']); ?>">
                    <?php echo htmlspecialchars($alerta['mensaje']); ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="block-content">
        <!-- Campo de búsqueda por nombre del paciente -->
        <div class="mb-3">
            <input type="text" id="buscarCitas" class="form-control" placeholder="Buscar por nombre del paciente">
        </div>

        <!-- Tabla de citas -->
        <table id="tablaCitas" class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del Paciente</th>
                    <th>Fecha de la Cita</th>
                    <th>Hora de la Cita</th>
                    <th>Detalles</th>
                </tr>
            </thead>
            <tbody id="bodyTablaCitas">
                <!-- Aquí se insertarán las citas con AJAX -->
                <?php foreach ($citas as $cita): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($cita['id']); ?></td>
                        <td><?php echo htmlspecialchars($cita['nombre_paciente'] . ' ' . $cita['apellidos_paciente']); ?></td>
                        <td><?php echo htmlspecialchars($cita['fecha']); ?></td>
                        <td><?php echo htmlspecialchars($cita['hora']); ?></td>
                        <td><?php echo htmlspecialchars($cita['descripcion']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p id="mensajeError" class="text-center alert alert-warning" style="display: none;">No se encontraron citas para el término de búsqueda proporcionado.</p>
    </div>
</div>


<!-- Script personalizado para AJAX y DataTables -->
<script>
  $(document).ready(function() {
    // Configuración del filtro de búsqueda con AJAX
    $('#buscarCitas').on('keyup', function() {
        var nombre = $(this).val();

        if (nombre.length > 2) { // Realizar la búsqueda solo si hay más de 2 caracteres
            $.ajax({
                url: '/admin/historico',
                type: 'GET',
                data: { nombre: nombre, ajax: true },
                success: function(data) {
                    var citas = JSON.parse(data);
                    actualizarTablaCitas(citas);
                }
            });
        } else {
            // Limpiar la tabla si no hay suficiente texto para buscar
            $('#bodyTablaCitas').empty();
            $('#mensajeError').hide();
        }
    });

    // Función para actualizar la tabla de citas
    function actualizarTablaCitas(citas) {
        var bodyTabla = $('#bodyTablaCitas');
        bodyTabla.empty(); // Limpiar el cuerpo de la tabla

        if (citas.length > 0) {
            $('#mensajeError').hide();

            citas.forEach(function(cita) {
                var fila = '<tr>' +
                           '<td>' + cita.id + '</td>' +
                           '<td>' + cita.nombre_paciente + ' ' + cita.apellidos_paciente + '</td>' +
                           '<td>' + cita.fecha + '</td>' +
                           '<td>' + cita.hora + '</td>' +
                           '<td>' + cita.descripcion + '</td>' +
                           '</tr>';
                bodyTabla.append(fila);
            });
        } else {
            $('#mensajeError').show();
        }
    }

    // Ocultar alertas PHP si se muestran
    var alertasContainer = $('#alertas');
    alertasContainer.hide(); // Ocultar inicialmente
});

</script>
