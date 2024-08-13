<!-- Block Default Style -->
<div class="block">
    <div class="container-fluid">
        <fieldset>
            <legend>Datos del Paciente</legend>

            <div class="alert alert-warning" role="alert">
                <i class="text-uppercase"><b>Nota:</b> Los Campos con Asterisco son Obligatorios.</i><br>
            </div>

            <div class="row">
                <!-- Nombre del Paciente -->
                <div class="col-md-6 mb-3">
                    <div class="form-material">
                        <input type="text" class="form-control" id="nombre" name="nombre"
                            placeholder="Nombre del paciente" value="<?php echo $paciente->nombre ?? ''; ?>">
                        <label for="nombre"><span class="text-danger">*</span>Nombre del Paciente</label>
                    </div>
                </div>

                <!-- Apellidos del Paciente -->
                <div class="col-md-6 mb-3">
                    <div class="form-material">
                        <input type="text" class="form-control" id="apellidos" name="apellidos"
                            placeholder="Apellidos del paciente" value="<?php echo $paciente->apellidos ?? ''; ?>">
                        <label for="apellidos"><span class="text-danger">*</span>Apellidos del Paciente</label>
                    </div>
                </div>

                <!-- Fecha de Nacimiento -->
                <div class="col-md-6 mb-3">
                    <div id="notaEdad" class="alert alert-info" style="display:none; margin-top: 10px;">
                        La edad ha sido calculada.
                    </div>
                    <div class="form-material">
                        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento"
                            value="<?php echo $paciente->fecha_nacimiento ?? ''; ?>"
                            onblur="calcularEdad(); mostrarNota()">
                        <label for="fecha_nacimiento"><span class="text-danger">*</span>Fecha de Nacimiento</label>
                    </div>
                </div>

                <!-- Edad -->
                <div class="col-md-6 mb-3">
                    <div class="form-material">
                        <input type="text" class="form-control" id="edad" name="edad"
                            value="<?php echo $paciente->edad ?? ''; ?>" readonly>
                        <label for="edad">Edad</label>
                    </div>
                </div>

                <!-- Género -->
                <div class="col-md-6 mb-3">
                    <div class="form-material">
                        <select class="form-control" id="sexo_id" name="sexo_id">
                            <option>-- Selecciona una Opción --</option>
                            <?php foreach ($generos as $genero) { ?>
                            <option <?php echo ($paciente->sexo_id === $genero->id ? 'selected' : ''); ?>
                                value="<?php echo $genero->id; ?>"><?php echo $genero->sexo; ?></option>
                            <?php } ?>
                        </select>
                        <label for="sexo_id"><span class="text-danger">*</span>Selecciona el Género</label>
                    </div>
                </div>

                <!-- Peso del Paciente -->
                <div class="col-md-6 mb-3">
                    <div class="form-material">
                        <input type="number" class="form-control" id="peso" name="peso" placeholder="Peso"
                            value="<?php echo $paciente->peso ?? ''; ?>">
                        <label for="peso"><span class="text-danger">*</span>Peso del Paciente</label>
                    </div>
                </div>

                <!-- Telefono del Paciente -->
                <div class="col-md-6 mb-3">
                    <div class="form-material">
                        <input type="number" class="form-control" id="telefono" name="telefono" placeholder="Teléfono"
                            value="<?php echo $paciente->telefono ?? ''; ?>">
                        <label for="telefono"><span class="text-danger">*</span>Teléfono del Paciente</label>
                    </div>
                </div>

                <!-- Correo del Paciente -->
                <div class="col-md-6 mb-3">
                    <div class="form-material">
                        <input type="email" class="form-control" id="correo" name="correo"
                            placeholder="Correo Electrónico" value="<?php echo $paciente->correo ?? ''; ?>">
                        <label for="correo"><span class="text-danger">*</span>Correo Electrónico del Paciente</label>
                    </div>
                </div>

                <!-- Presión Arterial -->
                <div class="col-md-6 mb-3">
                    <div class="form-material">
                        <input type="text" class="form-control" id="presion_arterial" name="presion_arterial"
                            placeholder="Presión Arterial" value="<?php echo $paciente->presion_arterial ?? ''; ?>">
                        <label for="presion_arterial"><span class="text-danger">*</span>Presión Arterial del
                            Paciente</label>
                    </div>
                </div>

                <!-- Nivel de Azúcar -->
                <div class="col-md-6 mb-3">
                    <div class="form-material">
                        <input type="text" class="form-control" id="nivel_azucar" name="nivel_azucar"
                            placeholder="Nivel de Azúcar" value="<?php echo $paciente->nivel_azucar ?? ''; ?>">
                        <label for="nivel_azucar"><span class="text-danger">*</span>Nivel de Azúcar del Paciente</label>
                    </div>
                </div>

                <!-- Estatura del Paciente -->
                <div class="col-md-6 mb-3">
                    <div class="form-material d-flex align-items-center">
                        <label for="estatura"><span class="text-danger">*</span>Estatura del Paciente (metros,
                            centímetros)</label>
                        <div class="input-group ml-3">
                            <input type="number" class="form-control" id="metros" name="metros" placeholder="Metros"
                                style="max-width: 250px;" value="<?php echo isset($metros) ? $metros : ''; ?>">
                            <div class="input-group-append">
                                <span class="input-group-text">m</span>
                            </div>
                        </div>
                        <div class="input-group ml-3">
                            <input type="number" class="form-control" id="centimetros" name="centimetros"
                                placeholder="Centímetros" style="max-width: 250px;"
                                value="<?php echo isset($centimetros) ? $centimetros : ''; ?>">
                            <div class="input-group-append">
                                <span class="input-group-text">cm</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Temperatura Corporal -->
                <div class="col-md-6 mb-3">
                    <div class="form-material">
                        <input type="text" class="form-control" id="temperatura" name="temperatura"
                            placeholder="Temperatura Corporal" value="<?php echo $paciente->temperatura ?? ''; ?>">
                        <label for="temperatura"><span class="text-danger">*</span>Temperatura Corporal del
                            Paciente</label>
                    </div>
                </div>
            </div>

            <legend>Datos de Consulta & Antecedentes</legend>

            <div class="row">
                <!-- Antecedentes Médicos -->
                <?php 
    $antecedentes = [
        "diabetes" => "Diabetes",
        "cancer" => "Cáncer",
        "obesidad" => "Obesidad",
        "infartos" => "Infartos",
        "alergias" => "Alergias",
        "depresion" => "Depresión",
        "artritis" => "Artritis",
        "estrenimiento" => "Estreñimiento",
        "gastritis" => "Gastritis",
        "comida_chatarra" => "Comida Chatarra",
        "fumas" => "Fumas",
        "bebes" => "Bebes",
        "cirugias" => "Cirugías",
        "embarazos" => "Embarazos",
        "abortos" => "Abortos"
    ];
    foreach ($antecedentes as $id => $label) { ?>
                <div class="col-md-3 mb-4">
                    <div class="form-material">
                        <input type="checkbox" class="form-check-input" id="<?php echo $id; ?>"
                            name="<?php echo $id; ?>" value="1" <?php echo ($paciente->$id == '1') ? 'checked' : ''; ?>
                            onclick="toggleField('<?php echo $id; ?>')">
                        <label class="form-check-label" for="<?php echo $id; ?>"><?php echo $label; ?></label>
                    </div>
                </div>
                <?php } ?>
            </div>

            <!-- Campos adicionales -->
            <div id="cirugias_fields" class="row" style="display: none;">
                <div class="col-md-6 mb-4">
                    <label for="num_cirugias">Número de cirugías:</label>
                    <input type="number" class="form-control" id="num_cirugias" name="num_cirugias">
                </div>
                <div class="col-md-6 mb-4">
                    <label for="desc_cirugias">Descripción de cirugías:</label>
                    <textarea class="form-control" id="desc_cirugias" name="desc_cirugias"></textarea>
                </div>
            </div>

            <div id="embarazos_fields" class="row" style="display: none;">
                <div class="col-md-6 mb-4">
                    <label for="num_embarazos">Número de embarazos:</label>
                    <input type="number" class="form-control" id="num_embarazos" name="num_embarazos">
                </div>
            </div>

            <div id="abortos_fields" class="row" style="display: none;">
                <div class="col-md-6 mb-4">
                    <label for="num_abortos">Número de abortos:</label>
                    <input type="number" class="form-control" id="num_abortos" name="num_abortos">
                </div>
            </div>

            <div class="row">
                <!-- Motivo de Consulta -->
                <div class="col-md-12 mb-3">
                    <div class="form-material">
                        <textarea class="form-control" id="motivo_consulta" name="motivo_consulta" rows="8"
                            placeholder="Motivo de consulta"><?php echo $paciente->motivo_consulta ?? ''; ?></textarea>
                        <label for="motivo_consulta"><span class="text-danger">*</span>Motivo de Consulta...</label>
                    </div>
                </div>

                <!-- Tratamiento Sugerido -->
                <div class="col-md-12 mb-3">
                    <div class="form-material">
                        <textarea class="form-control" id="tratamiento_sujerido" name="tratamiento_sujerido" rows="8"
                            placeholder="Tratamiento sugerido"><?php echo $paciente->tratamiento_sujerido ?? ''; ?></textarea>
                        <label for="tratamiento_sujerido"><span class="text-danger">*</span>Ingresa el Tratamiento
                            Sugerido...</label>
                    </div>
                </div>

                <!-- Tiempo de Tratamiento -->
                <div class="col-md-6 mb-3">
                    <div class="form-material">
                        <input type="text" class="form-control" id="tiempo_tratamiento_clinico"
                            name="tiempo_tratamiento_clinico" placeholder="Tiempo de tratamiento clínico"
                            value="<?php echo $paciente->tiempo_tratamiento_clinico ?? ''; ?>">
                        <label for="tiempo_tratamiento_clinico"><span class="text-danger">*</span>Tiempo de Tratamiento
                            Clínico</label>
                    </div>
                </div>

                <!-- Tiempo de Tratamiento -->
                <div class="col-md-6 mb-3">
                    <div class="form-material">
                        <input type="text" class="form-control" id="tiempo_tratamiento_clinico"
                            name="tiempo_tratamiento_sujerido" placeholder="Tiempo de tratamiento sugerido"
                            value="<?php echo $paciente->tiempo_tratamiento_sujerido ?? ''; ?>">
                        <label for="tiempo_tratamiento_sujerido"><span class="text-danger">*</span>Tiempo de Tratamiento
                            Sugerido</label>
                    </div>
                </div>


                <!-- Tiempo de Tratamiento -->
                <div class="col-md-6 mb-3">
                    <div class="form-material">
                        <input type="text" class="form-control" id="tiempo_tratamiento_clinico" name="dosis_tratamiento"
                            placeholder="Dosis del Tratamiento"
                            value="<?php echo $paciente->dosis_tratamiento ?? ''; ?>">
                        <label for="dosis_tratamiento"><span class="text-danger">*</span>Ingresa la dosis por día y
                            hora</label>
                    </div>
                </div>

                <!-- Diagnóstico -->
                <div class="col-md-6 mb-3">
                    <div class="form-material">
                        <input type="text" class="form-control" id="diagnostico" name="diagnostico"
                            placeholder="Diagnóstico" value="<?php echo $paciente->diagnostico ?? ''; ?>">
                        <label for="diagnostico"><span class="text-danger">*</span>Diagnóstico</label>
                    </div>
                </div>

                <!-- Observaciones -->
                <div class="col-md-12 mb-3">
                    <div class="form-material">
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="8"
                            placeholder="Observaciones..."><?php echo $paciente->observaciones ?? ''; ?></textarea>
                        <label for="observaciones"><span class="text-danger">*</span>Observaciones...</label>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-material">
                        <input type="file" class="form-control" id="expediente_file" name="expediente_file"
                            accept=".pdf,.docx,.doc" multiple>
                        <label for="expediente_file"><span class="text-danger">*</span>Expediente Médico</label>
                    </div>
                </div>

                <?php if (isset($paciente->expediente_actual)) { ?>
                <div class="col-md-12 mb-3">
                    <div class="form-material">
                        <label for="expediente_file"><span class="text-danger">*</span>Expediente Médico
                            Actual:</label><br>
                        <a href="<?php echo $_ENV['HOST'] . '/docs/patients/' . $paciente->expediente_file; ?>"
                            class="btn btn-rounded btn-outline-primary" target="_black"><i
                                class="fa fa-file-pdf-o mr-5"></i>Click aquí para ver el Expediente actual</a>
                    </div>
                </div>
                <?php } ?>


                <legend>Domicilio del Paciente</legend>

                <div class="col-md-6 mb-3">
                    <div class="form-material">
                        <input type="text" class="form-control" id="n_calle_avenida" name="n_calle_avenida"
                            placeholder="Calle o avenida" value="<?php echo $paciente->n_calle_avenida ?? ''; ?>">
                        <label for="n_calle_avenida">Calle o Avenida</label>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-material">
                        <input type="text" class="form-control" id="n_exterior" name="n_exterior"
                            placeholder="Número exterior" value="<?php echo $paciente->n_exterior ?? ''; ?>">
                        <label for="n_exterior">Número Exterior</label>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-material">
                        <input type="text" class="form-control" id="n_interior" name="n_interior"
                            placeholder="Número interior" value="<?php echo $paciente->n_interior ?? ''; ?>">
                        <label for="n_interior">Número Interior</label>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-material">
                        <input type="text" class="form-control" id="colonia_barrio" name="colonia_barrio"
                            placeholder="Colonia o barrio" value="<?php echo $paciente->colonia_barrio ?? ''; ?>">
                        <label for="colonia_barrio">Colonia o Barrio</label>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-material">
                        <input type="text" class="form-control" id="municipio_delegacion" name="municipio_delegacion"
                            placeholder="Municipio o delegación"
                            value="<?php echo $paciente->municipio_delegacion ?? ''; ?>">
                        <label for="municipio_delegacion">Municipio o Delegación</label>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-material">
                        <input type="text" class="form-control" id="estado_provincia" name="estado_provincia"
                            placeholder="Estado o provincia" value="<?php echo $paciente->estado_provincia ?? ''; ?>">
                        <label for="estado_provincia">Estado o Provincia</label>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-material">
                        <input type="text" class="form-control" id="cp" name="cp" placeholder="Código postal"
                            value="<?php echo $paciente->cp ?? ''; ?>">
                        <label for="cp">Código Postal</label>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</div>

