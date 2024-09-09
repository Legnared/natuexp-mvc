<div class="block">
    <div class="block-header block-header-default">
        <a href="/admin/system/usuarios" class="btn btn-alt-primary">
            Regresar <i class="si si-action-undo ml-5"></i>
        </a>

        <a href="/admin/system/usuarios/cambiar-password?id=<?= $usuario->id ?>"
            class="btn btn-alt-primary float-right">
            Cambiar Contraseña del Usuario <i class="si si-lock ml-5"></i>
        </a>

    </div>
</div>
<div class="block">
    <div class="block-content">
        <div class="block-header block-header-default">
            <h1 class="block-title"><?php echo $titulo; ?></h1>
        </div>
        <div class="row justify-content-center py-20">
            <div class="col-xl-6">
                <?php include_once __DIR__ . '/../../../template/alerta.php'; ?>
                <form class="js-validation-material" id="usuario_form" method="POST" enctype="multipart/form-data">

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
                                <input type="file" class="form-control" id="foto" name="foto[]"
                                    accept=".png,.jpg,.jpeg,.webp" multiple>
                            </div>
                        </div>
                    </div>

                    <!-- Mostrar imagen de perfil actual -->
                    <?php if (isset($usuario->foto) && $usuario->foto) { ?>
                    <div class="col-md-6 mb-3">
                        <div class="form-material">
                            <label for="foto_actual">
                                <span class="text-danger">*</span> Foto del Usuario Actual:
                            </label><br>
                            <div class="d-flex">
                                <?php 
            $imageFormats = ['png', 'jpg', 'jpeg', 'webp'];
            foreach (explode(',', $usuario->foto) as $foto) {
                $filePath = $_ENV['HOST'] . '/img/users/' . urlencode($foto);
                echo '<img src="' . htmlspecialchars($filePath, ENT_QUOTES, 'UTF-8') . '" class="img-thumbnail mr-2" width="150">';
            }
            ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
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
                                <input type="text" class="form-control" id="colonia" name="colonia"
                                    value="<?php echo htmlspecialchars($direccion->colonia); ?>">
                                <label for="colonia">Colonia o Barrio</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-12">
                            <div class="form-material floating">
                                <input type="text" class="form-control" id="pais" name="pais"
                                    value="<?php echo htmlspecialchars($direccion->pais); ?>">
                                <label for="pais">País</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-12">
                            <div class="form-material floating">
                                <input type="text" class="form-control" id="municipio" name="municipio"
                                    value="<?php echo htmlspecialchars($direccion->municipio); ?>">
                                <label for="municipio">Municipio</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-12">
                            <div class="form-material floating">
                                <input type="text" class="form-control" id="estado" name="estado"
                                    value="<?php echo htmlspecialchars($direccion->estado); ?>">
                                <label for="estado">Estado</label>
                            </div>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-12">
                            <div class="form-material floating">
                                <select class="form-control" id="rol_id" name="rol_id" required>
                                    <option value="">-- Selecciona un Rol --</option>
                                    <?php foreach ($roles as $rol): ?>
                                    <option value="<?php echo htmlspecialchars($rol->id); ?>"
                                        <?php echo $usuario->rol_id == $rol->id ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($rol->nombre); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="rol_id"><span class="text-danger">*</span> Rol</label>
                            </div>
                        </div>
                    </div>



                    <div class="form-group row">
                        <div class="col-12">
                            <div class="form-material floating">
                                <select class="form-control" id="estatus" name="estatus" required>
                                    <option value="">-- Selecciona el Estatus --</option>
                                    <option value="1" <?php echo $usuario->estatus == 1 ? 'selected' : ''; ?>>Activo
                                    </option>
                                    <option value="0" <?php echo $usuario->estatus == 0 ? 'selected' : ''; ?>>Inactivo
                                    </option>
                                </select>
                                <label for="estatus"><span class="text-danger">*</span> Estatus</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" name="save" id="btneditarPaciente" class="btn btn-danger mr-5 mb-5"> <i
                                class="fa fa-edit mr-5"></i>Actualizar Paciente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if (isset($_SESSION['redirect'])): ?>
<script>
setTimeout(function() {
    window.location.href = "<?php echo $_SESSION['redirect']; ?>";
}, 5000); // Redirige después de 5 segundos
</script>
<?php unset($_SESSION['redirect']); // Elimina la variable de sesión después de usarla ?>
<?php endif; ?>