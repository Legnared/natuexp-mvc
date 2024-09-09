<div class="block">
    <div class="block-header block-header-default">
        <a href="/admin/pacientes" class="btn btn-alt-primary">
            Regresar <i class="si si-action-undo ml-5"></i>
        </a>
    </div>
</div>
<div class="block">
    <div class="block-content">
        <div class="block-header block-header-default">
            <h1 class="block-title"><?php echo $titulo; ?></h1>
        </div>
        <div class="row justify-content-center py-20">
            <div class="col-xl">
                <?php include_once __DIR__ . '/../../template/alerta.php'; ?>
                <form class="js-validation-material" id="paciente_form" method="POST" enctype="multipart/form-data">
                    <?php include_once __DIR__ . '/formulario.php'; ?>

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