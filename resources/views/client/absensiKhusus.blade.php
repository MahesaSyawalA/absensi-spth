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

    <div class="card">
        <div class="card-header pb-0 card-no-border d-flex justify-content-between">
            <h5>Absensi Khusus</h5>
        </div>
        <div class="card-body">
            <span class="d-block fw-normal fs-6 m-b-10 m-t-20">
                Gunakan halaman ini untuk absen diluar jadwal dan tempat yang telah ditentukan. File
                dokumen yang diunggah akan diteruskan kepada admin untuk pengajuan absensi.
            </span>

            <ul class="nav nav-tabs d-flex flex-row m-t-45" id="absensiTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="absensiDinas-tab" data-bs-toggle="tab" data-bs-target="#absensiDinas"
                        type="button" role="tab" aria-controls="absensiDinas" aria-selected="true">Absen Dinas</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="absensiSakit-tab" data-bs-toggle="tab" data-bs-target="#absensiSakit" type="button"
                        role="tab" aria-controls="absensiSakit" aria-selected="false">Absen Sakit</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="absensiWFH-tab" data-bs-toggle="tab" data-bs-target="#absensiWFH" type="button"
                        role="tab" aria-controls="absensiWFH" aria-selected="false">Absen WFH/WFA</button>
                </li>
            </ul>

            <div class="tab-content" id="absensiTabContent">
                <div class="tab-pane fade show active m-t-30" id="absensiDinas" role="tabpanel" aria-labelledby="absensiDinas-tab">
                    <p>Silahkan upload surat dinas keluar pada form dibawah berikut.</p>
                    <form id="submitSuratDinasForm" action="{{ route('absen_khusus.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf <!-- Tambahkan CSRF token -->
                        <input id="user_id" name="user_id" type="text" value="{{ $user->id }}" hidden>
                        <input id="nip_pegawai" name="nip_pegawai" type="text" value="{{ $user->nip }}" hidden>
                        <input id="nama_pegawai" name="nama_pegawai" type="text" value="{{ $user->nama }}" hidden>
                        <input id="jenis_absen" name="jenis_absen" type="text" value="Dinas" hidden>
                        <div class="form-group">
                            <label for="dokumen">Surat Dinas</label>
                            <input type="file" class="form-control" id="dokumen" name="dokumen">
                        </div>
                        <button type="submit" class="btn btn-primary m-t-20">Submit</button>
                    </form>
                </div>
                <div class="tab-pane fade m-t-30" id="absensiSakit" role="tabpanel" aria-labelledby="absensiSakit-tab">
                    <p>Silahkan upload surat sakit pada form dibawah berikut.</p>
                    <form id="submitSuratSakitForm" action="{{ route('absen_khusus.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf <!-- Tambahkan CSRF token -->
                        <div class="form-group">
                            <label for="dokumen">Surat Sakit</label>
                            <input type="file" class="form-control" id="dokumen" name="dokumen">
                        </div>
                        <button type="submit" class="btn btn-primary m-t-20">Submit</button>
                    </form>
                </div>
                <div class="tab-pane fade m-t-30" id="absensiWFH" role="tabpanel" aria-labelledby="absensiWFH-tab">
                    <p>Silahkan upload dokumen bukti WFH pada form dibawah berikut.</p>
                    <form id="submitDokumenBuktiWFH" action="{{ route('absen_khusus.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf <!-- Tambahkan CSRF token -->
                        <div class="form-group">
                            <label for="dokumen">Dokumen Bukti</label>
                            <input type="file" class="form-control" id="dokumen" name="dokumen">
                        </div>
                        <button type="submit" class="btn btn-primary m-t-20">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



@endsection
