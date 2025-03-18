@extends('admin.layout.adminLayout')

@section('title', 'Management User')

@section('linkPlugins')
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/slick.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/slick-theme.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/scrollbar.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/dataTables.bootstrap5.css">
@endsection

@section('content')
    <div>
        <div class="card">
            <div class="card-header pb-0 card-no-border">
                <h5>Table Data User</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive custom-scrollbar">
                    <table class="display table-striped border" id="basic-1">
                        <thead>
                            <tr>
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
                                            <li class="edit"> <a href="#!"><i
                                                        class="fa-regular fa-pen-to-square"></i></a></li>
                                            <li class="delete"><a href="#!"><i class="fa-solid fa-trash-can"></i></a>
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
