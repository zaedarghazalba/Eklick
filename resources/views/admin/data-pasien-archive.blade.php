<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Arsip Data Pasien - Admin Dashboard</title>
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
        <a class="nav-link active" href="{{ route('admin.data-pasien.archive') }}">
          <i class="bi bi-archive"></i>
          <span>Arsip Data Pasien</span>
        </a>
      </li>

    </ul>

  </aside>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Arsip Data Pasien</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.data-pasien') }}">Data Pasien</a></li>
          <li class="breadcrumb-item active">Arsip</li>
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

    <section class="section dashboard">
      <div class="row">
        <div class="col-lg-12">

          <!-- Info Alert -->
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="bi bi-info-circle me-2"></i>
            <strong>Arsip:</strong> Menampilkan data pasien dengan status <strong>"selesai"</strong> atau <strong>"skip"</strong> yang sudah lebih dari 1 hari.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>

          <!-- Archived Data Table -->
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Arsip Data Pasien <span>| {{ count($archived) }} Pasien</span></h5>

              <div class="table-responsive">
                <table class="table table-hover table-striped">
                  <thead class="table-primary">
                    <tr>
                      <th>#</th>
                      <th>Nama</th>
                      <th>No. KTP</th>
                      <th>Poli</th>
                      <th>Tanggal Periksa</th>
                      <th>Diagnosa</th>
                      <th>Resep Obat</th>
                      <th>Rekam Medis</th>
                      <th>Status</th>
                      <th>Tanggal Selesai</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($archived as $index => $item)
                      <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $item->nama }}</strong></td>
                        <td>{{ $item->no_ktp }}</td>
                        <td><span class="badge bg-info">{{ $item->poli }}</span></td>
                        <td>{{ $item->tanggal_periksa ? $item->tanggal_periksa->format('d M Y H:i') : '-' }}</td>
                        <td>
                          <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $item->diagnosa }}
                          </div>
                        </td>
                        <td>
                          <div style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $item->resep_obat ?: '-' }}
                          </div>
                        </td>
                        <td>
                          @if($item->rekam_medis)
                            <div class="d-flex gap-1">
                              <a href="{{ route('admin.rekammedis.view', $item->rekam_medis) }}" target="_blank" class="btn btn-sm btn-info" title="Preview">
                                <i class="bi bi-eye"></i>
                              </a>
                              <a href="{{ route('admin.rekammedis.download', $item->rekam_medis) }}" class="btn btn-sm btn-success" title="Download">
                                <i class="bi bi-download"></i>
                              </a>
                            </div>
                          @else
                            <span class="badge bg-secondary">Tidak ada</span>
                          @endif
                        </td>
                        <td>
                          @if($item->status == 'selesai')
                            <span class="badge bg-success">Selesai</span>
                          @else
                            <span class="badge bg-warning text-dark">Skip</span>
                          @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($item->updated_at)->format('d M Y H:i') }}</td>
                        <td>
                          <button class="btn btn-sm btn-info" onclick="lihatDetail({{ $item->id }})">
                            <i class="bi bi-eye"></i> Detail
                          </button>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="11" class="text-center text-muted py-4">
                          <i class="bi bi-archive fs-1 d-block mb-2"></i>
                          Tidak ada data arsip
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

  <!-- Modal Lihat Detail Pasien -->
  <div class="modal fade" id="lihatDetailModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header bg-info text-white">
          <h5 class="modal-title"><i class="bi bi-file-medical me-2"></i>Rekam Medis Elektronik - Detail Lengkap</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body" style="max-height: 75vh; overflow-y: auto;">

          <div class="card mb-3">
            <div class="card-header bg-light">
              <h6 class="mb-0"><i class="bi bi-person-badge me-2"></i>Identitas Pasien</h6>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-2"><strong>Nama:</strong> <span id="lihatNama"></span></div>
                  <div class="mb-2"><strong>No. KTP:</strong> <span id="lihatKTP"></span></div>
                  <div class="mb-2"><strong>Jenis Kelamin:</strong> <span id="lihatJK"></span></div>
                </div>
                <div class="col-md-6">
                  <div class="mb-2"><strong>No. HP:</strong> <span id="lihatHP"></span></div>
                  <div class="mb-2"><strong>Alamat:</strong> <span id="lihatAlamat"></span></div>
                </div>
              </div>
            </div>
          </div>

          <div class="card mb-3">
            <div class="card-header bg-light">
              <h6 class="mb-0"><i class="bi bi-hospital me-2"></i>Informasi Pemeriksaan</h6>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-4"><div class="mb-2"><strong>Poli:</strong> <span id="lihatPoli"></span></div></div>
                <div class="col-md-4"><div class="mb-2"><strong>Tanggal Periksa:</strong> <span id="lihatTanggalPeriksa"></span></div></div>
                <div class="col-md-4"><div class="mb-2"><strong>Status:</strong> <span id="lihatStatus"></span></div></div>
              </div>
            </div>
          </div>

          <div class="card mb-3">
            <div class="card-header bg-light">
              <h6 class="mb-0"><i class="bi bi-file-medical-fill me-2"></i>Diagnosa & Terapi</h6>
            </div>
            <div class="card-body">
              <div class="mb-3">
                <strong><i class="bi bi-file-medical me-2"></i>Diagnosa:</strong>
                <div class="border rounded p-3 bg-light mt-2" id="lihatDiagnosa"></div>
              </div>
              <div class="mb-3">
                <strong><i class="bi bi-capsule me-2"></i>Resep Obat:</strong>
                <pre class="border rounded p-3 bg-light mt-2" style="white-space: pre-wrap;" id="lihatResepObat"></pre>
              </div>
              <div id="lihatCatatanDokterSection"></div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <div id="lihatRekamMedis"></div>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

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
    function lihatDetail(antrianId) {
      fetch(`/admin/antrian/${antrianId}`)
        .then(response => response.json())
        .then(result => {
          if (result.error || !result.success || !result.data) { alert(result.error || 'Data tidak ditemukan'); return; }

          const data = result.data;

          document.getElementById('lihatNama').textContent = data.nama || '-';
          document.getElementById('lihatKTP').textContent = data.no_ktp || '-';
          document.getElementById('lihatHP').textContent = data.no_hp || '-';
          document.getElementById('lihatJK').textContent = data.jenis_kelamin || '-';
          document.getElementById('lihatAlamat').textContent = data.alamat || '-';
          document.getElementById('lihatPoli').textContent = data.poli || '-';

          let tanggalPeriksa = '-';
          if (data.tanggal_periksa) {
            const date = new Date(data.tanggal_periksa);
            tanggalPeriksa = date.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
          }
          document.getElementById('lihatTanggalPeriksa').textContent = tanggalPeriksa;
          document.getElementById('lihatStatus').textContent = data.status || '-';

          document.getElementById('lihatDiagnosa').textContent = data.diagnosa || '-';
          document.getElementById('lihatResepObat').textContent = data.resep_obat || '-';

          const catatanSection = document.getElementById('lihatCatatanDokterSection');
          if (data.catatan_dokter) { catatanSection.innerHTML = `<strong><i class="bi bi-journal-text me-2"></i>Catatan Dokter:</strong><div class="border rounded p-3 bg-light mt-2">${data.catatan_dokter}</div>`; }
          else { catatanSection.innerHTML = ''; }

          if (data.rekam_medis) {
            document.getElementById('lihatRekamMedis').innerHTML =
              '<a href="/admin/rekam-medis/view/' + data.rekam_medis + '" target="_blank" class="btn btn-info me-2"><i class="bi bi-eye me-1"></i>Lihat</a> ' +
              '<a href="/admin/rekam-medis/download/' + data.rekam_medis + '" class="btn btn-success"><i class="bi bi-download me-1"></i>Download</a>';
          } else { document.getElementById('lihatRekamMedis').innerHTML = '<span class="text-muted">Tidak ada rekam medis</span>'; }

          const modal = new bootstrap.Modal(document.getElementById('lihatDetailModal'));
          modal.show();
        })
        .catch(error => { console.error('Error:', error); alert('Terjadi kesalahan saat mengambil data.'); });
    }
  </script>

</body>

</html>
