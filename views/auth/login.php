<div id="page-container" class="main-content-boxed">
    <main id="main-container">
        <div class="bg-image" style="background-image: url('/build/assets/img/photos/photo34@2x.jpg');">
            <div class="row mx-0 bg-black-op">
                <div class="hero-static col-md-6 col-xl-8 d-none d-md-flex align-items-md-end">
                    <div class="p-30 invisible" data-toggle="appear">
                        <p class="font-size-h3 font-w600 text-white">
                            <?php echo $title; ?>
                        </p>
                        <p class="font-size-h5 text-white">
                            <i class="fa fa-angles-right"></i> <?php echo $sitio; ?>
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
                        <!-- Header -->
                        <div class="px-30 py-10">
                            <a class="link-effect font-w700" href="/">
                                <i class="fa fa-heartbeat text-primary"></i>
                                <span class="font-size-xl text-primary-dark">Natu</span><span
                                    class="font-size-xl">Exp</span>
                            </a>
                            <h2 class="h5 font-w400 text-muted mb-0"><?php echo $title; ?></h2>
                        </div>
                        <?php
                            require_once __DIR__ . '/../templates/alertas.php';
                        ?>
                        <form method="POST" action="/login">
                            <div class="form-group row">
                                <div class="col-12">
                                    <div class="form-material floating">
                                        <input type="email" class="form-control" id="email" name="email"
                                            autocomplete="username">
                                        <label for="email">Correo Electrónico</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <div class="form-material floating">
                                        <input type="password" class="form-control" id="password" name="password"
                                            autocomplete="current-password">
                                        <label for="password">Contraseña</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <!-- <input type="hidden" name="enviar" class="form-control" value="si"> -->
                                <button type="submit" class="btn btn-sm btn-hero btn-outline-primary">
                                    <i class="si si-login mr-10"></i> Iniciar Sesión
                                </button>
                                <div class="mt-30">
                                    <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="/crear">
                                        <i class="fa fa-plus-square-o mr-5"></i> ¿Aún no tienes una cuenta para médicos?
                                        <strong>Obtener una</strong>
                                    </a>

                                    <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="/olvide">
                                        <i class="si si-lock mr-5"></i> ¿Olvidaste tu Password?
                                    </a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </main>
</div>