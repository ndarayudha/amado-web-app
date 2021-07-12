@extends('client.app')

@section('content')
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
@endsection
