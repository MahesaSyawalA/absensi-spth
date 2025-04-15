@extends('admin.layout.adminLayout')

@section('linkPlugins')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/slick.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/slick-theme.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/scrollbar.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/dataTables.bootstrap5.css">
@endsection

@section('content')
<div class="card">
    <div class="card-header pb-0 card-no-border d-flex justify-content-between">
        <h5>Pengajuan Absen</h5>
    </div>
    <div class="card-body">
        <p> Daftar pengajuan absen pegawai yang dinas keluar, sakit, atau WFH/WFA. </p>
        <div class="table-responsive custom-scrollbar">
            <table class="display table-striped border" id="basic-1">
                <thead>
                    <tr>
                        <th>ID User</th>
                        <th>Keterangan</th>
                        <th>Tanggal diajukan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($absen_data as $a)
                        <tr>
                            <td>{{ $a->user_id }}</td>
                            <td>{{ $a->keterangan }}</td>
                            <td>{{ $a->scanned_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


@section('scriptPlugins')
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    <script src="../assets/js/sidebar-menu.js"></script>
    <script src="../assets/js/sidebar-pin.js"></script>
    <script src="../assets/js/slick/slick.min.js"></script>
    <script src="../assets/js/slick/slick.js"></script>
    <script src="../assets/js/header-slick.js"></script>
    {{-- <script src="../assets/js/chart/chartjs/chart.min.js"></script> --}}
    <script src="../assets/js/chart/chartjs/chart.custom.js"></script>
    <script src="../assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/js/datatable/datatables/dataTables1.js"></script>
    <script src="../assets/js/datatable/datatables/dataTables.bootstrap5.js"></script>
    <script src="../assets/js/datatable/datatables/datatable.custom2.js"></script>
@endsection