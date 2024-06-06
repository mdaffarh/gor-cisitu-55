<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>
        Gor Cisitu 55 - Admin Login
    </title>

    {{-- custom css --}}
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">

    {{-- icon --}}
    <link rel="stylesheet" href="{{ asset('dashboard-assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css">
</head>

<body class="bg-gradient-success">
    @include('sweetalert::alert')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-12 col-xl-10">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    <div class="card-body p-0 ">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-flex">
                                <div class="flex-grow-1 bg-login-image"
                                    style="background-image: url('https://images.unsplash.com/photo-1617696618050-b0fef0c666af?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D);">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <img src="{{ asset('img/cisitu55.png') }}" alt=""
                                            class="img-fluid col-6" style="background-color: var(--navy)">
                                        <h3 class="text-dark mt-5 mb-4 fw-bold">Login Admin</h3>
                                    </div>
                                    <form class="user" method="POST" action="/login">
                                        @csrf
                                        <div class="mb-3">
                                            <input class="form-control form-control-user" type="text"
                                                placeholder="Username" name="username">
                                        </div>
                                        <div class="mb-3">
                                            <input class="form-control form-control-user" type="password"
                                                placeholder="Password" name="password">
                                        </div>
                                        @if (session()->has('loginError'))
                                            <div class="ms-3">
                                                <small class="text-danger">Username atau password salah.</small>
                                            </div>
                                        @endif
                                        <button class="btn btn-primary d-block btn-user w-100" type="submit">
                                            Login
                                        </button>
                                        <hr>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>
