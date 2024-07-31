<h2 class="content-heading d-print-none">
    <a href="/admin/consulta_terapia_alternativa" class="btn btn-alt-primary float-right">
       Regresar <i class="si si-action-undo ml-5"></i>
    </a>
    <?php echo $titulo; ?> | Seguimiento
</h2>
<div class="block">
    <div class="block-content">
        <div class="block-header block-header-default">
            <h3 class="block-title text-uppercase"><?php echo $titulo; ?></h3>
        </div>
        <div class="row justify-content-center py-20">
            <div class="col-xl-6">
                <?php include_once __DIR__ . '/../../templates/alertas.php'; ?>
                <form class="js-validation-material" id="paciente_form" method="POST" enctype="multipart/form-data" action="/admin/consulta_terapia_alternativa/crear">
                    <?php include_once __DIR__ . '/formulario.php'; ?>

                    <div class="form-group">
                        <button type="submit" name="save" id="btnguardarPaciente" class="btn btn-alt-primary">Registrar Consulta Alternativa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>