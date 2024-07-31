<div id="page-container" class="main-content-boxed">
    <main id="main-container">
        <div class="bg-image" style="background-image: url('/build/assets/img/photos/photo37@2x.jpg');">
            <div class="row mx-0 bg-black-op">
                <div class="hero-static col-md-6 col-xl-8 d-none d-md-flex align-items-md-end">
                    <div class="p-30 invisible" data-toggle="appear">
                        <p class="font-size-h3 font-w600 text-white">
                            Expedientes Clínicos
                        </p>
                        <p class="font-italic text-white-op">
                            Copyright &copy; - Todos los derechos reservados® <span
                                class="js-year-copy"><?php echo date('Y'); ?></span>
                        </p>
                    </div>
                </div>
                <div class="hero-static col-md-6 col-xl-4 d-flex align-items-center bg-white invisible"
                    data-toggle="appear" data-class="animated fadeInRight">
                    <div class="content content-full">
                        <div class="px-30 py-10">
                            <a class="link-effect font-w700" href="/">
                                <i class="fa fa-heartbeat text-red"></i>
                                <span class="font-size-xl text-primary-dark">Natu</span><span
                                    class="font-size-xl">Exp</span>
                            </a>
                            <h2 class="h5 font-w400 text-muted mb-0">Recuperar Contraseña</h2>
                        </div>
                        <?php
                         require_once __DIR__ . '/../templates/alertas.php';
                        ?>
                        <div class="px-30 py-10">
                            <form method="POST" action="/olvide" novalidate>
                                <div class="form-group row">

                                    <div class="col-12">
                                        <div class="form-material floating">
                                            <input type="email" class="form-control" id="email" name="email">
                                            <label for="email">Correo Electrónico</label>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <button type="submit" name="action" class="btn btn-sm btn-hero btn-outline-primary"
                                        id="btnrecuperar">
                                        <i class="fa fa-send-o mr-10"></i> Enviar intrucciones
                                    </button>
                                </div>
                            </form>
                            <div class="mt-30">
                                <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="/login">
                                    <i class="fa fa-sign-in mr-5"></i> Ir a Login
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     </div>
  </main>
</div>