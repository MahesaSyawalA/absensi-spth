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
                    <button class="nav-link active" id="absensiDinas-tab" data-bs-toggle="tab"
                        data-bs-target="#absensiDinas" type="button" role="tab" aria-controls="absensiDinas"
                        aria-selected="true" onclick="resetFileInput()">Absen Dinas</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="absensiSakit-tab" data-bs-toggle="tab" 
                        data-bs-target="#absensiSakit" type="button" role="tab" aria-controls="absensiSakit"
                        aria-selected="false" onclick="resetFileInput()">Absen Sakit</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="absensiWFH-tab" data-bs-toggle="tab"
                        data-bs-target="#absensiWFH" type="button" role="tab" aria-controls="absensiWFH" 
                        aria-selected="false" onclick="resetFileInput()">Absen WFH/WFA</button>
                </li>
            </ul>

            <div class="tab-content" id="absensiTabContent">
                <div class="tab-pane fade show active m-t-30" id="absensiDinas" role="tabpanel"
                    aria-labelledby="absensiDinas-tab">
                    <p>Silahkan upload surat dinas keluar pada form dibawah berikut.</p>
                    <form id="submitSuratDinasForm" action="{{ route('absen_khusus.store') }}" method="POST">
                        @csrf
                        <input id="user_id" name="user_id" type="text" value="{{ $user->id }}" hidden>
                        <input id="nip_pegawai" name="nip_pegawai" type="text" value="{{ $user->nip }}" hidden>
                        <input id="nama_pegawai" name="nama_pegawai" type="text" value="{{ $user->nama }}" hidden>
                        <input id="jenis_absen" name="jenis_absen" type="text" value="Dinas" hidden>
                        <input id="dokumenDinas" name="dokumenDinas" type="file" class="form-control" required>
                        <button type="submit" class="btn btn-primary m-t-20">
                            <div id="spinner-1" class="custom-loader-white" style="display: none"></div>
                            <p id="submit-text-1" style="color: white">Submit</p>
                        </button>

                        <button class="btn btn-outline-primary m-t-20" onclick="resetFileInput()" type="button">
                            Reset File
                        </button>
                    </form>
                </div>
                <div class="tab-pane fade m-t-30" id="absensiSakit" role="tabpanel" aria-labelledby="absensiSakit-tab">
                    <p>Silahkan upload surat sakit pada form dibawah berikut.</p>
                    <form id="submitSuratSakitForm" action="{{ route('absen_khusus.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <input id="user_id" name="user_id" type="text" value="{{ $user->id }}" hidden>
                        <input id="nip_pegawai" name="nip_pegawai" type="text" value="{{ $user->nip }}" hidden>
                        <input id="nama_pegawai" name="nama_pegawai" type="text" value="{{ $user->nama }}" hidden>
                        <input id="jenis_absen" name="jenis_absen" type="text" value="Sakit" hidden>
                        <input id="dokumenSakit" name="dokumenSakit" type="file" class="form-control" required>
                        <button type="submit" class="btn btn-primary m-t-20">
                            <div id="spinner-2" class="custom-loader-white" style="display: none"></div>
                            <p id="submit-text-2" style="color: white">Submit</p>
                        </button>

                        <button class="btn btn-outline-primary m-t-20" onclick="resetFileInput()" type="button">
                            Reset File
                        </button>
                    </form>
                </div>
                <div class="tab-pane fade m-t-30" id="absensiWFH" role="tabpanel" aria-labelledby="absensiWFH-tab">
                    <p>Silahkan upload dokumen bukti WFH pada form dibawah berikut.</p>
                    <form id="submitDokumenBuktiWFHForm" action="{{ route('absen_khusus.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <input id="user_id" name="user_id" type="text" value="{{ $user->id }}" hidden>
                        <input id="nip_pegawai" name="nip_pegawai" type="text" value="{{ $user->nip }}" hidden>
                        <input id="nama_pegawai" name="nama_pegawai" type="text" value="{{ $user->nama }}" hidden>
                        <input id="jenis_absen" name="jenis_absen" type="text" value="WFH" hidden>
                        <input id="dokumenWFH" name="dokumenWFH" type="file" class="form-control" required>
                        <button type="submit" class="btn btn-primary m-t-20">
                            <div id="spinner-3" class="custom-loader-white" style="display: none"></div>
                            <p id="submit-text-3" style="color: white">Submit</p>
                        </button>

                        <button class="btn btn-outline-primary m-t-20" onclick="resetFileInput()" type="button">
                            Reset File
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script>
        // Reset button buat file input
        function resetFileInput() {
            const dokumenInputDinas = document.getElementById('dokumenDinas');
            const dokumenInputSakit = document.getElementById('dokumenSakit');
            const dokumenInputWFH = document.getElementById('dokumenWFH');

            dokumenInputDinas.value = '';
            dokumenInputSakit.value = '';
            dokumenInputWFH.value = '';
        }

        // Submit Absen Dinas
        submitSuratDinasForm.addEventListener('submit', function(e) {
            document.getElementById("spinner-1").style.display = "block";
            document.getElementById("submit-text-1").style.display = "none";

            e.preventDefault();

            let formData = new FormData(submitSuratDinasForm);

            formData.append('dokumen', document.querySelector('#dokumenDinas').files[0]);

            fetch(submitSuratDinasForm.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById("spinner-1").style.display = "none";
                        document.getElementById("submit-text-1").style.display = "block";

                        Swal.fire({
                            title: 'Success',
                            text: 'Absen dinas berhasil diajukan.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location = '/staff/absensi';
                        });
                    }
                })
                .catch(err => {
                    document.getElementById("spinner-1").style.display = "none";
                    document.getElementById("submit-text-1").style.display = "block";

                    Swal.fire({
                        title: 'Gagal',
                        text: err,
                        icon: 'error',
                        timer: 2000,
                        showConfirmButton: true
                    });

                    console.error('Error:', err);
                })
        });

        // Submit Absen Sakit
        submitSuratSakitForm.addEventListener('submit', function(e) {
            document.getElementById("spinner-2").style.display = "block";
            document.getElementById("submit-text-2").style.display = "none";

            e.preventDefault();

            let formData = new FormData(submitSuratSakitForm);

            formData.append('dokumen', document.querySelector('#dokumenSakit').files[0]);

            fetch(submitSuratSakitForm.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById("spinner-2").style.display = "none";
                        document.getElementById("submit-text-2").style.display = "block";

                        Swal.fire({
                            title: 'Success',
                            text: 'Absen sakit berhasil diajukan.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location = '/staff/absensi';
                        });
                    }
                })
                .catch(err => {
                    document.getElementById("spinner-2").style.display = "none";
                    document.getElementById("submit-text-2").style.display = "block";

                    Swal.fire({
                        title: 'Gagal',
                        text: err,
                        icon: 'error',
                        timer: 2000,
                        showConfirmButton: true
                    });

                    console.error('Error:', err);
                })
        });

        // Submit Absen WFH
        submitDokumenBuktiWFHForm.addEventListener('submit', function(e) {
            document.getElementById("spinner-3").style.display = "block";
            document.getElementById("submit-text-3").style.display = "none";

            e.preventDefault();

            let formData = new FormData(submitDokumenBuktiWFHForm);

            formData.append('dokumen', document.querySelector('#dokumenWFH').files[0]);

            fetch(submitDokumenBuktiWFHForm.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById("spinner-3").style.display = "none";
                        document.getElementById("submit-text-3").style.display = "block";

                        Swal.fire({
                            title: 'Success',
                            text: 'Absen WFH berhasil diajukan.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location = '/staff/absensi';
                        });
                    }
                })
                .catch(err => {
                    document.getElementById("spinner-3").style.display = "none";
                    document.getElementById("submit-text-3").style.display = "block";

                    Swal.fire({
                        title: 'Gagal',
                        text: err,
                        icon: 'error',
                        timer: 2000,
                        showConfirmButton: true
                    });

                    console.error('Error:', err);
                })
        });
    </script>
@endsection
