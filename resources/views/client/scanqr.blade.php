@extends('client.layout.commonLayout')

@section('linkPlugins')
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/slick.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/slick-theme.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/scrollbar.css">
@endsection

@section('content')
    <div id="spinner" class="custom-loader" style="margin-inline: auto; display: flex;"></div>
    <div id="result" class="f-20 text-center"></div>
    <div id="latlon" class="f-15 m-t-5 text-center"></div>
    <div id="time" class="f-15 m-t-5 text-center"></div>

    <a href="/staff/absensi" class="btn btn-primary" id="back-to-prevpage" style="display: none; width: 50%; margin-inline: auto; margin-top: 20px">Kembali ke halaman absensi utama</>

    <script>
        window.onload = function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        let latitude = position.coords.latitude;
                        let longitude = position.coords.longitude;

                        document.getElementById("spinner").style.display = "block";
                        document.getElementById("result").innerText = "";
                        document.getElementById("latlon").innerText = "";
                        document.getElementById("time").innerText = "";
                        document.getElementById("back-to-prevpage").style.display = "none";

                        fetch('/api/attendance', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    latitude: latitude,
                                    longitude: longitude
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.message) {
                                    document.getElementById("spinner").style.display = "none";
                                    document.getElementById("result").innerText = data.message;
                                    document.getElementById("latlon").innerText = `Lat: ${data.latitude}, Lon: ${data.longitude}`;
                                    document.getElementById("time").innerText = data.time;
                                    document.getElementById("back-to-prevpage").style.display = "block";
                                }
                            });
                    },
                    (error) => {
                        alert('Gagal mendapatkan lokasi: ' + error.message);
                    }
                );
            } else {
                alert("Geolocation tidak didukung oleh browser ini.");
            }
        }
    </script>
@endsection

@section('scriptPlugins')
    <script src="../assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/js/datatable/datatables/dataTables1.js"></script>
    <script src="../assets/js/datatable/datatables/dataTables.bootstrap5.js"></script>
    <script src="../assets/js/datatable/datatables/datatable.custom2.js"></script>
@endsection
