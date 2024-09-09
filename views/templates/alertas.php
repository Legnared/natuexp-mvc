<?php if (!empty($alertas) && is_array($alertas)): ?>
    <?php foreach ($alertas as $tipo => $mensajes): ?>
        <?php if (is_array($mensajes)): ?>
            <?php foreach ($mensajes as $mensaje): ?>
                <div class="alert alert-dismissible alert-<?php echo htmlspecialchars($tipo); ?> fade show" role="alert">
                    <div class="d-flex align-items-center justify-content-start">
                        <i class="icon ion-ios-checkmark alert-icon tx-32 mg-t-5 mg-xs-t-0"></i>
                        <span><?php echo htmlspecialchars($mensaje); ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>
