<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">Listado de Permisos</h3>
        <a href="/admin/system/permisos/crear" class="btn btn-alt-primary">
            Nuevo Permiso <i class="si si-plus ml-5"></i>
        </a>
    </div>
    <div class="block-content block-content-full">
        <div class="table-responsive">
            <?php if (!empty($permisos)) { ?>
            <table id="tablaPermisos" class="table table-bordered table-striped table-vcenter">
                <thead>
                    <tr>
                        <th>Nombre del Permiso</th>
                        <th>Descripción</th>
                        <th>Rol Asociado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($permisos as $permiso) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($permiso->nombre); ?></td>
                        <td><?php echo htmlspecialchars($permiso->descripcion); ?></td>
                        <td><?php echo htmlspecialchars($permiso->rol()->nombre); ?></td>
                        <td class="d-none d-sm-table-cell">
                            <div class="center col-xl-6">
                                <div class="push">
                                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                        <a class="btn btn-sm btn-primary"
                                            href="/admin/system/permisos/editar?id=<?php echo $permiso->id; ?>">
                                            <i class="fa fa-solid fa-edit"></i> Editar
                                        </a>

                                        <div class="btn-group" role="group">
                                            <button type="button"
                                                class="btn btn-sm btn-alt-primary mr-5 mb-5 dropdown-toggle"
                                                id="btnGroupDrop1" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Acciones
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                <?php if ($_SESSION["perfil"] == "admin") : ?>
                                                <div class="dropdown-divider"></div>
                                                <form method="POST" action="/admin/system/permisos/eliminar">
                                                    <input type="hidden" name="id" value="<?php echo $permiso->id; ?>">
                                                    <button class="dropdown-item btn btn-alt-danger" type="submit">
                                                        <i class="fa fa-solid fa-trash"></i> Eliminar
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
                $('#tablaPermisos').DataTable({
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
            <p class="text-center">No Hay Permisos Aún.</p>
            <?php } ?>
        </div>
    </div>
</div>
