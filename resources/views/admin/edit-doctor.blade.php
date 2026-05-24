<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Edit Dokter - Admin Dashboard</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/eklick.png') }}" rel="icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

</head>

<body>

  <!-- Header -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="{{ route('admin.dashboard') }}" class="logo d-flex align-items-center">
        <img src="{{ asset('assets/img/eklick.png') }}" alt="">
        <span class="d-none d-lg-block">Eklick Admin</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-person-circle fs-4"></i>
            <span class="d-none d-md-block dropdown-toggle ps-2">{{ session('admin_name') }}</span>
          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{ session('admin_name') }}</h6>
              <span>Administrator</span>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.logout') }}">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>

  </header>

  <!-- Sidebar -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('admin.dashboard') }}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('admin.users') }}">
          <i class="bi bi-people"></i>
          <span>Kelola User</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.doctors') }}">
          <i class="bi bi-person-badge"></i>
          <span>Kelola Dokter</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('admin.antrian') }}">
          <i class="bi bi-list-ol"></i>
          <span>Kelola Antrian</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('admin.data-pasien') }}">
          <i class="bi bi-clipboard2-pulse"></i>
          <span>Data Pasien</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('admin.data-pasien.archive') }}">
          <i class="bi bi-archive"></i>
          <span>Arsip Data Pasien</span>
        </a>
      </li>

    </ul>

  </aside>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Edit Dokter</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.doctors') }}">Kelola Dokter</a></li>
          <li class="breadcrumb-item active">Edit Dokter</li>
        </ol>
      </nav>
    </div>

    @if ($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <section class="section">
      <div class="row">
        <div class="col-lg-8">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Form Edit Dokter</h5>

              <form method="POST" action="{{ route('admin.doctors.update', $doctor->id) }}">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                  <label for="name" class="col-sm-3 col-form-label">Nama Dokter</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $doctor->name) }}" required>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="email" class="col-sm-3 col-form-label">Email</label>
                  <div class="col-sm-9">
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $doctor->email) }}" required>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="poli_spesialisasi" class="col-sm-3 col-form-label">Poli Spesialisasi</label>
                  <div class="col-sm-9">
                    <select class="form-select" id="poli_spesialisasi" name="poli_spesialisasi" required>
                      <option value="">Pilih Poli</option>
                      <option value="Umum" {{ old('poli_spesialisasi', $doctor->poli_spesialisasi) == 'Umum' ? 'selected' : '' }}>Poli Umum</option>
                      <option value="Tht" {{ old('poli_spesialisasi', $doctor->poli_spesialisasi) == 'Tht' ? 'selected' : '' }}>Poli THT</option>
                      <option value="Syaraf" {{ old('poli_spesialisasi', $doctor->poli_spesialisasi) == 'Syaraf' ? 'selected' : '' }}>Poli Syaraf</option>
                      <option value="Balita" {{ old('poli_spesialisasi', $doctor->poli_spesialisasi) == 'Balita' ? 'selected' : '' }}>Poli Balita</option>
                      <option value="Kulit" {{ old('poli_spesialisasi', $doctor->poli_spesialisasi) == 'Kulit' ? 'selected' : '' }}>Poli Kulit dan Kelamin</option>
                      <option value="Mata" {{ old('poli_spesialisasi', $doctor->poli_spesialisasi) == 'Mata' ? 'selected' : '' }}>Poli Mata</option>
                    </select>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="password" class="col-sm-3 col-form-label">Password Baru</label>
                  <div class="col-sm-9">
                    <input type="password" class="form-control" id="password" name="password">
                    <div class="form-text">Kosongkan jika tidak ingin mengubah password. Minimal 6 karakter</div>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="password_confirmation" class="col-sm-3 col-form-label">Konfirmasi Password</label>
                  <div class="col-sm-9">
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-sm-9 offset-sm-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.doctors') }}" class="btn btn-secondary">Batal</a>
                  </div>
                </div>

              </form>

            </div>
          </div>

        </div>
      </div>
    </section>

  </main>

  <!-- Footer -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>Eklick</span></strong>. All Rights Reserved
    </div>
  </footer>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>
