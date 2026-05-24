<!-- Doctor Header -->
<header id="header" class="header fixed-top d-flex align-items-center" style="z-index: 997;">

    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('dashboardoc') }}" class="logo d-flex align-items-center">
            <img src="{{ asset('assets/img/eklick.png') }}" alt="" class="logo-img">
            <span class="logo-text d-none d-lg-block">{{ $title ?? 'Eklick Dokter' }}</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle fs-4"></i>
                    <span class="d-none d-md-block dropdown-toggle ps-2">
                        {{ session('user_name', 'Dokter') }}
                    </span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{ session('user_name', 'Dokter') }}</h6>
                        <span>Poli {{ session('dokter_poli', $specialty ?? 'Umum') }}</span>
                    </li>
                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>

                </ul>
            </li>

        </ul>
    </nav>

</header>
<!-- End Header -->