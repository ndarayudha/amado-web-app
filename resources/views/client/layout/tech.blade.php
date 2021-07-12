@extends('client.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('client/css/tech.css') }}">
@endpush

@section('content')
    <main>
        <article class="container-fluid tech-home">
            <section class="content">
                <h2>Alat Ukur Saturasi Oksigen Portabel Terintegrasi</h2>
                <h4>Inovasi teknologi IoT tepat guna dengan skalabilitas pelayanan kesehatan yang luas</h4>
            </section>
        </article>  

        <article class="container-fluid tech-component">
            <h2 class="tech-title">Komponen Utama Amado E-Health</h2>
            <div class="row list-component">
                <div class="col-xs-12 col-sm-6 col-lg-4 component">
                    <div class="card">
                        <img src="{{ asset('resources/img-web/max30100.jpg') }}" alt="">
                        <h5>MAX 30100</h5>
                        <p>Perangkat non infasif yang dapat
                            mengukur kadar saturasi oksigen dan
                            detak jantung</p>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-lg-4 component">
                    <div class="card">
                        <img src="{{ asset('resources/img-web/nano.jpg') }}" alt="">
                        <h5>Arduino Nano</h5>
                        <p>Mikrokontroler mini sebagai pusat pemrosesan data</p>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-lg-4 component">
                    <div class="card">
                        <img src="{{ asset('resources/img-web/gps.jpg') }}" alt="">
                        <h5>GPS</h5>
                        <p>Modul pelacak lokasi melalui titik koordinat</p>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-lg-12 component">
                    <div class="card">
                        <img src="{{ asset('resources/img-web/mcu.jpg') }}" alt="">
                        <h5>Node MCU</h5>
                        <p>Sebagai perantara koneksi dengan jaringan internet</p>
                    </div>
                </div>
            </div>
            <div class="utilities">
                <p>Dilengkapi dengan Micro USB-Charger</p>
            </div>
        </article>

        <article class="container-fluid tech-spesification">
            <h2 class="tech-title">Spesifikasi Amado</h2>
            <section class="tech-spec"></section>
        </article>
    </main>
@endsection
