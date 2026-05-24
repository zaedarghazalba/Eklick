<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Admin Dashboard - Klinik PUI</title>
  <meta content="Admin Dashboard Klinik PUI" name="description">
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

  <!-- Custom Dashboard Styles -->
  <style>
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

    /* Info Cards */
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

    /* Table wrapper for dashboard */
    @media (min-width: 1200px) {
      .table-wrapper {
        max-width: 100%;
      }
    }
  </style>

<body>

  <!-- Header -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="{{ route('admin.dashboard') }}" class="logo d-flex align-items-center">
        <img src="{{ asset('assets/img/eklick.png') }}" alt="" class="logo-img">
        <span class="d-none d-lg-block logo-text">Eklick Admin</span>
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
            <li>
              <hr class="dropdown-divider">
            </li>
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
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
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
        <a class="nav-link collapsed" href="{{ route('admin.doctors') }}">
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
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div>

    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <section class="section dashboard">
      <div class="row">

        <!-- Statistik Hari Ini -->
        <div class="col-12">
          <h5 class="card-title">Statistik Hari Ini <span>| {{ date('d M Y') }}</span></h5>
        </div>

        <!-- Antrian Hari Ini Card -->
        <div class="col-xxl-3 col-md-6">
          <div class="card info-card sales-card">
            <div class="card-body">
              <h5 class="card-title">Antrian <span>| Hari Ini</span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-people"></i>
                </div>
                <div class="ps-3">
                  <h6>{{ $antrianHariIni }}</h6>
                  <span class="text-muted small pt-2">Total Pasien</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Menunggu Hari Ini Card -->
        <div class="col-xxl-3 col-md-6">
          <div class="card info-card warning-card">
            <div class="card-body">
              <h5 class="card-title">Menunggu <span>| Hari Ini</span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-clock"></i>
                </div>
                <div class="ps-3">
                  <h6>{{ $antrianMenungguHariIni }}</h6>
                  <span class="text-muted small pt-2">Belum Dipanggil</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Dipanggil Hari Ini Card -->
        <div class="col-xxl-3 col-md-6">
          <div class="card info-card info-card">
            <div class="card-body">
              <h5 class="card-title">Dipanggil <span>| Hari Ini</span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-megaphone"></i>
                </div>
                <div class="ps-3">
                  <h6>{{ $antrianDipanggilHariIni }}</h6>
                  <span class="text-muted small pt-2">Sedang Dilayani</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Selesai Hari Ini Card -->
        <div class="col-xxl-3 col-md-6">
          <div class="card info-card success-card">
            <div class="card-body">
              <h5 class="card-title">Selesai <span>| Hari Ini</span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-check-circle"></i>
                </div>
                <div class="ps-3">
                  <h6>{{ $antrianSelesaiHariIni }}</h6>
                  <span class="text-muted small pt-2">Pasien Selesai</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Statistik Keseluruhan -->
        <div class="col-12 mt-3">
          <h5 class="card-title">Statistik Keseluruhan</h5>
        </div>

        <!-- Total Users -->
        <div class="col-xxl-4 col-md-4">
          <div class="card info-card revenue-card">
            <div class="card-body">
              <h5 class="card-title">Total Pasien</h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-person"></i>
                </div>
                <div class="ps-3">
                  <h6>{{ $totalUsers }}</h6>
                  <span class="text-muted small pt-2">Terdaftar</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Total Dokter -->
        <div class="col-xxl-4 col-md-4">
          <div class="card info-card customers-card">
            <div class="card-body">
              <h5 class="card-title">Total Dokter</h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-person-badge"></i>
                </div>
                <div class="ps-3">
                  <h6>{{ $totalDokter }}</h6>
                  <span class="text-muted small pt-2">Dokter Aktif</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Total Antrian -->
        <div class="col-xxl-4 col-md-4">
          <div class="card info-card">
            <div class="card-body">
              <h5 class="card-title">Total Antrian</h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-list-ol"></i>
                </div>
                <div class="ps-3">
                  <h6>{{ $totalAntrian }}</h6>
                  <span class="text-muted small pt-2">Semua Waktu</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Antrian Per Poli Chart -->
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Antrian Per Poli <span>| Hari Ini</span></h5>
              <canvas id="poliChart" style="max-height: 300px;"></canvas>
            </div>
          </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Quick Actions</h5>
              <div class="d-grid gap-2">
                <a href="{{ route('admin.antrian') }}" class="btn btn-primary">
                  <i class="bi bi-list-ol me-1"></i> Kelola Antrian
                </a>
                <a href="{{ route('admin.users') }}" class="btn btn-outline-primary">
                  <i class="bi bi-people me-1"></i> Kelola User
                </a>
                <a href="{{ route('admin.doctors') }}" class="btn btn-outline-primary">
                  <i class="bi bi-person-badge me-1"></i> Kelola Dokter
                </a>
                <a href="{{ route('admin.data-pasien') }}" class="btn btn-outline-primary">
                  <i class="bi bi-clipboard2-pulse me-1"></i> Lihat Data Pasien
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Audio Test Player -->
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Test Audio Panggilan Antrian</h5>
              <p class="text-muted small">Test audio sebelum memanggil antrian untuk memastikan speaker berfungsi dengan baik</p>

              <div class="row g-3">
                <!-- Test Nomor Antrian -->
                <div class="col-md-6">
                  <label class="form-label"><i class="bi bi-megaphone-fill me-1"></i> Test Nomor Antrian</label>
                  <div class="input-group">
                    <select class="form-select" id="testNoAntrian">
                      @for($i = 1; $i <= 15; $i++)
                        <option value="{{ $i }}">Nomor {{ $i }}</option>
                      @endfor
                    </select>
                    <button class="btn btn-primary" onclick="testAudioNomor()">
                      <i class="bi bi-play-fill"></i> Play
                    </button>
                  </div>
                  <small class="text-muted">Audio nomor 1-15 tersedia</small>
                </div>

                <!-- Test Nama Poli -->
                <div class="col-md-6">
                  <label class="form-label"><i class="bi bi-hospital me-1"></i> Test Nama Poli</label>
                  <div class="input-group">
                    <select class="form-select" id="testPoli">
                      <option value="Umum">Poli Umum</option>
                      <option value="Mata">Poli Mata</option>
                      <option value="Tht">Poli THT</option>
                      <option value="Syaraf">Poli Syaraf</option>
                      <option value="Balita">Poli Balita (Ibu & Anak)</option>
                      <option value="Kulit">Poli Kulit</option>
                    </select>
                    <button class="btn btn-primary" onclick="testAudioPoli()">
                      <i class="bi bi-play-fill"></i> Play
                    </button>
                  </div>
                </div>

                <!-- Test Full Announcement -->
                <div class="col-12">
                  <label class="form-label"><i class="bi bi-volume-up-fill me-1"></i> Test Panggilan Lengkap</label>
                  <div class="input-group">
                    <select class="form-select" id="testNoAntrianFull" style="max-width: 200px;">
                      @for($i = 1; $i <= 15; $i++)
                        <option value="{{ $i }}">Nomor {{ $i }}</option>
                      @endfor
                    </select>
                    <select class="form-select" id="testPoliFull">
                      <option value="Umum">Poli Umum</option>
                      <option value="Mata">Poli Mata</option>
                      <option value="Tht">Poli THT</option>
                      <option value="Syaraf">Poli Syaraf</option>
                      <option value="Balita">Poli Balita</option>
                      <option value="Kulit">Poli Kulit</option>
                    </select>
                    <button class="btn btn-success" onclick="testAudioFull()">
                      <i class="bi bi-play-circle-fill"></i> Play Full Announcement
                    </button>
                  </div>
                  <small class="text-muted">Menguji audio lengkap: "Nomor [X] Poli [Nama]"</small>
                </div>

                <!-- Audio Status -->
                <div class="col-12">
                  <div id="audioStatus" class="alert alert-info d-none" role="alert">
                    <i class="bi bi-info-circle me-2"></i>
                    <span id="audioStatusText"></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Recent Antrian Table -->
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Antrian Terbaru <span>| 10 Terakhir</span></h5>
              <div class="table-wrapper">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th style="width: 50px;">#</th>
                      <th style="width: 90px;">No. Antrian</th>
                      <th>Nama Pasien</th>
                      <th style="width: 100px;">Poli</th>
                      <th style="width: 110px;">Tanggal</th>
                      <th style="width: 90px;">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($recentAntrian as $index => $antrian)
                      <tr>
                        <th scope="row">{{ $index + 1 }}</th>
                        <td><span class="badge bg-primary">#{{ $antrian->no_antrian }}</span></td>
                        <td class="fw-semibold">{{ $antrian->nama }}</td>
                        <td><span class="badge bg-info">{{ $antrian->poli }}</span></td>
                        <td class="text-nowrap small">{{ \Carbon\Carbon::parse($antrian->tanggal_daftar)->format('d M Y') }}</td>
                        <td>
                          @if ($antrian->status === 'selesai')
                            <span class="badge bg-success">Selesai</span>
                          @elseif ($antrian->status === 'dipanggil')
                            <span class="badge bg-info">Dipanggil</span>
                          @else
                            <span class="badge bg-warning text-dark">Menunggu</span>
                          @endif
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                          <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                          Belum ada data antrian
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

  </main><!-- End #main -->


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
  <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
  <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
  <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
  <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

  
  <script>
  document.getElementById("editForm").addEventListener("submit", function (event) {
  event.preventDefault(); // Prevent the form from submitting the default way

  const id = document.getElementById("editForm").dataset.id; // Get the ID from the form's data-id
  const updatedData = {
    nama: document.getElementById("editNama").value,
    no_ktp: document.getElementById("editNoKtp").value,
    alamat: document.getElementById("editAlamat").value,
  };

  // Send PUT request to update the antrian
  fetch(`/dashboard/antrian/update/${id}`, {
    method: 'PUT',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(updatedData),
  })
  .then(response => response.json())
  .then(data => {
    alert(data.message);
    // Close the modal and refresh the data
    var editModal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
    editModal.hide();
    loadPoli('Umum'); // Reload the data for 'Umum' poli
  })
  .catch(error => console.error('Error updating data:', error));
});






    let allData = []; // Variable to hold all data for filtering

    function loadPoli(poli) {
      var poliContent = document.getElementById("poliContent");
      poliContent.innerHTML = "<p>Loading data...</p>"; // Show loading message

      // Using Fetch API to get data from the server
      fetch(`/dashboard/antrian/${poli}`)
        .then(response => response.json())
        .then(data => {
          allData = data; // Store all fetched data

          // Sort data by 'tanggal_daftar'
          data.sort((a, b) => new Date(a.tanggal_daftar) - new Date(b.tanggal_daftar));

          displayData(data);
        })
        .catch(error => {
          poliContent.innerHTML = "<p>An error occurred while loading data.</p>";
          console.error('Error fetching data:', error);
        });
    }

    function displayData(data) {
  let tableRows = data.map((antrian, index) => `
    <tr>
      <td>${antrian.no_antrian}</td>
      <td>${antrian.nama}</td>
      <td>${antrian.no_ktp}</td>
      <td>${antrian.alamat}</td>
      <td>${antrian.poli}</td>
      <td>${antrian.tanggal_daftar}</td>
      <td>${antrian.jenis_kelamin}</td>
      <td>${antrian.no_hp}</td>
      <td>${antrian.tgl_lahir}</td>
      <td>${antrian.pekerjaan}</td>
     <td>
    <div class="btn-group" role="group" aria-label="Action buttons">
        <button class="btn btn-warning" onclick="editAntrian(${antrian.id})">Edit</button>
        <button class="btn btn-danger" onclick="hapusAntrian(${antrian.id})">Hapus</button>
        <button class="btn btn-success" onclick="panggilAntrian(${index + 1}, '${antrian.poli}')">Panggil</button>
    </div>
</td>
<td>
    <!-- Check if Rekam Medis exists -->
    ${antrian.rekam_medis ? `
        <a href="/storage/rekam_medis/${antrian.rekam_medis}" target="_blank" class="btn btn-success btn-sm mt-2">Lihat Rekam Medis</a>
    ` : `
        <p class="text-danger mt-2">Belum ada rekam medis</p>
    `}
</td>

  `).join('');

  const poliContent = document.getElementById("poliContent");
  poliContent.innerHTML = `
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>No. Antrian</th>
          <th>Nama</th>
          <th>No. KTP</th>
          <th>Alamat</th>
          <th>Poli</th>
          <th>Tanggal Daftar</th>
          <th>Jenis Kelamin</th>
          <th>No. HP</th>
          <th>Tanggal Lahir</th>
          <th>Pekerjaan</th>
          <th>Aksi</th>
          <th>Rekam Medis</th> <!-- Kolom baru -->
        </tr>
      </thead>
      <tbody>
        ${tableRows}
      </tbody>
    </table>`;
}


    function filterByDate() {
      const filterDate = document.getElementById("filterDate").value;
      const filteredData = allData.filter(antrian => {
        const tanggalDaftar = new Date(antrian.tanggal_daftar).toISOString().split('T')[0]; // Format to YYYY-MM-DD
        return tanggalDaftar === filterDate;
      });

      displayData(filteredData);
    }


    function hapusAntrian(id) {
      if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
        fetch(`/dashboard/antrian/${id}`, {
    method: 'DELETE',
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}', // Ensure this is passed correctly
        'Content-Type': 'application/json'
    }
})
        .then(response => response.json())
        .then(result => {
          alert(result.message);
          // Refresh data setelah dihapus
          loadPoli('Umum');
        })
        .catch(error => console.error('Error deleting data:', error));
      }
    }

    function editAntrian(id) {
  fetch(`/dashboard/antrian/edit/${id}`)
    .then(response => response.json())
    .then(data => {
      document.getElementById("editNama").value = data.nama;
      document.getElementById("editNoKtp").value = data.no_ktp;
      document.getElementById("editAlamat").value = data.alamat;
        // Set the ID as a data attribute on the form
      document.getElementById("editForm").dataset.id = data.id; // Set the ID on the form
      // Tampilkan modal edit
      var editModal = new bootstrap.Modal(document.getElementById('editModal'));
      editModal.show();
    
    })
    .catch(error => console.error('Error fetching data:', error));
}

    function panggilAntrian(noAntrian, poli) {
    // Call the backend to log the called queue number
    fetch(`/panggil/${noAntrian}`)
        .then(response => response.json())
        .then(data => {
            console.log(data.message); // Log the response message
            playSound(noAntrian, poli); // Call function to play sound with poli
        })
        .catch(error => console.error('Error calling antrian:', error));
}


