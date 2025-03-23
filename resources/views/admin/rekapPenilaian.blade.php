@extends('admin.layout.adminLayout')

@section('title', 'Rekap Penilaian')

@section('linkPlugins')
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/slick.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/slick-theme.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/scrollbar.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/animate.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/select.bootstrap5.css">

@endsection

@section('content')
    <div>
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
        <div class="card">
            <div class="card-header pb-0 card-no-border">
                <h5>Table Data Absensi Pegawai</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive custom-scrollbar">
                    <table class="display table-striped border" id="basic-1">
                        <thead>
                            <tr>
                                <th>Peringkat</th>
                                <th>Nama Pegawai</th>
                                <th>Total Absensi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($top_pegawai as $index => $pegawai)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $pegawai->nama }}</td>
                                    <td>{{ $pegawai->total_scans }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scriptPlugins')
    <script src="../assets/js/sidebar-menu.js"></script>
    <script src="../assets/js/sidebar-pin.js"></script>
    <script src="../assets/js/slick/slick.min.js"></script>
    <script src="../assets/js/slick/slick.js"></script>
    <script src="../assets/js/header-slick.js"></script>
    <script src="../assets/js/chart/chartjs/chart.min.js"></script>
    <script src="../assets/js/chart/chartjs/chart.custom.js"></script>
    <script src="../assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/js/datatable/datatables/dataTables1.js"></script>
    <script src="../assets/js/datatable/datatables/dataTables.bootstrap5.js"></script>
    <script src="../assets/js/datatable/datatables/datatable.custom2.js"></script>
@endsection
