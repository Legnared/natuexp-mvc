<h2 class="content-heading d-print-none">
    <a href="/admin/system/perfil" class="btn btn-alt-primary float-left">
        Regresar <i class="si si-action-undo ml-5"></i>
    </a>
    <a href="/admin/system/perfil/cambiar-foto" class="btn btn-alt-primary float-right">
        Cambiar Foto de Perfil <i class="si si-action-redo ml-5"></i>
    </a>
</h2>


<h2 class="content-heading">Datos de Perfil</h2>
<p>Puedes Modificar los datos de inicio de sesión.</p>
<div class="block">
    <div class="block-content">
        <div class="col-xl-12">
            <?php include_once __DIR__ . '/../../../template/alerta.php'; ?>
            <form class="js-validation-material" method="POST" action="/admin/system/perfil/cambiar-password">
                <div class="form-group">
                    <div class="form-material">
                        <input type="password" class="form-control form-control-sm" id="password_actual"
                            name="password_actual" placeholder="Tú Password Actual">
                        <label for="password_actual"><span class="text-danger">*</span>Password Actual</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material">
                        <input type="password" class="form-control form-control-sm" id="password_nuevo"
                            name="password_nuevo" placeholder="Tú Nueva Password">
                        <label for="password_nuevo"><span class="text-danger">*</span>Password Nuevo</label>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-alt-primary">Guardar Cambios</button>
                </div>
            </form>


        </div>
    </div>
</div>