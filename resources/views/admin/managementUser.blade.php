@extends('admin.layout.adminLayout')

@section('title', 'Management User')

@section('linkPlugins')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/slick.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/slick-theme.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/scrollbar.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/dataTables.bootstrap5.css">
@endsection

@section('content')
    <style>
        /* Posisikan alert di pojok kanan atas */
        #successAlert,
        #dangerAlert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            width: 300px;
            /* Sesuaikan lebar sesuai kebutuhan */
        }
    </style>

    <div>
        <div class="card">
            <div class="card-header d-flex justify-content-between pb-0 card-no-border">
                <h5>Table Data User</h5>
                <button class="btn btn-success d-flex align-items-center gap-2" type="button" data-bs-toggle="modal"
                    data-original-title="Add New User" data-bs-target="#createUserModal"><i class="fa-solid fa-plus"></i>
                    Add New User</button>
            </div>
            <div class="card-body">
                <div class="table-responsive custom-scrollbar">
                    <table class="display table-striped border" id="basic-1">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Tanggal Lahir</th>
                                <th>Status</th>
                                <th>Jenis Kelamin</th>
                                <th>Foto</th>
                                <th>QR</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $u)
                            <tr>
                                    <td>{{ $u->username }}</td>
                                    <td>{{ $u->nip }}</td>
                                    <td>{{ $u->nama }}</td>
                                    <td>{{ $u->jabatan }}</td>
                                    <td>{{ $u->tanggal_lahir }}</td>
                                    <td>{{ $u->status_pegawai }}</td>
                                    <td>{{ $u->jenis_kelamin }}</td>
                                    <td>{{ $u->foto }}</td>
                                    <td>{{ $u->barcode }}</td>
                                    <td>{{ ucfirst(trans($u->role)) }}</td>
                                    <td>
                                        <ul class="action">
                                            <li class="edit">
                                                <button class="btn btn-light" type="button" data-bs-toggle="modal"
                                                    data-bs-target="#updateUserModal" data-nip="{{ $u->nip }}">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>
                                            </li>
                                            <li class="delete">
                                                <button class="btn btn-light" type="button" data-bs-toggle="modal"
                                                    data-bs-target="#deleteUserModal" data-nip="{{ $u->nip }}"
                                                    data-nama="{{ $u->nama }}">
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
    <div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-toggle-wrapper">
                        <form id="addUserForm" action="{{ route('user.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf <!-- Tambahkan CSRF token -->
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="text" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="nip">NIP</label>
                                <input type="text" class="form-control" id="nip" name="nip" required>
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="form-group">
                                <label for="jabatan">Jabatan</label>
                                <input type="text" class="form-control" id="jabatan" name="jabatan" required>
                            </div>
                            <div class="form-group">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                            </div>
                            <div class="form-group">
                                <label for="status_pegawai">Status</label>
                                <select class="form-control" id="status" name="status_pegawai" required>
                                    <option value="ASN">ASN</option>
                                    <option value="Non ASN">Non ASN</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="Laki laki">Laki laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="foto">Foto</label>
                                <input type="file" class="form-control" id="foto" name="foto">
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select class="form-control" id="role" name="role" required>
                                    <option value="superadmin">Super Admin</option>
                                    <option value="admin">Admin</option>
                                    <option value="pegawai">Pegawai</option>
                                </select>
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

    {{-- Modal update --}}
    <div class="modal fade" id="updateUserModal" tabindex="-1" role="dialog" aria-labelledby="updateUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm">
                        <div class="form-group mb-2">
                            <label for="username" class="d-flex justify-content-between">Username <span>isi jika ingin mengubah</span></label>
                            <input type="text" class="form-control" id="editUsername" name="username" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="password" class="d-flex justify-content-between">Password <span>Isi jika ingin mengubah</span></label>
                            <input type="text" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="editNip">NIP</label>
                            <input type="text" class="form-control" id="editNip" name="nip" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="editNama">Nama</label>
                            <input type="text" class="form-control" id="editNama" name="nama" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="editJabatan">Jabatan</label>
                            <input type="text" class="form-control" id="editJabatan" name="jabatan" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="editTanggalLahir">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="editTanggalLahir" name="tanggal_lahir"
                                required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="editStatus">Status</label>
                            <select class="form-control" id="editStatus" name="status_pegawai" required>
                                <option value="ASN">ASN</option>
                                <option value="Non ASN">Non ASN</option>
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="editJenisKelamin">Jenis Kelamin</label>
                            <select class="form-control" id="editJenisKelamin" name="jenis_kelamin" required>
                                <option value="Laki laki">Laki laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="editFoto" class="d-flex justify-content-between">Foto <span>isi jika ingin mengubah</span></label>
                            <input type="file" class="form-control" id="editFoto" name="foto">
                        </div>
                        <div class="form-group mb-2">
                            <label for="editRole">Role</label>
                            <select class="form-control" id="editRole" name="role" required>
                                <option value="superadmin">Super Admin</option>
                                <option value="admin">Admin</option>
                                <option value="pegawai">Pegawai</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="updateUser">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal delete --}}
    <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="tooltipmodal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete User</h5>
                    <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Informasi user akan ditampilkan di sini -->
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-danger" type="button">Delete</button>
                </div>
            </div>
        </div>
    </div>

    {{-- <!-- Alert Success -->
    <div id="successAlert" class="alert alert-success d-flex align-items-center d-none" role="alert"
        style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
        <div>
            <i class="stroke-success" data-feather="check-square"></i>
        </div>
        <span class="txt-light" id="successMessage">User berhasil dihapus!</span>
    </div>

    <!-- Alert Danger -->
    <div id="dangerAlert" class="alert alert-danger d-flex align-items-center d-none" role="alert"
        style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
        <div>
            <i class="stroke-danger" data-feather="alert-circle"></i>
        </div>
        <span class="txt-light" id="dangerMessage">Gagal menghapus user!</span>
    </div> --}}

    {{-- scripts --}}
    <script>
        function showSuccessAlert(message) {
            // Set pesan ke dalam alert
            document.getElementById('successMessage').innerText = message;

            // Tampilkan alert
            var alertElement = document.getElementById('successAlert');
            alertElement.classList.remove('d-none'); // Hilangkan class d-none

            // Sembunyikan alert setelah 3 detik
            setTimeout(function() {
                alertElement.classList.add('d-none');
            }, 3000); // 3000 ms = 3 detik
        }

        function showDangerAlert(message) {
            // Set pesan ke dalam alert
            document.getElementById('dangerMessage').innerText = message;

            // Tampilkan alert
            var alertElement = document.getElementById('dangerAlert');
            alertElement.classList.remove('d-none'); // Hilangkan class d-none

            // Sembunyikan alert setelah 3 detik
            setTimeout(function() {
                alertElement.classList.add('d-none');
            }, 3000); // 3000 ms = 3 detik
        }

        // create new user
        document.addEventListener('DOMContentLoaded', function() {
            var addUserForm = document.getElementById('addUserForm');

            // Handle submit form
            addUserForm.addEventListener('submit', function(event) {
                event.preventDefault(); // Mencegah form dikirim secara default

                // Ambil data form
                let formData = new FormData(addUserForm);

                // Kirim data ke server menggunakan fetch
                fetch(addUserForm.action, {
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
                            showSuccessAlert('User berhasil disimpan!');
                            // Tutup modal
                            var modal = bootstrap.Modal.getInstance(document.getElementById(
                                'createUserModal'));
                            modal.hide();
                            // Reload halaman atau update tampilan (opsional)
                            window.location.reload();
                        } else {
                            showDangerAlert('Gagal menyimpan user: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat menyimpan user!');
                    });
            });
        });

        // update user
        document.addEventListener('DOMContentLoaded', function() {
            var updateUserModal = document.getElementById('updateUserModal');
            var editUserForm = document.getElementById('editUserForm');
            var updateUserButton = document.getElementById('updateUser');

            // Event listener untuk membuka modal
            updateUserModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget; // Tombol yang memicu modal
                var nip = button.getAttribute('data-nip'); // Ambil NIP dari atribut data

                // Ambil data user dari server berdasarkan NIP
                fetch(`/users/${nip}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        // Isi form dengan data user
                        // document.getElementById('editUsername').value = data.user.username;
                        document.getElementById('editNip').value = data.user.nip;
                        document.getElementById('editNama').value = data.user.nama;
                        document.getElementById('editJabatan').value = data.user.jabatan;
                        document.getElementById('editTanggalLahir').value = data.user.tanggal_lahir;
                        document.getElementById('editStatus').value = data.user.status_pegawai;
                        document.getElementById('editJenisKelamin').value = data.user.jenis_kelamin;
                        document.getElementById('editRole').value = data.user.role;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal mengambil data user!');
                    });
            });

            // Event listener untuk tombol Simpan Perubahan
            updateUserButton.addEventListener('click', function() {
                let formData = new FormData(editUserForm);
                let nip = document.getElementById('editNip').value;

                // Tambahkan _method karena Laravel menangani PUT/PATCH secara berbeda
                formData.append('_method', 'PUT');

                fetch(`/users/${nip}`, {
                        method: 'POST', // Gunakan POST karena _method akan menangani PUT
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showSuccessAlert('User berhasil diperbarui!');
                            var modal = bootstrap.Modal.getInstance(updateUserModal);
                            modal.hide();
                            window.location.reload();
                        } else {
                            showDangerAlert('Gagal memperbarui user: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat memperbarui user!');
                    });
            });
        });

        // delete user
        document.addEventListener('DOMContentLoaded', function() {

            var deleteUserModal = document.getElementById('deleteUserModal');
            var deleteButton = deleteUserModal.querySelector('.btn-danger');

            deleteUserModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget; // Tombol yang memicu modal
                var nip = button.getAttribute('data-nip');
                var nama = button.getAttribute('data-nama');

                // Menampilkan informasi user di modal
                var modalBody = deleteUserModal.querySelector('.modal-body');
                modalBody.innerHTML =
                    `Apakah Anda yakin ingin menghapus user <strong>${nama}</strong> (NIP: ${nip})?`;

                // Menyimpan NIP di tombol delete untuk request ke controller
                deleteButton.setAttribute('data-nip', nip);
            });

            // Menangani klik tombol delete
            deleteButton.addEventListener('click', function() {
                var nip = this.getAttribute('data-nip');

                // Kirim request ke controller untuk menghapus user
                fetch(`/users/${nip}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Tutup modal setelah request selesai
                        var modalInstance = bootstrap.Modal.getInstance(deleteUserModal);
                        modalInstance.hide();

                        if (data.success) {
                            showSuccessAlert('User berhasil dihapus!');
                            window.location.reload(); // Reload halaman setelah penghapusan
                        } else {
                            showDangerAlert('Gagal menghapus user!');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Tutup modal jika terjadi error
                        var modalInstance = bootstrap.Modal.getInstance(deleteUserModal);
                        modalInstance.hide();
                        showDangerAlert('Terjadi kesalahan saat menghapus user!');
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
