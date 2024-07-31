<h2 class="content-heading d-print-none">
    <a href="/admin/perfil/cambiar-password" class="btn btn-alt-primary float-right">
       Cambiar Password <i class="si si-action-redo ml-5"></i>
    </a>
</h2>
<h2 class="content-heading">Datos de Perfil</h2>
<p>Puedes Modificar los datos de inicio de sesión.</p>
<div class="block">
    <div class="block-content">
        <div class="col-xl-12">
            <?php include_once __DIR__ . '/../../templates/alertas.php'; ?>
            

            <form class="js-validation-material" method="POST" action="/admin/perfil">
                <div class="form-group">
                    <div class="form-material">
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Tú nombre" value="<?php echo $usuario->nombre; ?>">
                        <label for="nombre"><span class="text-danger">*</span>Nombre</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material">
                        <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Tú apellido(s)" value="<?php echo $usuario->apellido; ?>">
                        <label for="apellido"><span class="text-danger">*</span>Apellido(s)</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Tú email" value="<?php echo $usuario->email; ?>">
                        <label for="email"><span class="text-danger">*</span>Email</label>
                    </div>
                </div>


                <div class="form-group">
                    <button type="submit" class="btn btn-alt-primary">Guardar Cambios</button>
                </div>
            </form>

        </div>
    </div>
</div>