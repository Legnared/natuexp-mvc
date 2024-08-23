<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">Listado de Roles</h3>
        <a href="/admin/system/roles/crear" class="btn btn-alt-primary">
            Nuevo Rol <i class="si si-plus ml-5"></i>
        </a>
    </div>
    <div class="block-content block-content-full">
        <div class="table-responsive">
            <?php if (!empty($roles)) { ?>
            <table id="tablaRoles" class="table table-bordered table-striped table-vcenter">
                <thead>
                    <tr>
                        <th>Nombre del Rol</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($roles as $rol) { ?>
                    <tr>
                        <td><?php echo $rol->nombre; ?></td>
                        <td><?php echo $rol->descripcion; ?></td>
                        <td class="d-none d-sm-table-cell">
                            <div class="center col-xl-6">
                                <div class="push">
                                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                        <a class="btn btn-sm btn-primary"
                                            href="/admin/system/roles/editar?id=<?php echo $rol->id; ?>">
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
                                                <form method="POST" action="/admin/system/roles/eliminar">
                                                    <input type="hidden" name="id" value="<?php echo $rol->id; ?>">
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
                $('#tablaRoles').DataTable({
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
            <p class="text-center">No Hay Roles Aún.</p>
            <?php } ?>
        </div>
    </div>
</div>
