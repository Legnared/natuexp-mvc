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
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ej. Fulano"
                            value="<?php echo $paciente->nombre ?? ''; ?>">
                        <label for="nombre"><span class="text-danger">*</span>Nombre del Paciente</label>
                    </div>
                </div>

                <!-- Apellidos del Paciente -->
                <div class="col-md-6 mb-3">
                    <div class="form-material">
                        <input type="text" class="form-control" id="apellidos" name="apellidos"
                            placeholder="Ej. Sultano" value="<?php echo $paciente->apellidos ?? ''; ?>">
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
                            <option value="">-- Selecciona una Opción --</option>
                            <?php foreach ($generos as $genero) { ?>
                            <option <?php echo ((int)$paciente->sexo_id === (int)$genero->id ? 'selected' : ''); ?>
                                value="<?php echo $genero->id; ?>"><?php echo $genero->sexo; ?></option>
                            <?php } ?>
                        </select>
                        <label for="sexo_id"><span class="text-danger">*</span>Selecciona el Género</label>
                    </div>
                </div>


                <!-- Peso del Paciente -->
                <div class="col-md-6 mb-3">
                    <div class="form-material">
                        <input type="number" class="form-control" id="peso" name="peso" placeholder="Ej. 70.00"
                            value="<?php echo $paciente->peso ?? ''; ?>">
                        <label for="peso"><span class="text-danger">*</span>Peso del Paciente</label>
                    </div>
                </div>

                <!-- Telefono del Paciente -->
                <div class="col-md-6 mb-3">
                    <div class="form-material">
                        <input type="number" class="form-control" id="telefono" name="telefono"
                            placeholder="Ej. 4432014708" value="<?php echo $paciente->telefono ?? ''; ?>">
                        <label for="telefono"><span class="text-danger">*</span>Teléfono del Paciente</label>
                    </div>
                </div>

                <!-- Correo del Paciente -->
                <div class="col-md-6 mb-3">
                    <div class="form-material">
                        <input type="email" class="form-control" id="correo" name="correo"
                            placeholder="Ej. example@email.mx" value="<?php echo $paciente->correo ?? ''; ?>">
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
                            placeholder="Ej. 90 mg/dL" value="<?php echo $paciente->nivel_azucar ?? ''; ?>">
                        <label for="nivel_azucar"><span class="text-danger">*</span>Nivel de Azúcar del Paciente</label>
                    </div>
                </div>



                <!-- Estatura del Paciente -->
                <div class="col-md-6 mb-3">
                    <div class="form-material d-flex align-items-center">
                        <label for="estatura"><span class="text-danger">*</span> Estatura del Paciente (metros)</label>
                        <div class="input-group ml-3">
                            <input type="number" step="0.01" class="form-control" id="estatura" name="estatura"
                                placeholder="Ej. 1.70" style="max-width: 250px;"
                                value="<?php echo $paciente->estatura ?? ''; ?>">
                            <div class="input-group-append">
                                <span class="input-group-text">m</span>
                            </div>
                        </div>
                    </div>
                </div>





                <!-- Temperatura Corporal -->
                <div class="col-md-6 mb-3">
                    <div class="form-material">
                        <input type="text" class="form-control" id="temperatura" name="temperatura"
                            placeholder="Ej. 36.60" value="<?php echo $paciente->temperatura ?? ''; ?>">
                        <label for="temperatura"><span class="text-danger">*</span>Temperatura Corporal del
                            Paciente</label>
                    </div>
                </div>
            </div>

            <legend>Datos de Consulta & Antecedentes</legend>

            <div class="row justify-content-center">
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
                <div class="col-md-3 col-6 mb-4 text-center">
                    <div class="form-check">
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
                <div class="col-md-12 mb-3">
                    <div class="form-material">
                        <input type="number" class="form-control" id="num_cirugias" name="num_cirugias"
                            value="<?php echo isset($paciente->num_cirugias) ? htmlspecialchars($paciente->num_cirugias) : ''; ?>"
                            placeholder="Número de cirugías">
                        <label for="num_cirugias"><span class="text-danger">*</span>Número de Cirugías</label>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="form-material">
                        <textarea class="form-control" id="desc_cirugias" name="desc_cirugias" rows="4"
                            placeholder="Descripción de las cirugías"><?php echo isset($paciente->desc_cirugias) ? htmlspecialchars($paciente->desc_cirugias) : ''; ?></textarea>
                        <label for="desc_cirugias">Descripción de Cirugías</label>
                    </div>
                </div>
            </div>

            <div id="embarazos_fields" class="row" style="display: none;">
                <div class="col-md-12 mb-3">
                    <div class="form-material">
                        <input type="number" class="form-control" id="num_embarazos" name="num_embarazos"
                            value="<?php echo isset($paciente->num_embarazos) ? htmlspecialchars($paciente->num_embarazos) : ''; ?>"
                            placeholder="Número de embarazos">
                        <label for="num_embarazos"><span class="text-danger">*</span>Número de Embarazos</label>
                    </div>
                </div>
            </div>

            <div id="abortos_fields" class="row" style="display: none;">
                <div class="col-md-12 mb-3">
                    <div class="form-material">
                        <input type="number" class="form-control" id="num_abortos" name="num_abortos"
                            value="<?php echo isset($paciente->num_abortos) ? htmlspecialchars($paciente->num_abortos) : ''; ?>"
                            placeholder="Número de abortos">
                        <label for="num_abortos"><span class="text-danger">*</span>Número de Abortos</label>
                    </div>
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

                <!-- Cargar nuevo archivo -->
                <div class="col-md-6 mb-3">
                    <div class="form-material">
                        <input type="file" class="form-control" id="expediente_file" name="expediente_file[]"
                            accept=".pdf,.docx,.doc,.png,.jpg,.jpeg,.webp" multiple>
                        <label for="expediente_file">
                            <span class="text-danger">*</span> Expediente Médico
                        </label>
                    </div>
                </div>

                <!-- Mostrar el archivo actual -->
                <?php if (isset($paciente->expediente_file) && $paciente->expediente_file) { ?>
                <div class="col-md-12 mb-3">
                    <div class="form-material">
                        <label for="expediente_file">
                            <span class="text-danger">*</span> Expediente Médico Actual:
                        </label><br>
                        <a href="<?php echo $_ENV['HOST'] . '/docs/patients/' . $paciente->expediente_file; ?>"
                            class="btn btn-rounded btn-outline-primary" target="_blank">
                            <i class="fa fa-file-pdf-o mr-5"></i> Click aquí para ver el Expediente actual
                        </a>
                    </div>
                </div>
                <?php } ?>

                <!-- Mostrar imagen de perfil actual -->
                <?php if (isset($paciente->foto) && $paciente->foto) { ?>
                <div class="col-md-12 mb-3">
                    <div class="form-material">
                        <label for="foto_actual">
                            <span class="text-danger">*</span> Foto de Perfil Actual:
                        </label><br>
                        <div class="d-flex">
                            <?php 
                            $imageFormats = ['png', 'jpg', 'jpeg', 'webp'];
                            foreach ($imageFormats as $format) {
                                $imagePath = $_ENV['HOST'] . '/img/patients/' . $paciente->foto . '.' . $format;
                                $filePath = '../public/img/patients/' . $paciente->foto . '.' . $format;
                                if (file_exists($filePath)) {
                                    echo '<img src="' . $imagePath . '" class="img-thumbnail mr-2" width="150">';
                                    break; // Mostrar solo la primera imagen que exista
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?php } ?>

                <!--DATOS DE DOMICILIO DEL PACIENTE-->
                <legend>Domicilio del Paciente</legend>

                <div class="col-md-6 mb-3">
                    <div class="form-material">
                        <input type="text" class="form-control" id="calle" name="calle" placeholder="Calle o avenida"
                            value="<?php echo $paciente->calle ?? ''; ?>">
                        <label for="calle">Calle o Avenida</label>
                    </div>
                </div>


                <div class="col-md-6 mb-3">
                    <div class="form-material">
                        <input type="text" class="form-control" id="numero_exterior" name="numero_exterior"
                            placeholder="Número exterior" value="<?php echo $paciente->numero_exterior ?? ''; ?>">
                        <label for="numero_exterior">Número Exterior</label>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-material">
                        <input type="text" class="form-control" id="numero_interior" name="numero_interior"
                            placeholder="Número interior" value="<?php echo $paciente->numero_interior ?? ''; ?>">
                        <label for="numero_interior">Número Interior</label>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-material">
                        <input type="text" class="form-control" id="colonia" name="colonia"
                            placeholder="Colonia o barrio" value="<?php echo $paciente->colonia ?? ''; ?>">
                        <label for="colonia">Colonia o Barrio</label>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-material">
                        <input type="text" class="form-control" id="municipio" name="municipio"
                            placeholder="Municipio o delegación" value="<?php echo $paciente->municipio ?? ''; ?>">
                        <label for="municipio">Municipio o Delegación</label>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-material">
                        <input type="text" class="form-control" id="estado" name="estado"
                            placeholder="Estado o provincia" value="<?php echo $paciente->estado ?? ''; ?>">
                        <label for="estado">Estado o Provincia</label>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-material">
                        <input type="text" class="form-control" id="codigo_postal" name="codigo_postal"
                            placeholder="Código postal" value="<?php echo $paciente->codigo_postal ?? ''; ?>">
                        <label for="codigo_postal">Código Postal</label>
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
    } else {
        document.getElementById('edad').value = '';
    }
}

function mostrarNota() {
    const notaEdad = document.getElementById('notaEdad');
    if (notaEdad) {
        notaEdad.style.display = 'block';
        setTimeout(() => {
            notaEdad.style.display = 'none';
        }, 1000);
    }
}

function toggleField(id) {
    const fields = {
        'cirugias': 'cirugias_fields',
        'embarazos': 'embarazos_fields',
        'abortos': 'abortos_fields'
    };

    if (fields[id]) {
        const fieldSet = document.getElementById(fields[id]);
        const checkbox = document.getElementById(id);
        if (checkbox && fieldSet) {
            fieldSet.style.display = checkbox.checked ? 'block' : 'none';
        }
    }
}

// Verifica si alguna casilla ya está marcada al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    toggleField('cirugias');
    toggleField('embarazos');
    toggleField('abortos');

    // Asocia el evento de cambio a los checkboxes
    document.getElementById('cirugias').addEventListener('change', () => toggleField('cirugias'));
    document.getElementById('embarazos').addEventListener('change', () => toggleField('embarazos'));
    document.getElementById('abortos').addEventListener('change', () => toggleField('abortos'));
});
</script>