<script>
function calcularEdad() {
    const fechaNacimiento = document.getElementById('fecha_nacimiento').value;
    if (fechaNacimiento) {
        const hoy = new Date();
        const nacimiento = new Date(fechaNacimiento);
        let edad = hoy.getFullYear() - nacimiento.getFullYear();
        const mes = hoy.getMonth() - nacimiento.getMonth();
        if (mes < 0 || (mes === 0 && hoy.getDate() < nacimiento.getDate())) {
            edad--;
        }
        document.getElementById('edad').value = edad;
    }
}

function mostrarNota() {
    const notaEdad = document.getElementById('notaEdad');
    notaEdad.style.display = 'block';
    setTimeout(() => {
        notaEdad.style.display = 'none';
    }, 1000);
}

function toggleField(id) {
    const fields = {
        'cirugias': 'cirugias_fields',
        'embarazos': 'embarazos_fields',
        'abortos': 'abortos_fields'
    };

    if (fields[id]) {
        const fieldSet = document.getElementById(fields[id]);
        if (document.getElementById(id).checked) {
            fieldSet.style.display = 'block';
        } else {
            fieldSet.style.display = 'none';
        }
    }
}

// Verifica si alguna casilla ya está marcada al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    toggleField('cirugias');
    toggleField('embarazos');
    toggleField('abortos');
});
</script>