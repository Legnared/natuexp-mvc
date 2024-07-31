<h2 class="content-heading d-print-none">
    <a href="/admin/perfil" class="btn btn-alt-primary float-left">
        Regresar <i class="si si-action-undo ml-5"></i>
    </a>
</h2>

<h2 class="content-heading">Datos de Perfil</h2>
<p>Puedes Modificar los datos de inicio de sesión.</p>
<div class="block">
    <div class="block-content">
        <div class="col-xl-12">
            <?php include_once __DIR__ . '/../../templates/alertas.php'; ?>
            <form class="js-validation-material" method="POST" enctype="multipart/form-data" action="/admin/perfil/cambiar-foto">
                <div class="form-group">
                    <div class="form-material">
                        <input type="file" class="form-control" id="foto" name="foto" accept=".jpg, .png, .webp">
                        <label for="foto"><span class="text-danger">*</span>Foto de Perfil </label>
                    </div>
                </div>
                <?php if (isset($usuario->foto_actual)) { ?>
                    <p>Imagen Actual:</p>
                    <div class="form-material">
                        <picture>
                            <source class="img-avatar" srcset="<?php echo $_ENV['HOST'] . '/img/photosperfil/' . $usuario->foto; ?>.webp" type="image/webp">
                            <source class="img-avatar" srcset="<?php echo $_ENV['HOST'] . '/img/photosperfil/' . $usuario->foto; ?>.png" type="image/png">
                            <source class="img-avatar" srcset="<?php echo $_ENV['HOST'] . '/img/photosperfil/' . $usuario->foto; ?>.jpg" type="image/jpg">

                            <img class="img-avatar" src="<?php echo $_ENV['HOST'] . '/img/photosperfil/' . $usuario->foto; ?>.png" alt="Foto Perfil">
                        </picture>
                    </div>

                <?php } ?>

                <div class="form-group">
                    <button type="submit" class="btn btn-alt-primary">Guardar Cambios</button>
                </div>
            </form>

        </div>
    </div>
</div>