<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('css/mail.css') }}">
    <title>Hello, world!</title>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center kop-container">
            <div class="col">
                <img src="{{ asset('image/ic_amado.png') }}" alt="">
            </div>
            <div class="col">
                <h1>Nama Rumah Sakit</h1>
                <h3>Alamat Rumah Sakit</h3>
                <h3>Nomor Telepon Rumah Sakit</h3>
                <h3>Email Rumah Sakit</h3>
            </div>
        </div>

        <hr>

        <div class="row title-container">
            <h1>SURAT KETERANGAN RAWAT INAP</h1>
        </div>

        <br>
        <br>
        <br>

        <div class="row">
            <h4>Menyatakan Bahwa</h4>
        </div>

        <div class="row desc-container">
            <div class=" col">No. Rk : 1</div>
            <div class=" col">Nama : Yofan</div>
            <div class=" col">Umur : 21</div>
        </div>
        <br>
        <div class="row desc-container">
            <div class=" col">Diagnosa : Sehat</div>
            <div class=" col">Jenis Kelamin : Laki - Laki</div>
            <div class=" col">Alamat : Banyuwangi</div>
        </div>
        <br>
        <div class="row desc-container">
            <div class=" col">Tindakan : Rawat Inap</div>
            <div class=" col">Tanggal Masuk : 17 August 2021, 12:11:03</div>
            <div class=" col">Tanggal Keluar : 21 August 2021, 12:11:06</div>
        </div>
        <br>
        <div class="row desc-container">
            <div class=" col">Keterangan : Silahkan menuju rumah sakit Amado dan tunjukan surat ini kepada petugas medis
            </div>
        </div>

        <br><br><br>

        <div class="row ttd">
            <div class="col">
                <div>
                    <h5>23 Agustus 2021</h5>
                    <h5>Mengetahui</h5>
                    <h5>Dokter</h5>
                    <br>
                    <br>
                    <br>
                    <br>
                    <h5>Dr. Yofan</h5>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous">
    </script>
</body>

</html>
