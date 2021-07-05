@extends('_layouts.app')

@section('title', 'Detail Pasien')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h2 class="h6 m-0 font-weight-bold text-primary">Data Pasien</h2>
                </div>
                <div class="card-body d-flex">
                    <div class="col-lg-3 mb-4">
                        {{-- <img src="{{ $patient->photo }}" class="img-fluid rounded"> --}}
                        <img src="{{ asset('storage/profiles/profile.jpg') }}" class="img-fluid rounded" alt="">
                    </div>
                    <div class="col-lg-9 mb-2">
                        <div class="row">
                            <div class="col-lg-10">
                                <h2 class="h6 m-0 font-weight-bold">{{ $patient->name }} , {!! Carbon\Carbon::parse($patient->tanggal_lahir)->diffInYears(Carbon\Carbon::now()) . ' Tahun' !!}</h2>
                                <p>{{ $patient->alamat }}</p>
                            </div>
                            <div class="col-lg-2">
                                <h2 class="h6 m-0 font-weight-bold"><span><i class="text-success fa fa-circle"></i></span>
                                    Check</h2>
                            </div>
                        </div>
                        <hr>
                        <div class="row d-flex justify-content-center">
                            <div class="col-lg-3 text-center">
                                <h2 class="h6 font-weight-bold">Total Cek</h2>
                                <p>2/3</p>
                            </div>
                            <div class="col-lg-3 text-center">
                                <h2 class="h6 font-weight-bold">Spo2</h2>
                                <p>70%</p>
                            </div>
                            <div class="col-lg-3 text-center">
                                <h2 class="h6 font-weight-bold">Bpm</h2>
                                <p>80</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="container">
                                <div id="map" style="width:auto;height:400px;"></div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('patient.edit', $patient->id) }}" class="btn btn-primary">Edit</a>
                    <a href="{{ route('patient.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://js.api.here.com/v3/3.1/mapsjs-core.js"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-service.js"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-ui.js"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js"></script>

    <script type="text/javascript">
        //Begin geocoding
        const lat = '-8.23648';
        const long = '114.35851';

        const platform = new H.service.Platform({
            apikey: 'X5wdPPV7YALJd-lJEmbgp8evwHrMBrDYpk7WrX1G7bs'
        });
        const defaultLayers = platform.createDefaultLayers();
        const map = new H.Map(document.getElementById('map'),
            defaultLayers.vector.normal.map, {
                center: {
                    lat: lat,
                    lng: long
                },
                zoom: 12,
                pixelRatio: window.devicePixelRatio || 1
            });
        window.addEventListener('resize', () => map.getViewPort().resize());
        const behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));
        const ui = H.ui.UI.createDefault(map, defaultLayers);


        const service = platform.getSearchService();
        service.reverseGeocode({
            at: lat + ',' + long
        }, (result) => {
            result.items.forEach((item) => {
                map.addObject(new H.map.Marker(item.position));
            });
        }, alert);

    </script>


@endsection
