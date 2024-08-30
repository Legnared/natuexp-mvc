<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">Listado de Usuarios</h3>
        <a href="/admin/system/usuarios/crear" class="btn btn-alt-primary">
            Nuevo Usuario <i class="si si-plus ml-5"></i>
        </a>
    </div>
    <div class="block-content block-content-full">
        <div class="table-responsive">
            <?php if (!empty($usuarios)) { ?>
            <table id="tablaUsuarios" class="table table-bordered table-striped table-vcenter">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($usuario->nombre); ?></td>
                        <td><?php echo htmlspecialchars($usuario->apellido); ?></td>
                        <td><?php echo htmlspecialchars($usuario->email); ?></td>
                        <td><?php echo htmlspecialchars($usuario->telefono); ?></td>
                        <td><?php echo htmlspecialchars($usuario->obtenerRol()); ?></td>
                        <td><?php echo $usuario->estado ? 'Activado' : 'No Activado'; ?></td>
                        <td class="d-none d-sm-table-cell">
                            <div class="center col-xl-6">
                                <div class="push">
                                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                        <a class="btn btn-sm btn-primary"
                                            href="/admin/system/usuarios/editar?id=<?php echo $usuario->id; ?>">
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
                                                <?php if (is_admin()) : ?>
                                                <form method="POST" action="/admin/system/usuarios/activar" id="activar-form-<?php echo $usuario->id; ?>">
                                                    <input type="hidden" name="id" value="<?php echo $usuario->id; ?>">
                                                    <button class="dropdown-item btn btn-alt-success" type="submit">
                                                        <i class="fa fa-solid fa-user"></i> Activar Usuario
                                                    </button>
                                                </form>

                                                <div class="dropdown-divider"></div>
                                                <form method="POST" action="/admin/system/usuarios/eliminar" id="eliminar-form-<?php echo $usuario->id; ?>">
                                                    <input type="hidden" name="id" value="<?php echo $usuario->id; ?>">
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
                $('#tablaUsuarios').DataTable({
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

            // Manejar el formulario de activación
            document.querySelectorAll('[id^="activar-form-"]').forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();

                    // Crear un objeto FormData para enviar los datos del formulario
                    var formData = new FormData(this);

                    // Enviar la solicitud usando fetch
                    fetch('/admin/system/usuarios/activar', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: data.success.join('<br>'),
                                timeout: 3000
                            }).show();
                        }
                        if (data.error) {
                            new Noty({
                                type: 'error',
                                layout: 'topRight',
                                text: data.error.join('<br>'),
                                timeout: 3000
                            }).show();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                });
            });

            // Manejar el formulario de eliminación
            document.querySelectorAll('[id^="eliminar-form-"]').forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();

                    // Crear un objeto FormData para enviar los datos del formulario
                    var formData = new FormData(this);

                    // Enviar la solicitud usando fetch
                    fetch('/admin/system/usuarios/eliminar', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: data.success.join('<br>'),
                                timeout: 3000
                            }).show();
                            // Opcionalmente, puedes recargar la página para reflejar los cambios
                            location.reload();
                        }
                        if (data.error) {
                            new Noty({
                                type: 'error',
                                layout: 'topRight',
                                text: data.error.join('<br>'),
                                timeout: 3000
                            }).show();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                });
            });
            </script>

            <?php } else { ?>
            <p class="text-center">No Hay Usuarios Aún.</p>
            <?php } ?>
        </div>
    </div>
</div>
