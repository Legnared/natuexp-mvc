
<h2 class="content-heading d-print-none">
    <?php echo htmlspecialchars($titulo); ?><br><br>
    <a href="/admin/pacientes" class="btn btn-alt-primary float-left">
        Regresar <i class="si si-action-undo ml-5"></i>
    </a>
</h2>


<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title"><?php echo htmlspecialchars($titulo); ?></h3><br>
        <div class="block-options">
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
        <div class="row my-20">
            <!-- Company Info -->
            <div class="col-6">
                <p class="h3">E Clínicos</p>
                <address>
                    Morelia, Michoacán<br>
                    Region, 58197<br>
                    Terapeuta: <strong><b><?php echo htmlspecialchars($_SESSION["nombre"] . " " . $_SESSION['apellido']); ?></b></strong><br>
                    Correo: <strong><b><?php echo htmlspecialchars($_SESSION["email"]); ?></b></strong><br>
                    Teléfono: <strong><b><?php echo htmlspecialchars($_SESSION["telefono"]); ?></b></strong><br>
                </address>
            </div>
            <!-- END Company Info -->

            <!-- Patient Info -->
            <div class="col-6 text-right">
                <p class="h3">Paciente:</p>
                <address>
                    Nombre: <?php echo htmlspecialchars($nombre_paciente); ?><br>
                    Edad: <?php echo htmlspecialchars($edad); ?> años<br>
                    Género: <?php echo htmlspecialchars($sexo); ?><br>
                    Peso: <?php echo htmlspecialchars($peso); ?> Kgs<br>
                    Estatura: <?php echo htmlspecialchars($estatura); ?> mts.<br>
                    Glucosa: <?php echo htmlspecialchars($nivel_azucar); ?> .<br>
                    Presión Arterial: <?php echo htmlspecialchars($presion_arterial); ?>.<br>
                </address>
            </div>
            <!-- END Patient Info -->
        </div>
        <!-- END Patient Info -->

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
                            <div class="text-muted"><?php echo htmlspecialchars($motivo_consulta); ?></div>
                            <p class="font-w600 mb-5">Observaciones:</p>
                            <div class="text-muted"><?php echo htmlspecialchars($observaciones); ?></div>
                            <p class="font-w600 mb-5">Diagnóstico:</p>
                            <div class="text-muted"><?php echo htmlspecialchars($diagnostico); ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center"></td>
                        <td>
                            <p class="font-w600 mb-5">Tratamiento Sugerido:</p>
                            <div class="text-muted"><?php echo  htmlspecialchars($tratamiento_sujerido); ?></div>
                            <p class="font-w600 mb-5">Dosis del Tratamiento:</p>
                            <div class="text-muted"><?php echo htmlspecialchars($dosis_tratamiento); ?></div>
                            <p class="font-w600 mb-5">Duración del Tratamiento:</p>
                            <div class="text-muted"><?php echo htmlspecialchars($tiempo_tratamiento_clinico); ?></div>
                            <p class="font-w600 mb-5">Duración del Tratamiento Antes de Proxima Revisión:</p>
                            <div class="text-muted"><?php echo htmlspecialchars($tiempo_tratamiento_sujerido); ?></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- END Table -->

        <!-- Footer -->
        <p class="text-muted text-center">Agradecemos su preferencia. | <?php echo htmlspecialchars($titulo); ?></p>
        <!-- END Footer -->
    </div>
</div>
