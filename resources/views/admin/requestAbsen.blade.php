@extends('admin.layout.adminLayout')

@section('linkPlugins')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/slick.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/slick-theme.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/scrollbar.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/dataTables.bootstrap5.css">
@endsection

@php
    use Carbon\Carbon; // buat format tanggal pengajuan
@endphp


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
                            <th>ID Pegawai</th>
                            <th>NIP</th>
                            <th>Nama Pegawai</th>
                            <th>Jenis Absen</th>
                            <th>Tanggal diajukan</th>
                            <th>Dokumen/Surat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($absen_data as $a)
                            <tr>
                                <td>{{ $a->user_id }}</td>
                                <td>{{ $a->nip_pegawai }}</td>
                                <td>{{ $a->nama_pegawai }}</td>
                                <td>{{ $a->jenis_absen }}</td>
                                <td>{{ Carbon::parse($a->tanggal_pengajuan)->format('d/m/y, H:i') }}</td>
                                <td class="text-center">
                                    <button class="btn btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#previewDokumenModal{{ $a->id }}">Lihat</button>
                                    <!-- Image Preview Modal -->
                                    <div class="modal fade" id="previewDokumenModal{{ $a->id }}" tabindex="-1"
                                        aria-labelledby="previewDokumenModal{{ $a->id }}Label" aria-hidden="true">
                                        <div class="modal-dialog modal-xl modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5"
                                                        id="previewDokumenModal{{ $a->id }}Label"></h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body" style="overflow: scroll">
                                                    <img src="{{ asset($a->dokumen) }}" alt="dokumen-preview"
                                                        style="width: 100%; height: 100%;">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="d-flex gap-3">
                                    <button class="btn btn-success w-50" onclick="accPengajuanAbsen({{ $a->id }})">
                                        <div id="spinner-1" class="custom-loader-white-small" style="display: none"></div>
                                        <i id="check-circle" class="fas fa-check-circle"></i>
                                    </button>
                                    <button class="btn btn-danger w-50" onclick="tolakPengajuanAbsen({{ $a->id }})">
                                        <div id="spinner-2" class="custom-loader-white-small" style="display: none"></div>
                                        <i id="close-x" class="fas fa-close"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function accPengajuanAbsen(id) {
            document.getElementById("spinner-1").style.display = "block";
            document.getElementById("check-circle").style.display = "none";

            /* ACC PENGAJUAN  */
            fetch(`/admin/pengajuan-absen/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    attendanceReqId: id,
                    approval: 'Yes',
                    updatedStatus: 'Diterima'
                })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById("spinner-1").style.display = "none";
                document.getElementById("check-circle").style.display = "block";
                if (data.success) {
                    console.log(data);
                    Swal.fire({
                        title: 'Success',
                        text: 'Pengajuan berhasil di acc.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                }
                if (data.failed) {
                    console.log(data);
                    Swal.fire({
                        title: 'Gagal',
                        text: data.error,
                        icon: 'error',
                        timer: 2000,
                        showConfirmButton: true
                    });
                }
            })
            .catch(err => {
                document.getElementById("spinner-1").style.display = "none";
                document.getElementById("check-circle").style.display = "block";
                Swal.fire({
                    title: 'Gagal',
                    text: err,
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: true
                });
                console.error('Error:', err);
            })
        }

        /* TOLAK PENGAJUAN  */
        function tolakPengajuanAbsen(id) {
            document.getElementById("spinner-2").style.display = "block";
            document.getElementById("close-x").style.display = "none";

            fetch(`/admin/pengajuan-absen/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    attendanceReqId: id,
                    approval: 'No',
                    updatedStatus: 'Ditolak'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById("spinner-2").style.display = "none";
                    document.getElementById("close-x").style.display = "block";
                    console.log(data);
                    Swal.fire({
                        title: 'Success',
                        text: 'Pengajuan berhasil ditolak.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                }
            })
            .catch(err => {
                document.getElementById("spinner-2").style.display = "none";
                document.getElementById("close-x").style.display = "block";
                Swal.fire({
                    title: 'Gagal',
                    text: err,
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: true
                });
                console.error('Error:', err);
            })
        }
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
