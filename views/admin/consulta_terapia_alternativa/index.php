<div class="block">
    <div class="block-header block-header-default">
     <h2 class="content-heading "><?php echo $titulo ?></h2>
        <a href="/admin/consulta_terapia_alternativa/crear" class="btn btn-alt-primary">
            Nuevo Paciente <i class="si si-plus ml-5"></i>
        </a>
    </div>
    <div class="block-content block-content-full">
        <div class="table-responsive">
            <?php if (!empty($pacientes)) { ?>
                <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                    <thead>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 15%;"></th>
                            <th>Nombre del Paciente</th>
                            <th>Motivo de Consulta</th>
                            <th>Estudios Clínicos Previos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($pacientes as $paciente) { ?>
                            <tr>
                                <!--Mostrar el ID del usuario-->
                                <td class="d-none d-sm-table-cell"><a href="/admin/consulta?id=<?php echo $paciente->url_avance; ?>"><span class="badge badge-success">EXP<input type="hidden" name="id" value="<?php echo $paciente->id; ?>"></span></a></td>
                                <td><?php echo $paciente->nombre . " " . $paciente->apellidos; ?></td>
                                <td><?php echo $paciente->sintoma_diagnostico; ?></td>
                                <td><?php echo $paciente->expediente_file; ?></td>
                                <td class="d-none d-sm-table-cell">
                                    <div class="center col-xl-6">
                                        <div class="push">
                                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                                <a class="btn btn-sm btn-primary" href="/admin/consulta?id=<?php echo $paciente->url_avance; ?>"><i class="fa fa-solid fa-eye"></i>Ver Expediente<input type="hidden" name="id" value="<?php echo $paciente->id; ?>"></a>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-sm btn-alt-primary mr-5 mb-5 dropdown-toggle" id="btnGroupDrop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones</button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                        <div class="dropdown-divider"></div>
                                                        <a class="btn btn-outline-warning dropdown-item" href="/admin/consulta_terapia_alternativa/editar?id=<?php echo $paciente->id; ?> ">
                                                            <i class="fa fa-solid fa-edit"></i> Editar
                                                        </a>
                                                        <!-- //Elimina un registro -->
                                                        <?php if ($_SESSION["perfil"] ==  "admin") :  ?>
                                                            <div class="dropdown-divider"></div>
                                                            <form method="POST" action="/admin/consulta_terapia_alternativa/eliminar">
                                                                <input type="hidden" name="id" value="<?php echo $paciente->id; ?>">
                                                                <button class="dropdown-item btn btn-alt-danger" type="submit">
                                                                    <i class="fa fa-solid fa-user-times"></i>
                                                                    Eliminar
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

            <?php  } else { ?>
                <p class="text-center">No Hay Pacientes Aún.</p>
            <?php } ?>

        </div>
    </div>

</div>