function playSound(noAntrian, poli) {
    const audioPath = `/assets/audio/${noAntrian}.mp3`; // Path for the queue number sound
    const audioPath2 = `/assets/audio/${poli}.mp3`; // Path for the poli sound

    const audio = new Audio(audioPath);

    // Play the queue sound
    audio.play().then(() => {
        // Set a timeout to play the poli sound after 3 seconds
        setTimeout(() => {
            const audio2 = new Audio(audioPath2);
            audio2.play().catch(error => {
                console.error('Error playing poli sound:', error);
            });
        }, 4000); // 3000 milliseconds = 3 seconds
    }).catch(error => {
        console.error('Error playing queue sound:', error);
    });
}

// ========== AUDIO TEST FUNCTIONS ==========

function showAudioStatus(message, type = 'info') {
  const statusDiv = document.getElementById('audioStatus');
  const statusText = document.getElementById('audioStatusText');

  statusDiv.className = `alert alert-${type}`;
  statusDiv.classList.remove('d-none');
  statusText.textContent = message;

  setTimeout(() => {
    statusDiv.classList.add('d-none');
  }, 5000);
}

function testAudioNomor() {
  const nomor = document.getElementById('testNoAntrian').value;
  const audioPath = `/assets/audio/${nomor}.mp3`;

  showAudioStatus(`Memutar audio nomor ${nomor}...`, 'info');

  const audio = new Audio(audioPath);
  audio.play()
    .then(() => {
      console.log(`Playing test audio: ${audioPath}`);
      showAudioStatus(`Audio nomor ${nomor} berhasil diputar`, 'success');
    })
    .catch(error => {
      console.error('Error playing audio:', error);
      showAudioStatus(`Gagal memutar audio: ${error.message}`, 'danger');
    });
}

