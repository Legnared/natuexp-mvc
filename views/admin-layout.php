<!DOCTYPE html>
<html lang="en" class="no-focus">

<head>
    <meta charset="utf-8">
    <title>Backoffice NatuExp | <?php echo $titulo ?? ''; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description"
        content="Codebase - Bootstrap 4 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="noindex, nofollow">
    <meta property="og:title" content="Codebase - Bootstrap 4 Admin Template &amp; UI Framework">
    <meta property="og:site_name" content="Codebase">
    <meta property="og:description"
        content="Codebase - Bootstrap 4 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <link rel="shortcut icon" href="/build/assets/img/favicons/favico-192x192.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/build/assets/img/favicons/favico-192x192.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/build/assets/img/favicons/favico-180x180.png">

    <link rel="stylesheet" href="/build/assets/js/plugins/datatables/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" id="css-main" href="/build/assets/css/codebase.min.css">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet" />
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    <!-- Notyfy CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css">

    <!-- Notyfy JS -->
    <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Include FullCalendar CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/es.js"></script>

    <!-- Include jQuery from a CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Incluye Noty CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.css" />

    <!-- Incluye Noty JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js"></script>


</head>

<body>

    <div id="page-container"
        class="sidebar-o side-scroll page-header-glass page-header-inverse main-content-boxed sidebar-inverse">

        <aside id="side-overlay">
            <?php include_once __DIR__ . '/templates/aside.php'; ?>
        </aside>

        <nav id="sidebar">
            <?php include_once __DIR__ . '/templates/nav.php'; ?>
        </nav>
        <header id="page-header">
            <?php include_once __DIR__ . '/templates/header.php'; ?>
        </header>

        <main id="main-container">
            <?php include_once __DIR__ . '/templates/header-bg.php'; ?>
            <div class="content">
                <?php echo $contenido; ?>
            </div>
        </main>

        <footer id="page-footer" class="opacity-0">
            <?php include_once __DIR__ . '/templates/footer.php'; ?>
        </footer>

    </div>

    <script src="/build/assets/js/core/jquery.min.js"></script>
    <script src="/build/assets/js/core/popper.min.js"></script>
    <script src="/build/assets/js/core/bootstrap.min.js"></script>
    <script src="/build/assets/js/core/jquery.slimscroll.min.js"></script>
    <script src="/build/assets/js/core/jquery.scrollLock.min.js"></script>
    <script src="/build/assets/js/core/jquery.appear.min.js"></script>
    <script src="/build/assets/js/core/jquery.countTo.min.js"></script>
    <script src="/build/assets/js/core/js.cookie.min.js"></script>
    <script src="/build/assets/js/codebase.js"></script>
    <script src="/build/assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/build/assets/js/plugins/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="/build/assets/js/pages/be_tables_datatables.js"></script>
    <!-- Page Plugins -->
    <script src="/build/assets/js/plugins/jquery-vide/jquery.vide.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/build/js/bundle.min.js" defer></script>

</body>

</html>