<!-- formulario.php -->
<label for="nombre"><span class="text-danger">*</span> Nombre del Rol</label>
<input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($rol->nombre); ?>" required>

<label for="estatus"><span class="text-danger">*</span> Estatus</label>
<select class="form-control" id="estatus" name="estatus" required>
    <option value="">-- Selecciona el Estatus --</option>
    <option value="1" <?php echo $rol->estatus == 1 ? 'selected' : ''; ?>>Activo</option>
    <option value="0" <?php echo $rol->estatus == 0 ? 'selected' : ''; ?>>Inactivo</option>
</select>

<label for="descripcion">Descripción del Rol</label>
<textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Ingresa la Descripción del Rol"><?php echo htmlspecialchars($rol->descripcion); ?></textarea>
