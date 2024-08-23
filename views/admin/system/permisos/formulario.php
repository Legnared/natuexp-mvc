<label for="nombre"><span class="text-danger">*</span> Nombre del Permiso</label>
<input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($permiso->nombre); ?>" required>

<label for="rol_id"><span class="text-danger">*</span> Rol Asociado</label>
<select class="form-control" id="rol_id" name="rol_id" required>
    <option value="">-- Selecciona el Rol --</option>
    <?php foreach ($roles as $rol) : ?>
        <option value="<?php echo htmlspecialchars($rol->id); ?>" <?php echo $permiso->rol_id == $rol->id ? 'selected' : ''; ?>>
            <?php echo htmlspecialchars($rol->nombre); ?>
        </option>
    <?php endforeach; ?>
</select>

<label for="descripcion">Descripción del Permiso</label>
<textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Ingresa la Descripción del Permiso"><?php echo htmlspecialchars($permiso->descripcion); ?></textarea>
