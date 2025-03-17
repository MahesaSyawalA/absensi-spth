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
                            <img src="/images/user.jpg" alt="User Image" class="img-fluid rounded-circle mb-3" width="100"
                                height="100">

                            <!-- Tulisan Selamat Datang -->
                            <h5 class="card-title">Selamat Datang</h5>
                            <p class="card-text">Silakan lakukan absensi dengan menekan tombol di bawah.</p>

                            <!-- Tombol Aksi untuk Absensi -->
                            <a href="/scan-qr" class="btn btn-primary">
                                <i class="fas fa-qrcode"></i> Absen Sekarang
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="card h-100 ">
                        <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                            <h1>Jam Saat Ini:</h1>
                            <div id="clock" class="display-4">14:07:46</div>

                            <!-- Tulisan Selamat Datang -->
                            <h5 class="card-title">Status Absensi Hari Ini</h5>
                            <div class="d-flex flex-wrap gap-2 justify-content-center">
                                <span class="badge badge-success">Absensi Ke 1</span>
                                <span class="badge badge-success">Absensi Ke 2</span>
                                <span class="badge badge-warning">Absensi Ke 3</span>
                                <span class="badge badge-dark">Absensi Ke 4</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid card">
            <div class="card-header pb-0 card-no-">
                <h5>Riwayat Absensi</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive custom-scrollbar">
                    <table class="display table-striped " id="basic-1">
                        <thead>
                            <tr>
                                <th>Hari Tanggal</th>
                                <th>Absen Ke-1</th>
                                <th>Absen ke-2</th>
                                <th>Absen ke-3</th>
                                <th>Absen ke-4</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Tiger Nixon</td>
                                <td>System Architect</td>
                                <td>Edinburgh</td>
                                <td>61</td>
                                <td>25/04/2011</td>
                                <td>$320,800</td>
                            </tr>
                            <tr>
                                <td>Garrett Winters</td>
                                <td>Accountant</td>
                                <td>Tokyo</td>
                                <td>63</td>
                                <td>25/07/2015</td>
                                <td>$170,750</td>
                            </tr>
                            <tr>
                                <td>Ashton Cox</td>
                                <td>Junior Technical Author</td>
                                <td>San Francisco</td>
                                <td>66</td>
                                <td>12/01/2009</td>
                                <td>$86,000</td>
                            </tr>
                            <tr>
                                <td>Cedric Kelly</td>
                                <td>Senior Javascript Developer</td>
                                <td>Edinburgh</td>
                                <td>22</td>
                                <td>29/03/2016</td>
                                <td>$433,060</td>
                            </tr>
                            <tr>
                                <td>Airi Satou</td>
                                <td>Accountant</td>
                                <td>Tokyo</td>
                                <td>33</td>
                                <td>28/11/2008</td>
                                <td>$162,700</td>
                            </tr>
                            <tr>
                                <td>Brielle Williamson</td>
                                <td>Integration Specialist</td>
                                <td>New York</td>
                                <td>61</td>
                                <td>02/12/2012</td>
                                <td>$372,000</td>
                            </tr>
                            <tr>
                                <td>Herrod Chandler</td>
                                <td>Sales Assistant</td>
                                <td>San Francisco</td>
                                <td>59</td>
                                <td>06/08/2012</td>
                                <td>$137,500</td>
                            </tr>
                            <tr>
                                <td>Rhona Davidson</td>
                                <td>Integration Specialist</td>
                                <td>Tokyo</td>
                                <td>55</td>
                                <td>14/10/2010</td>
                                <td>$327,900</td>
                            </tr>
                            <tr>
                                <td>Colleen Hurst</td>
                                <td>Javascript Developer</td>
                                <td>San Francisco</td>
                                <td>39</td>
                                <td>15/09/2009</td>
                                <td>$205,500</td>
                            </tr>
                            <tr>
                                <td>Sonya Frost</td>
                                <td>Software Engineer</td>
                                <td>Edinburgh</td>
                                <td>23</td>
                                <td>13/12/2008</td>
                                <td>$103,600</td>
                            </tr>
                            <tr>
                                <td>Jena Gaines</td>
                                <td>Office Manager</td>
                                <td>London</td>
                                <td>30</td>
                                <td>19/12/2008</td>
                                <td>$90,560</td>
                            </tr>
                            <tr>
                                <td>Quinn Flynn</td>
                                <td>Support Lead</td>
                                <td>Edinburgh</td>
                                <td>22</td>
                                <td>03/03/2013</td>
                                <td>$342,000</td>
                            </tr>
                            <tr>
                                <td>Charde Marshall</td>
                                <td>Regional Director</td>
                                <td>San Francisco</td>
                                <td>36</td>
                                <td>16/10/2008</td>
                                <td>$470,600</td>
                            </tr>
                            <tr>
                                <td>Donna Snider</td>
                                <td>Customer Support</td>
                                <td>New York</td>
                                <td>27</td>
                                <td>25/01/2011</td>
                                <td>$112,000</td>
                            </tr>
                            <tr>
                                <td>Amir Reyes</td>
                                <td>JS Developer</td>
                                <td>US</td>
                                <td>22</td>
                                <td>21/07/2024</td>
                                <td>$148,450</td>
                            </tr>
                            <tr>
                                <td>Leon Mann</td>
                                <td>Software Engineer</td>
                                <td>UK</td>
                                <td>20</td>
                                <td>23/08/2024</td>
                                <td>$250,400</td>
                            </tr>
                            <tr>
                                <td>Eliezer Orr</td>
                                <td>Manager</td>
                                <td>New York</td>
                                <td>26</td>
                                <td>12/05/2023</td>
                                <td>$587,480</td>
                            </tr>
                            <tr>
                                <td>Ana Hanson</td>
                                <td>SEO</td>
                                <td>New York</td>
                                <td>28</td>
                                <td>05/09/2024</td>
                                <td>$145,000</td>
                            </tr>
                            <tr>
                                <td>Kaia Kline</td>
                                <td>HR</td>
                                <td>Singapore</td>
                                <td>24</td>
                                <td>18/09/2022</td>
                                <td>$600,580</td>
                            </tr>
                            <tr>
                                <td>Tori Hale</td>
                                <td>Customer Support</td>
                                <td>San Francisco</td>
                                <td>26</td>
                                <td>29/10/2024</td>
                                <td>$120,000</td>
                            </tr>
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
