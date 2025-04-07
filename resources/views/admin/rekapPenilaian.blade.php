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
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-end rounded">
                    <form class="d-flex align-items-end gap-3" action="{{ route('admin.index') }}" method="GET">
                        <div>
                            <label class="form-label">Bulan Awal</label>
                            <select class="form-select" name="bulan_awal" required id="bulan_awal">
                                <option selected disabled value="">Pilih</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" @if (request('bulan_awal') == $i) selected @endif>
                                        {{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div>
                            <label class="form-label">Bulan Akhir</label>
                            <select class="form-select" name="bulan_akhir" required id="bulan_akhir">
                                <option selected disabled value="">Pilih</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" @if (request('bulan_akhir') == $i) selected @endif>
                                        {{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div>
                            <button class="btn btn-primary" type="submit" style="height: 38px;">
                                <i class="fa fa-filter me-2"></i> Filter
                            </button>
                        </div>
                    </form>

                    <form action="{{ route('print-rekap-penilaian') }}" method="GET" target="_blank">
                        <input type="hidden" name="bulan_awal" value="{{ request('bulan_awal') }}">
                        <input type="hidden" name="bulan_akhir" value="{{ request('bulan_akhir') }}">
                        <button class="btn btn-success" type="submit" id="downloadBtn"
                            @if (!request('bulan_awal') || !request('bulan_akhir')) disabled @endif style="height: 38px;">
                            <i class="fa fa-download me-2"></i> Download PDF
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Penilaian Masyarakat --}}
        <div class="row">
            <div class="col-xl-6 col-md-12 box-col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Top Pegawai ASN </h5>
                    </div>
                    <div class="card-body chart-block">
                        <canvas id="graphTopPenilaianAsn"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-12 box-col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Top Pegawai Non ASN</h5>
                    </div>
                    <div class="card-body chart-block">
                        <canvas id="graphTopPenilaianNonAsn"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- rekapan Penilaian Akhir --}}
        <div class="card">
            <div class="card-header pb-0 card-no-border">
                <h5>Table Data Rekapan Nilai Akhir</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive custom-scrollbar">
                    <table class="display table-striped border" id="rekapPenilaianAkhir">
                        <thead>
                            <tr>
                                <th>Pegawai</th>
                                <th>Bulan</th>
                                <th>Tahun</th>
                                <th>Total Point Absensi</th>
                                <th>Rata-Rata Penilaian Masyarakat</th>
                                <th>Rata-Rata Penilaian Penilai</th>
                                <th>Nilai Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($penilaianAkhir) && !empty($penilaianAkhir))
                                @foreach ($penilaianAkhir as $data)
                                    <tr>
                                        <td>{{ $data['user']['nama'] ?? '-' }}</td>
                                        <td>{{ $data['bulan'] ?? '-' }}</td>
                                        <td>{{ $data['tahun'] ?? '-' }}</td>
                                        <td>{{ number_format($data['nilai_absensi'] ?? 0, 2) }}</td>
                                        <td>{{ number_format($data['nilai_masyarakat'] ?? 0, 2) }}</td>
                                        <td>{{ number_format($data['nilai_penilai'] ?? 0, 2) }}</td>
                                        <td>{{ number_format($data['nilai_akhir'] ?? 0, 2) }}</td>
                                    </tr>
                                @endforeach
                           
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- <div class="row">
            <div class="col-xl-6 col-md-12 box-col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Top 1 Pegawai ASN</h5>
                    </div>
                    <div class="card-body chart-block">
                        <canvas id="chartTop1ASN"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-12 box-col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Top 1 Pegawai Non ASN</h5>
                    </div>
                    <div class="card-body chart-block">
                        <canvas id="chartTop1NonASN"></canvas>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="card">
            <div class="card-header pb-0 card-no-border">
                <h5>Table Data Absensi Pegawai</h5>
            </div>

            {{-- {{dd($topEmployeesAttendance)}} --}}
            <div class="card-body">
                <div class="table-responsive custom-scrollbar">
                    <table class="display table-striped border" id="basic-1">
                        <thead>
                            <tr>
                                <th>Peringkat</th>
                                <th>Nama Pegawai</th>
                                <th>Total Absensi</th>
                                <th>Total Point Absensi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($topEmployeesAttendance) && !empty($topEmployeesAttendance))
                                @foreach ($topEmployeesAttendance as $index => $pegawai)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $pegawai->user->nama ?? '-' }}</td>
                                        <td>{{ $pegawai->total_absen ?? 0 }}</td>
                                        <td>{{ $pegawai->total_poin ?? 0 }}</td>
                                    </tr>
                                @endforeach

                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Penilaian Masyarakat --}}
        {{-- <div class="row">
            <div class="col-xl-6 col-md-12 box-col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Top Penilaian Pegawai ASN dari Masyarakat</h5>
                    </div>
                    <div class="card-body chart-block">
                        <canvas id="graphTopPenilaianAsn"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-12 box-col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Top Penilian Pegawai Non ASN dari Masyarakat</h5>
                    </div>
                    <div class="card-body chart-block">
                        <canvas id="graphTopPenilaianNonAsn"></canvas>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="card">
            <div class="card-header pb-0 card-no-border">
                <h5>Table Data Penilaian Masyarakat</h5>
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
                            @if (isset($rekapan) && !empty($rekapan))
                                @foreach ($rekapan as $data)
                                    <tr>
                                        <td>{{ $data['nama'] ?? '-' }}</td>
                                        <td>{{ $data['bulan'] ?? '-' }}</td>
                                        <td>{{ $data['tahun'] ?? '-' }}</td>
                                        <td>{{ $data['total_penilaian'] ?? 0 }}</td>
                                        <td>{{ number_format($data['avg_perilaku_petugas'] ?? 0, 2) }}</td>
                                        <td>{{ number_format($data['avg_penampilan'] ?? 0, 2) }}</td>
                                        <td>{{ number_format($data['avg_kecepatan_pelayanan'] ?? 0, 2) }}</td>
                                        <td>{{ number_format($data['avg_ketepatan_transparansi'] ?? 0, 2) }}</td>
                                    </tr>
                                @endforeach

                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header pb-0 card-no-border">
                <h5>Table Data Penilaian Penilai</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive custom-scrollbar">
                    <table class="display table-striped border" id="tableRekapPenilaianKhusus">
                        <thead>
                            <tr>
                                <th>Penilai</th>
                                <th>Pegawai</th>
                                <th>Bulan</th>
                                <th>Tahun</th>
                                <th>Perilaku</th>
                                <th>Penampilan</th>
                                <th>Kecepatan</th>
                                <th>Ketepatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($rekapPenilaianKhusus) && !empty($rekapPenilaianKhusus))
                                @foreach ($rekapPenilaianKhusus as $data)
                                    <tr>
                                        <td>{{ $data['penilai']['nama'] ?? '-' }}</td>
                                        <td>{{ $data['user']['nama'] ?? '-' }}</td>
                                        <td>{{ $data['bulan'] ?? '-' }}</td>
                                        <td>{{ $data['tahun'] ?? '-' }}</td>
                                        <td>{{ number_format($data['perilaku_petugas'] ?? 0, 2) }}</td>
                                        <td>{{ number_format($data['penampilan'] ?? 0, 2) }}</td>
                                        <td>{{ number_format($data['kecepatan_pelayanan'] ?? 0, 2) }}</td>
                                        <td>{{ number_format($data['ketepatan_transparansi'] ?? 0, 2) }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- <script>
        var top1_asn = @json($top1_asn);
        var top1_nonasn = @json($top1_nonasn);

        const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October",
            "November", "December"
        ];
        console.log(top1_nonasn);

        const namaTop1AbsensiASN = top1_asn.map(item => item.user.nama);
        const namaTop1AbsensiNonASN = top1_nonasn.map(item => item.user.nama);

        const labelTop1ASN = top1_asn.map(item => months[item.bulan - 1]);
        const labelTop1NonASN = top1_nonasn.map(item => months[item.bulan - 1]);

        const jumlahAbsensiTop1ASN = top1_asn.map(item => item.total_poin);
        const jumlahAbsensiTop1NonASN = top1_nonasn.map(item => item.total_poin);

        function getLastThreeMonths() {
            const months = [];
            const currentDate = new Date();

            for (let i = 2; i >= 0; i--) {
                let date = new Date();
                date.setMonth(currentDate.getMonth() - i);
                months.push(date.toLocaleString('default', {
                    month: 'long'
                }));
            }
            return months;
        }

        const ctxTop1ASN = document.getElementById('chartTop1ASN');
        const ctxTop1NonASN = document.getElementById('chartTop1NonASN');

        new Chart(ctxTop1ASN, {
            type: 'bar',
            data: {
                labels: labelTop1ASN,
                datasets: [{
                    label: 'Total Poin absensi',
                    data: jumlahAbsensiTop1ASN ?? [0, 0, 0],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: namaTop1AbsensiASN[0] ?? '',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        new Chart(ctxTop1NonASN, {
            type: 'bar',
            data: {
                labels: labelTop1NonASN,
                datasets: [{
                    label: 'Jumlah absensi',
                    data: jumlahAbsensiTop1NonASN ?? [0, 0, 0],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: namaTop1AbsensiNonASN[0] ?? '',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script> --}}

    <script>
        var topAsnData = @json($topAsn ?? []);
        var topNonAsnData = @json($topNonAsn ?? []);

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
                        labels: data.map(item => item?.user?.nama),
                        datasets: [{
                            label: label,
                            backgroundColor: "#7366FF",
                            borderColor: "#7366FF",
                            data: data.map(item => item?.nilai_akhir),
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
                                        // var totalAvg = dataset.data[index];
                                        var totalPenilaian = data[index].nilai_akhir;
                                        var nilaiMasyarakat = data[index].nilai_masyarakat;
                                        var nilaiPenilai = data[index].nilai_penilai;
                                        var nilaiAbsensi = data[index].nilai_absensi;

                                        return [
                                            // `Total Rata-rata: ${totalAvg.toFixed(2)}`,
                                            `Total Penilaian Akhir: ${totalPenilaian}`,
                                            `Rata-rata Penilaian Masyarakat: ${nilaiMasyarakat}`,
                                            `Rata-rata Penilaian Penilai: ${nilaiPenilai}`,
                                            `Total Score Absensi: ${nilaiAbsensi}`,
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

            if (topAsnData && topAsnData.length > 0) {
                createChart(ctxAsn, topAsnData, "Top Penilaian ASN");
            } else {
                ctxAsn.innerHTML = '<p class="text-center">Tidak ada data penilaian ASN.</p>';
            }

            if (topNonAsnData && topNonAsnData.length > 0) {
                createChart(ctxNonAsn, topNonAsnData, "Top Penilaian Non ASN");
            } else {
                ctxNonAsn.innerHTML = '<p class="text-center">Tidak ada data penilaian Non ASN.</p>';
            }
        });
    </script>

    <script>
        // Fungsi untuk mengecek status tombol download
        function checkDownloadButton() {
            const bulanAwal = document.getElementById('bulan_awal').value;
            const bulanAkhir = document.getElementById('bulan_akhir').value;
            const downloadBtn = document.getElementById('downloadBtn');

            if (bulanAwal && bulanAkhir) {
                downloadBtn.disabled = false;
                // Update nilai hidden input
                document.querySelector('input[name="bulan_awal"]').value = bulanAwal;
                document.querySelector('input[name="bulan_akhir"]').value = bulanAkhir;
            } else {
                downloadBtn.disabled = true;
            }
        }

        // Event listener untuk perubahan select
        document.getElementById('bulan_awal').addEventListener('change', checkDownloadButton);
        document.getElementById('bulan_akhir').addEventListener('change', checkDownloadButton);

        // Jalankan saat pertama kali load
        document.addEventListener('DOMContentLoaded', checkDownloadButton);
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
