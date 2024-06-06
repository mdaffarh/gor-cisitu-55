<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Gor Cisitu 55 Bulutangkis</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/Raleway.css') }}">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>

<body data-bs-spy="scroll" data-bs-target="#navbar" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true"
    class="scrollspy-example">
    @include('sweetalert::alert')

    <nav class="navbar navbar-expand-md fixed-top navbar-shrink py-3 navbar-light bg-success" id="mainNav">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#header"><img src="img/cisitu55.png"
                    width="140"></a>
            <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1">
                <span class="visually-hidden">Toggle
                    navigation</span><span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="#header"><strong>Tentang Kami</strong></a></li>
                    <li class="nav-item"><a class="nav-link" href="#facility"><strong>Fasilitas</strong></a></li>
                    <li class="nav-item"><a class="nav-link" href="#testimonies"><strong>Testimoni</strong></a></li>
                    <li class="nav-item"><a class="nav-link" href="#location"><strong>Lokasi</strong></a>
                    <li class="nav-item"><a class="nav-link" href="#contact"><strong>Kontak</strong></a>
                    </li>
                </ul>

                <ul class="mt-1 mt-lg-0 p-0 m-0 nav-item dropdown">
                    {{-- @auth
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Halo! {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu" style="border-radius:10px">
                            <li><a class="dropdown-item" href="/dashboard">Dashboard</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="/logout" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    @else --}}
                    {{-- <a class="btn btn-primary shadow" role="button" href="/login">Masuk</a> --}}
                    {{-- @endauth --}}
                </ul>
            </div>
        </div>
    </nav>
    {{-- Header --}}
    <header class="pt-3" id="header">
        <div class="container pt-5 pt-xl-5">
            <div class="row pt-5">
                <div class="py-5 col-md-8 col-xxl-10 text-center text-md-start mx-auto">
                    <div class="text-center">
                        <h1 class="display-4 fw-bold text-success mb-5"><strong>Sewa lapangan bulutangkis di
                                Bandung, berdiri sejak 1989.</strong></h1>
                        <p class="fs-5 mb-5" style="color: var(--navy)">Menerima sewa lapangan badminton dengan
                            fasilitas lengkap untuk pribadi,
                            organisasi, ataupun turnamen. </p>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <section>
        <img src="{{ asset('img/header2.png') }}" alt="" class="img-fluid">
    </section>

    {{-- Fasilitas Section --}}
    <section style="background-color: var(--navy)" class="py-5" id="facility">
        <div class="container py-4 py-xl-5">
            <h2 class="text-center fw-bold text-white my-5">Fasilitas</h2>
            <div class="row gy-4">
                <div class="col-12" data-aos="fade-up">
                    <div class="card d-flex justify-content-center">
                        <div class="card-body" style="padding:0px;">
                            <img src="{{ asset('img/fasilitas1.jpg') }}" class="img-fluid" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-12" data-aos="fade-up">
                    <div class="card d-flex justify-content-center">
                        <div class="card-body" style="padding:0px;">
                            <img src="{{ asset('img/fasilitas2.jpg') }}" class="img-fluid" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <img src="{{ asset('img/header.png') }}" alt="" class="img-fluid">
    {{-- Testimoni Section --}}
    <section class="py-5 text-white" style="background-color: var(--green-2)" id="testimonies">
        <div class="container py-4 py-xl-5">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="display-6 fw-bold pb-md-4">Apa sih kata <span>mereka&nbsp;</span>
                        tentang Gor Cisitu 55</h3>
                </div>
                <div class="col-md-6 pt-4">
                    <p class="text-white mb-4">Sudah banyak orang menyewa lapangan kami, ini pesan-pesan yang mereka
                        tinggalkan setelah menggunakan layanan kami.</p>
                </div>
            </div>
            <div class="row gy-4 gy-md-0">
                <div
                    class="col-md-6 d-flex d-sm-flex d-md-flex justify-content-center align-items-center justify-content-md-start align-items-md-center justify-content-xl-center">
                    <div>
                        <div class="m-2 row align-items-center" data-aos="fade-right">
                            <div class="col">
                                <h5 class="fw-bold">"Lumayan lapangannya agak banyak, harga juga gak mahal."</h5>
                                <p class="text-white">- Google Maps Reviews</p>
                            </div>
                        </div>
                        <div class="m-2 row align-items-center" data-aos="fade-right">
                            <div class="col">
                                <h5 class="fw-bold">"Ada 4 lapangan, ada tempat duduk di pinggir2 gt buat yg mau
                                    nonton..
                                    Oh ada kursi wasit dan penomorannya juga oke.
                                    Langganan terus buat kantor kita ❤️."</h5>
                                <p class="text-white">- Google Maps Reviews</p>
                            </div>
                        </div>
                        <div class="m-2 row align-items-center" data-aos="fade-right">
                            <div class="col">
                                <h5 class="fw-bold">"Tempat bersih, ada mushola dan tempat ganti baju. Tersedia juga
                                    warung di dalam, cukup nyaman 👌."</h5>
                                <p class="text-white">- Google Maps Reviews</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 order-first order-md-last">
                    <div><img class="rounded img-fluid w-100 fit-cover" style="min-height: 300px;"
                            src="assets/img/illustrations/teamwork.svg"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- Kontak Section --}}
    <section class="py-4 py-xl-5" id="location">
        <div class="container">
            <h2 class="text-center fw-bold my-5">Lokasi</h2>
            <div style="width: 100%" class="text-center"><iframe width="100%" height="400" frameborder="0"
                    scrolling="no" marginheight="0" marginwidth="0"
                    src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=Gor%20Cisitu%2055+(My%20Business%20Name)&amp;t=&amp;z=15&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"><a
                        href="https://www.gps.ie/">gps devices</a></iframe></div>
            <div class="text-white bg-primary border rounded border-0 border-primary d-flex flex-column justify-content-between flex-lg-row p-4 p-md-5"
                id="contact">
                <div class="pb-2 pb-lg-1">
                    <h2 class="fw-bold mb-2">Mau sewa atau nanya-nanya dulu?</h2>
                    <p class="mb-0">Bisa hubungi kami lewat tombol dibawah ini.</p>
                </div>
                <div class="my-2"><a class="btn btn-light fs-5 py-2 px-4" role="button"
                        href="https://wa.me/6287721235040" target="_blank">Kontak Kami</a></div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer style="background-color: var(--navy);">
        <div class="container py-4 py-lg-5">
            <div class="text-center my-5">
                <img src="img/yukkemah.png" alt="" class="img-fluid" style="width: 200px">
            </div>
            {{-- <hr> --}}
            <div class="d-flex justify-content-between align-items-center pt-3 text-white">
                <p class="mb-0" style="font-size: 0.9em">Copyright © 2024 GOR CISITU 55 (Template by Bootstrap
                    Studio)
                </p>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/startup-modern.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>
