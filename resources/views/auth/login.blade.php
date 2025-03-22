<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/logo_jabar.png" type="image/x-icon">
    <link rel="shortcut icon" href="../images/logo_jabar.png" type="image/x-icon">
    <title>Login</title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap"
        rel="stylesheet">
    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="../assets/css/fontawesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/feather-icon.css">
    <!-- Plugins css start-->
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <link id="color" rel="stylesheet" href="../assets/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="../assets/css/responsive.css">
</head>

<body>
    <!-- login page start-->
    <div class="container-fluid p-0">
        <div class="row m-0">
            <div class="col-12 p-0">
                <div class="login-card login-dark">
                    <div>
                        <div class="d-flex justify-content-center"><img class="img-fluid for-light"
                                src="/images/SPTH.png" alt="looginpage"><img class="img-fluid for-dark"
                                src="/images/SPTH.png" alt="looginpage"></div>
                        <div class="login-main">
                            <form id="loginForm" class="theme-form" method="POST" action="{{ route('login.post') }}">
                                @csrf
                                <h4>Sign in to account</h4>
                                <p>Masukan Username dan Password </p>
                                <div class="form-group">
                                    <label class="col-form-label">Username</label>
                                    <input name="username" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="validatepwd">Password</label>
                                    <div class="input-group">
                                        <input class="form-control" id="validatepwd" type="password" placeholder="Enter your password" name="password" required>
                                    </div>

                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" type="checkbox" id="showPasswordCheck">
                                        <label class="form-check-label" for="showPasswordCheck">Show Password</label>
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <div class="text-end">
                                        <button class="btn btn-primary btn-block w-100 mt-3" type="submit">Sign
                                            in</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.getElementById('showPasswordCheck').addEventListener('change', function () {
                const passwordField = document.getElementById('validatepwd');
                passwordField.type = this.checked ? 'text' : 'password';
            });
        </script>

        <script>
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            document.getElementById('loginForm').addEventListener('submit', function(event) {
                event.preventDefault();

                const form = event.target;
                const formData = new FormData(form);

                fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken, // Menambahkan CSRF token
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message === 'Login berhasil') {
                            window.location.href = data.redirect;
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert(`Terjadi kesalahan saat memproses login. ${error}`);
                    });
            });
        </script>

        <!-- latest jquery-->
        <script src="../assets/js/jquery.min.js"></script>
        <!-- Bootstrap js-->
        <script src="../assets/js/bootstrap/bootstrap.bundle.min.js"></script>
        <!-- feather icon js-->
        <script src="../assets/js/icons/feather-icon/feather.min.js"></script>
        <script src="../assets/js/icons/feather-icon/feather-icon.js"></script>
        <!-- scrollbar js-->
        <!-- Sidebar jquery-->
        <script src="../assets/js/config.js"></script>
        <!-- Plugins JS start-->
        <!-- Plugins JS Ends-->
        <!-- Theme js-->
        <script src="../assets/js/script.js"></script>
        <script src="../assets/js/script1.js"></script>
    </div>
</body>

</html>
