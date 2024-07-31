<?php if (!empty($pacientes)): ?>
    <label for="paciente"><span class="text-danger">*</span>Seleccionar Paciente</label>
    <select class="form-control" id="paciente" name="paciente_id" required>
        <option value="">-- Selecciona al Paciente --</option>
        <?php foreach ($pacientes as $paciente): ?>
            <option value="<?php echo $paciente->id; ?>"><?php echo htmlspecialchars($paciente->nombre . ' ' . $paciente->apellidos); ?></option>
        <?php endforeach; ?>
    </select>

    <label for="fecha"><span class="text-danger">*</span>Fecha de la Cita</label>
    <input type="date" class="form-control" id="fecha" name="fecha" required>

    <label for="hora"><span class="text-danger">*</span>Hora de la Cita</label>
    <input type="time" class="form-control" id="hora" name="hora" required>

    <label for="descripcion"><span class="text-danger">*</span>Descripción de la Cita</label>
    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Ingresa la Descripción de la Cita" required></textarea>
<?php else: ?>
    <div class="alert alert-warning" role="alert">
        No hay pacientes asociados a este médico. Por favor, registre pacientes antes de crear una cita.
    </div>
<?php endif; ?>