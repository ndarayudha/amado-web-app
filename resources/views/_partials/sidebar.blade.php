<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon d-block d-md-none">
            {{ substr(setting('name'), 0, 3) }}
        </div>
        <div class="sidebar-brand-text mx-3">Amado Dashboard</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ active('/') }}">

        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Amado</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">


    <!-- Nav Item - Pages Collapse Menu -->
    {{-- <li class="nav-item {{ active('patient') }}">
        <a class="nav-link collapsed" href="{{ route('patient.index') }}">
            <i class="fas fa-fw fa-stethoscope"></i>
            <span>Data Pasien</span>
        </a>
    </li> --}}

    <li class="nav-item {{ active('record') }}">
        <a class="nav-link collapsed" href="{{ route('record.index') }}">
            <i class="fas fa-fw fa-notes-medical"></i>
            <span>Rekam Medis</span>
        </a>
    </li>


    <li class="nav-item {{ active('lokasi') }}">
        <a class="nav-link collapsed" href="{{ route('lokasi.index') }}">
            <i class="fas fa-fw fa-map-marker-alt"></i>
            <span>Lokasi Pasien</span>
        </a>
    </li>




    <!-- Divider -->
    <hr class="sidebar-divider">


    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
