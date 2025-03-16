@extends('admin.layout.adminLayout')

@section('title', 'Rekap Penilaian')

@section('linkPlugins')
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/slick.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/slick-theme.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/scrollbar.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/animate.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/select.bootstrap5.css">

@endsection

@section('content')
    <div>
        <div class="row">
            <div class="col-xl-6 col-md-12 box-col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Pegawai ASN</h5>
                    </div>
                    <div class="card-body chart-block">
                        <canvas id="myBarGraph"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-12 box-col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Pegawai Non ASN</h5>
                    </div>
                    <div class="card-body chart-block">
                        <canvas id="myBarGraph2"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header pb-0 card-no-border">
                <h5>Table Data Absensi Pegawai</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive custom-scrollbar">
                    <table class="display table-striped border" id="basic-1">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Office</th>
                                <th>Age</th>
                                <th>Start date</th>
                                <th>Salary</th>
                                <th>Action</th>
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
                                <td>
                                    <ul class="action">
                                        <li class="edit"> <a href="#!"><i
                                                    class="fa-regular fa-pen-to-square"></i></a></li>
                                        <li class="delete"><a href="#!"><i class="fa-solid fa-trash-can"></i></a></li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>Garrett Winters</td>
                                <td>Accountant</td>
                                <td>Tokyo</td>
                                <td>63</td>
                                <td>25/07/2015</td>
                                <td>$170,750</td>
                                <td>
                                    <ul class="action">
                                        <li class="edit"> <a href="#!"><i
                                                    class="fa-regular fa-pen-to-square"></i></a></li>
                                        <li class="delete"><a href="#!"><i class="fa-solid fa-trash-can"></i></a></li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>Ashton Cox</td>
                                <td>Junior Technical Author</td>
                                <td>San Francisco</td>
                                <td>66</td>
                                <td>12/01/2009</td>
                                <td>$86,000</td>
                                <td>
                                    <ul class="action">
                                        <li class="edit"> <a href="#!"><i
                                                    class="fa-regular fa-pen-to-square"></i></a></li>
                                        <li class="delete"><a href="#!"><i class="fa-solid fa-trash-can"></i></a></li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>Cedric Kelly</td>
                                <td>Senior Javascript Developer</td>
                                <td>Edinburgh</td>
                                <td>22</td>
                                <td>29/03/2016</td>
                                <td>$433,060</td>
                                <td>
                                    <ul class="action">
                                        <li class="edit"> <a href="#!"><i
                                                    class="fa-regular fa-pen-to-square"></i></a></li>
                                        <li class="delete"><a href="#!"><i class="fa-solid fa-trash-can"></i></a></li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>Airi Satou</td>
                                <td>Accountant</td>
                                <td>Tokyo</td>
                                <td>33</td>
                                <td>28/11/2008</td>
                                <td>$162,700</td>
                                <td>
                                    <ul class="action">
                                        <li class="edit"> <a href="#!"><i
                                                    class="fa-regular fa-pen-to-square"></i></a></li>
                                        <li class="delete"><a href="#!"><i class="fa-solid fa-trash-can"></i></a></li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>Brielle Williamson</td>
                                <td>Integration Specialist</td>
                                <td>New York</td>
                                <td>61</td>
                                <td>02/12/2012</td>
                                <td>$372,000</td>
                                <td>
                                    <ul class="action">
                                        <li class="edit"> <a href="#!"><i
                                                    class="fa-regular fa-pen-to-square"></i></a></li>
                                        <li class="delete"><a href="#!"><i class="fa-solid fa-trash-can"></i></a></li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>Herrod Chandler</td>
                                <td>Sales Assistant</td>
                                <td>San Francisco</td>
                                <td>59</td>
                                <td>06/08/2012</td>
                                <td>$137,500</td>
                                <td>
                                    <ul class="action">
                                        <li class="edit"> <a href="#!"><i
                                                    class="fa-regular fa-pen-to-square"></i></a></li>
                                        <li class="delete"><a href="#!"><i class="fa-solid fa-trash-can"></i></a></li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>Rhona Davidson</td>
                                <td>Integration Specialist</td>
                                <td>Tokyo</td>
                                <td>55</td>
                                <td>14/10/2010</td>
                                <td>$327,900</td>
                                <td>
                                    <ul class="action">
                                        <li class="edit"> <a href="#!"><i
                                                    class="fa-regular fa-pen-to-square"></i></a></li>
                                        <li class="delete"><a href="#!"><i class="fa-solid fa-trash-can"></i></a></li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>Colleen Hurst</td>
                                <td>Javascript Developer</td>
                                <td>San Francisco</td>
                                <td>39</td>
                                <td>15/09/2009</td>
                                <td>$205,500</td>
                                <td>
                                    <ul class="action">
                                        <li class="edit"> <a href="#!"><i
                                                    class="fa-regular fa-pen-to-square"></i></a></li>
                                        <li class="delete"><a href="#!"><i class="fa-solid fa-trash-can"></i></a></li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>Sonya Frost</td>
                                <td>Software Engineer</td>
                                <td>Edinburgh</td>
                                <td>23</td>
                                <td>13/12/2008</td>
                                <td>$103,600</td>
                                <td>
                                    <ul class="action">
                                        <li class="edit"> <a href="#!"><i
                                                    class="fa-regular fa-pen-to-square"></i></a></li>
                                        <li class="delete"><a href="#!"><i class="fa-solid fa-trash-can"></i></a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>Jena Gaines</td>
                                <td>Office Manager</td>
                                <td>London</td>
                                <td>30</td>
                                <td>19/12/2008</td>
                                <td>$90,560</td>
                                <td>
                                    <ul class="action">
                                        <li class="edit"> <a href="#!"><i
                                                    class="fa-regular fa-pen-to-square"></i></a></li>
                                        <li class="delete"><a href="#!"><i class="fa-solid fa-trash-can"></i></a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>Quinn Flynn</td>
                                <td>Support Lead</td>
                                <td>Edinburgh</td>
                                <td>22</td>
                                <td>03/03/2013</td>
                                <td>$342,000</td>
                                <td>
                                    <ul class="action">
                                        <li class="edit"> <a href="#!"><i
                                                    class="fa-regular fa-pen-to-square"></i></a></li>
                                        <li class="delete"><a href="#!"><i class="fa-solid fa-trash-can"></i></a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>Charde Marshall</td>
                                <td>Regional Director</td>
                                <td>San Francisco</td>
                                <td>36</td>
                                <td>16/10/2008</td>
                                <td>$470,600</td>
                                <td>
                                    <ul class="action">
                                        <li class="edit"> <a href="#!"><i
                                                    class="fa-regular fa-pen-to-square"></i></a></li>
                                        <li class="delete"><a href="#!"><i class="fa-solid fa-trash-can"></i></a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>Donna Snider</td>
                                <td>Customer Support</td>
                                <td>New York</td>
                                <td>27</td>
                                <td>25/01/2011</td>
                                <td>$112,000</td>
                                <td>
                                    <ul class="action">
                                        <li class="edit"> <a href="#!"><i
                                                    class="fa-regular fa-pen-to-square"></i></a></li>
                                        <li class="delete"><a href="#!"><i class="fa-solid fa-trash-can"></i></a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>Amir Reyes</td>
                                <td>JS Developer</td>
                                <td>US</td>
                                <td>22</td>
                                <td>21/07/2024</td>
                                <td>$148,450</td>
                                <td>
                                    <ul class="action">
                                        <li class="edit"> <a href="#!"><i
                                                    class="fa-regular fa-pen-to-square"></i></a></li>
                                        <li class="delete"><a href="#!"><i class="fa-solid fa-trash-can"></i></a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>Leon Mann</td>
                                <td>Software Engineer</td>
                                <td>UK</td>
                                <td>20</td>
                                <td>23/08/2024</td>
                                <td>$250,400</td>
                                <td>
                                    <ul class="action">
                                        <li class="edit"> <a href="#!"><i
                                                    class="fa-regular fa-pen-to-square"></i></a></li>
                                        <li class="delete"><a href="#!"><i class="fa-solid fa-trash-can"></i></a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>Eliezer Orr</td>
                                <td>Manager</td>
                                <td>New York</td>
                                <td>26</td>
                                <td>12/05/2023</td>
                                <td>$587,480</td>
                                <td>
                                    <ul class="action">
                                        <li class="edit"> <a href="#!"><i
                                                    class="fa-regular fa-pen-to-square"></i></a></li>
                                        <li class="delete"><a href="#!"><i class="fa-solid fa-trash-can"></i></a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>Ana Hanson</td>
                                <td>SEO</td>
                                <td>New York</td>
                                <td>28</td>
                                <td>05/09/2024</td>
                                <td>$145,000</td>
                                <td>
                                    <ul class="action">
                                        <li class="edit"> <a href="#!"><i
                                                    class="fa-regular fa-pen-to-square"></i></a></li>
                                        <li class="delete"><a href="#!"><i class="fa-solid fa-trash-can"></i></a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>Kaia Kline</td>
                                <td>HR</td>
                                <td>Singapore</td>
                                <td>24</td>
                                <td>18/09/2022</td>
                                <td>$600,580</td>
                                <td>
                                    <ul class="action">
                                        <li class="edit"> <a href="#!"><i
                                                    class="fa-regular fa-pen-to-square"></i></a></li>
                                        <li class="delete"><a href="#!"><i class="fa-solid fa-trash-can"></i></a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>Tori Hale</td>
                                <td>Customer Support</td>
                                <td>San Francisco</td>
                                <td>26</td>
                                <td>29/10/2024</td>
                                <td>$120,000</td>
                                <td>
                                    <ul class="action">
                                        <li class="edit"> <a href="#!"><i
                                                    class="fa-regular fa-pen-to-square"></i></a></li>
                                        <li class="delete"><a href="#!"><i class="fa-solid fa-trash-can"></i></a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
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
    <script src="../assets/js/chart/chartjs/chart.min.js"></script>
    <script src="../assets/js/chart/chartjs/chart.custom.js"></script>
    <script src="../assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/js/datatable/datatables/dataTables1.js"></script>
    <script src="../assets/js/datatable/datatables/dataTables.bootstrap5.js"></script>
    <script src="../assets/js/datatable/datatables/datatable.custom2.js"></script>
@endsection
