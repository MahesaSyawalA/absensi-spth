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

        <div class="row">
            <div class="col-xl-6 col-md-12 box-col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Top Penilaian Pegawai ASN</h5>
                    </div>
                    <div class="card-body chart-block">
                        <canvas id="graphTopPenilaianAsn"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-12 box-col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Top Penilian Pegawai Non ASN</h5>
                    </div>
                    <div class="card-body chart-block">
                        <canvas id="graphTopPenilaianNonAsn"></canvas>
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

        <div class="card">
            <div class="card-header pb-0 card-no-border">
                <h5>Table Data Absensi Pegawai</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive custom-scrollbar">
                    <table class="display table-striped border" id="tableRekapPenilaian">
                        <thead>
                            <tr>
                                <th>Pegawai</th>
                                <th>Bulan</th>
                                <th>Tahun</th>
                                <th>Total Penilaian</th>
                                <th>Perilaku</th>
                                <th>Penampilan</th>
                                <th>Kecepatan</th>
                                <th>Ketepatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rekapan as $data)
                                <tr>
                                    <td>{{ $data['nama'] }}</td> <!-- Menampilkan Nama -->
                                    <td>{{ $data['bulan'] }}</td>
                                    <td>{{ $data['tahun'] }}</td>
                                    <td>{{ $data['total_penilaian'] }}</td>
                                    <td>{{ number_format($data['avg_perilaku_petugas'], 2) }}</td>
                                    <td>{{ number_format($data['avg_penampilan'], 2) }}</td>
                                    <td>{{ number_format($data['avg_kecepatan_pelayanan'], 2) }}</td>
                                    <td>{{ number_format($data['avg_ketepatan_transparansi'], 2) }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        var topAsnData = @json($topAsn);
        var topNonAsnData = @json($topNonAsn);

        document.addEventListener("DOMContentLoaded", function() {
            var ctxAsn = document.getElementById("graphTopPenilaianAsn");
            var ctxNonAsn = document.getElementById("graphTopPenilaianNonAsn");

            if (!ctxAsn || !ctxNonAsn) {
                console.error("Canvas tidak ditemukan!");
                return;
            }

            function createChart(ctx, data, label) {
                new Chart(ctx.getContext("2d"), {
                    type: "bar",
                    data: {
                        labels: data.map(item => item.nama),
                        datasets: [{
                            label: label,
                            backgroundColor: "#7366FF",
                            borderColor: "#7366FF",
                            data: data.map(item => item.total_avg),
                        }]
                    },
                    options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    var dataset = tooltipItem.dataset;
                                    var index = tooltipItem.dataIndex;
                                    var totalAvg = dataset.data[index];
                                    var totalPenilaian = data[index].total_penilaian;

                                    return [
                                        `Total Rata-rata: ${totalAvg.toFixed(2)}`,
                                        `Total Penilaian: ${totalPenilaian}`
                                    ];
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
                });
            }

            createChart(ctxAsn, topAsnData, "Top Penilaian ASN");
            createChart(ctxNonAsn, topNonAsnData, "Top Penilaian Non ASN");
        });
    </script>

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
