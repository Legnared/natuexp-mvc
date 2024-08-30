<!-- formulario_usuario.php -->
<div class="form-group row">
    <div class="col-12">
        <div class="form-material floating">
            <input type="text" class="form-control" id="nombre" name="nombre"
                value="<?php echo htmlspecialchars($usuario->nombre); ?>" required>
            <label for="nombre"><span class="text-danger">*</span> Nombre del Usuario</label>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-12">
        <div class="form-material floating">
            <input type="text" class="form-control" id="apellido" name="apellido"
                value="<?php echo htmlspecialchars($usuario->apellido); ?>" required>
            <label for="apellido"><span class="text-danger">*</span> Apellido del Usuario</label>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-12">
        <div class="form-material floating">
            <input type="email" class="form-control" id="email" name="email"
                value="<?php echo htmlspecialchars($usuario->email); ?>" required>
            <label for="email"><span class="text-danger">*</span> Correo Electrónico</label>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-12">
        <div class="form-material floating">
            <input type="text" class="form-control" id="telefono" name="telefono"
                value="<?php echo htmlspecialchars($usuario->telefono); ?>">
            <label for="telefono">Teléfono</label>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-12">
        <div class="form-material floating">
            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
            <label for="foto">Foto</label>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-12">
        <div class="form-material floating">
            <input type="password" class="form-control" id="password" name="password">
            <label for="password">Contraseña</label>
        </div>
    </div>
</div>
<div class="form-group row">
    <div class="col-12">
        <div class="form-material floating">
            <input type="password" class="form-control" id="password2" name="password2">
            <label for="password2">Confirmar Contraseña</label>
        </div>
    </div>
</div>


<div class="form-group row">
    <div class="col-12">
        <div class="form-material floating">
            <input type="text" class="form-control" id="calle" name="calle"
                value="<?php echo htmlspecialchars($direccion->calle); ?>" required>
            <label for="calle"><span class="text-danger">*</span> Calle</label>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-12">
        <div class="form-material floating">
            <input type="text" class="form-control" id="numero_exterior" name="numero_exterior"
                value="<?php echo htmlspecialchars($direccion->numero_exterior); ?>" required>
            <label for="numero_exterior"><span class="text-danger">*</span> Número Exterior</label>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-12">
        <div class="form-material floating">
            <input type="text" class="form-control" id="numero_interior" name="numero_interior"
                value="<?php echo htmlspecialchars($direccion->numero_interior); ?>">
            <label for="numero_interior">Número Interior</label>
        </div>
    </div>
</div>



<div class="form-group row">
    <div class="col-12">
        <div class="form-material floating">
            <input type="text" class="form-control" id="codigo_postal" name="codigo_postal"
                value="<?php echo htmlspecialchars($direccion->codigo_postal); ?>">
            <label for="codigo_postal">Código Postal</label>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-12">
        <div class="form-material floating">
            <select class="form-control" id="colonia" name="colonia">
                <option value="">-- Selecciona una Colonia --</option>
            </select>
            <label for="colonia">Colonia</label>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-12">
        <div class="form-material floating">
            <select class="form-control" id="pais" name="pais">
                <option value="">-- Selecciona un País --</option> <!-- Corregido -->
            </select>
            <label for="pais">País</label> <!-- También agregué la tilde en País -->
        </div>
    </div>
</div>


