<?php if (!empty($alertas)) : ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php foreach ($alertas as $key => $mensajes) : ?>
                <?php foreach ($mensajes as $mensaje) : ?>
                    new Noty({
                        type: '<?php echo $key; ?>',
                        layout: 'topRight',
                        text: '<?php echo $mensaje; ?>',
                        timeout: 5000,
                        progressBar: true,
                        closeWith: ['click', 'button'],
                        theme: 'relax'
                    }).show();
                <?php endforeach; ?>
            <?php endforeach; ?>
        });
    </script>
<?php endif; ?>
