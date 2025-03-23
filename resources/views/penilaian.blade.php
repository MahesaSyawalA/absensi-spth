<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/logo_jabar.png" type="image/x-icon">
    <link rel="shortcut icon" href="../images/logo_jabar.png" type="image/x-icon">
    <title>SPTH - Penilaian Staff</title>
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
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            {{-- <ul class="d-flex ">
                <li class=" px-3 py-2 rounded">
                    <a href="/login" style="">Berikan Penilaian</a>
                </li>
                <li class="bg-primary px-3 py-2 rounded">
                    <a href="/login" style="color: white; ">Login</a>
                </li>

            </ul> --}}
        </div>
        <!-- Page Header Ends-->
        <!-- Page Body Start-->
        <div class="">
            <!-- Page Sidebar Ends-->
            <div class="page-body" style="background-color: white">
                <div class="p-5">
                    <div class="card p-3">
                        <h3>Bio Data Staff</h3>
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-md-4 text-center"> <!-- Gambar diperlebar -->
                                    <img class="img-fluid" src="{{ asset('storage/' . $selectedUser->foto) }}"
                                        alt="Foto Staff">
                                </div>

                                <div class="col-md-8"> <!-- Form diperlebar -->
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="nama" class="form-label">Nama</label>
                                            <input type="text" class="form-control" id="nama"
                                                value="{{ $selectedUser->nama }}" disabled>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="nik" class="form-label">NIP/No</label>
                                            <input type="text" class="form-control" id="nik"
                                                value="{{ $selectedUser->nip }}" disabled>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="jabatan" class="form-label">Jabatan</label>
                                            <textarea class="form-control" id="jabatan" disabled>{{ $selectedUser->jabatan }}</textarea>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="status pegawai" class="form-label">Status Pegawai</label>
                                            <input type="text" class="form-control" id="status pegawai"
                                                value="{{ $selectedUser->status_pegawai }}" disabled>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                            <input type="jenis_kelamin" class="form-control" id="jenis_kelamin"
                                                value="{{ $selectedUser->jenis_kelamin }}" disabled>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card py-3">
                        <div class="container-fluid">
                            <h3>Data Diri</h3>
                            <form class="row row-cols-1 row-cols-md-2 row-gap-2" method="POST"
                                action="{{ route('store.penilaian') }}">
                                @csrf
                                <input type="hidden" name="slug" id="slugInput" value="{{$slug}}">
                                <div class="col">
                                    <label class="form-label" for="validationTooltipName">Nama</label>
                                    <input class="form-control required" id="validationTooltipName" type="text"
                                        placeholder="Masukan nama anda" name="nama" required="">
                                </div>
                                <div class="col">
                                    <label class="form-label" for="validationTooltipGmail">Gmail</label>
                                    <input class="form-control required email" id="validationTooltipGmail"
                                        type="email" placeholder="contoh@gmail.com" name="email" required="">
                                </div>
                                <div class="col">
                                    <label class="form-label" for="validationTooltipName">Tujuan</label>
                                    <input class="form-control required" id="validationTooltipName" type="text"
                                        placeholder="Masukan Tujuan" name="tujuan" required="">
                                </div>
                                <div class="col">
                                    <label class="form-label" for="validationTooltipName">Pelayanannya</label>
                                    <input class="form-control required" id="validationTooltipName" type="text"
                                        placeholder="Masukan Pelayanannya" name="pelayanan" required="">
                                </div>
                                @foreach ($kriteriaWithSub as $k)
                                    <div class="col">
                                        <!-- Label Kriteria -->
                                        <label class="">{{ Str::headline($k->name) }}</label>

                                        <div class="mb-3 d-flex flex-wrap gap-3">
                                            @foreach ($k->subKriteria as $index => $sub)
                                                <div class="form-check">
                                                    <input class="form-check-input" id="radio{{ $sub->uuid }}"
                                                        type="radio" name="subKriteria[{{ $k->uuid }}]"
                                                        value="{{ $sub->nilai }}"
                                                        {{ $index == 0 ? 'checked' : '' }}>
                                                    <label class="form-check-label mb-0"
                                                        for="radio{{ $sub->uuid }}">{{ $sub->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach


                                <div  class="col-md-12 d-flex justify-content-end mt-auto">
                                    <button type='submit' class="btn btn-pill btn-outline-success">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Container-fluid body starts-->


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
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector("form");
            const submitButton = form.querySelector("button[type='submit']");

            form.addEventListener("submit", function(event) {
                event.preventDefault(); // Mencegah refresh halaman

                const formData = new FormData(form);
                const url = form.getAttribute("action");

                // Menampilkan efek loading
                submitButton.innerHTML = "Mengirim...";
                submitButton.disabled = true;

                fetch(url, {
                        method: "POST",
                        headers: {
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: formData
                    })
                    .then(response => response.json().then(data => ({
                        status: response.status,
                        body: data
                    }))) // Tangani response JSON
                    .then(result => {
                        if (result.status === 201) {
                            showSuccessAlert(result.body.message);
                            setTimeout(() => {
                                window.location.href = "/"; // Redirect ke home setelah 3 detik
                            }, 3000);
                        } else {
                            showDangerAlert(result.body.message ||
                                "Terjadi kesalahan saat menyimpan data.");
                        }
                    })
                    .catch(error => {
                        showDangerAlert("Gagal mengirim data!");
                        console.error(error);
                    })
                    .finally(() => {
                        // Mengembalikan tombol submit ke kondisi semula
                        submitButton.innerHTML = "Submit";
                        submitButton.disabled = false;
                    });
            });
        });
    </script>

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
