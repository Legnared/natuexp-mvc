<!-- crear.php -->
<h2 class="content-heading d-print-none">
    <a href="/admin/system/roles" class="btn btn-alt-primary mt-3 float-right">
        Regresar <i class="si si-action-undo ml-5"></i>
    </a>
    <?php echo $titulo; ?> | Gestión de Roles | Crear Nuevo Rol
</h2>
<div class="block">
    <div class="block-content">
        <div class="block-header block-header-default">
            <h3 class="block-title text-uppercase"><?php echo $titulo; ?></h3>
        </div>
        <div class="row justify-content-center py-20">
            <div class="col-xl-6">
                <?php include_once __DIR__ . '/../../../template/alerta.php'; ?>

                <!-- Formulario para crear un nuevo rol -->
                <form class="js-validation-material" id="rol_form" method="POST" action="/admin/system/roles/crear">
                    <?php include_once __DIR__ . '/formulario.php'; ?>

                    <!-- Botón de submit -->
                    <button type="submit" class="btn btn-primary mt-3">Crear Rol</button>
                </form>
            </div>
        </div>
    </div>
</div>