function testAudioPoli() {
  const poli = document.getElementById('testPoli').value;
  const audioPath = `/assets/audio/${poli}.mp3`;

  showAudioStatus(`Memutar audio ${poli}...`, 'info');

  const audio = new Audio(audioPath);
  audio.play()
    .then(() => {
      console.log(`Playing test audio: ${audioPath}`);
      showAudioStatus(`Audio ${poli} berhasil diputar`, 'success');
    })
    .catch(error => {
      console.error('Error playing audio:', error);
      showAudioStatus(`Gagal memutar audio: ${error.message}`, 'danger');
    });
}

function testAudioFull() {
  const nomor = document.getElementById('testNoAntrianFull').value;
  const poli = document.getElementById('testPoliFull').value;

  const audioPath1 = `/assets/audio/${nomor}.mp3`;
  const audioPath2 = `/assets/audio/${poli}.mp3`;

  showAudioStatus(`Memutar panggilan lengkap: Nomor ${nomor}, Poli ${poli}...`, 'info');

  const audio1 = new Audio(audioPath1);

  // Play nomor antrian first
  audio1.play()
    .then(() => {
      console.log(`Playing: ${audioPath1}`);

      // Wait for first audio to finish, then play poli audio
      audio1.addEventListener('ended', () => {
        const audio2 = new Audio(audioPath2);
        audio2.play()
          .then(() => {
            console.log(`Playing: ${audioPath2}`);
            showAudioStatus(`Panggilan lengkap berhasil: Nomor ${nomor}, Poli ${poli}`, 'success');
          })
          .catch(error => {
            console.error('Error playing poli audio:', error);
            showAudioStatus(`Gagal memutar audio poli: ${error.message}`, 'danger');
          });
      });
    })
    .catch(error => {
      console.error('Error playing nomor audio:', error);
      showAudioStatus(`Gagal memutar audio nomor: ${error.message}`, 'danger');
    });
}
  </script>
</body>
</html>
