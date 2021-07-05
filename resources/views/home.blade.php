@extends('_layouts.app')

@section('title', 'Dashboard')

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible">
            <span>{{ session('success') }}</span>
            <button class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Admin</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalAdmin }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Pasien</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPasien }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-stethoscope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Kontak Erat</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalKontakErat }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-handshake fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        {{-- <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
@@ -78,50 +78,85 @@
            </div>
          </div>
        </div>
      </div> --}}

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-8">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Total Pasien Per Bulan</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="pasien-per-month"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-4">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Jenis Kelamin Pasien</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="pasienGender"></canvas>
                    </div>
                    <div class="mt-4 text-center small label-jenis-kelamin">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-5 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Usia Pasien</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="pasienAge"></canvas>
                    </div>
                    <div class="mt-4 text-center small label-usia">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-7 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Monitoring Terbaru</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id=""></canvas>
                    </div>
                    <div class="mt-4 text-center small label-usia">
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@push('js')
    <script>
        const pasienPerMonth = @json($pasienPerMonth);
        const pasienGender = @json($pasienGender);
        const pasienAge = @json($pasienAge);

    </script>
    <script src="{{ asset('sbadmin/vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endpush
