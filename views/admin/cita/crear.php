<!-- crear.php -->
<h2 class="content-heading d-print-none">
    <a href="/admin/cita" class="btn btn-alt-primary mt-3 float-right">
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

                <?php if (!empty($pacientes)): ?>
                    <form class="js-validation-material" id="cita_form" method="POST" action="/admin/cita/crear">
                        <?php include_once __DIR__ . '/formulario.php'; ?>
                        
                        <!-- Botón de submit -->
                        <button type="submit" class="btn btn-primary mt-3">Agendar Cita</button>
                    </form>
                <?php else: ?>
                    <div class="alert alert-warning" role="alert">
                        No hay pacientes asociados a este médico. Por favor, registre pacientes antes de crear una cita.
                    </div>
                <?php endif; ?>
                
            </div>
        </div>
    </div>
</div>
