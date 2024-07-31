<h2 class="content-heading d-print-none">

    <?php echo $titulo; ?>
</h2>
<div class="block">
    <div class="block-header block-header-default">

        <h3 class="block-title"><?php echo $titulo ?></h3><br>

        <div class="block-options">
            <!-- Print Page functionality is initialized in Codebase() -> uiHelperPrint() -->
            <button type="button" class="btn-block-option" onclick="Codebase.helpers('print-page');">
                <i class="si si-printer"></i> Imprimir Receta Médica
            </button>
            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"></button>
            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                <i class="si si-refresh"></i>
            </button>
        </div>
    </div>
    <div class="block-content">
        <!-- Invoice Info -->
        <div class="row my-20">
            <!-- Company Info -->
            <div class="col-6">
                <p class="h3">E Clínicos</p>
                <address>
                    <br>
                    Morelia, Michoacán<br>
                    Region, 58197<br>
                    Treapeuta: <strong><b> <?php echo $_SESSION["nombre"] . " " . $_SESSION['apellido']; ?><br></b></strong>
                    Correo: <strong><b><?php echo $_SESSION["email"]; ?><br></b></strong>
                    Telefono: <strong><b><?php echo $_SESSION["telefono"]; ?><br></b></strong>
                </address>
            </div>
            <!-- END Company Info -->

            <!-- Client Info -->
            <div class="col-6 text-right">

                <p class="h3">Paciente:</p>
                <address>
                    Nombre: <?php echo $nombre_paciente; ?><br>
                    Edad: <?php echo $edad; ?><br>
                    Genero: <?php echo $sexo; ?><br>
                    Presión Arterial: <?php echo $presion_arterial; ?><br>
                    Azucar: <?php echo $nivel_azucar; ?><br>
                    Peso: <?php echo $peso; ?><br>
                    Estatura: <?php echo $estatura; ?><br>
                    Temperatura: <?php echo $temperatura; ?><br>
                </address>
            </div>
            <!-- END Client Info -->
        </div>
        <!-- END Invoice Info -->

        <!-- Table -->
        <div class="table-responsive push">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center"></th>
                        <th>Datos de Revisión del Paciente</th>


                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center"></td>
                        <td>
                            <p class="font-w600 mb-5">Motivo de Consulta:</p>
                            <div class="text-muted"><?php echo $motivo_consulta; ?></div>

                        </td>
                    </tr>
                    <tr>
                        <td class="text-center"></td>
                        <td>

                            <p class="font-w600 mb-5">Tratamiento Sugerido:</p>
                            <div class="text-muted"><?php echo $tratamiento_sujerido; ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center"></td>
                        <td>

                            <p class="font-w600 mb-5">Tiempo de Tratamiento:</p>
                            <div class="text-muted"><?php echo $tiempo_tratamiento_clinico; ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center"></td>
                        <td>

                            <p class="font-w600 mb-5">Tiempo de Tratamiento Sujerido:</p>
                            <div class="text-muted"><?php echo $tiempo_tratamiento_sujerido; ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center"></td>
                        <td>

                            <p class="font-w600 mb-5">Dosis del Tratamiento:</p>
                            <div class="text-muted"><?php echo $dosis_del_tratamiento; ?></div>
                        </td>
                    </tr>


                </tbody>
            </table>
        </div>
        <!-- Footer -->
        <p class="text-muted text-center">Agradecemos su prefencia. | <?php echo $titulo; ?></p>
        <!-- END Footer -->
        <!-- END Table -->


    </div>




</div>