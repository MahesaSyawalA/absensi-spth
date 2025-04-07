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

        /* CSS untuk chart dan foto */
        .staff-photo {
            width: 350px;
            object-fit: cover;
            margin: 0 auto 20px;
            display: block;
        }

        .default-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f5f5f5;
            border: 3px dashed #ccc;
            color: #999;
        }

        .chart-container {
            position: relative;
            height: fit-content;
            width: 100%;
            margin-top: 20px;
        }

        .no-data-message {
            text-align: center;
            padding: 20px;
            color: #666;
            font-style: italic;
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

<body>
    <div class="p-4">
        <div class="row">
            <div class="col-xl-6 col-md-12 box-col-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Top Penilaian Pegawai ASN</h2>
                    </div>
                    <div class="card-body text-center">
                        @if (isset($topAsn) && count($topAsn) > 0 && $topAsn[0]['user']['foto'])
                            <img class="staff-photo" src="{{ public_path($topAsn[0]['user']['foto']) }}"
                                alt="Foto Staff">
                        @else
                            <div class="default-photo">
                                <span>Tidak ada foto</span>
                            </div>
                        @endif

                        <div class="chart-container d-flex flex-column gap-2 py-2 text-start">
                            @if (isset($topAsn) && count($topAsn) > 0)
                                <h3>Nama Lengkap : {{ $topAsn[0]['user']['nama'] }}</h3>
                                <h3>NIP : {{ $topAsn[0]['user']['nip'] }}</h3>
                                <h3>Jabatan : {{ $topAsn[0]['user']['jabatan'] }}</h3>
                                <h3>Tanggal Lahir : {{ $topAsn[0]['user']['tanggal_lahir'] }}</h3>
                                <h3>Status Pegawai : {{ $topAsn[0]['user']['status_pegawai'] }}</h3>
                                <h3>Jenis Kelamin : {{ $topAsn[0]['user']['jenis_kelamin'] }}</h3>
                                <h3>Periode : {{ $periode['bulan_awal'] }} - {{ $periode['bulan_akhir'] }}
                                    {{ $periode['tahun'] }}</h3>
                                <h3>Total Nilai Absensi : {{ number_format($topAsn[0]['total_nilai_absensi'], 2) }}
                                </h3>
                                <h3>Total Nilai Masyarakat :
                                    {{ number_format($topAsn[0]['total_nilai_masyarakat'], 2) }}</h3>
                                <h3>Total Nilai Penilai: {{ number_format($topAsn[0]['total_nilai_penilai'], 2) }}</h3>
                                <h3>Rata-rata Nilai Akhir : {{ number_format($topAsn[0]['rata_nilai_akhir'], 2) }}</h3>
                            @else
                                <div class="no-data-message">
                                    Belum ada data penilaian untuk pegawai ASN
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-12 box-col-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Top Penilaian Pegawai Non ASN</h2>
                    </div>
                    <div class="card-body text-center">
                        @if (isset($topNonAsn) && count($topNonAsn) > 0 && $topNonAsn[0]['user']['foto'])
                            <img class="staff-photo" src="{{ public_path($topNonAsn[0]['user']['foto']) }}"
                                alt="Foto Staff">
                        @else
                            <div class="default-photo">
                                <span>Tidak ada foto</span>
                            </div>
                        @endif

                        <div class="chart-container d-flex flex-column gap-2 py-2 text-start">
                            @if (isset($topNonAsn) && count($topNonAsn) > 0)
                                <h3>Nama Lengkap : {{ $topNonAsn[0]['user']['nama'] }}</h3>
                                <h3>NIP : {{ $topNonAsn[0]['user']['nip'] }}</h3>
                                <h3>Jabatan : {{ $topNonAsn[0]['user']['jabatan'] }}</h3>
                                <h3>Tanggal Lahir : {{ $topNonAsn[0]['user']['tanggal_lahir'] }}</h3>
                                <h3>Status Pegawai : {{ $topNonAsn[0]['user']['status_pegawai'] }}</h3>
                                <h3>Jenis Kelamin : {{ $topNonAsn[0]['user']['jenis_kelamin'] }}</h3>
                                <h3>Periode : {{ $periode['bulan_awal'] }} - {{ $periode['bulan_akhir'] }}
                                    {{ $periode['tahun'] }}</h3>
                                    <h3>Total Nilai Absensi : {{ number_format($topNonAsn[0]['total_nilai_absensi'], 2) }}</h3>
                                    <h3>Total Nilai Masyarakat : {{ number_format($topNonAsn[0]['total_nilai_masyarakat'], 2) }}</h3>
                                    <h3>Total Nilai Penilai: {{ number_format($topNonAsn[0]['total_nilai_penilai'], 2) }}</h3>
                                    <h3>Rata-rata Nilai Akhir : {{ number_format($topNonAsn[0]['rata_nilai_akhir'], 2) }}</h3>
                            @else
                                <div class="no-data-message">
                                    Belum ada data penilaian untuk pegawai Non ASN
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../assets/js/chart/chartjs/chart.custom.js"></script>
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="../assets/js/script.js"></script>
    <script src="../assets/js/script1.js"></script>
</body>

</html>
