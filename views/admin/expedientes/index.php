<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">Listado de Pacientes</h3>
        <a href="/admin/expedientes/crear" class="btn btn-alt-primary">
            Nuevo Paciente <i class="si si-plus ml-5"></i>
        </a>
    </div>
    <div class="block-content block-content-full">
        <div class="table-responsive">
            <?php if (!empty($pacientes)) { ?>
            <table id="tablaPacientes" class="table table-bordered table-striped table-vcenter">
                <thead>
                    <tr>
                        <th class="d-none d-sm-table-cell" style="width: 15%;"></th>
                        <th>Nombre del Paciente</th>
                        <th>Motivo de Consulta</th>
                        <th>Estudios Clínicos Previos Archivos</th>
                        <th>Estudios Clínicos Previos Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Se asegura que $consultas esté inicializado como un array vacío si no está definido
                    $consultas = $consultas ?? [];
                    ?>
                    <?php foreach ($pacientes as $paciente) { ?>
                    <tr>
                        <td class="d-none d-sm-table-cell">
                            <a href="/admin/receta?id=<?php echo $paciente->url_avance; ?>">
                                <span class="badge badge-success">EXP<input type="hidden" name="id"
                                        value="<?php echo $paciente->id; ?>"></span>
                            </a>
                        </td>
                        <td><?php echo $paciente->nombre . " " . $paciente->apellidos; ?></td>
                        <td>
                            <?php
                            $consulta = array_filter($consultas, function($c) use ($paciente) {
                                return $c->paciente_id == $paciente->id;
                            });
                            $consulta = reset($consulta);
                            echo $consulta ? $consulta->motivo_consulta : 'No disponible';
                            ?>
                        </td>
                        <td>
                            <!-- Botón para ver el análisis clínico -->
                            <a href="<?php echo $_ENV['HOST'] . '/docs/patients/' . $paciente->expediente_file; ?>"
                                class="btn btn-rounded btn-outline-success mr-5 mb-5" target="_blank">
                                <i class="fa fa-file-pdf-o mr-5"></i>Click aquí para ver análisis Clínico del Paciente
                            </a>

                        </td>
                        <td>

                            <!-- Mostrar la imagen del paciente -->
                            <div class="patient-image mt-3">
                                <img src="<?php echo $_ENV['HOST'] . '/img/patients/' . $paciente->foto; ?>"
                                    alt="Imagen del Paciente" style="max-width: 50%; height: auto;" />
                            </div>
                        </td>

                        <td class="d-none d-sm-table-cell">
                            <div class="center col-xl-6">
                                <div class="push">
                                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                        <a class="btn btn-sm btn-primary"
                                            href="/admin/receta?id=<?php echo $paciente->url_avance; ?>">
                                            <i class="fa fa-solid fa-eye"></i> Ver Receta Médica
                                            <input type="hidden" name="id" value="<?php echo $paciente->id; ?>">
                                        </a>

                                        <div class="btn-group" role="group">
                                            <button type="button"
                                                class="btn btn-sm btn-alt-primary mr-5 mb-5 dropdown-toggle"
                                                id="btnGroupDrop1" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Acciones
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                <div class="dropdown-divider"></div>
                                                <a class="btn btn-outline-warning dropdown-item"
                                                    href="/admin/expedientes/editar?id=<?php echo $paciente->id; ?>">
                                                    <i class="fa fa-solid fa-edit"></i> Editar
                                                </a>

                                                <?php if (tiene_acceso([1, 2, 3], [4, 5, 6, 7, 8])) : ?>
                                                <div class="dropdown-divider"></div>
                                                <form method="POST" action="/admin/expedientes/eliminar">
                                                    <input type="hidden" name="id" value="<?php echo $paciente->id; ?>">
                                                    <button class="dropdown-item btn btn-alt-danger" type="submit">
                                                        <i class="fa fa-solid fa-user-times"></i> Eliminar
                                                    </button>
                                                </form>
                                                <?php endif ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

            <script>
            $(document).ready(function() {
                $('#tablaPacientes').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
                    },
                    "paging": true, // Activar paginación
                    "pageLength": 5, // Cantidad de registros por página
                    "lengthChange": false, // Desactivar cambio de cantidad de registros por página
                    "searching": true, // Activar barra de búsqueda
                    "info": true, // Mostrar información de paginación
                    "autoWidth": false, // Desactivar ajuste automático del ancho de las columnas
                    "responsive": true // Activar diseño responsivo
                });
            });
            </script>

            <?php } else { ?>
            <p class="text-center">No Hay Pacientes Aún.</p>
            <?php } ?>
        </div>
    </div>
</div>