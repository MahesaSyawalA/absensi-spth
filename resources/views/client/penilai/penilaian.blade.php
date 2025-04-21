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
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-end align-items-end rounded">
                        <form class="d-flex align-items-end gap-3" action="{{ route('penilai.index') }}" method="GET">
                            <div>
                                <label class="form-label">Bulan Awal</label>
                                <select class="form-select" name="bulan_awal" required id="bulan_awal">
                                    <option selected disabled value="">Pilih</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}"
                                            @if (request('bulan_awal') == $i) selected @endif>
                                            {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div>
                                <label class="form-label">Bulan Akhir</label>
                                <select class="form-select" name="bulan_akhir" required id="bulan_akhir">
                                    <option selected disabled value="">Pilih</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}"
                                            @if (request('bulan_akhir') == $i) selected @endif>
                                            {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div>
                                <label class="form-label">Tahun</label>
                                <select class="form-select" name="tahun" required id="tahun">
                                    <option selected disabled value="">Pilih</option>
                                    @php
                                        $currentYear = date('Y');
                                        $startYear = $currentYear - 5; // 5 tahun kebelakang
                                        $endYear = $currentYear + 5; // 5 tahun kedepan
                                    @endphp
                                    @for ($year = $startYear; $year <= $endYear; $year++)
                                        <option value="{{ $year }}"
                                            @if (request('tahun') == $year) selected @endif>
                                            {{ $year }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div>
                                <button class="btn btn-primary" type="submit" style="height: 38px;">
                                    <i class="fa fa-filter me-2"></i> Filter
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


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
                <h5>List Total Point Absensi</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive custom-scrollbar">
                    <table class="display table-striped border" id="riwayatPenilaian">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>NIP</th>
                                <th>Bulan</th>
                                <th>Tahun</th>
                                <th>Total Absen</th>
                                <th>Total Poin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rekapanAbsensi as $data)
                                <tr>
                                    <td>{{ $data->user->nama }}</td>
                                    <td>{{ $data->user->jabatan }}</td>
                                    <td>{{ $data->user->nip }}</td>
                                    <td>{{ $data->bulan }}</td>
                                    <td>{{ $data->tahun }}</td>
                                    <td>{{ $data->total_absen }}</td>
                                    <td>{{ $data->total_poin }}</td>
                                </tr>
                            @endforeach
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
