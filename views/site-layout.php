<!DOCTYPE html>
<html lang="en" class="no-focus">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">


    <title>Natuexp | <?php echo $titulo ?? ''; ?></title>

    <meta name="description" content="Sitio web de Natuexp">
    <meta name="author" content="Natuexp">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="Natuexp - Sitio Web">
    <meta property="og:site_name" content="Natuexp">
    <meta property="og:description" content="Sitio web oficial de Natuexp">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <!-- Favicons -->
    <link href="/build/styles/img/favicon-natuexp.png" rel="icon">
    <link href="/build/styles/img/logo-natuexp.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="/build/styles/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/build/styles/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/build/styles/vendor/aos/aos.css" rel="stylesheet">
    <link href="/build/styles/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="/build/styles/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="/build/styles/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="/build/styles/css/main.css" rel="stylesheet">

    <!-- Incluye Noty CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.css" />

    <!-- Incluye Noty JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js"></script>


</head>

<body class="index-page">


    <!-- Header -->
    <header id="header" class="header sticky-top">
        <?php include_once __DIR__ . '/template/header.php'; ?>
    </header>
    <!-- END Header -->

    <!-- Main Container -->
    <main class="main">
        <?php echo $contenido; ?>

    </main>
    <!-- END Main Container -->

    <!-- Footer -->
    <footer id="footer" class="footer light-background">
        <?php include_once __DIR__ . '/template/footer.php'; ?>

        <!-- Social Bar -->
        <div class="social-bar">
            <?php include_once __DIR__ . '/template/social-bar.php'; ?>
        </div>


    </footer>
    <!-- END Footer -->
    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Preloader -->


    <!-- Vendor JS Files -->
    <script src="/build/styles/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/build/styles/vendor/php-email-form/validate.js"></script>
    <script src="/build/styles/vendor/aos/aos.js"></script>
    <script src="/build/styles/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="/build/styles/vendor/purecounter/purecounter_vanilla.js"></script>

    <script src="/build/js/enlaces.js"></script>

    <script src="/build/styles/vendor/swiper/swiper-bundle.min.js"></script>
    <!-- Main JS File -->
    <script src="/build/styles/js/main.js"></script>
</body>

</html>