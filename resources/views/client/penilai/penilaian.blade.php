@extends('client.layout.commonLayout')

@section('title', $title)

@section('linkPlugins')
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/slick.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/slick-theme.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/scrollbar.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/dataTables.bootstrap5.css">
@endsection

@section('content')
    <div class="container-fluid d-flex flex-column">

        <div class="container-fluid card">
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

        <div class="container-fluid card">
            <div class="card-header pb-0 card-no-border">
                <h5>List Penilaian Masyarakat</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive custom-scrollbar">
                    <table class="display table-striped border" id="riwayatPenilaian">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>NIP</th>
                                <th>Perilaku Petugas</th>
                                <th>Penampilan</th>
                                <th>Kecepatan Pelayanan</th>
                                <th>Ketepatan Transparansi</th>
                                <th>Rata-rata Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->nama }}</td>
                                    <td>{{ $user->jabatan }}</td>
                                    <td>{{ $user->nip }}</td>

                                    @php
                                        // Pastikan relasi penilaianMasyarakat ada dan memiliki data
                                        $penilaian = $user->penilaianMasyarakat->first() ?? null;
                                    @endphp

                                    @if ($penilaian)
                                        <td class="text-center">{{ $penilaian->avg_perilaku_petugas }}</td>
                                        <td class="text-center">{{ $penilaian->avg_penampilan }}</td>
                                        <td class="text-center">{{ $penilaian->avg_kecepatan_pelayanan }}</td>
                                        <td class="text-center">{{ $penilaian->avg_ketepatan_transparansi }}</td>
                                        <td class="text-center">{{ $penilaian->avg_total }}</td>
                                    @else
                                        <td class="text-center">Belum ada penilaian</td>
                                        <td class="text-center">Belum ada penilaian</td>
                                        <td class="text-center">Belum ada penilaian</td>
                                        <td class="text-center">Belum ada penilaian</td>
                                        <td class="text-center">Belum ada penilaian</td>
                                    @endif

                                    <td>
                                        <ul class="action">
                                            <li class="edit">
                                                <a href="/penilaian-staff/{{ $user->slug }}"><i
                                                        class="fa-regular fa-pen-to-square"></i>
                                                    Berikan Penilaian
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="container-fluid card">
            <div class="card-header pb-0 card-no-border">
                <h5>Riwayat Penilaian</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive custom-scrollbar">
                    <table class="display table-striped border" id="basic-1">
                        <thead>
                            <tr>
                                <th>Nama Pegawai</th>
                                <th>Jabatan Pegawai</th>
                                <th>Status Pegawai</th>
                                <th>Tujuan</th>
                                <th>Pelayanan</th>
                                <th>Perilaku Petugas</th>
                                <th>Penampilan</th>
                                <th>Kecepatan Pelayanan</th>
                                <th>Ketepatan Transparansi</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($riwayatPenilaian as $item)
                                <tr>
                                    <td>{{ $item->user->nama }}</td>
                                    <td>{{ $item->user->jabatan }}</td>
                                    <td>{{ $item->user->status_pegawai }}</td>
                                    <td>{{ $item->tujuan }}</td>
                                    <td>{{ $item->pelayanan }}</td>
                                    <td>{{ $item->perilaku_petugas }}</td>
                                    <td>{{ $item->penampilan }}</td>
                                    <td>{{ $item->kecepatan_pelayanan }}</td>
                                    <td>{{ $item->ketepatan_transparansi }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ $item->updated_at }}</td>
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
    <script src="../assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/js/datatable/datatables/dataTables1.js"></script>
    <script src="../assets/js/datatable/datatables/dataTables.bootstrap5.js"></script>
    <script src="../assets/js/datatable/datatables/datatable.custom2.js"></script>
@endsection
