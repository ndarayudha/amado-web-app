<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('client/css/home.css') }}">
    <title>Amado</title>

    <!-- add icon link -->
    <link rel="icon" href="https://i.ibb.co/ssb5mKk/amado.png" type="image/x-icon">
</head>

<body>
    <header>
        <nav>
            <ul class="nav-logo">
                <img src="{{ asset('resources/img-web/amado-icon.png') }}" alt="amado-logo" class="nav-logo-img">
                <a href="#" class="nav-logo-title">Amado <span>E-Health</span></a>
            </ul>
            <input id="burger" type="checkbox" />
            <label for="burger">
                <span></span>
                <span></span>
                <span></span>
            </label>
            <div class="navigation">
                <ul class="nav-list">
                    <li class="nav-item"><a href="#">Teknologi</a></li>
                    <li class="nav-item"><a href="#">Untuk Klinik & RS</a></li>
                    <li class="nav-item"><a href="#" class="btn-second color-white">Login</a></li>
                    <li class="nav-item"><a href="#" class="btn-first color-white">Beli Sekarang</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <article class="container home">
            <div class="row justify-content-md-center content">
                <div class="col-md-6 description">
                    <h2 class="home-title-first">Prioritaskan</h2>
                    <h2 class="home-title-second">Kesehatan Pasien</h2>
                    <p>Pemantauan saturasi oksigen jarak jauh bagi pasien isolasi mandiri Covid 19</p>
                    <a href="#about" class="btn-first an-pulse color-white">Pelajari Lanjut</a>
                </div>
                <div class="col-md-6 image">
                    <figure>
                        <img src="{{ asset('resources/img-web/home-picture.png') }}" alt="home image">
                    </figure>
                </div>
            </div>
        </article>

        <article class="container about" id="about">
            <div class="title">
                <h2>Tentang Sistem Kami</h2>
            </div>
            <div class="row content">
                <div class="col-md-6 image">
                    <figure>
                        <img src="{{ asset('resources/img-web/about-website.png') }}" alt="about image">
                    </figure>
                </div>
                <div class="col-md-6 description">
                    <h2 class="content-title">Modernisasi Pengalaman Pasien</h2>
                    <p>Amado E-Health dapat melakukan proses monitoring kadar oksigen terlarut dalam darah pada pasien
                        Covid-19 yang menjalani isolasi mandiri
                        dan terintegrasi melalui smartphone,
                        dan menghasilkan rekam medis melalui analisis data di website</p>
                </div>
            </div>
        </article>

        <article class="container how-it-works" id="how-it-works">
            <div class="title">
                <h2>Cara Kerja Sistem</h2>
            </div>
            <div class="row content">
                <div class="col-md-6 col-lg-4" id="item">
                    <div class="card">
                        <div class="circle">1</div>
                        <h4>Registrasi</h4>
                        <p>Pasien melakukan pendaftaran akun
                            melalui aplikasi Amado</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" id="item">
                    <div class="card">
                        <div class="circle">2</div>
                        <h4>Lengkapi Data</h4>
                        <p>Pasien melengkapi data pribadi
                            pada aplikasi</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" id="item">
                    <div class="card">
                        <div class="circle">3</div>
                        <h4>Geolokasi</h4>
                        <p>Pasien pasien mengaktifkan fitur
                            geolokasi</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" id="item">
                    <div class="card">
                        <div class="circle">4</div>
                        <h4>Monitoring</h4>
                        <p>Pasien melakukan monitoring melalui
                            perangkat Amado</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" id="item">
                    <div class="card">
                        <div class="circle">5</div>
                        <h4>Pemantauan</h4>
                        <p>Pasien dipantau oleh tenaga medis selama isolasi mandiri</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" id="item">
                    <div class="card">
                        <div class="circle">6</div>
                        <h4>Rekam Medis</h4>
                        <p>Pasien mendapatkan hasil diagnosa
                            serta rekomendasi penanganan. </p>
                    </div>
                </div>
            </div>
        </article>

        <article class="container application">
            <div class="row content">
                <div class="col-md-6 description">
                    <h2>Aplikasi Kami Telah Tersedia</h2>
                    <p>Aplikasi kami telah tersedia
                        untuk platform Android, download sekarang melalui Google Playstore</p>
                    <a href="#" class="btn-first an-pulse color-white">Download</a>
                </div>
                <div class="col-md-6 image">
                    <figure>
                        <img src="{{ asset('resources/img-web/app-website.png') }}" alt="about image">
                    </figure>
                </div>
            </div>
        </article>
    </main>


    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-3">
                    <h6>Tentang Kami</h6>
                    <p class="text-justify">Jalan Raya Jember No.KM13, Kawang, Labanasem,
                        Kec. Kabat, Kabupaten Banyuwangi, Jawa Timur 68461</p>
                </div>

                <div class="col-sm-6 col-md-3">
                    <h6>Kategori</h6>
                    <ul class="footer-links">
                        <li><a href="#">Teknologi</a></li>
                        <li><a href="#">Untuk RS</a></li>
                        <li><a href="#">Beli Sekarang</a></li>
                        <li><a href="#">Download</a></li>
                    </ul>
                </div>

                <div class="col-sm-6 col-md-3">
                    <h6>Link</h6>
                    <ul class="footer-links">
                        <li><a href="#">Tentang Kami</a></li>
                        <li><a href="#">Hubungi Kami</a></li>
                        <li><a href="#">Kontribusi</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="col-sm-6 col-md-3">
                    <h6>Support</h6>
                    <ul class="footer-links">
                        <li><a href="#">Vectorjuice</a></li>
                    </ul>
                </div>
            </div>
            <hr>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-6 col-xs-12">
                    <p class="copyright-text">Copyright &copy; 2021 Amado E-Health
                    </p>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <ul class="social-icons">
                        <li><a class="instagram" href="#"><i class="fab fa-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('client/js/home.js') }}"></script>
</body>

</html>
