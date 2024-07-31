<div id="page-container" class="main-content-boxed">
    <!-- Main Container -->
    <main id="main-container">
        <!-- Page Content -->
        <div class="bg-image" style="background-image: url('/build/assets/img/photos/photo36@2x.jpg');">
            <div class="row mx-0 bg-black-op">
                <div class="hero-static col-md-6 col-xl-8 d-none d-md-flex align-items-md-end">
                    <div class="p-30 invisible" data-toggle="appear">
                        <p class="font-size-h3 font-w600 text-white mb-5">
                        <?php echo $title; ?>
                        </p>
                        <p class="font-size-h5 text-white">
                            <i class="fa fa-angles-right"></i> www.natuexp.com
                        </p>
                        <p class="font-italic text-white-op">
                        Copyright &copy; - Todos los derechos reservados® <span class="js-year-copy"><?php echo date('Y'); ?></span>
                        </p>
                    </div>
                </div>
                <div class="hero-static col-md-6 col-xl-4 d-flex align-items-center bg-white invisible" data-toggle="appear" data-class="animated fadeInRight">
                    <div class="content content-full">
                        <!-- Header -->
                        <div class="px-30 py-10">
                            <a class="link-effect font-w700" href="/login">
                                <i class="fa fa-heartbeat text-primary"></i>
                                <span class="font-size-xl text-primary-dark">Natu </span><span class="font-size-xl"> Exp</span>
                            </a>
                            <h2 class="h5 font-w400 text-muted mb-0"><?php echo $title; ?></h2>
                        </div>
                        <!-- END Header -->
                        <?php
                        require_once __DIR__ . '/../templates/alertas.php';
                        ?>
                        <!-- Sign Up Form -->
                        <div class="px-30 py-10">
                            <form method="POST" action="/crear">
                                <div class="form-group row">
                                    <div class="col-12">
                                        <div class="form-material floating">
                                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $usuario->nombre; ?>">
                                            <label for="nombre">Nombre(s)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12">
                                        <div class="form-material floating">
                                            <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $usuario->apellido; ?>">
                                            <label for="apellido">Apellido(s)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12">
                                        <div class="form-material floating">
                                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $usuario->email; ?>">
                                            <label for="email">Email</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12">
                                        <div class="form-material floating">
                                            <input type="number" class="form-control" id="telefono" name="telefono" value="<?php echo $usuario->telefono; ?>">
                                            <label for="telefono">Telefóno</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12">
                                        <div class="form-material floating">
                                            <input type="password" class="form-control" id="password" name="password">
                                            <label for="txtpassword1">Contraseña</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12">
                                        <div class="form-material floating">
                                            <input type="password" class="form-control" id="password2" name="password2">
                                            <label for="password2">Confirmar Contraseña</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <button type="submit" name="action" value="Crear Cuenta" class="btn btn-sm btn-hero btn-outline-success">
                                        <i class="fa fa-plus mr-10"></i> Crear Cuenta
                                    </button>
                                    <div class="mt-30">
                                        <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="/login">
                                            <i class="fa fa-user text-muted mr-5"></i> Iniciar Sesión
                                        </a>
                                        <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="/olvide">
                                            <i class="fa fa-warning mr-5"></i> Olvide mi Contraseña
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- END Sign Up Form -->
                    </div>
                </div>
            </div>
        </div>
        <!-- END Page Content -->
    </main>
    <!-- END Main Container -->
</div>