<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="../images/logo_jabar.png" type="image/x-icon">
    <link rel="shortcut icon" href="../images/logo_jabar.png" type="image/x-icon">
    <title>SPTH - Home</title>
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
    <style>
        /* Custom CSS untuk mengatur lebar maksimum gambar */
        .max-w-md-113 {
            max-width: 113px;
        }

        .max-w-sm-113 {
            max-width: 250px;
        }

        .max-w-sm-75 {
            max-width: 75px;
        }

        .max-w-xs-50 {
            max-width: 50px;
        }

        /* Jika Anda ingin menambahkan breakpoint untuk layar besar (lg) */
        @media (min-width: 992px) {
            .max-w-lg-150 {
                max-width: 100px;
            }

            .max-w-sm-113 {
                max-width: 350px;
            }
        }
    </style>

</head>

<body class="horizontal-page">
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
    <div class="page-wrapper horizontal-wrapper" id="pageWrapper">
        <!-- Page Header Start-->

        <div class=" shadow-sm d-flex align-items-center justify-content-between p-3 px-2 px-md-4" style="width:100%; ">
            <div class="logo-wrapper">
                <a href="/" class="d-none d-md-block">
                    <img class="img-fluid for-light" src="/images/SPTH.png" alt="" style="width: 10vw;">
                    <img class="img-fluid for-dark" src="/images/SPTH.png" alt="">
                </a>
            </div>
            <ul class="d-flex ">
                <li class="px-3 py-2 rounded">
                    <a href="#formPenilaian" id="scrollToForm">Berikan Penilaian</a>
                </li>
                <li class="bg-primary px-3 py-2 rounded">
                    <a href="/login" style="color: white; ">Login</a>
                </li>

            </ul>
        </div>
        <!-- Page Header Ends-->

        <!-- Page Body Start-->
        <div class="">
            <!-- Page Sidebar Ends-->
            <div class="page-body" style="background-color: white">
                <div class="container-fluid mt-3">
                    <div class="card pb-4  py-md-5 d-flex flex-column align-items-center justify-content-center"
                        style="background-image: url('/images/bg.webp'); background-repeat: no-repeat; background-position: top;">
                        <div class="grid align-items-center py-4 gap-4">
                            <img src="/images/logo_jabar.png" class="img-fluid max-w-lg-150 max-w-md-113 max-w-sm-75 "
                                alt="Logo Jabar">
                            <img src="/images/SPTH.png" class="img-fluid max-w-md-150 max-w-sm-113" alt="SPTH">
                        </div>
                        <h1 class="text-center">Selamat Datang Di Website SIDIK SPTH </h1>
                    </div>
                </div>
                <!-- Container-fluid body starts-->
                <div class="row">
                    <div class="col-xl-6 col-md-12 box-col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Pegawai ASN</h5>
                            </div>
                            <div class="card-body chart-block">
                                <canvas id="myBarGraph"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-12 box-col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Pegawai Non ASN</h5>
                            </div>
                            <div class="card-body chart-block">
                                <canvas id="myBarGraph2"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card" id="listStaff">
                    <div class="container mt-5">
                        <h1 class="text-center mb-4">Daftar Staff</h1>

                        <div class="row">
                            @foreach ($staffs as $staff)
                                <div class="col-md-6 col-lg-4 mb-4 d-flex align-items-stretch">
                                    <div class="card w-100">
                                        <!-- Foto Staff -->
                                        <img src="{{ asset('storage/' . $staff->foto) }}" class="card-img-top"
                                            alt="{{ $staff->nama }}" style="height: 200px; object-fit: cover;">

                                        <div class="card-body d-flex flex-column">
                                            <!-- Nama Staff -->
                                            <h5 class="card-title">{{ $staff->nama }}</h5>

                                            <!-- Jabatan -->
                                            <p class="card-text">
                                                <strong>Jabatan:</strong> {{ $staff->jabatan }}
                                            </p>

                                            <!-- Email -->
                                            <p class="card-text">
                                                <strong>Email:</strong> {{ $staff->email }}
                                            </p>
                                            <div class="container d-flex justify-content-end">

                                                <a href="{{ route('index.penilaian', ['slug' => $staff->slug]) }}"
                                                    class="btn btn-primary mt-auto">Berikan Penilaian</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination (jika menggunakan paginate) -->
                        {{-- @if ($staffs->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $staffs->links() }}
                            </div>
                        @endif --}}
                    </div>
                </div>
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
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("scrollToForm").addEventListener("click", function(event) {
                event.preventDefault(); // Mencegah perubahan halaman

                const target = document.getElementById("listStaff");
                if (target) {
                    target.scrollIntoView({
                        behavior: "smooth", // Scroll halus
                        block: "start" // Fokus ke bagian atas elemen
                    });
                }
            });
        });
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
    <script src="../assets/js/chart/chartjs/chart.min.js"></script>
    <script src="../assets/js/chart/chartjs/chart.custom.js"></script>
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="../assets/js/script.js"></script>
    <script src="../assets/js/script1.js"></script>
    {{-- <script src="../assets/js/theme-customizer/customizer.js"></script> --}}
</body>

</html>
