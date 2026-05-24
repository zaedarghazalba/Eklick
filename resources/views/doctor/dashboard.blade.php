<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard Dokter - Klinik PUI</title>
  <meta content="Dashboard Dokter Klinik PUI" name="description">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/eklick.png') }}" rel="icon">
  <link href="{{ asset('assets/img/eklick.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Nunito:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">

  <!-- Template CSS -->
  <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/clinic-dashboard.css') }}" rel="stylesheet">

  <!-- Custom Dashboard Styles -->
  <style>
    /* Warning Card Style */
    .info-card.warning-card {
      background: linear-gradient(90deg, #fff5e6 0%, #ffffff 100%);
      border-left: 4px solid #ffc107;
    }

    .info-card.warning-card .card-icon {
      background: #ffc107;
      color: #fff;
    }

    /* Enhanced Card Styles */
    .info-card {
      border-radius: 0.5rem;
      transition: all 0.3s ease;
    }

    .info-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
    }

    .info-card .card-icon {
      width: 60px;
      height: 60px;
      font-size: 32px;
    }

    .info-card h6 {
      font-size: 28px;
      font-weight: 700;
      margin: 0;
    }

    /* Queue Badge */
    .queue-badge {
      font-size: 1.1rem;
      padding: 0.5rem 1rem;
    }

    /* Table enhancements */
    .table-responsive {
      border-radius: 0.5rem;
      overflow: hidden;
    }

    /* Status badges */
    .status-menunggu { background: #0dcaf0; color: #fff; }
    .status-dipanggil { background: #ffc107; color: #000; }
    .status-selesai { background: #198754; color: #fff; }
    .status-skip { background: #6c757d; color: #fff; }

    /* Header */
    .header {
      background: #fff;
      box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
      padding: 0 1.5rem;
      height: 60px;
    }

    /* Sidebar */
    .sidebar {
      position: fixed;
      top: 60px;
      left: 0;
      bottom: 0;
      width: 250px;
      background: #fff;
      border-right: 1px solid #e9ecef;
      padding: 1rem 0;
      overflow-y: auto;
      z-index: 996;
    }

    .sidebar-nav .nav-link {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      padding: 0.75rem 1rem;
      color: #6c757d;
      text-decoration: none;
      border-radius: 0.5rem;
      margin: 0.25rem 0.75rem;
      transition: all 0.3s ease;
    }

    .sidebar-nav .nav-link:hover {
      background: #f8f9fa;
      color: #0d6efd;
    }

    .sidebar-nav .nav-link.active {
      background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
      color: white;
    }

    /* Main content */
    #main {
      margin-left: 250px;
      margin-top: 60px;
      padding: 2rem;
      min-height: calc(100vh - 60px);
      background: #f6f9ff;
    }

    /* Logo */
    .logo {
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }

    .logo img {
      height: 32px;
    }

    .logo-text {
      font-family: 'Nunito', sans-serif;
      font-weight: 700;
      font-size: 1.25rem;
      color: #0d6efd;
    }

    /* Footer */
    .footer {
      padding: 1rem 2rem;
      text-align: center;
      color: #6c757d;
      font-size: 0.875rem;
      margin-left: 250px;
    }

    /* Back to top */
    .back-to-top {
      position: fixed;
      visibility: hidden;
      opacity: 0;
      right: 15px;
      bottom: 15px;
      z-index: 99999;
      background: #0d6efd;
      width: 40px;
      height: 40px;
      border-radius: 4px;
      transition: all 0.4s;
    }

    .back-to-top.active {
      visibility: visible;
      opacity: 1;
    }

    /* Responsive */
    @media (max-width: 991.98px) {
      .sidebar { transform: translateX(-100%); }
      .sidebar.active { transform: translateX(0); }
      #main, .footer { margin-left: 0; }
      .toggle-sidebar-btn { display: block !important; }
    }

    @media (min-width: 992px) {
      .toggle-sidebar-btn { display: none; }
    }
  </style>

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="{{ route('dashboardoc') }}" class="logo d-flex align-items-center">
        <img src="{{ asset('assets/img/eklick.png') }}" alt="">
        <span class="d-none d-lg-block">Eklick Dasboard Dokter</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <span class="d-none d-md-block dropdown-toggle ps-2">Dr. {{ $dokter_name ?? 'Dokter' }}</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>Dr. {{ $dokter_name ?? 'Dokter' }}</h6>
              <span>Poli {{ $dokter_poli ?? '-' }}</span>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ route('dokter.logout') }}">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>
          </ul>
        </li><!-- End Profile Nav -->
      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboardoc') }}">
          <i class="bx bxs-home"></i>
          <span>Dashboard Poli {{ $dokter_poli }}</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('dokter.archive') }}">
          <i class="bi bi-archive"></i>
          <span>Arsip</span>
        </a>
      </li><!-- End Arsip Nav -->


  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard Dokter - Poli {{ $dokter_poli ?? 'Dokter' }}</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboardoc') }}">Home</a></li>
          <li class="breadcrumb-item active">Dashboard Poli {{ $dokter_poli }}</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <!-- Dokter Info Banner -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle me-1"></i>
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-1"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

