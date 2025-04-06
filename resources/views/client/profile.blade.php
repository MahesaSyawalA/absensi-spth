@extends('client.layout.commonLayout')

@section('title', $title)

@section('linkPlugins')
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/slick.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/slick-theme.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/scrollbar.css">
@endsection

@section('content')
    <div class="user-profile">
        <div class="card hovercard text-center common-user-image">
            <div class="cardheader">
                <div class="user-image">
                    <div class="avatar">
                        <div class="common-align">
                            <div>
                                <img id="output" src="{{asset('storage/'.$user->foto)}}" alt="Profile Image" style="min-height: 80px;">
                                {{-- <input type="file" accept="image/*" onchange="loadFile(event)">
                                <div class="icon-wrapper" id="cancelButton"><i class="icofont icofont-error"></i></div>
                                <div class="icon-wrapper"><i class="icofont icofont-pencil-alt-5"></i></div> --}}
                            </div>
                            <div class="user-designation"><a target="_blank" href="">{{$user->nama}}</a>
                                <div class="desc">{{$user->jabatan}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card user-bio">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="ttl-info text-start">
                            <h6><i class="icon-id-badge"></i> Nip</h6><span>{{$user->nip}}</span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="ttl-info text-start">
                            <h6><i class="fa-solid fa-calendar-days pe-2"></i>Tanggal Lahir</h6><span>{{$user->tanggal_lahir}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scriptPlugins')
    <script src="../assets/js/counter/custom-counter1.js"></script>
    <script src="../assets/js/tooltip-init.js"></script>
    <script src="../assets/js/common-avatar-change.js"></script>
@endsection
