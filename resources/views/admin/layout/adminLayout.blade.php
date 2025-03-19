<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Cuba admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Cuba admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="../images/logo_jabar.png" type="image/x-icon">
    <link rel="shortcut icon" href="../images/logo_jabar.png" type="image/x-icon">
    <title>@yield('title', 'SPTH - Admin')</title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap"
        rel="stylesheet">
    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="../assets/css/fontawesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/feather-icon.css">
    <!-- Plugins css start-->
    @section('linkPlugins')
        <link rel="stylesheet" type="text/css" href="../assets/css/vendors/slick.css">
        <link rel="stylesheet" type="text/css" href="../assets/css/vendors/slick-theme.css">
        <link rel="stylesheet" type="text/css" href="../assets/css/vendors/scrollbar.css">
        <link rel="stylesheet" type="text/css" href="../assets/css/vendors/prism.css">
    @show
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <link id="color" rel="stylesheet" href="../assets/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="../assets/css/responsive.css">
</head>

<body>
    <!-- loader starts-->
    <div class="loader-wrapper">
        <div class="loader-index"> <span></span></div>
        <svg>
            <defs></defs>
            <filter id="goo">
                <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
                <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo">
                </fecolormatrix>
            </filter>
        </svg>
    </div>
    <!-- loader ends-->
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <!-- Page Header Start-->
        @include('admin.layout.section.navbar')
        <!-- Page Header Ends-->

        <!-- Page Body Start-->
        <div class="page-body-wrapper horizontal-menu">
            <!-- Page Sidebar Start-->
            @include('admin.layout.section.sidebar')
            <!-- Page Sidebar Ends-->
            <div class="page-body">
                <!-- Alert Success -->
                <div id="successAlert" class="alert alert-success d-flex align-items-center d-none" role="alert"
                    style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
                    <div>
                        <i class="stroke-success" data-feather="check-square"></i>
                    </div>
                    <span class="txt-light" id="successMessage">User berhasil dihapus!</span>
                </div>

                <!-- Alert Danger -->
                <div id="dangerAlert" class="alert alert-danger d-flex align-items-center d-none" role="alert"
                    style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
                    <div>
                        <i class="stroke-danger" data-feather="alert-circle"></i>
                    </div>
                    <span class="txt-light" id="dangerMessage">Gagal menghapus user!</span>
                </div>

                <div class="container-fluid">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-sm-6">
                                <h3>@yield('title')</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid body starts-->
                @yield('content')
                <!-- Container-fluid body Ends-->
            </div>
            <!-- footer start-->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 footer-copyright text-center">
                            <p class="mb-0">Copyright <span class="year-update"> </span> © SPTH
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script>
        function showSuccessAlert(message) {
            // Set pesan ke dalam alert
            document.getElementById('successMessage').innerText = message;

            // Tampilkan alert
            var alertElement = document.getElementById('successAlert');
            alertElement.classList.remove('d-none'); // Hilangkan class d-none

            // Sembunyikan alert setelah 3 detik
            setTimeout(function() {
                alertElement.classList.add('d-none');
            }, 3000); // 3000 ms = 3 detik
        }

        function showDangerAlert(message) {
            // Set pesan ke dalam alert
            document.getElementById('dangerMessage').innerText = message;

            // Tampilkan alert
            var alertElement = document.getElementById('dangerAlert');
            alertElement.classList.remove('d-none'); // Hilangkan class d-none

            // Sembunyikan alert setelah 3 detik
            setTimeout(function() {
                alertElement.classList.add('d-none');
            }, 3000); // 3000 ms = 3 detik
        }
    </script>


    <!-- latest jquery-->
    <script src="../assets/js/jquery.min.js"></script>
    <!-- Bootstrap js-->
    <script src="../assets/js/bootstrap/bootstrap.bundle.min.js"></script>
    <!-- feather icon js-->
    <script src="../assets/js/icons/feather-icon/feather.min.js"></script>
    <script src="../assets/js/icons/feather-icon/feather-icon.js"></script>
    <!-- scrollbar js-->
    <script src="../assets/js/scrollbar/simplebar.min.js"></script>
    <script src="../assets/js/scrollbar/custom.js"></script>
    <!-- Sidebar jquery-->
    <script src="../assets/js/config.js"></script>
    <!-- Plugins JS start-->
    @section('scriptPlugins')
        <script src="../assets/js/sidebar-menu.js"></script>
        <script src="../assets/js/sidebar-pin.js"></script>
        <script src="../assets/js/slick/slick.min.js"></script>
        <script src="../assets/js/slick/slick.js"></script>
        <script src="../assets/js/header-slick.js"></script>
        <script src="../assets/js/prism/prism.min.js"></script>
        <script src="../assets/js/clipboard/clipboard.min.js"></script>
        <script src="../assets/js/custom-card/custom-card.js"></script>
        <script src="../assets/js/typeahead/handlebars.js"></script>
        <script src="../assets/js/typeahead/typeahead.bundle.js"></script>
        <script src="../assets/js/typeahead/typeahead.custom.js"></script>
        <script src="../assets/js/typeahead-search/handlebars.js"></script>
        <script src="../assets/js/typeahead-search/typeahead-custom.js"></script>
    @show
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="../assets/js/script.js"></script>
    <script src="../assets/js/script1.js"></script>
    {{-- <script src="../assets/js/theme-customizer/customizer.js"></script> --}}
</body>

</html>