@isset($errors)
      @if ($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-1"></i>
        <strong>Terjadi kesalahan:</strong>
        <ul class="mb-0 mt-2">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
      @endisset

    <div class="alert alert-info border-0 alert-dismissible fade show" role="alert">
      <h4 class="alert-heading"><i class="bi bi-person-badge me-2"></i>Selamat Datang, Dr. {{ $dokter_name }}</h4>
      <p class="mb-0">Anda login sebagai dokter <strong>Poli {{ $dokter_poli }}</strong>. Dashboard ini menampilkan data antrian khusus untuk poli Anda.</p>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <!-- Statistics Cards Section -->
    <section class="section dashboard">
      <div class="row">

        <!-- Total Antrian Card -->
        <div class="col-xxl-3 col-md-6">
          <div class="card info-card sales-card">
            <div class="card-body">
              <h5 class="card-title">Total Antrian <span>| All Time</span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-people"></i>
                </div>
                <div class="ps-3">
                  <h6>{{ $total_antrian }}</h6>
                  <span class="text-muted small pt-2">Semua antrian</span>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Total Antrian Card -->

        <!-- Antrian Hari Ini Card -->
        <div class="col-xxl-3 col-md-6">
          <div class="card info-card revenue-card">
            <div class="card-body">
              <h5 class="card-title">Antrian Hari Ini <span>| {{ date('d M Y') }}</span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-calendar-check"></i>
                </div>
                <div class="ps-3">
                  <h6>{{ $antrian_hari_ini }}</h6>
                  <span class="text-success small pt-1 fw-bold">Hari ini</span>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Antrian Hari Ini Card -->

        <!-- Antrian Minggu Ini Card -->
        <div class="col-xxl-3 col-md-6">
          <div class="card info-card customers-card">
            <div class="card-body">
              <h5 class="card-title">Antrian Minggu Ini <span>| Week</span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-calendar-week"></i>
                </div>
                <div class="ps-3">
                  <h6>{{ $antrian_minggu_ini }}</h6>
                  <span class="text-muted small pt-2">Minggu ini</span>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Antrian Minggu Ini Card -->

        <!-- Antrian Bulan Ini Card -->
        <div class="col-xxl-3 col-md-6">
          <div class="card info-card warning-card">
            <div class="card-body">
              <h5 class="card-title">Antrian Bulan Ini <span>| {{ date('F') }}</span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-calendar-month"></i>
                </div>
                <div class="ps-3">
                  <h6>{{ $antrian_bulan_ini }}</h6>
                  <span class="text-muted small pt-2">Bulan {{ date('F') }}</span>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Antrian Bulan Ini Card -->

      </div><!-- End Statistics Row -->

      <!-- Per-Poli Breakdown Section -->
      <div class="row mt-4">

        <!-- Breakdown Semua Waktu -->
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Antrian Per Poli <span>| All Time</span></h5>
              <div class="list-group">
                @if(isset($antrian_per_poli) && count($antrian_per_poli) > 0)
                  @foreach($antrian_per_poli as $poli => $total)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                      <span><i class="bi bi-hospital me-2"></i>{{ $poli }}</span>
                      <span class="badge bg-primary rounded-pill">{{ $total }}</span>
                    </div>
                  @endforeach
                @else
                  <p class="text-muted">Belum ada data antrian</p>
                @endif
              </div>
            </div>
          </div>
        </div>

        <!-- Breakdown Hari Ini -->
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Antrian Per Poli Hari Ini <span>| {{ date('d M Y') }}</span></h5>
              <div class="list-group">
                @if(isset($antrian_per_poli_hari_ini) && count($antrian_per_poli_hari_ini) > 0)
                  @foreach($antrian_per_poli_hari_ini as $poli => $total)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                      <span><i class="bi bi-hospital me-2"></i>{{ $poli }}</span>
                      <span class="badge bg-success rounded-pill">{{ $total }}</span>
                    </div>
                  @endforeach
                @else
                  <p class="text-muted">Belum ada antrian hari ini</p>
                @endif
              </div>
            </div>
          </div>
        </div>

      </div><!-- End Per-Poli Breakdown Row -->

      <!-- Recent Antrian Section -->
      <div class="row mt-4">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Antrian Terbaru <span>| Latest 5</span></h5>
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>No. Antrian</th>
                      <th>Nama</th>
                      <th>Poli</th>
                      <th>Tanggal Daftar</th>
                      <th>Waktu</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(isset($recent_antrian) && count($recent_antrian) > 0)
                      @foreach($recent_antrian as $antrian)
                        <tr>
                          <td><span class="badge bg-info">{{ $antrian->no_antrian }}</span></td>
                          <td>{{ $antrian->nama }}</td>
                          <td><span class="badge bg-primary">{{ $antrian->poli }}</span></td>
                          <td>{{ \Carbon\Carbon::parse($antrian->tanggal_daftar)->format('d M Y') }}</td>
                          <td class="text-muted">{{ \Carbon\Carbon::parse($antrian->created_at)->diffForHumans() }}</td>
                        </tr>
                      @endforeach
                    @else
                      <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada antrian</td>
                      </tr>
                    @endif
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div><!-- End Recent Antrian Row -->

    </section><!-- End Dashboard Section -->

    <!-- Divider -->
    <hr class="my-5">

    <!-- All Antrian Data Section -->
    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Semua Data Antrian Poli {{ $dokter_poli }}</h5>

              <!-- Info Alert -->
              <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Info:</strong> Pasien dengan status "selesai" atau "skip" <strong>disembunyikan secara default</strong>.
                Aktifkan toggle "Tampilkan Selesai" untuk melihatnya.
                Data yang sudah selesai <strong>lebih dari 1 hari akan diarsipkan otomatis</strong>. Lihat menu <strong>"Arsip"</strong> untuk data hari-hari sebelumnya.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>

              <!-- Filter Section -->
              <div class="row mb-3">
                <div class="col-md-5">
                  <label for="searchName" class="form-label">Cari Nama Pasien:</label>
                  <input type="text" id="searchName" class="form-control" placeholder="Ketik nama pasien..." onkeyup="filterTable()">
                </div>
                <div class="col-md-3">
                  <label for="filterDate" class="form-label">Filter Tanggal:</label>
                  <input type="date" id="filterDate" class="form-control" onchange="filterTable()">
                </div>
                <div class="col-md-2">
                  <label class="form-label">Tampilkan Selesai:</label>
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="showCompletedToggle" {{ $show_completed ? 'checked' : '' }} onchange="toggleShowCompleted()">
                    <label class="form-check-label" for="showCompletedToggle">
                      <span id="completedStatus">{{ $show_completed ? 'Ya' : 'Tidak' }}</span>
                    </label>
                  </div>
                </div>
                <div class="col-md-2">
                  <label class="form-label">Auto-Refresh:</label>
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="autoRefreshToggle">
                    <label class="form-check-label" for="autoRefreshToggle">
                      <span id="refreshStatus">Nonaktif</span>
                    </label>
                  </div>
                </div>
              </div>

              <!-- Clear Filter Button -->
              <div class="row mb-3">
                <div class="col-12">
                  <button class="btn btn-sm btn-secondary" onclick="clearFilters()">
                    <i class="bi bi-x-circle me-1"></i>Clear Filters
                  </button>
                  <span id="lastRefresh" class="text-muted ms-3">
                    <i class="bi bi-clock me-1"></i>Last refresh: Just now
                  </span>
                </div>
              </div>

              <!-- Table -->
              <div class="table-wrapper">
                <table class="table table-hover" id="antrianTable">
                  <thead>
                    <tr>
                      <th style="width: 70px;">No.</th>
                      <th style="min-width: 140px;">Nama Pasien</th>
                      <th class="d-none d-lg-table-cell" style="width: 100px;">Tgl Daftar</th>
                      <th class="d-none d-lg-table-cell" style="width: 60px;">JK</th>
                      <th class="d-none d-xl-table-cell" style="width: 100px;">No. HP</th>
                      <th style="min-width: 110px;">Rekam Medis</th>
                      <th style="min-width: 90px;">Pemeriksaan</th>
                      <th style="width: 50px;">Detail</th>
                    </tr>
                  </thead>
                  <tbody id="antrianTableBody">
                    @if(isset($all_antrian) && count($all_antrian) > 0)
                      @foreach($all_antrian as $antrian)
                        <tr data-name="{{ strtolower($antrian->nama) }}" data-date="{{ $antrian->tanggal_daftar }}"
                            data-noktp="{{ $antrian->no_ktp }}"
                            data-alamat="{{ $antrian->alamat }}"
                            data-tgllahir="{{ \Carbon\Carbon::parse($antrian->tgl_lahir)->format('d M Y') }}"
                            data-pekerjaan="{{ $antrian->pekerjaan }}"
                            data-nohp="{{ $antrian->no_hp }}">
                          <td><span class="badge bg-primary">{{ $antrian->no_antrian }}</span></td>
                          <td>
                            <div class="fw-semibold">{{ \Illuminate\Support\Str::limit($antrian->nama, 22) }}</div>
                            <div class="d-lg-none small text-muted">{{ \Carbon\Carbon::parse($antrian->tanggal_daftar)->format('d M Y') }}</div>
                          </td>
                          <td class="d-none d-lg-table-cell small text-nowrap">{{ \Carbon\Carbon::parse($antrian->tanggal_daftar)->format('d M Y') }}</td>
                          <td class="d-none d-lg-table-cell small">{{ $antrian->jenis_kelamin }}</td>
                          <td class="d-none d-xl-table-cell small text-nowrap">{{ $antrian->no_hp }}</td>
                          <td>
                            @if($antrian->rekam_medis)
                              <div class="action-group">
                                <a href="{{ route('rekammedis.view', $antrian->rekam_medis) }}" target="_blank" class="action-btn btn-view" title="Preview">
                                  <i class="bi bi-eye-fill"></i>
                                </a>
                                <a href="{{ route('rekammedis.download', $antrian->rekam_medis) }}" class="action-btn btn-success" title="Download">
                                  <i class="bi bi-download"></i>
                                </a>
                                <button type="button" class="action-btn btn-warning" onclick="showUploadForm({{ $antrian->id }})" title="Ganti File">
                                  <i class="bi bi-arrow-repeat"></i>
                                </button>
                              </div>
                              <form id="upload-form-{{ $antrian->id }}" action="{{ route('uploadRekamMedis', $antrian->id) }}" method="POST" enctype="multipart/form-data" class="mt-1" style="display: none;">
                                @csrf
                                <div class="input-group input-group-sm">
                                  <input type="file" name="rekam_medis" class="form-control form-control-sm" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                                  <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-upload"></i></button>
                                </div>
                              </form>
                            @else
                              <button type="button" class="action-btn btn-primary" onclick="showUploadForm({{ $antrian->id }})" title="Upload Rekam Medis">
                                <i class="bi bi-upload"></i>
                              </button>
                              <form id="upload-form-{{ $antrian->id }}" action="{{ route('uploadRekamMedis', $antrian->id) }}" method="POST" enctype="multipart/form-data" class="mt-1" style="display: none;">
                                @csrf
                                <div class="input-group input-group-sm">
                                  <input type="file" name="rekam_medis" class="form-control form-control-sm" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                                  <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-upload"></i></button>
                                </div>
                              </form>
                            @endif
                          </td>
                          <td>
                            @if($antrian->diagnosa)
                              <div class="action-group">
                                <button class="action-btn btn-view" onclick="lihatDiagnosa({{ $antrian->id }})" title="Lihat Diagnosa">
                                  <i class="bi bi-eye-fill"></i>
                                </button>
                                <button class="action-btn btn-edit" onclick="editDiagnosa({{ $antrian->id }})" title="Edit Diagnosa">
                                  <i class="bi bi-pencil-fill"></i>
                                </button>
                              </div>
                            @else
                              <button class="action-btn btn-primary" onclick="inputDiagnosa({{ $antrian->id }}, '{{ $antrian->nama }}')" title="Input Diagnosa">
                                <i class="bi bi-plus-circle-fill"></i>
                              </button>
                            @endif
                          </td>
                          <td>
                            <button class="action-btn btn-secondary" onclick="showDetail({{ $antrian->id }})" title="Detail Pasien">
                              <i class="bi bi-three-dots"></i>
                            </button>
                          </td>
                        </tr>
                      @endforeach
                    @else
                      <tr id="noDataRow">
                        <td colspan="8" class="text-center text-muted py-4">
                          <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                          Belum ada data antrian untuk Poli {{ $dokter_poli }}
                        </td>
                      </tr>
                    @endif
                  </tbody>
                </table>
              </div>

              <!-- Modal Detail Pasien -->
              <div class="modal fade" id="detailPasienModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-scrollable">
                  <div class="modal-content">
                    <div class="modal-header bg-secondary text-white">
                      <h5 class="modal-title"><i class="bi bi-person-badge me-2"></i>Detail Pasien</h5>
                      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                      <table class="table table-borderless table-sm">
                        <tr><td class="fw-bold text-muted" style="width: 120px;">No. KTP</td><td id="detailNoKtp">-</td></tr>
                        <tr><td class="fw-bold text-muted">Alamat</td><td id="detailAlamat">-</td></tr>
                        <tr><td class="fw-bold text-muted">Tgl Lahir</td><td id="detailTglLahir">-</td></tr>
                        <tr><td class="fw-bold text-muted">Pekerjaan</td><td id="detailPekerjaan">-</td></tr>
                        <tr><td class="fw-bold text-muted">No. HP</td><td id="detailNoHp">-</td></tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Total Count -->
              <div class="mt-3">
                <strong>Total: <span id="totalCount">{{ count($all_antrian) }}</span> antrian</strong>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section><!-- End All Antrian Data Section -->

  </main><!-- End #main -->

  <!-- Modal Input/Edit Rekam Medis -->
  <div class="modal fade" id="diagnosaModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <div>
            <h5 class="modal-title mb-1" id="diagnosaModalTitle">
              <i class="bi bi-file-medical me-2"></i>Rekam Medis Pasien
            </h5>
            <small class="opacity-75">Electronic Klinik - Sistem Rekam Medis Elektronik</small>
          </div>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <form id="diagnosaForm" enctype="multipart/form-data">
          <input type="hidden" id="antrianId" name="antrian_id">
          <div class="modal-body">

            <!-- IDENTITAS PASIEN (AUTO-FILL) -->
            <div class="card mb-3">
              <div class="card-header bg-light">
                <h6 class="mb-0"><i class="bi bi-person-badge me-2"></i>Identitas Pasien</h6>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6 mb-2">
                    <small class="text-muted">Nama Lengkap:</small>
                    <p class="mb-0 fw-bold" id="pasienNama"></p>
                  </div>
                  <div class="col-md-3 mb-2">
                    <small class="text-muted">No. Rekam Medis:</small>
                    <p class="mb-0 fw-bold" id="pasienNoRM"></p>
                  </div>
                  <div class="col-md-3 mb-2">
                    <small class="text-muted">Tanggal Pemeriksaan:</small>
                    <p class="mb-0 fw-bold" id="tanggalPemeriksaan"></p>
                  </div>
                </div>
              </div>
            </div>

            <!-- TANDA-TANDA VITAL -->
            <div class="card mb-3">
              <div class="card-header bg-light">
                <h6 class="mb-0"><i class="bi bi-activity me-2"></i>Tanda-Tanda Vital (Vital Signs)</h6>
              </div>
              <div class="card-body">
                <div class="row g-3">
                  <div class="col-md-3">
                    <label class="form-label">Tekanan Darah</label>
                    <input type="text" class="form-control" id="tekanan_darah" name="tekanan_darah" placeholder="120/80 mmHg">
                  </div>
                  <div class="col-md-3">
                    <label class="form-label">Nadi</label>
                    <input type="text" class="form-control" id="nadi" name="nadi" placeholder="80 x/menit">
                  </div>
                  <div class="col-md-2">
                    <label class="form-label">Suhu</label>
                    <input type="text" class="form-control" id="suhu_tubuh" name="suhu_tubuh" placeholder="36.5°C">
                  </div>
                  <div class="col-md-2">
                    <label class="form-label">Tinggi (cm)</label>
                    <input type="number" class="form-control" id="tinggi_badan" name="tinggi_badan" placeholder="170">
                  </div>
                  <div class="col-md-2">
                    <label class="form-label">Berat (kg)</label>
                    <input type="number" class="form-control" id="berat_badan" name="berat_badan" placeholder="65">
                  </div>
                </div>
              </div>
            </div>

            <!-- ANAMNESA -->
            <div class="card mb-3">
              <div class="card-header bg-light">
                <h6 class="mb-0"><i class="bi bi-chat-left-text me-2"></i>Anamnesa</h6>
              </div>
              <div class="card-body">
                <div class="mb-3">
                  <label for="keluhan_utama" class="form-label">Keluhan Utama <span class="text-danger">*</span></label>
                  <textarea class="form-control" id="keluhan_utama" name="keluhan_utama" rows="2" required placeholder="Keluhan pasien saat datang..."></textarea>
                </div>
                <div class="mb-0">
                  <label for="riwayat_penyakit" class="form-label">Riwayat Penyakit</label>
                  <textarea class="form-control" id="riwayat_penyakit" name="riwayat_penyakit" rows="2" placeholder="Riwayat penyakit sekarang dan dahulu..."></textarea>
                </div>
              </div>
            </div>

            <!-- PEMERIKSAAN FISIK -->
            <div class="card mb-3">
              <div class="card-header bg-light">
                <h6 class="mb-0"><i class="bi bi-heart-pulse me-2"></i>Pemeriksaan Fisik</h6>
              </div>
              <div class="card-body">
                <textarea class="form-control" id="pemeriksaan_fisik" name="pemeriksaan_fisik" rows="3" placeholder="Hasil pemeriksaan fisik (inspeksi, palpasi, perkusi, auskultasi)..."></textarea>
              </div>
            </div>

            <!-- HASIL LABORATORIUM -->
            <div class="card mb-3">
              <div class="card-header bg-light">
                <h6 class="mb-0"><i class="bi bi-clipboard2-pulse me-2"></i>Hasil Laboratorium / Pemeriksaan Penunjang</h6>
              </div>
              <div class="card-body">
                <textarea class="form-control" id="hasil_lab" name="hasil_lab" rows="2" placeholder="Hasil lab, rontgen, EKG, dll (jika ada)..."></textarea>
              </div>
            </div>

            <!-- DIAGNOSA & TERAPI -->
            <div class="card mb-3">
              <div class="card-header bg-light">
                <h6 class="mb-0"><i class="bi bi-file-medical me-2"></i>Diagnosa & Terapi</h6>
              </div>
              <div class="card-body">
                <div class="mb-3">
                  <label for="diagnosa" class="form-label">Diagnosa <span class="text-danger">*</span></label>
                  <textarea class="form-control" id="diagnosa" name="diagnosa" rows="2" required placeholder="Diagnosa penyakit (ICD-10 jika memungkinkan)..."></textarea>
                  <small class="text-muted">Contoh: Influenza (J11.1), Hipertensi Esensial (I10)</small>
                </div>

                <div class="mb-3">
                  <label for="tindakan_medis" class="form-label">Tindakan Medis</label>
                  <textarea class="form-control" id="tindakan_medis" name="tindakan_medis" rows="2" placeholder="Tindakan yang dilakukan (injeksi, nebulizer, jahit luka, dll)..."></textarea>
                </div>

                <div class="mb-0">
                  <label for="resep_obat" class="form-label">Resep Obat <span class="text-danger">*</span></label>
                  <textarea class="form-control" id="resep_obat" name="resep_obat" rows="3" required placeholder="R/ Paracetamol tab 500mg No. X
S 3 dd 1 tab (sesudah makan)"></textarea>
                  <small class="text-muted">Format: R/ [Nama Obat] [Dosis] No. [Jumlah] - S [Signa/Aturan Pakai]</small>
                </div>
              </div>
            </div>

            <!-- ANJURAN & CATATAN -->
            <div class="card mb-3">
              <div class="card-header bg-light">
                <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Anjuran & Catatan</h6>
              </div>
              <div class="card-body">
                <div class="mb-3">
                  <label for="anjuran" class="form-label">Anjuran / Edukasi</label>
                  <textarea class="form-control" id="anjuran" name="anjuran" rows="2" placeholder="Anjuran untuk pasien (istirahat, diet, kontrol, dll)..."></textarea>
                </div>
                <div class="mb-0">
                  <label for="catatan_dokter" class="form-label">Catatan Dokter</label>
                  <textarea class="form-control" id="catatan_dokter" name="catatan_dokter" rows="2" placeholder="Catatan tambahan..."></textarea>
                </div>
              </div>
            </div>

            <!-- UPLOAD DOKUMEN PENDUKUNG -->
            <div class="card mb-3">
              <div class="card-header bg-light">
                <h6 class="mb-0"><i class="bi bi-images me-2"></i>Dokumen Pendukung</h6>
              </div>
              <div class="card-body">
                <div class="row g-3">
                  <div class="col-md-4">
                    <label for="foto_pemeriksaan" class="form-label">
                      <i class="bi bi-camera me-1"></i>Foto Pemeriksaan
                    </label>
                    <input type="file" class="form-control" id="foto_pemeriksaan" name="foto_pemeriksaan[]" accept="image/*" multiple>
                    <small class="text-muted">JPG, PNG (Max 5MB/file)</small>
                  </div>
                  <div class="col-md-4">
                    <label for="foto_rontgen" class="form-label">
                      <i class="bi bi-file-medical me-1"></i>Foto Rontgen/Radiologi
                    </label>
                    <input type="file" class="form-control" id="foto_rontgen" name="foto_rontgen[]" accept="image/*" multiple>
                    <small class="text-muted">JPG, PNG (Max 5MB/file)</small>
                  </div>
                  <div class="col-md-4">
                    <label for="file_pendukung" class="form-label">
                      <i class="bi bi-paperclip me-1"></i>File Pendukung Lain
                    </label>
                    <input type="file" class="form-control" id="file_pendukung" name="file_pendukung[]" accept=".pdf,.doc,.docx,image/*" multiple>
                    <small class="text-muted">PDF, DOC, IMG (Max 5MB/file)</small>
                  </div>
                </div>
                <div class="alert alert-info mt-3 mb-0">
                  <i class="bi bi-info-circle me-2"></i>
                  <small>Anda dapat mengupload multiple file untuk setiap kategori. Klik "Choose File" dan pilih beberapa file sekaligus.</small>
                </div>

                <!-- Preview existing files -->
                <div id="existing_files_preview" class="mt-3" style="display: none;">
                  <h6 class="text-muted">File yang Sudah Ada:</h6>
                  <div id="existing_files_list"></div>
                </div>
              </div>
            </div>

          </div>
          <div class="modal-footer bg-light">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
              <i class="bi bi-x-circle me-1"></i>Batal
            </button>
            <button type="submit" class="btn btn-primary" id="submitDiagnosaBtn">
              <i class="bi bi-save me-1"></i>Simpan Rekam Medis
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal Lihat Diagnosa - Complete Medical Record View -->
  <div class="modal fade" id="lihatDiagnosaModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header bg-info text-white">
          <h5 class="modal-title"><i class="bi bi-file-medical me-2"></i>Rekam Medis Elektronik - Detail Lengkap</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">

          <!-- Patient Identity -->
          <div class="card mb-3">
            <div class="card-header bg-light">
              <h6 class="mb-0"><i class="bi bi-person-badge me-2"></i>Identitas Pasien</h6>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-2"><strong>Nama Pasien:</strong> <span id="lihatPasienNama"></span></div>
                  <div class="mb-2"><strong>No. Rekam Medis:</strong> <span id="lihatNoRM"></span></div>
                </div>
                <div class="col-md-6">
                  <div class="mb-2"><strong>Tanggal Pemeriksaan:</strong> <span id="lihatTanggalPeriksa"></span></div>
                  <div class="mb-2"><strong>Dokter Pemeriksa:</strong> <span id="lihatDokterPemeriksa"></span></div>
                </div>
              </div>
            </div>
          </div>

          <!-- Vital Signs -->
          <div class="card mb-3" id="lihatVitalSignsCard" style="display: none;">
            <div class="card-header bg-light">
              <h6 class="mb-0"><i class="bi bi-activity me-2"></i>Tanda-Tanda Vital</h6>
            </div>
            <div class="card-body">
              <div class="row g-3" id="lihatVitalSignsContent"></div>
            </div>
          </div>

          <!-- Anamnesa -->
          <div class="card mb-3" id="lihatAnamnesaCard" style="display: none;">
            <div class="card-header bg-light">
              <h6 class="mb-0"><i class="bi bi-chat-left-text me-2"></i>Anamnesa</h6>
            </div>
            <div class="card-body">
              <div class="mb-3" id="lihatKeluhanUtamaSection"></div>
              <div id="lihatRiwayatPenyakitSection"></div>
            </div>
          </div>

          <!-- Pemeriksaan Fisik & Lab -->
          <div class="card mb-3" id="lihatExamCard" style="display: none;">
            <div class="card-header bg-light">
              <h6 class="mb-0"><i class="bi bi-heart-pulse me-2"></i>Pemeriksaan</h6>
            </div>
            <div class="card-body">
              <div class="mb-3" id="lihatPemeriksaanFisikSection"></div>
              <div id="lihatHasilLabSection"></div>
            </div>
          </div>

          <!-- Diagnosis & Treatment -->
          <div class="card mb-3">
            <div class="card-header bg-light">
              <h6 class="mb-0"><i class="bi bi-file-medical-fill me-2"></i>Diagnosa & Terapi</h6>
            </div>
            <div class="card-body">
              <div class="mb-3">
                <strong><i class="bi bi-file-medical me-2"></i>Diagnosa:</strong>
                <div class="border rounded p-3 bg-light mt-2" id="lihatDiagnosa"></div>
              </div>

              <div class="mb-3" id="lihatTindakanMedisSection"></div>

              <div class="mb-3">
                <strong><i class="bi bi-capsule me-2"></i>Resep Obat:</strong>
                <pre class="border rounded p-3 bg-light mt-2" style="white-space: pre-wrap; font-family: inherit;" id="lihatResepObat"></pre>
              </div>

              <div class="mb-3" id="lihatAnjuranSection"></div>

              <div id="lihatCatatanDokterSection"></div>
            </div>
          </div>

          <!-- Medical Images/Files -->
          <div class="card mb-3" id="lihatFilesCard" style="display: none;">
            <div class="card-header bg-light">
              <h6 class="mb-0"><i class="bi bi-images me-2"></i>Dokumen Pemeriksaan</h6>
            </div>
            <div class="card-body" id="lihatFilesContent"></div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>Eklick</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- Designed by Eklick -->
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>


  <script>
    let autoRefreshInterval = null;
    let isAutoRefreshEnabled = false;

    // Filter table by name and date
    function filterTable() {
      const searchValue = document.getElementById('searchName').value.toLowerCase();
      const dateValue = document.getElementById('filterDate').value;
      const tbody = document.getElementById('antrianTableBody');
      const rows = tbody.getElementsByTagName('tr');
      let visibleCount = 0;

      for (let i = 0; i < rows.length; i++) {
        const row = rows[i];

        // Skip "no data" row
        if (row.id === 'noDataRow') continue;

        const nameData = row.getAttribute('data-name');
        const dateData = row.getAttribute('data-date');

        let showRow = true;

        // Filter by name
        if (searchValue && !nameData.includes(searchValue)) {
          showRow = false;
        }

        // Filter by date
        if (dateValue && dateData !== dateValue) {
          showRow = false;
        }

        row.style.display = showRow ? '' : 'none';
        if (showRow) visibleCount++;
      }

      // Update total count
      document.getElementById('totalCount').textContent = visibleCount;
    }

    // Clear all filters
    function clearFilters() {
      document.getElementById('searchName').value = '';
      document.getElementById('filterDate').value = '';
      filterTable();
    }

    // Toggle show completed patients
    function toggleShowCompleted() {
      const checkbox = document.getElementById('showCompletedToggle');
      const status = document.getElementById('completedStatus');

      status.textContent = checkbox.checked ? 'Ya' : 'Tidak';

      // Reload page with new filter parameter
      const url = new URL(window.location.href);
      if (checkbox.checked) {
        url.searchParams.set('show_completed', '1');
      } else {
        url.searchParams.delete('show_completed');
      }
      window.location.href = url.toString();
    }

    // Auto-refresh functionality
    function refreshData() {
      // Get current show_completed state
      const showCompleted = document.getElementById('showCompletedToggle').checked ? '1' : '0';
      const url = '{{ route('dashboardoc.ajax') }}?show_completed=' + showCompleted;

      fetch(url)
        .then(response => response.json())
        .then(data => {
          updateTable(data);
          updateLastRefreshTime();
        })
        .catch(error => {
          console.error('Auto-refresh error:', error);
        });
    }

    // Update table with new data
    function updateTable(data) {
      const tbody = document.getElementById('antrianTableBody');
      const currentSearchValue = document.getElementById('searchName').value;
      const currentDateValue = document.getElementById('filterDate').value;

      let html = '';

      if (data.length === 0) {
        html = '<tr id="noDataRow"><td colspan="11" class="text-center text-muted">Belum ada data antrian untuk Poli {{ $dokter_poli }}</td></tr>';
      } else {
        data.forEach(antrian => {
          const tanggalDaftar = new Date(antrian.tanggal_daftar).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
          const tglLahir = new Date(antrian.tgl_lahir).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });

          html += `
            <tr data-name="${antrian.nama.toLowerCase()}" data-date="${antrian.tanggal_daftar}">
              <td><span class="badge bg-info fs-6">${antrian.no_antrian}</span></td>
              <td><strong>${antrian.nama}</strong></td>
              <td>${antrian.no_ktp}</td>
              <td>${antrian.alamat}</td>
              <td>${tanggalDaftar}</td>
              <td>${antrian.jenis_kelamin}</td>
              <td>${antrian.no_hp}</td>
              <td>${tglLahir}</td>
              <td>${antrian.pekerjaan}</td>
              <td>
                ${antrian.rekam_medis ?
                  `<div class="d-flex flex-column gap-1">
                    <a href="/rekam-medis/view/${antrian.rekam_medis}" target="_blank" class="btn btn-info btn-sm">
                      <i class="bi bi-eye me-1"></i>Preview
                    </a>
                    <a href="/rekam-medis/download/${antrian.rekam_medis}" class="btn btn-success btn-sm">
                      <i class="bi bi-download me-1"></i>Download
                    </a>
                    <button type="button" class="btn btn-warning btn-sm" onclick="showUploadForm(${antrian.id})">
                      <i class="bi bi-arrow-repeat me-1"></i>Ganti File
                    </button>
                    <form id="upload-form-${antrian.id}" action="/antrian/${antrian.id}/upload-rekam-medis" method="POST" enctype="multipart/form-data" class="mt-2" style="display: none;">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <div class="input-group input-group-sm">
                        <input type="file" name="rekam_medis" class="form-control form-control-sm" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                        <button type="submit" class="btn btn-primary btn-sm">
                          <i class="bi bi-upload"></i> Upload
                        </button>
                      </div>
                      <small class="text-muted">Format: PDF, DOC, DOCX, JPG, PNG (Max 5MB)</small>
                    </form>
                  </div>` :
                  `<form action="/antrian/${antrian.id}/upload-rekam-medis" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="input-group input-group-sm mb-1">
                      <input type="file" name="rekam_medis" class="form-control form-control-sm" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                      <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-upload"></i> Upload
                      </button>
                    </div>
                    <small class="text-muted">PDF, DOC, JPG (Max 5MB)</small>
                  </form>`
                }
              </td>
              <td>
                ${antrian.diagnosa ?
                  `<button class="btn btn-info btn-sm" onclick="lihatDiagnosa(${antrian.id})">
                    <i class="bi bi-eye me-1"></i>Lihat
                  </button>
                  <button class="btn btn-warning btn-sm" onclick="editDiagnosa(${antrian.id})">
                    <i class="bi bi-pencil me-1"></i>Edit
                  </button>` :
                  `<button class="btn btn-primary btn-sm" onclick="inputDiagnosa(${antrian.id}, '${antrian.nama}')">
                    <i class="bi bi-plus-circle me-1"></i>Input
                  </button>`
                }
              </td>
            </tr>
          `;
        });
      }

      tbody.innerHTML = html;

      // Reapply filters if any
      if (currentSearchValue || currentDateValue) {
        filterTable();
      } else {
        document.getElementById('totalCount').textContent = data.length;
      }
    }

    // Update last refresh time
    function updateLastRefreshTime() {
      const now = new Date();
      const timeString = now.toLocaleTimeString('id-ID');
      document.getElementById('lastRefresh').innerHTML = `<i class="bi bi-clock me-1"></i>Last refresh: ${timeString}`;
    }

    // Toggle auto-refresh
    document.getElementById('autoRefreshToggle').addEventListener('change', function() {
      isAutoRefreshEnabled = this.checked;

      if (isAutoRefreshEnabled) {
        document.getElementById('refreshStatus').textContent = 'Aktif (30s)';
        startAutoRefresh();
      } else {
        document.getElementById('refreshStatus').textContent = 'Nonaktif';
        stopAutoRefresh();
      }
    });

    // Start auto-refresh
    function startAutoRefresh() {
      if (autoRefreshInterval) {
        clearInterval(autoRefreshInterval);
      }
      autoRefreshInterval = setInterval(refreshData, 30000); // 30 seconds
    }

    // Stop auto-refresh
    function stopAutoRefresh() {
      if (autoRefreshInterval) {
        clearInterval(autoRefreshInterval);
        autoRefreshInterval = null;
      }
    }

    // Initialize auto-refresh on page load
    document.addEventListener('DOMContentLoaded', function() {
      if (isAutoRefreshEnabled) {
        startAutoRefresh();
      }
      updateLastRefreshTime();
    });

    // Check for session flash messages
    @if (session('success'))
        console.log("{{ session('success') }}");
    @endif

    @if (session('error'))
        console.log("{{ session('error') }}");
    @endif

    // Function to toggle upload form
    function showUploadForm(antrianId) {
      const form = document.getElementById('upload-form-' + antrianId);
      if (form.style.display === 'none') {
        form.style.display = 'block';
      } else {
        form.style.display = 'none';
      }
    }

    // Function to show patient detail modal
    function showDetail(antrianId) {
      const button = event.target.closest('button');
      const row = button.closest('tr');
      
      if (row) {
        document.getElementById('detailNoKtp').textContent = row.dataset.noktp || '-';
        document.getElementById('detailAlamat').textContent = row.dataset.alamat || '-';
        document.getElementById('detailTglLahir').textContent = row.dataset.tgllahir || '-';
        document.getElementById('detailPekerjaan').textContent = row.dataset.pekerjaan || '-';
        document.getElementById('detailNoHp').textContent = row.dataset.nohp || '-';
        
        const modal = new bootstrap.Modal(document.getElementById('detailPasienModal'));
        modal.show();
      }
    }

    // Functions for Diagnosa Management
    function inputDiagnosa(antrianId, nama) {
      document.getElementById('diagnosaModalTitle').textContent = 'Input Rekam Medis Pasien';
      document.getElementById('antrianId').value = antrianId;

      // Auto-fill Patient Identity
      document.getElementById('pasienNama').textContent = nama;

      // Auto-fill No. RM (format: #000001)
      const noRM = '#' + antrianId.toString().padStart(6, '0');
      document.getElementById('pasienNoRM').textContent = noRM;

      // Auto-fill Tanggal Pemeriksaan (Today's date in Indonesian format)
      const today = new Date();
      const dateStr = today.toLocaleDateString('id-ID', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      });
      document.getElementById('tanggalPemeriksaan').textContent = dateStr;

      // Reset all form fields
      document.getElementById('tekanan_darah').value = '';
      document.getElementById('suhu_tubuh').value = '';
      document.getElementById('nadi').value = '';
      document.getElementById('tinggi_badan').value = '';
      document.getElementById('berat_badan').value = '';

      document.getElementById('keluhan_utama').value = '';
      document.getElementById('riwayat_penyakit').value = '';
      document.getElementById('pemeriksaan_fisik').value = '';
      document.getElementById('hasil_lab').value = '';

      document.getElementById('diagnosa').value = '';
      document.getElementById('tindakan_medis').value = '';
      document.getElementById('resep_obat').value = '';
      document.getElementById('anjuran').value = '';
      document.getElementById('catatan_dokter').value = '';

      // Clear file inputs
      document.getElementById('foto_pemeriksaan').value = '';
      document.getElementById('foto_rontgen').value = '';
      document.getElementById('file_pendukung').value = '';

      // Hide existing files preview
      document.getElementById('existing_files_preview').style.display = 'none';

      const modal = new bootstrap.Modal(document.getElementById('diagnosaModal'));
      modal.show();
    }

    function editDiagnosa(antrianId) {
      // Get antrian data
      fetch(`/dokter/antrian/${antrianId}/diagnosa`)
        .then(response => response.json())
        .then(data => {
          if (data.error) {
            alert(data.error);
            return;
          }

          document.getElementById('diagnosaModalTitle').textContent = 'Edit Rekam Medis Pasien';
          document.getElementById('antrianId').value = antrianId;

          // Auto-fill Patient Identity
          document.getElementById('pasienNama').textContent = data.nama;

          // Auto-fill No. RM
          const noRM = '#' + antrianId.toString().padStart(6, '0');
          document.getElementById('pasienNoRM').textContent = noRM;

          // Display examination date (either saved date or today's date)
          if (data.tanggal_periksa) {
            document.getElementById('tanggalPemeriksaan').textContent = data.tanggal_periksa;
          } else {
            const today = new Date();
            const dateStr = today.toLocaleDateString('id-ID', {
              weekday: 'long',
              year: 'numeric',
              month: 'long',
              day: 'numeric'
            });
            document.getElementById('tanggalPemeriksaan').textContent = dateStr;
          }

          // Load Vital Signs
          document.getElementById('tekanan_darah').value = data.tekanan_darah || '';
          document.getElementById('suhu_tubuh').value = data.suhu_tubuh || '';
          document.getElementById('nadi').value = data.nadi || '';
          document.getElementById('tinggi_badan').value = data.tinggi_badan || '';
          document.getElementById('berat_badan').value = data.berat_badan || '';

          // Load Examination
          document.getElementById('keluhan_utama').value = data.keluhan_utama || '';
          document.getElementById('riwayat_penyakit').value = data.riwayat_penyakit || '';
          document.getElementById('pemeriksaan_fisik').value = data.pemeriksaan_fisik || '';
          document.getElementById('hasil_lab').value = data.hasil_lab || '';

          // Load Diagnosis & Treatment
          document.getElementById('diagnosa').value = data.diagnosa || '';
          document.getElementById('tindakan_medis').value = data.tindakan_medis || '';
          document.getElementById('resep_obat').value = data.resep_obat || '';
          document.getElementById('anjuran').value = data.anjuran || '';
          document.getElementById('catatan_dokter').value = data.catatan_dokter || '';

          // Clear file inputs (user can add new files)
          document.getElementById('foto_pemeriksaan').value = '';
          document.getElementById('foto_rontgen').value = '';
          document.getElementById('file_pendukung').value = '';

          // Display existing files if any
          const existingFilesDiv = document.getElementById('existing_files_preview');
          const existingFilesList = document.getElementById('existing_files_list');
          existingFilesList.innerHTML = '';

          let hasFiles = false;

          // Show existing foto pemeriksaan
          if (data.foto_pemeriksaan && data.foto_pemeriksaan.length > 0) {
            hasFiles = true;
            let html = '<div class="mb-2"><strong>Foto Pemeriksaan:</strong><div class="d-flex flex-wrap gap-2 mt-1">';
            data.foto_pemeriksaan.forEach(file => {
              html += `<div class="position-relative">
                <img src="/storage/foto_pemeriksaan/${file}" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                <small class="d-block text-center">${file.substring(0, 15)}...</small>
              </div>`;
            });
            html += '</div></div>';
            existingFilesList.innerHTML += html;
          }

          // Show existing foto rontgen
          if (data.foto_rontgen && data.foto_rontgen.length > 0) {
            hasFiles = true;
            let html = '<div class="mb-2"><strong>Foto Rontgen:</strong><div class="d-flex flex-wrap gap-2 mt-1">';
            data.foto_rontgen.forEach(file => {
              html += `<div class="position-relative">
                <img src="/storage/foto_rontgen/${file}" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                <small class="d-block text-center">${file.substring(0, 15)}...</small>
              </div>`;
            });
            html += '</div></div>';
            existingFilesList.innerHTML += html;
          }

          // Show existing file pendukung
          if (data.file_pendukung && data.file_pendukung.length > 0) {
            hasFiles = true;
            let html = '<div class="mb-2"><strong>File Pendukung:</strong><div class="d-flex flex-wrap gap-2 mt-1">';
            data.file_pendukung.forEach(file => {
              const fileExt = file.split('.').pop().toLowerCase();
              const isImage = ['jpg', 'jpeg', 'png', 'gif'].includes(fileExt);
              if (isImage) {
                html += `<div class="position-relative">
                  <img src="/storage/file_pendukung/${file}" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                  <small class="d-block text-center">${file.substring(0, 15)}...</small>
                </div>`;
              } else {
                html += `<div class="text-center">
                  <i class="bi bi-file-earmark-pdf fs-1 text-danger"></i>
                  <small class="d-block">${file.substring(0, 15)}...</small>
                </div>`;
              }
            });
            html += '</div></div>';
            existingFilesList.innerHTML += html;
          }

          existingFilesDiv.style.display = hasFiles ? 'block' : 'none';

          const modal = new bootstrap.Modal(document.getElementById('diagnosaModal'));
          modal.show();
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Terjadi kesalahan saat mengambil data.');
        });
    }

    function lihatDiagnosa(antrianId) {
      // Get complete antrian data
      fetch(`/dokter/antrian/${antrianId}/diagnosa`)
        .then(response => response.json())
        .then(data => {
          if (data.error) {
            alert(data.error);
            return;
          }

          // ===== Patient Identity =====
          document.getElementById('lihatPasienNama').textContent = data.nama || '-';
          document.getElementById('lihatNoRM').textContent = '#' + antrianId.toString().padStart(6, '0');
          document.getElementById('lihatTanggalPeriksa').textContent = data.tanggal_periksa || '-';
          document.getElementById('lihatDokterPemeriksa').textContent = data.nama_dokter ? data.nama_dokter + ' (' + (data.dokter_poli || '') + ')' : '-';

          // ===== Vital Signs =====
          const vitalSignsCard = document.getElementById('lihatVitalSignsCard');
          const vitalSignsContent = document.getElementById('lihatVitalSignsContent');
          let hasVitalSigns = false;
          let vitalSignsHTML = '';

          if (data.tekanan_darah) {
            hasVitalSigns = true;
            vitalSignsHTML += `<div class="col-md-3"><div class="p-2 border rounded"><small class="text-muted">Tekanan Darah</small><br><strong>${data.tekanan_darah}</strong></div></div>`;
          }
          if (data.nadi) {
            hasVitalSigns = true;
            vitalSignsHTML += `<div class="col-md-3"><div class="p-2 border rounded"><small class="text-muted">Nadi</small><br><strong>${data.nadi}</strong></div></div>`;
          }
          if (data.suhu_tubuh) {
            hasVitalSigns = true;
            vitalSignsHTML += `<div class="col-md-3"><div class="p-2 border rounded"><small class="text-muted">Suhu Tubuh</small><br><strong>${data.suhu_tubuh}</strong></div></div>`;
          }
          if (data.tinggi_badan) {
            hasVitalSigns = true;
            vitalSignsHTML += `<div class="col-md-3"><div class="p-2 border rounded"><small class="text-muted">Tinggi Badan</small><br><strong>${data.tinggi_badan} cm</strong></div></div>`;
          }
          if (data.berat_badan) {
            hasVitalSigns = true;
            vitalSignsHTML += `<div class="col-md-3"><div class="p-2 border rounded"><small class="text-muted">Berat Badan</small><br><strong>${data.berat_badan} kg</strong></div></div>`;
          }

          if (hasVitalSigns) {
            vitalSignsContent.innerHTML = vitalSignsHTML;
            vitalSignsCard.style.display = 'block';
          } else {
            vitalSignsCard.style.display = 'none';
          }

          // ===== Anamnesa =====
          const anamnesaCard = document.getElementById('lihatAnamnesaCard');
          const keluhanUtamaSection = document.getElementById('lihatKeluhanUtamaSection');
          const riwayatPenyakitSection = document.getElementById('lihatRiwayatPenyakitSection');
          let hasAnamnesa = false;

          if (data.keluhan_utama) {
            hasAnamnesa = true;
            keluhanUtamaSection.innerHTML = `<strong><i class="bi bi-chat-left-text me-2"></i>Keluhan Utama:</strong><p class="mt-2">${data.keluhan_utama}</p>`;
          } else {
            keluhanUtamaSection.innerHTML = '';
          }

          if (data.riwayat_penyakit) {
            hasAnamnesa = true;
            riwayatPenyakitSection.innerHTML = `<strong><i class="bi bi-clock-history me-2"></i>Riwayat Penyakit:</strong><p class="mt-2">${data.riwayat_penyakit}</p>`;
          } else {
            riwayatPenyakitSection.innerHTML = '';
          }

          anamnesaCard.style.display = hasAnamnesa ? 'block' : 'none';

          // ===== Pemeriksaan Fisik & Lab =====
          const examCard = document.getElementById('lihatExamCard');
          const pemeriksaanFisikSection = document.getElementById('lihatPemeriksaanFisikSection');
          const hasilLabSection = document.getElementById('lihatHasilLabSection');
          let hasExam = false;

          if (data.pemeriksaan_fisik) {
            hasExam = true;
            pemeriksaanFisikSection.innerHTML = `<strong><i class="bi bi-heart-pulse me-2"></i>Pemeriksaan Fisik:</strong><p class="mt-2">${data.pemeriksaan_fisik}</p>`;
          } else {
            pemeriksaanFisikSection.innerHTML = '';
          }

          if (data.hasil_lab) {
            hasExam = true;
            hasilLabSection.innerHTML = `<strong><i class="bi bi-clipboard2-pulse me-2"></i>Hasil Laboratorium:</strong><p class="mt-2">${data.hasil_lab}</p>`;
          } else {
            hasilLabSection.innerHTML = '';
          }

          examCard.style.display = hasExam ? 'block' : 'none';

          // ===== Diagnosis & Treatment =====
          document.getElementById('lihatDiagnosa').textContent = data.diagnosa || '-';
          document.getElementById('lihatResepObat').textContent = data.resep_obat || '-';

          const tindakanMedisSection = document.getElementById('lihatTindakanMedisSection');
          if (data.tindakan_medis) {
            tindakanMedisSection.innerHTML = `<strong><i class="bi bi-bandaid me-2"></i>Tindakan Medis:</strong><div class="border rounded p-3 bg-light mt-2">${data.tindakan_medis}</div>`;
          } else {
            tindakanMedisSection.innerHTML = '';
          }

          const anjuranSection = document.getElementById('lihatAnjuranSection');
          if (data.anjuran) {
            anjuranSection.innerHTML = `<strong><i class="bi bi-info-circle me-2"></i>Anjuran:</strong><div class="border rounded p-3 bg-light mt-2">${data.anjuran}</div>`;
          } else {
            anjuranSection.innerHTML = '';
          }

          const catatanDokterSection = document.getElementById('lihatCatatanDokterSection');
          if (data.catatan_dokter) {
            catatanDokterSection.innerHTML = `<strong><i class="bi bi-journal-text me-2"></i>Catatan Dokter:</strong><div class="border rounded p-3 bg-light mt-2">${data.catatan_dokter}</div>`;
          } else {
            catatanDokterSection.innerHTML = '';
          }

          // ===== Medical Images/Files =====
          const filesCard = document.getElementById('lihatFilesCard');
          const filesContent = document.getElementById('lihatFilesContent');
          let hasFiles = false;
          let filesHTML = '';

          // Foto Pemeriksaan
          if (data.foto_pemeriksaan && data.foto_pemeriksaan.length > 0) {
            hasFiles = true;
            filesHTML += '<div class="mb-3"><h6><i class="bi bi-camera me-2"></i>Foto Pemeriksaan</h6><div class="row g-2">';
            data.foto_pemeriksaan.forEach(foto => {
              filesHTML += `<div class="col-3"><a href="/storage/foto_pemeriksaan/${foto}" target="_blank">
                <img src="/storage/foto_pemeriksaan/${foto}" class="img-fluid rounded shadow-sm" style="height: 120px; width: 100%; object-fit: cover;">
              </a></div>`;
            });
            filesHTML += '</div></div>';
          }

          // Foto Rontgen
          if (data.foto_rontgen && data.foto_rontgen.length > 0) {
            hasFiles = true;
            filesHTML += '<div class="mb-3"><h6><i class="bi bi-file-medical me-2"></i>Foto Rontgen</h6><div class="row g-2">';
            data.foto_rontgen.forEach(foto => {
              filesHTML += `<div class="col-3"><a href="/storage/foto_rontgen/${foto}" target="_blank">
                <img src="/storage/foto_rontgen/${foto}" class="img-fluid rounded shadow-sm" style="height: 120px; width: 100%; object-fit: cover;">
              </a></div>`;
            });
            filesHTML += '</div></div>';
          }

          // File Pendukung
          if (data.file_pendukung && data.file_pendukung.length > 0) {
            hasFiles = true;
            filesHTML += '<div class="mb-3"><h6><i class="bi bi-paperclip me-2"></i>File Pendukung</h6><div class="row g-2">';
            data.file_pendukung.forEach(file => {
              const ext = file.split('.').pop().toLowerCase();
              const isImage = ['jpg', 'jpeg', 'png', 'gif'].includes(ext);
              if (isImage) {
                filesHTML += `<div class="col-3"><a href="/storage/file_pendukung/${file}" target="_blank">
                  <img src="/storage/file_pendukung/${file}" class="img-fluid rounded shadow-sm" style="height: 120px; width: 100%; object-fit: cover;">
                </a></div>`;
              } else {
                filesHTML += `<div class="col-3"><a href="/storage/file_pendukung/${file}" target="_blank" class="text-decoration-none">
                  <div class="p-3 border rounded text-center" style="height: 120px; display: flex; flex-direction: column; justify-content: center;">
                    <i class="bi bi-file-earmark-pdf fs-1 text-danger"></i><small class="mt-2">${ext.toUpperCase()}</small>
                  </div>
                </a></div>`;
              }
            });
            filesHTML += '</div></div>';
          }

          if (hasFiles) {
            filesContent.innerHTML = filesHTML;
            filesCard.style.display = 'block';
          } else {
            filesCard.style.display = 'none';
          }

          const modal = new bootstrap.Modal(document.getElementById('lihatDiagnosaModal'));
          modal.show();
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Terjadi kesalahan saat mengambil data.');
        });
    }

    // Submit Diagnosa Form
    document.getElementById('diagnosaForm').addEventListener('submit', function(e) {
      e.preventDefault();

      const antrianId = document.getElementById('antrianId').value;
      const submitBtn = document.getElementById('submitDiagnosaBtn');

      // Disable button and show loading
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...';

      // Create FormData to handle file upload and all medical record fields
      const formData = new FormData();

      // Vital Signs
      formData.append('tekanan_darah', document.getElementById('tekanan_darah').value || '');
      formData.append('suhu_tubuh', document.getElementById('suhu_tubuh').value || '');
      formData.append('nadi', document.getElementById('nadi').value || '');
      formData.append('tinggi_badan', document.getElementById('tinggi_badan').value || '');
      formData.append('berat_badan', document.getElementById('berat_badan').value || '');

      // Examination
      formData.append('keluhan_utama', document.getElementById('keluhan_utama').value);
      formData.append('riwayat_penyakit', document.getElementById('riwayat_penyakit').value || '');
      formData.append('pemeriksaan_fisik', document.getElementById('pemeriksaan_fisik').value || '');
      formData.append('hasil_lab', document.getElementById('hasil_lab').value || '');

      // Diagnosis & Treatment
      formData.append('diagnosa', document.getElementById('diagnosa').value);
      formData.append('tindakan_medis', document.getElementById('tindakan_medis').value || '');
      formData.append('resep_obat', document.getElementById('resep_obat').value);
      formData.append('anjuran', document.getElementById('anjuran').value || '');
      formData.append('catatan_dokter', document.getElementById('catatan_dokter').value || '');

      // Handle Multiple File Uploads
      // Foto Pemeriksaan
      const fotoPemeriksaanInput = document.getElementById('foto_pemeriksaan');
      if (fotoPemeriksaanInput.files.length > 0) {
        for (let i = 0; i < fotoPemeriksaanInput.files.length; i++) {
          formData.append('foto_pemeriksaan[]', fotoPemeriksaanInput.files[i]);
        }
      }

      // Foto Rontgen
      const fotoRontgenInput = document.getElementById('foto_rontgen');
      if (fotoRontgenInput.files.length > 0) {
        for (let i = 0; i < fotoRontgenInput.files.length; i++) {
          formData.append('foto_rontgen[]', fotoRontgenInput.files[i]);
        }
      }

      // File Pendukung
      const filePendukungInput = document.getElementById('file_pendukung');
      if (filePendukungInput.files.length > 0) {
        for (let i = 0; i < filePendukungInput.files.length; i++) {
          formData.append('file_pendukung[]', filePendukungInput.files[i]);
        }
      }

      fetch(`/dokter/antrian/${antrianId}/diagnosa`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
          // Don't set Content-Type, let browser set it with boundary for FormData
        },
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.message) {
          alert(data.message);
          location.reload();
        } else if (data.error) {
          alert('Error: ' + data.error);
          if (data.details) {
            console.error('Validation errors:', data.details);
          }
          // Re-enable button
          submitBtn.disabled = false;
          submitBtn.innerHTML = '<i class="bi bi-save me-1"></i>Simpan Rekam Medis';
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menyimpan data.');
        // Re-enable button
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="bi bi-save me-1"></i>Simpan';
      });
    });
  </script>
</body>

</html>
