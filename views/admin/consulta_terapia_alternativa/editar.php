<div class="block">
    <div class="block-header block-header-default">
        <a href="/admin/consulta_terapia_alternativa" class="btn btn-alt-primary">
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
            <div class="col-xl-6">
                <?php include_once __DIR__ . '/../../templates/alertas.php'; ?>
                <form class="js-validation-material" id="paciente_form" method="POST" enctype="multipart/form-data">
                    <?php include_once __DIR__ . '/formulario.php'; ?>

                    <div class="form-group">
                        <button type="submit" name="save" id="btneditarPaciente" class="btn btn-outline-danger mr-5 mb-5"> <i class="fa fa-edit mr-5"></i>Actualizar Paciente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>