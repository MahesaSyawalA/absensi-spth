@extends('client.layout.commonLayout')

@section('linkPlugins')
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/slick.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/slick-theme.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/scrollbar.css">
@endsection

@section('content')
    <div id="spinner" class="custom-loader" style="margin-inline: auto; display: flex;"></div>
    <div id="result" class="f-20 text-center mx-5"></div>
    <div id="absen_ke" class="f-16 text-center mx-5"></div>
    <div id="latlon" class="f-15 m-t-5 text-center"></div>
    <div id="time" class="f-24 m-t-5 text-center"></div>
    <div id="datetime" class="f-15 m-t-5 text-center"></div>
    <div id="distance" class="f-15 m-t-5 text-center"></div>

    <button id="retryButton" class="btn btn-primary"
        style="display: none; width: 50%; margin-inline: auto; margin-top: 20px">Ulangi</button>
    <a href="/staff/absensi" class="btn btn-primary" id="back-to-prevpage"
        style="display: none; width: 50%; margin-inline: auto; margin-top: 50px">Kembali ke halaman absensi utama</>

        <script>
            document.getElementById("retryButton").addEventListener("click", function() {
                checkGeolocationPermission();
            });

            async function checkGeolocationPermission() {
                try {
                    let permissionStatus = await navigator.permissions.query({
                        name: 'geolocation'
                    });

                    if (permissionStatus.state === 'granted') {
                        getLocation();
                    } else if (permissionStatus.state === 'prompt') {
                        getLocation();
                    } else {
                        alert("Akses lokasi tidak diizinkan. Harap izinkan akses pada browser.");
                        document.getElementById("retryButton").style.display = "block";
                    }

                    permissionStatus.onchange = () => {
                        if (permissionStatus.state === 'granted') {
                            getLocation();
                        }
                    };
                } catch (error) {
                    console.error("Error memeriksa izin geolokasi: ", error);
                }
            }

            function getLocation() {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        let latitude = position.coords.latitude;
                        let longitude = position.coords.longitude;
                        let id_pegawai = @json($user->id);
                        
                        // remove previous state on elements
                        document.getElementById("spinner").style.display = "block";
                        document.getElementById("result").innerText = "";
                        document.getElementById("absen_ke").innerText = "";
                        document.getElementById("latlon").innerText = "";
                        document.getElementById("time").innerText = "";
                        document.getElementById("datetime").innerText = "";
                        document.getElementById("distance").innerText = "";
                        document.getElementById("back-to-prevpage").style.display = "none";

                        fetch('/api/attendance', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    latitude: latitude,
                                    longitude: longitude,
                                    id_pegawai: id_pegawai,
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.message) {
                                    document.getElementById("spinner").style.display = "none";
                                    document.getElementById("result").innerText = data.message;

                                    if (data.distance) {
                                        document.getElementById("distance").innerText =
                                            `Radius dari tempat absen: ${data.distance} meter`;
                                    }

                                    if (data.latitude & data.longitude) {
                                        document.getElementById("latlon").innerText =
                                            `Lat: ${data.latitude}, Lon: ${data.longitude}`;
                                    }

                                    if (data.time) {
                                        document.getElementById("time").innerText = `${data.time} WIB`;
                                    }

                                    if (data.datetime) {
                                        document.getElementById("datetime").innerText = data.datetime;
                                    }

                                    if (data.absen_ke) {
                                        document.getElementById("absen_ke").innerText = `Absen ke-${data.absen_ke}`;
                                    }
                                    document.getElementById("back-to-prevpage").style.display = "block";
                                }
                            });
                    },
                    (error) => {
                        alert('Gagal mendapatkan lokasi: ' + error.message);
                    }
                );
            }

            window.onload = function() {
                if (navigator.geolocation) {
                    checkGeolocationPermission();
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
