@extends('client.layout.commonLayout')

@section('title', 'Absensi Staff')

@section('linkPlugins')
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/slick.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/slick-theme.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/scrollbar.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/dataTables.bootstrap5.css">
@endsection

@section('content')
    <style>
        .equal-height-cards {
            display: flex;
            flex-wrap: wrap;
        }

        .equal-height-cards .col {
            display: flex;
        }

        .equal-height-cards .card {
            flex: 1;
        }
    </style>

    <div class="container-fluid d-flex flex-column">
        <div class="container-fluid mb-4">
            <div class="row gap-2 gap-md-0 justify-content-center">
                <div class="col-12 col-md-6">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <!-- Foto User -->
                            <img src="/images/user.jpg" alt="User Image" class="img-fluid rounded-circle mb-3"
                                width="100" height="100">

                            <!-- Tulisan Selamat Datang -->
                            <h5 class="card-title">Selamat Datang</h5>
                            <p class="card-text">Silakan lakukan absensi dengan menekan tombol di bawah.</p>

                            {{-- LINK AKSI UNTUK ABSENSI --}}
                            <a href="/staff/absen-scan" class="btn btn-primary w-75">
                                <div id="button-attendance-text" style="display: flex; justify-content: center; gap: 10px">
                                    <i class="fas fa-qrcode" style="margin-block: auto"></i>
                                    <span>Absen Sekarang</span>
                                </div>
                                <div id="spinner" class="custom-loader" style="margin-inline: auto; display: none;"></div>
                            </a>

                            {{-- LINK AKSI UNTUK ABSENSI KHUSUS --}}
                            <a href="/staff/absen-khusus" class="btn btn-outline-primary mt-2 w-75">
                                <div id="button-attendance-text" style="display: flex; justify-content: center; gap: 10px">
                                    <i class="fas fa-pen" style="margin-block: auto"></i>
                                    <span>Absen Khusus</span>
                                </div>
                                <div id="spinner" class="custom-loader" style="margin-inline: auto; display: none;"></div>
                            </a>
                            <div id="result"></div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="card h-100 ">
                        <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                            <h1>Jam Saat Ini:</h1>
                            <div id="clock" class="display-4">14:07:46</div>

                            <!-- Tulisan Selamat Datang -->
                            <h5 class="card-title m-t-20">Status Absensi Hari Ini</h5>
                            <div class="d-flex flex-wrap gap-2 justify-content-center">
                                <span class="badge {{ ($absensi_1 == true) ? 'badge-success' : 'badge-dark' }}">Absensi Ke-1</span>
                                <span class="badge {{ ($absensi_2 == true) ? 'badge-success' : 'badge-dark' }}">Absensi Ke-2</span>
                                <span class="badge {{ ($absensi_3 == true) ? 'badge-success' : 'badge-dark' }}">Absensi Ke-3</span>
                                <span class="badge {{ ($absensi_4 == true) ? 'badge-success' : 'badge-dark' }}">Absensi Ke-4</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid card">
            <div class="card-header pb-0 card-no-">
                <h5>Riwayat Absensi ({{ $month }})</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive custom-scrollbar">
                    <table class="display table-striped " id="basic-1">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Absen Ke-1</th>
                                <th>Absen ke-2</th>
                                <th>Absen ke-3</th>
                                <th>Absen ke-4</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list_absensi as $la => $records)
                                <tr>
                                    <td>{{ $la }}</td>
                                    @php
                                        $attendance = [null, null, null, null]; // Array to hold attendance values
                                        $discipline = [];
                                        $time_of_attendance = [];
                                        foreach ($records as $r) {
                                            $attendance[$r->absen_ke - 1] = '✔';
                                            $discipline[$r->absen_ke - 1] = "($r->keterangan)";
                                            $time_of_attendance[$r->absen_ke - 1] = date(
                                                'h:i:s',
                                                strtotime($r->scanned_at),
                                            );
                                        }
                                    @endphp
                                    <td>{{ $attendance[0] ?? '-' }} {{ $time_of_attendance[0] ?? '-' }}
                                        {{ $discipline[0] ?? '-' }}</td>
                                    <td>{{ $attendance[1] ?? '-' }} {{ $time_of_attendance[1] ?? '-' }}
                                        {{ $discipline[1] ?? '-' }}</td>
                                    <td>{{ $attendance[2] ?? '-' }} {{ $time_of_attendance[2] ?? '-' }}
                                        {{ $discipline[2] ?? '-' }}</td>
                                    <td>{{ $attendance[3] ?? '-' }} {{ $time_of_attendance[3] ?? '-' }}
                                        {{ $discipline[3] ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateClock() {
            const clockElement = document.getElementById('clock');
            const now = new Date();
            now.toLocaleString('en-US', {
                timeZone: 'Asia/Jakarta'
            })
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const timeString = `${hours}:${minutes}:${seconds}`;
            clockElement.textContent = timeString;
        }

        setInterval(updateClock, 1000);
        updateClock();
    </script>
@endsection

@section('scriptPlugins')
    <script src="../assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/js/datatable/datatables/dataTables1.js"></script>
    <script src="../assets/js/datatable/datatables/dataTables.bootstrap5.js"></script>
    <script src="../assets/js/datatable/datatables/datatable.custom2.js"></script>
@endsection
