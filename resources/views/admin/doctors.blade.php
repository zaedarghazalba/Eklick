<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Kelola Dokter - Admin Dashboard</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

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

  <style>
    .info-card { border-radius: 0.5rem; transition: all 0.3s ease; }
    .info-card:hover { transform: translateY(-5px); box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1); }
    .header { background: #fff; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); padding: 0 1.5rem; height: 60px; }
    .sidebar { position: fixed; top: 60px; left: 0; bottom: 0; width: 250px; background: #fff; border-right: 1px solid #e9ecef; padding: 1rem 0; overflow-y: auto; z-index: 996; }
    .sidebar-nav .nav-link { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; color: #6c757d; text-decoration: none; border-radius: 0.5rem; margin: 0.25rem 0.75rem; transition: all 0.3s ease; }
    .sidebar-nav .nav-link:hover { background: #f8f9fa; color: #0d6efd; }
    .sidebar-nav .nav-link.active { background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); color: white; }
    #main { margin-left: 250px; margin-top: 60px; padding: 2rem; min-height: calc(100vh - 60px); background: #f6f9ff; }
    .footer { padding: 1rem 2rem; text-align: center; color: #6c757d; font-size: 0.875rem; margin-left: 250px; }
    .back-to-top { position: fixed; visibility: hidden; opacity: 0; right: 15px; bottom: 15px; z-index: 99999; background: #0d6efd; width: 40px; height: 40px; border-radius: 4px; transition: all 0.4s; }
    .back-to-top.active { visibility: visible; opacity: 1; }
    @media (max-width: 991.98px) { .sidebar { transform: translateX(-100%); } .sidebar.active { transform: translateX(0); } #main, .footer { margin-left: 0; } .toggle-sidebar-btn { display: block !important; } }
    @media (min-width: 992px) { .toggle-sidebar-btn { display: none; } }
  </style>

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
        <a class="nav-link active" href="{{ route('admin.doctors') }}">
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
      <h1>Kelola Dokter</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Kelola Dokter</li>
        </ol>
      </nav>
    </div>

    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-1"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

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

    <section class="section dashboard">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">Daftar Dokter <span>| {{ count($doctors) }} dokter</span></h5>
                <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary">
                  <i class="bi bi-plus-circle"></i> Tambah Dokter
                </a>
              </div>

              <div class="table-responsive">
                <table class="table table-hover table-striped">
                  <thead class="table-primary">
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Nama</th>
                      <th scope="col">Email</th>
                      <th scope="col">Poli Spesialisasi</th>
                      <th scope="col">Tanggal Daftar</th>
                      <th scope="col">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($doctors as $index => $doctor)
                      <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $doctor->name }}</strong></td>
                        <td>{{ $doctor->email }}</td>
                        <td><span class="badge bg-info">{{ $doctor->poli_spesialisasi }}</span></td>
                        <td>{{ $doctor->created_at->format('d M Y') }}</td>
                        <td>
                          <a href="{{ route('admin.doctors.edit', $doctor->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i> Edit
                          </a>
                          <button class="btn btn-sm btn-danger" onclick="deleteDoctor({{ $doctor->id }})">
                            <i class="bi bi-trash"></i> Hapus
                          </button>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                          <i class="bi bi-person-badge fs-1 d-block mb-2"></i>
                          Tidak ada dokter
                        </td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>

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

  <script>
    function deleteDoctor(id) {
      if (confirm('Apakah Anda yakin ingin menghapus dokter ini?')) {
        fetch(`/admin/doctors/${id}`, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.message) {
            alert(data.message);
            location.reload();
          } else if (data.error) {
            alert(data.error);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Terjadi kesalahan saat menghapus dokter.');
        });
      }
    }
  </script>

</body>

</html>
