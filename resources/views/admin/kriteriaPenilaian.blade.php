@extends('admin.layout.adminLayout')

@section('title', 'Kriteria Penilaian')

@section('linkPlugins')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/slick.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/slick-theme.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/scrollbar.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/dataTables.bootstrap5.css">
@endsection

@section('content')
    <div>
        <div class="card">
            <div class="card-header pb-0 card-no-border d-flex justify-content-between">
                <h5>Kriteria Penilaian</h5>
                <button class="btn btn-success d-flex align-items-center gap-2" type="button" data-bs-toggle="modal"
                    data-original-title="Add New Kriteria" data-bs-target="#createKriteriaModal"><i
                        class="fa-solid fa-plus"></i>
                    Add New Kriteria</button>
            </div>
            <div class="card-body">
                <div class="table-responsive custom-scrollbar">
                    <table class="display table-striped border" id="basic-1">
                        <thead>
                            <tr>
                                <th>Nama Kriteria</th>
                                <th>Bobot Persentase</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kriteriaAll as $i)
                                <tr>
                                    <td>{{ ucwords(str_replace('_', ' ', $i->name)) }}</td>
                                    <td>{{ $i->bobot }}</td>
                                    <td>
                                        <ul class="action">
                                            <li class="delete">
                                                <button class="btn btn-light" type="button" data-bs-toggle="modal"
                                                    data-bs-target="#deleteKriteriaModal" data-id="{{ $i->uuid }}"
                                                    data-nama="{{ ucwords(str_replace('_', ' ', $i->name)) }}">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
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

        <div class="card">
            <div class="card-header pb-0 card-no-border d-flex justify-content-between">
                <h5>Sub Kriteria Penilaian</h5>
                <button class="btn btn-success d-flex align-items-center gap-2" type="button" data-bs-toggle="modal"
                    data-original-title="Add New Kriteria" data-bs-target="#createSubKriteriaModal"><i
                        class="fa-solid fa-plus"></i>
                    Add New Sub Kriteria</button>
            </div>
            <div class="card-body">
                <div class="table-responsive custom-scrollbar">
                    <table class="display table-striped border" id="tableSubKriteria">
                        <thead>
                            <tr>
                                <th>Nama Kriteria</th>
                                <th>Nama Sub Kriteria</th>
                                <th>Bobot Penilaian</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subKriteriaAll as $i)
                                <tr>
                                    <td>{{ ucwords(str_replace('_', ' ', $i->kriteria->name)) }}</td>
                                    <td>{{ ucwords(str_replace('_', ' ', $i->name)) }}</td>
                                    <td>{{ $i->nilai }}</td>
                                    <td>
                                        <ul class="action">
                                            <li class="delete">
                                                <button class="btn btn-light" type="button" data-bs-toggle="modal"
                                                    data-bs-target="#deleteSubKriteriaModal" data-id="{{ $i->uuid }}"
                                                    data-nama="{{ ucwords(str_replace('_', ' ', $i->name)) }}">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
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
    </div>

    {{-- modal create --}}
    <div class="modal fade" id="createKriteriaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-toggle-wrapper">
                        <form id="addKriteriaForm" action="{{ route('kriteria.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf <!-- Tambahkan CSRF token -->
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="bobot">Bobot</label>
                                <input type="text" class="form-control" id="bobot" name="bobot" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal delete --}}
    <div class="modal fade" id="deleteKriteriaModal" tabindex="-1" role="dialog" aria-labelledby="tooltipmodal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Kriteria</h5>
                    <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Informasi user akan ditampilkan di sini -->
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-danger" type="button" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>

    {{-- modal create Sub Kriteria --}}
    <div class="modal fade" id="createSubKriteriaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-toggle-wrapper">
                        <form id="addSubKriteriaForm" action="{{ route('subKriteria.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf <!-- Tambahkan CSRF token -->
                            <div class="form-group">
                                <label for="kriteria">Kriteria</label>
                                <select class="form-control" id="status" name="kriteria" required>
                                    @foreach ($kriteriaAll as $x)
                                        <option value="{{$x->uuid}}"> {{ ucwords(str_replace('_', ' ', $x->name)) }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="nilai">Bobot Penilaian</label>
                                <input type="text" class="form-control" id="nilai" name="nilai" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal delete Sub Kriteria --}}
    <div class="modal fade" id="deleteSubKriteriaModal" tabindex="-1" role="dialog" aria-labelledby="tooltipmodal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete SubKriteria</h5>
                    <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Informasi user akan ditampilkan di sini -->
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-danger" type="button" id="confirmDeleteSub">Delete</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        // create new kriteria
        document.addEventListener('DOMContentLoaded', function() {
            var addKriteriaForm = document.getElementById('addKriteriaForm');

            // Handle submit form
            addKriteriaForm.addEventListener('submit', function(event) {
                event.preventDefault(); // Mencegah form dikirim secara default

                // Ambil data form
                let formData = new FormData(addKriteriaForm);

                // Kirim data ke server menggunakan fetch
                fetch(addKriteriaForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json()) // Parse response JSON
                    .then(data => {
                        if (data.success) {
                            showSuccessAlert('Kriteria berhasil disimpan!');
                            // Tutup modal
                            var modal = bootstrap.Modal.getInstance(document.getElementById(
                                'createKriteriaModal'));
                            modal.hide();
                            // Reload halaman atau update tampilan (opsional)
                            window.location.reload();
                        } else {
                            showDangerAlert('Gagal menyimpan Kriteria: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat menyimpan Kriteria!');
                    });
            });
        });

        // delete kriteria
        document.addEventListener('DOMContentLoaded', function() {
            var deleteKriteriaModal = document.getElementById('deleteKriteriaModal');
            var deleteButton = document.getElementById('confirmDelete'); // Perbaikan di sini

            deleteKriteriaModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget; // Ambil tombol yang memicu modal
                var id = button.getAttribute('data-id');
                var nama = button.getAttribute('data-nama');

                // Pastikan nama yang dikirim ke modal tidak null
                console.log("ID:", id, "Nama:", nama);

                // Menampilkan informasi user di modal
                var modalBody = deleteKriteriaModal.querySelector('.modal-body');
                modalBody.innerHTML =
                    `Apakah Anda yakin ingin menghapus kriteria <strong>${nama}</strong>?`;

                // Simpan ID di tombol delete untuk request ke server
                deleteButton.setAttribute('data-id', id);
            });

            // Menangani klik tombol delete
            deleteButton.addEventListener('click', function() {
                var id = this.getAttribute('data-id');

                // Kirim request ke controller untuk menghapus user
                fetch(`/kriteria/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        var modalInstance = bootstrap.Modal.getInstance(deleteKriteriaModal);
                        modalInstance.hide();

                        if (data.success) {
                            showSuccessAlert('Kriteria berhasil dihapus!');
                            window.location.reload(); // Reload halaman setelah penghapusan
                        } else {
                            showDangerAlert('Gagal menghapus kriteria!');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        var modalInstance = bootstrap.Modal.getInstance(deleteKriteriaModal);
                        modalInstance.hide();
                        showDangerAlert('Terjadi kesalahan saat menghapus kriteria!');
                    });
            });
        });

        // create new sub kriteria
        document.addEventListener('DOMContentLoaded', function() {
            var addSubKriteriaForm = document.getElementById('addSubKriteriaForm');

            // Handle submit form
            addSubKriteriaForm.addEventListener('submit', function(event) {
                event.preventDefault(); // Mencegah form dikirim secara default

                // Ambil data form
                let formData = new FormData(addSubKriteriaForm);

                // Kirim data ke server menggunakan fetch
                fetch(addSubKriteriaForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json()) // Parse response JSON
                    .then(data => {
                        if (data.success) {
                            showSuccessAlert('Sub Kriteria berhasil disimpan!');
                            // Tutup modal
                            var modal = bootstrap.Modal.getInstance(document.getElementById(
                                'createSubKriteriaModal'));
                            modal.hide();
                            // Reload halaman atau update tampilan (opsional)
                            window.location.reload();
                        } else {
                            showDangerAlert('Gagal menyimpan Sub Kriteria: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat menyimpan Sub Kriteria!');
                    });
            });
        });

        // delete sub kriteria
        document.addEventListener('DOMContentLoaded', function() {
            var deleteSubKriteriaModal = document.getElementById('deleteSubKriteriaModal');
            var deleteButton = document.getElementById('confirmDeleteSub'); // Perbaikan di sini

            deleteSubKriteriaModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget; // Ambil tombol yang memicu modal
                var id = button.getAttribute('data-id');
                var nama = button.getAttribute('data-nama');

                // Pastikan nama yang dikirim ke modal tidak null
                console.log("ID:", id, "Nama:", nama);

                // Menampilkan informasi user di modal
                var modalBody = deleteSubKriteriaModal.querySelector('.modal-body');
                modalBody.innerHTML =
                    `Apakah Anda yakin ingin menghapus sub kriteria <strong>${nama}</strong>?`;

                // Simpan ID di tombol delete untuk request ke server
                deleteButton.setAttribute('data-id', id);
            });

            // Menangani klik tombol delete
            deleteButton.addEventListener('click', function() {
                var id = this.getAttribute('data-id');

                // Kirim request ke controller untuk menghapus user
                fetch(`/sub-kriteria/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        var modalInstance = bootstrap.Modal.getInstance(deleteSubKriteriaModal);
                        modalInstance.hide();

                        if (data.success) {
                            showSuccessAlert('Sub Kriteria berhasil dihapus!');
                            window.location.reload(); // Reload halaman setelah penghapusan
                        } else {
                            showDangerAlert('Gagal menghapus sub kriteria!');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        var modalInstance = bootstrap.Modal.getInstance(deleteSubKriteriaModal);
                        modalInstance.hide();
                        showDangerAlert('Terjadi kesalahan saat menghapus sub kriteria!');
                    });
            });
        });
    </script>

@endsection

@section('scriptPlugins')
    <script src="../assets/js/sidebar-menu.js"></script>
    <script src="../assets/js/sidebar-pin.js"></script>
    <script src="../assets/js/slick/slick.min.js"></script>
    <script src="../assets/js/slick/slick.js"></script>
    <script src="../assets/js/header-slick.js"></script>
    <script src="../assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/js/datatable/datatables/dataTables1.js"></script>
    <script src="../assets/js/datatable/datatables/dataTables.bootstrap5.js"></script>
    <script src="../assets/js/datatable/datatables/datatable.custom2.js"></script>
@endsection
