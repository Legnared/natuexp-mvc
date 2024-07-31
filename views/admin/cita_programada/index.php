<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">Listado de Citas Programadas</h3>
        <!-- <a href="/admin/cita_programada/crear" class="btn btn-alt-primary">
            Nueva Cita <i class="si si-plus ml-5"></i>
        </a> -->
    </div>
    <div class="block-content block-content-full">
        <div class="table-responsive">
            <?php if (!empty($citas)) { ?>
                <table id="tablaCitas" class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th>Nombre del Paciente</th>
                            <th>Fecha y Hora</th>
                            <th>Motivo</th>
                            <th>Tipo de Consulta</th>
                            <!-- <th>Acciones</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($citas as $cita) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($cita->nombre); ?></td>
                                <td><?php echo htmlspecialchars($cita->fecha_hora); ?></td>
                                <td><?php echo htmlspecialchars($cita->motivo); ?></td>
                                <td><?php echo htmlspecialchars($cita->tipo_consulta); ?></td>
                                <!-- <td>
                                    <a class="btn btn-sm btn-primary" href="/admin/cita_programada/editar?id=<?php echo $cita->id; ?>">
                                        <i class="fa fa-solid fa-edit"></i> Editar
                                    </a>
                                    <form method="POST" action="/admin/cita_programada/eliminar" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $cita->id; ?>">
                                        <button class="btn btn-sm btn-danger" type="submit">
                                            <i class="fa fa-solid fa-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </td> -->
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <script>
                    $(document).ready(function() {
                        $('#tablaCitas').DataTable({
                            "language": {
                                "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
                            },
                            "paging": true,
                            "pageLength": 5,
                            "lengthChange": false,
                            "searching": true,
                            "info": true,
                            "autoWidth": false,
                            "responsive": true
                        });
                    });
                </script>

            <?php } else { ?>
                <p class="text-center">No Hay Citas Programadas Aún.</p>
            <?php } ?>
        </div>
    </div>
</div>
