<h2 class="content-heading d-print-none">
    <a href="/admin/system/usuarios" class="btn btn-alt-primary float-left">
        Regresar <i class="si si-action-undo ml-5"></i>
    </a>
</h2>

<h2 class="content-heading"><?php echo $titulo; ?></h2>
<p>Puedes restablecer la contraseña del usuario aquí.</p>
<div class="block">
    <div class="block-content">
        <div class="col-xl-12">
            <?php include_once __DIR__ . '/../../../template/alerta.php'; ?>
            <form class="js-validation-material" method="POST"
                action="/admin/system/usuarios/cambiar-password?id=<?= $usuario->id ?>">
                <div class="form-group">
                    <div class="form-material">
                        <input type="password" class="form-control form-control-sm" id="password_nuevo"
                            name="password_nuevo" placeholder="Nueva Contraseña">
                        <label for="password_nuevo"><span class="text-danger">*</span> Nueva Contraseña</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-material">
                        <input type="password" class="form-control form-control-sm" id="password_nuevo_confirm"
                            name="password_nuevo_confirm" placeholder="Confirmar Nueva Contraseña">
                        <label for="password_nuevo_confirm"><span class="text-danger">*</span> Confirmar Nueva
                            Contraseña</label>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-alt-primary">Guardar Cambios</button>
                </div>
            </form>
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