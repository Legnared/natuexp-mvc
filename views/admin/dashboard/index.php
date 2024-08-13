<!-- Header Section -->
<div class="bg-image" style="background-image: url('/build/assets/img/photos/photo36@2x.jpg');">
    <div class="bg-primary-dark-op">
        <div class="content content-full content-top">
            <h1 class="display-4 font-w700 text-white mb-10 text-uppercase text-center"><?php echo $subtitulo; ?></h1>
            <div class="container bg-light">
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center">
                        <a class="btn btn-hero btn-rounded btn-primary text-center" href="/admin/pacientes">
                            <i class="fa fa-user-md mr-10"></i> Nuevo Paciente
                        </a>
                    </div>
                    <div class="col-md-6 text-center">
                        <a class="btn btn-hero btn-rounded btn-secondary text-center" href="/admin/cita">
                            <i class="fa fa-calendar-alt mr-10"></i> Agendar Cita
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Boxes Components -->
<div class="container mt-4">
    <div class="row">
        <!-- Box 1 -->
        <div class="col-md-4">
            <div class="block block-rounded block-link-shadow text-center">
                <div class="block-content block-content-full">
                    <div class="item item-circle bg-info-light mx-auto mb-20">
                        <i class="fa fa-users text-info"></i>
                    </div>
                    <div class="font-size-h4 font-w600">Total Pacientes</div>
                    <div class="text-muted"><?php echo $totalPacientes; ?></div> <!-- Muestra el número de pacientes -->
                </div>
            </div>
        </div>
        <!-- Box 2 -->
        <div class="col-md-4">
            <div class="block block-rounded block-link-shadow text-center">
                <div class="block-content block-content-full">
                    <div class="item item-circle bg-success-light mx-auto mb-20">
                        <i class="fa fa-calendar-alt text-success"></i>
                    </div>
                    <div class="font-size-h4 font-w600">Total Citas</div>
                    <div class="text-muted"><?php echo $totalCitas; ?></div> <!-- Muestra el número de citas -->
                </div>
            </div>
        </div>
        <!-- Box 3 -->
        <div class="col-md-4">
            <div class="block block-rounded block-link-shadow text-center">
                <div class="block-content block-content-full">
                    <div class="item item-circle bg-warning-light mx-auto mb-20">
                        <i class="fa fa-bell text-warning"></i>
                    </div>
                    <div class="font-size-h4 font-w600">Notificaciones</div>
                    <div class="text-muted">2</div> <!-- Actualiza el número con datos reales -->
                </div>
            </div>
        </div>
    </div>
</div>
