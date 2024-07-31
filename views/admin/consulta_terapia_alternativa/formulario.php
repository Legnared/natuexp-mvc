<!-- Block Tabs Default Style -->
<div class="block">
    <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" href="#btabs-static-datos">Datos de Consulta</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#btabs-static-antecedentes">Datos Antecedentes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#btabs-static-exploracion">Datos de Exploración</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#btabs-static-sintomasDiagnosticos">Síntomas o Diagnosticos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#btabs-static-resonancia-biomagnetica-cuantica">Resonancia Biomagnética Cuántica</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#btabs-static-tratamiento">Tratamiento</a>
        </li>
    </ul>
    <div class="block-content tab-content">
        <div class="tab-pane active" id="btabs-static-datos" role="tabpanel">
            <p>
            <fieldset>
                <legend>Datos del Paciente</legend>

                <div class="alert alert-warning" role="alert">
                    <i class="text-uppercase"><b>Nota:</b> Los Campos con Asterisco son Obligatorios.</i><br>
                    <i class="text-uppercase"><b>Nota:</b> LLena todos los campos.</i><br>
                </div>
                <div class="form-group">
                    <div class="form-material">
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresa el Nombre del Paciente" value="<?php echo $paciente->nombre ?? ''; ?>">
                        <label for="nombre"><span class="text-danger">*</span>Nombre del Paciente</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material">
                        <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Ingresa los apellidos del Paciente" value="<?php echo $paciente->apellidos ?? ''; ?>">
                        <label for="apellidos"><span class="text-danger">*</span>Apellidos del Paciente</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material">
                        <input type="text" class="form-control" id="edad" name="edad" placeholder="Ingresa la edad del Paciente" value="<?php echo $paciente->edad ?? ''; ?>">
                        <label for="edad"><span class="text-danger">*</span>Edad del Paciente</label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-9">
                        <div class="form-material">
                            <select class="form-control" id="sexo" name="sexo">
                                <option>-- Selecciona una Opción --</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>

                            </select>
                            <label for="material-select"><span class="text-danger">*</span>Selecciona el Sexo</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material">
                        <input type="text" class="form-control" id="peso" name="peso" placeholder="Ejem: 50 kgs, 60 kgs etc." value="<?php echo $paciente->peso ?? ''; ?>">
                        <label for="peso"><span class="text-danger">*</span>Ingresa el peso del paciente</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material">
                        <input type="text" class="form-control" id="estatura" name="estatura" placeholder="Ejem: 1.60 mts, 1.65 mts etc." value="<?php echo $paciente->estatura ?? ''; ?>">
                        <label for="estatura"><span class="text-danger">*</span>Ingresa la estatura del Paciente</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material">
                        <input type="file" class="form-control" id="expediente_file" name="expediente_file" accept=".pdf,.docx,.doc" multiple>
                        <label for="expediente_file"><span class="text-danger">*</span>Estudio Clínico</label>
                    </div>
                </div>

                <?php if (isset($paciente->expediente_actual)) { ?>

                    <div class="form-group">
                        <div class="form-material">
                            <label for="expediente_file"><span class="text-danger">*</span>Expediente Médico Actual:<br></label>
                            <a href="<?php echo $_ENV['HOST'] . '/docs/consult/' . $paciente->expediente_file; ?>" class="btn btn-rounded btn-outline-primary mr-5 mb-5" target="_black"><i class="fa fa-file-pdf-o mr-5"></i>Click aquí para ver el Expediente actual</a>
                        </div>
                    </div>

                <?php } ?>


                <div class="alert alert-warning" role="alert">
                    <i class="text-uppercase"><b>Nota: </b> El archivo de Expediente Médico debe ser de 1 Megabyte.</i><br>
                    <i class="text-uppercase"><b>Nota: </b> <a href="https://www.ilovepdf.com/es/comprimir_pdf" target="_blank">Click Aquí para Comprimir archivos.</a></i><br>
                </div>


            </fieldset>
            </p>
        </div>
        <div class="tab-pane" id="btabs-static-antecedentes" role="tabpanel">
            <h4 class="font-w400">Antecedentes</h4>
            <p>
            <fieldset>

                <div class="form-group row">
                    <div class="col-md-9">
                        <div class="form-material">
                            <select class="form-control" id="diabetes" name="diabetes">
                                <option>-- Selecciona una Opción --</option>
                                <option value="DMT1">Diabetes Mellitus Tipo 1</option>
                                <option value="DMT2">Diabetes Mellitus Tipo 2</option>
                                <option value="DMG">Diabetes Gestional</option>
                                <option value="NA">Ninguna de las Anteriores</option>
                            </select>
                            <label for="material-select"><span class="text-danger">*</span>Selecciona el tipo de Diabetes</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-9">
                        <div class="form-material">
                            <select class="form-control" id="cancer" name="cancer">
                                <option>-- Selecciona una Opción --</option>
                                <option value="CCR">Cáncer de Colon y recto</option>
                                <option value="CE">Cáncer de endometrio</option>
                                <option value="CH">Cáncer de Hígado</option>
                                <option value="LC">Leucemia</option>
                                <option value="CP">Cáncer de Próstata</option>
                                <option value="CPP">Cáncer de Pulmón</option>
                                <option value="CR">Cáncer de Riñón</option>
                                <option value="CM">Cáncer de Seno(mama)</option>
                                <option value="CT">Cáncer de Tiroides</option>
                                <option value="CV">Cáncer de Vejiga</option>
                                <option value="NA">Ninguna de las Anteriores</option>
                            </select>
                            <label for="material-select"><span class="text-danger">*</span>Selecciona el tipo de Cáncer</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-9">
                        <div class="form-material">
                            <select class="form-control" id="obesidad" name="obesidad">
                                <option>-- Selecciona una Opción --</option>
                                <option value="AG">Anemia Grave</option>
                                <option value="AM">Anemia Moderada</option>
                                <option value="AL">Anemia Leve</option>
                                <option value="NP">Normal</option>
                                <option value="SP">Sobre Peso</option>
                                <option value="I">Obesidad Moderada (Grado I)</option>
                                <option value="II">Obesidad Grave (Grado II)</option>
                                <option value="III">Obesidad Mórbida (Grado III)</option>
                                <option value="IV">Doble Obesidad Mórbida</option>
                                <option value="NA">Ninguna de las Anteriores</option>
                            </select>
                            <label for="material-select"><span class="text-danger">*</span>Selecciona el Grado de Obesidad o Anemia</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-9">
                        <div class="form-material">
                            <select class="form-control" id="depresion" name="depresion">
                                <option>-- Selecciona una Opción --</option>
                                <option value="YES">Sí</option>
                                <option value="NO">No</option>
                            </select>
                            <label for="material-select"><span class="text-danger">*</span>Selecciona si el paciente padece depresión</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-9">
                        <div class="form-material">
                            <select class="form-control" id="infarto" name="infarto">
                                <option>-- Selecciona una Opción --</option>
                                <option value="YES">Sí</option>
                                <option value="NO">No</option>
                            </select>
                            <label for="material-select"><span class="text-danger">*</span>Selecciona si tuvo infarto en los ultimos 3 meses</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-9">
                        <div class="form-material">
                            <select class="form-control" id="estrinido" name="estrinido">
                                <option>-- Selecciona una Opción --</option>
                                <option value="YES">Sí</option>
                                <option value="NO">No</option>
                            </select>
                            <label for="material-select"><span class="text-danger">*</span>Selecciona si esta estriñido el paciente</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-9">
                        <div class="form-material">
                            <select class="form-control" id="alergia" name="alergia">
                                <option>-- Selecciona una Opción --</option>
                                <option value="YES">Sí</option>
                                <option value="NO">No</option>
                            </select>
                            <label for="material-select"><span class="text-danger">*</span>Selecciona si el paciente tiene alergias</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-9">
                        <div class="form-material">
                            <select class="form-control" id="gastritis" name="gastritis">
                                <option>-- Selecciona una Opción --</option>
                                <option value="YES">Sí</option>
                                <option value="NO">No</option>
                            </select>
                            <label for="material-select"><span class="text-danger">*</span>Selecciona si el paciente padece de Gastritis</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-9">
                        <div class="form-material">
                            <select class="form-control" id="artritis" name="artritis">
                                <option>-- Selecciona una Opción --</option>
                                <option value="YES">Sí</option>
                                <option value="NO">No</option>
                            </select>
                            <label for="material-select"><span class="text-danger">*</span>Selecciona si el paciente padece de Artritis</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-9">
                        <div class="form-material">
                            <select class="form-control" id="chatarra" name="chatarra">
                                <option>-- Selecciona una Opción --</option>
                                <option value="YES">Sí</option>
                                <option value="NO">No</option>
                            </select>
                            <label for="material-select"><span class="text-danger">*</span>Selecciona si el paciente come comida Chatarra</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-9">
                        <div class="form-material">
                            <select class="form-control" id="fumador" name="fumador">
                                <option>-- Selecciona una Opción --</option>
                                <option value="YES">Sí</option>
                                <option value="NO">No</option>
                            </select>
                            <label for="material-select"><span class="text-danger">*</span>Selecciona si el paciente es fumador</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-9">
                        <div class="form-material">
                            <select class="form-control" id="bebedor" name="bebedor">
                                <option>-- Selecciona una Opción --</option>
                                <option value="YES">Sí</option>
                                <option value="NO">No</option>
                            </select>
                            <label for="material-select"><span class="text-danger">*</span>Selecciona si el paciente es bebedor </label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-9">
                        <div class="form-material">
                            <select class="form-control" id="cirujias" name="cirujias">
                                <option>-- Selecciona una Opción --</option>
                                <option value="YES">Sí</option>
                                <option value="NO">No</option>
                            </select>
                            <label for="material-select"><span class="text-danger">*</span>Selecciona si el paciente es tiene cirujias </label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-9">
                        <div class="form-material">
                            <select class="form-control" id="embarazos" name="embarazos">
                                <option>-- Selecciona una Opción --</option>
                                <option value="YES">Sí</option>
                                <option value="NO">No</option>
                            </select>
                            <label for="material-select"><span class="text-danger">*</span>Selecciona si el paciente esta embarazado </label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-9">
                        <div class="form-material">
                            <select class="form-control" id="abortos" name="abortos">
                                <option>-- Selecciona una Opción --</option>
                                <option value="YES">Sí</option>
                                <option value="NO">No</option>
                            </select>
                            <label for="material-select"><span class="text-danger">*</span>Selecciona si el paciente a tenido abortos </label>
                        </div>
                    </div>
                </div>
              


            </fieldset>
            </p>
        </div>
        <div class="tab-pane" id="btabs-static-exploracion" role="tabpanel">
            <h4 class="font-w400">Datos de Exploración</h4>
            <p>
            <fieldset>
                <div class="form-group">
                    <div class="form-material">
                        <input type="text" class="form-control" id="oximetro" name="oximetro" placeholder="Ingresa los datos arrojados por el oxímetro del Paciente" value="<?php echo $paciente->oximetro ?? ''; ?>">
                        <label for="oximetro"><span class="text-danger">*</span>Oximetro del Paciente</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material">
                        <input type="text" class="form-control" id="presion" name="presion" placeholder="Ingresa los datos de la Presión del Paciente" value="<?php echo $paciente->presion ?? ''; ?>">
                        <label for="presion"><span class="text-danger">*</span>Presión del Paciente</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material">
                        <input type="text" class="form-control" id="glucosa" name="glucosa" placeholder="Ingresa los datos de la Glucosa del Paciente" value="<?php echo $paciente->glucosa ?? ''; ?>">
                        <label for="glucosa"><span class="text-danger">*</span>Glucosa del Paciente</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material">
                        <input type="text" class="form-control" id="unas" name="unas" placeholder="Ingresa el estado de las Uñas del Paciente" value="<?php echo $paciente->unas ?? ''; ?>">
                        <label for="unas"><span class="text-danger">*</span>Uñas del Paciente</label>
                    </div>
                </div>
            </fieldset>
            </p>
        </div>
        <div class="tab-pane" id="btabs-static-sintomasDiagnosticos" role="tabpanel">
            <h4 class="font-w400">Síntomas o Diagnósticos</h4>
            <p>
            <fieldset>
                <div class="form-group row">
                    <div class="col-12">
                        <div class="form-material">
                            <textarea class="form-control" id="sintoma_diagnostico" name="sintoma_diagnostico" rows="10" placeholder="Ingresa los Síntomas o Diagnósticos Previos a la consulta" value="<?php echo $paciente->sintoma_diagnostico ?? ''; ?>"></textarea>
                            <label for="sintoma_diagnostico"><span class="text-danger">*</span>Síntomas o Diagnósticos...</label>
                        </div>
                    </div>
                </div>
            </fieldset>
            </p>
        </div>
        <div class="tab-pane" id="btabs-static-resonancia-biomagnetica-cuantica" role="tabpanel">
            <h4 class="font-w400">Resultados Resonancia Biomagnética Cuántica</h4>
            <p>
            <fieldset>
                <div class="form-group">
                    <div class="form-material">
                        <input type="text" class="form-control" id="r_corazon" name="r_corazon" placeholder="Los resultados...." value="<?php echo $paciente->r_corazon ?? ''; ?>">
                        <label for="r_corazon"><span class="text-danger">*</span>Ingresa el resultado que dio del corazón</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material">
                        <input type="text" class="form-control" id="r_rinon" name="r_rinon" placeholder="Los resultados...." value="<?php echo $paciente->r_rinon ?? ''; ?>">
                        <label for="r_rinon"><span class="text-danger">*</span>Ingresa el resultado que dio del Riñon</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material">
                        <input type="text" class="form-control" id="r_cerebro" name="r_cerebro" placeholder="Los resultados...." value="<?php echo $paciente->r_cerebro ?? ''; ?>">
                        <label for="r_cerebro"><span class="text-danger">*</span>Ingresa el resultado que dio del Cerebro</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material">
                        <input type="text" class="form-control" id="r_estomago" name="r_estomago" placeholder="Los resultados...." value="<?php echo $paciente->r_estomago ?? ''; ?>">
                        <label for="r_estomago"><span class="text-danger">*</span>Ingresa el resultado que dio del Estomago</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material">
                        <input type="text" class="form-control" id="r_huesos" name="r_huesos" placeholder="Los resultados...." value="<?php echo $paciente->r_huesos ?? ''; ?>">
                        <label for="r_huesos"><span class="text-danger">*</span>Ingresa el resultado que dio de los Huesos</label>
                    </div>
                </div>
            </fieldset>
            </p>
        </div>
        <div class="tab-pane" id="btabs-static-tratamiento" role="tabpanel">
            <h4 class="font-w400">Tratamiento</h4>
            <p>
            <fieldset>
                <div class="form-group row">
                    <div class="col-12">
                        <div class="form-material">
                            <textarea class="form-control" id="tratamiento" name="tratamiento" rows="10" placeholder="Ingresa el Tratamiento a Seguir para el Paciente" value="<?php echo $paciente->tratamiento ?? ''; ?>"></textarea>
                            <label for="tratamiento"><span class="text-danger">*</span>Tratamiento...</label>
                        </div>
                    </div>
                </div>
            </fieldset>
            </p>
        </div>
    </div>
</div>
<!-- END Block Tabs Default Style -->