<div class="form-group row">
    <div class="col-12">
        <div class="form-material floating">
            <select class="form-control" id="municipio" name="municipio">
                <option value="">-- Selecciona un Municipio --</option>
            </select>
            <label for="municipio">Municipio</label>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-12">
        <div class="form-material floating">
            <select class="form-control" id="estado" name="estado">
                <option value="">-- Selecciona un Estado --</option>
            </select>
            <label for="estado">Estado</label>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-12">
        <div class="form-material floating">
            <select class="form-control" id="rol" name="rol" required>
                <option value="">-- Selecciona un Rol --</option>
                <?php foreach ($roles as $rol): ?>
                <option value="<?php echo $rol->id; ?>" <?php echo $usuario->rol_id == $rol->id ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($rol->nombre); ?>
                </option>
                <?php endforeach; ?>
            </select>
            <label for="rol"><span class="text-danger">*</span> Rol</label>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-12">
        <div class="form-material floating">
            <select class="form-control" id="estado_usuario" name="estado" required>
                <option value="">-- Selecciona el Estatus --</option>
                <option value="1" <?php echo $usuario->estado == 1 ? 'selected' : ''; ?>>Activo</option>
                <option value="0" <?php echo $usuario->estado == 0 ? 'selected' : ''; ?>>Inactivo</option>
            </select>
            <label for="estado_usuario"><span class="text-danger">*</span> Estatus</label>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const codigoPostalInput = document.getElementById('codigo_postal');

    codigoPostalInput.addEventListener('blur', function() {
        const codigoPostal = codigoPostalInput.value;

        // Verifica que el código postal tenga 5 dígitos numéricos
        if (codigoPostal.length === 5 && /^[0-9]{5}$/.test(codigoPostal)) {
            const apiKey = 'AIzaSyA5MnY_ZYn2LEiGHnEeFQhQGSARIBboVqE'; // Tu API Key
            const url = `https://maps.googleapis.com/maps/api/geocode/json?address=${codigoPostal},Mexico&key=${apiKey}`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    console.log('Respuesta de la API:', data); // Imprime la respuesta para depuración

                    if (data.status === 'OK' && data.results.length > 0) {
                        const result = data.results[0];
                        const addressComponents = result.address_components;
                        const postcodeLocalities = result.postcode_localities || [];

                        const paisSelect = document.getElementById('pais');
                        const coloniaSelect = document.getElementById('colonia');
                        const municipioSelect = document.getElementById('municipio');
                        const estadoSelect = document.getElementById('estado');

                        // Limpia las opciones previas
                        coloniaSelect.innerHTML = '<option value="">-- Selecciona una Colonia --</option>';
                        paisSelect.innerHTML = '<option value="">-- Selecciona el País --</option>';
                        municipioSelect.innerHTML = '<option value="">-- Selecciona un Municipio --</option>';
                        estadoSelect.innerHTML = '<option value="">-- Selecciona un Estado --</option>';

                        // Llena las opciones de colonia basadas en postcode_localities
                        postcodeLocalities.forEach(localidad => {
                            const option = document.createElement('option');
                            option.value = localidad;
                            option.textContent = localidad;
                            coloniaSelect.appendChild(option);
                        });

                        // Llena las opciones de municipio, estado y país basadas en address_components
                        addressComponents.forEach(component => {
                            if (component.types.includes('country')) {
                                const option = document.createElement('option');
                                option.value = component.long_name;
                                option.textContent = component.long_name;
                                paisSelect.appendChild(option);
                            } else if (component.types.includes('locality')) {
                                const option = document.createElement('option');
                                option.value = component.long_name;
                                option.textContent = component.long_name;
                                municipioSelect.appendChild(option);
                            } else if (component.types.includes('administrative_area_level_1')) {
                                const option = document.createElement('option');
                                option.value = component.long_name;
                                option.textContent = component.long_name;
                                estadoSelect.appendChild(option);
                            } else if (component.types.includes('sublocality_level_1') || component.types.includes('neighborhood')) {
                                const option = document.createElement('option');
                                option.value = component.long_name;
                                option.textContent = component.long_name;
                                coloniaSelect.appendChild(option);
                            }
                        });

                    } else {
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: 'Código postal no encontrado en México',
                            timeout: 3000
                        }).show();
                    }
                })
                .catch(error => {
                    console.error('Error al consultar la API:', error);
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Error al consultar la API. Verifica el código postal o intenta nuevamente.',
                        timeout: 3000
                    }).show();
                });
        } else {
            new Noty({
                type: 'warning',
                layout: 'topRight',
                text: 'El código postal debe tener 5 dígitos numéricos',
                timeout: 3000
            }).show();
        }
    });
});
</script>
