<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Arsip Antrian - Eklick Dokter</title>
  <meta content="Arsip Antrian Dokter" name="description">

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
    .info-card {
      border-radius: 0.5rem;
      transition: all 0.3s ease;
    }

    .info-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
    }

    .header {
      background: #fff;
      box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
      padding: 0 1.5rem;
      height: 60px;
    }

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

    #main {
      margin-left: 250px;
      margin-top: 60px;
      padding: 2rem;
      min-height: calc(100vh - 60px);
      background: #f6f9ff;
    }

    .footer {
      padding: 1rem 2rem;
      text-align: center;
      color: #6c757d;
      font-size: 0.875rem;
      margin-left: 250px;
    }

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
        <span class="d-none d-lg-block">Eklick Dashboard Dokter</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>

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
        </li>
      </ul>
    </nav>

  </header>

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('dashboardoc') }}">
          <i class="bx bxs-home"></i>
          <span>Dashboard Poli {{ $dokter_poli }}</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link active" href="{{ route('dokter.archive') }}">
          <i class="bi bi-archive"></i>
          <span>Arsip</span>
        </a>
      </li>

    </ul>

  </aside>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Arsip Antrian - Poli {{ $dokter_poli ?? 'Umum' }}</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboardoc') }}">Home</a></li>
          <li class="breadcrumb-item active">Arsip</li>
        </ol>
      </nav>
    </div>

    <!-- Info Alert -->
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <i class="bi bi-info-circle me-2"></i>
      Menampilkan data antrian dengan status <strong>"selesai"</strong> atau <strong>"skip"</strong> yang sudah lebih dari 1 hari.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <section class="section dashboard">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Arsip Antrian Selesai <span>| {{ count($archived_antrian ?? []) }} records</span></h5>

              <!-- Filter Section -->
              <div class="row mb-3">
                <div class="col-md-4">
                  <label for="searchName" class="form-label">Cari Nama Pasien:</label>
                  <input type="text" id="searchName" class="form-control" placeholder="Ketik nama pasien..." onkeyup="filterTable()">
                </div>
                <div class="col-md-3">
                  <label for="filterDate" class="form-label">Filter Tanggal:</label>
                  <input type="date" id="filterDate" class="form-control" onchange="filterTable()">
                </div>
                <div class="col-md-2">
                  <label class="form-label">&nbsp;</label>
                  <button class="btn btn-sm btn-secondary d-block" onclick="clearFilters()">
                    <i class="bi bi-x-circle me-1"></i>Clear
                  </button>
                </div>
              </div>

              <!-- Table -->
              <div class="table-responsive">
                <table class="table table-hover table-striped" id="archiveTable">
                  <thead class="table-primary">
                    <tr>
                      <th>No. Antrian</th>
                      <th>Nama</th>
                      <th>No. KTP</th>
                      <th>Alamat</th>
                      <th>Poli</th>
                      <th>Tanggal Daftar</th>
                      <th>Status</th>
                      <th>Diagnosa</th>
                      <th>Rekam Medis</th>
                      <th>Tanggal Selesai</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody id="archiveTableBody">
                    @forelse($archived_antrian as $antrian)
                      <tr data-name="{{ strtolower($antrian->nama) }}" data-date="{{ $antrian->tanggal_daftar }}">
                        <td><span class="badge bg-secondary fs-6">{{ $antrian->no_antrian }}</span></td>
                        <td><strong>{{ $antrian->nama }}</strong></td>
                        <td>{{ $antrian->no_ktp }}</td>
                        <td>{{ $antrian->alamat }}</td>
                        <td><span class="badge bg-info">{{ $antrian->poli }}</span></td>
                        <td>{{ \Carbon\Carbon::parse($antrian->tanggal_daftar)->format('d M Y') }}</td>
                        <td>
                          @if($antrian->status == 'selesai')
                            <span class="badge bg-success">Selesai</span>
                          @else
                            <span class="badge bg-warning text-dark">Skip</span>
                          @endif
                        </td>
                        <td>
                          <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $antrian->diagnosa ?? '-' }}
                          </div>
                        </td>
                        <td>
                          @if($antrian->rekam_medis)
                            <div class="d-flex flex-column gap-1">
                              <a href="{{ route('rekammedis.view', $antrian->rekam_medis) }}" target="_blank" class="btn btn-info btn-sm">
                                <i class="bi bi-eye me-1"></i>Preview
                              </a>
                              <a href="{{ route('rekammedis.download', $antrian->rekam_medis) }}" class="btn btn-success btn-sm">
                                <i class="bi bi-download me-1"></i>Download
                              </a>
                            </div>
                          @else
                            <span class="text-muted small">Belum ada</span>
                          @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($antrian->updated_at)->format('d M Y H:i') }}</td>
                        <td>
                          @if($antrian->diagnosa)
                            <button class="btn btn-info btn-sm" onclick="lihatDiagnosa({{ $antrian->id }})">
                              <i class="bi bi-eye me-1"></i>Lihat
                            </button>
                          @else
                            <span class="text-muted">-</span>
                          @endif
                        </td>
                      </tr>
                    @empty
                      <tr id="noDataRow">
                        <td colspan="11" class="text-center text-muted py-4">
                          <i class="bi bi-archive fs-1 d-block mb-2"></i>
                          Tidak ada data arsip
                        </td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>

              <!-- Total Count -->
              <div class="mt-3">
                <strong>Total: <span id="totalCount">{{ count($archived_antrian) }}</span> antrian</strong>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section>

  </main>

  <!-- Modal Lihat Diagnosa - Complete Medical Record View -->
  <div class="modal fade" id="lihatDiagnosaModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header bg-info text-white">
          <h5 class="modal-title"><i class="bi bi-file-medical me-2"></i>Rekam Medis Elektronik - Detail Lengkap</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body" style="max-height: 75vh; overflow-y: auto;">

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
                  <div class="mb-2"><strong>Status:</strong> <span id="lihatStatus"></span></div>
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
  </footer>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

  <script>
    // Filter table by name and date
    function filterTable() {
      const searchValue = document.getElementById('searchName').value.toLowerCase();
      const dateValue = document.getElementById('filterDate').value;
      const tbody = document.getElementById('archiveTableBody');
      const rows = tbody.getElementsByTagName('tr');
      let visibleCount = 0;

      for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        if (row.id === 'noDataRow') continue;

        const nameData = row.getAttribute('data-name');
        const dateData = row.getAttribute('data-date');

        let showRow = true;
        if (searchValue && !nameData.includes(searchValue)) showRow = false;
        if (dateValue && dateData !== dateValue) showRow = false;

        row.style.display = showRow ? '' : 'none';
        if (showRow) visibleCount++;
      }

      document.getElementById('totalCount').textContent = visibleCount;
    }

    function clearFilters() {
      document.getElementById('searchName').value = '';
      document.getElementById('filterDate').value = '';
      filterTable();
    }

    function lihatDiagnosa(antrianId) {
      fetch(`/dokter/antrian/${antrianId}/diagnosa`)
        .then(response => response.json())
        .then(data => {
          if (data.error) {
            alert(data.error);
            return;
          }

          document.getElementById('lihatPasienNama').textContent = data.nama || '-';
          document.getElementById('lihatNoRM').textContent = '#' + antrianId.toString().padStart(6, '0');
          document.getElementById('lihatTanggalPeriksa').textContent = data.tanggal_periksa || '-';
          document.getElementById('lihatStatus').textContent = data.status || '-';

          const vitalSignsCard = document.getElementById('lihatVitalSignsCard');
          const vitalSignsContent = document.getElementById('lihatVitalSignsContent');
          const hasVitals = data.tekanan_darah || data.nadi || data.suhu_tubuh || data.tinggi_badan || data.berat_badan;
          
          if (hasVitals) {
            vitalSignsCard.style.display = 'block';
            let vitalHTML = '';
            if (data.tekanan_darah) vitalHTML += `<div class="col-md-3"><small class="text-muted">Tekanan Darah</small><p class="mb-0 fw-bold">${data.tekanan_darah}</p></div>`;
            if (data.nadi) vitalHTML += `<div class="col-md-3"><small class="text-muted">Nadi</small><p class="mb-0 fw-bold">${data.nadi}</p></div>`;
            if (data.suhu_tubuh) vitalHTML += `<div class="col-md-2"><small class="text-muted">Suhu</small><p class="mb-0 fw-bold">${data.suhu_tubuh}</p></div>`;
            if (data.tinggi_badan) vitalHTML += `<div class="col-md-2"><small class="text-muted">Tinggi Badan</small><p class="mb-0 fw-bold">${data.tinggi_badan} cm</p></div>`;
            if (data.berat_badan) vitalHTML += `<div class="col-md-2"><small class="text-muted">Berat Badan</small><p class="mb-0 fw-bold">${data.berat_badan} kg</p></div>`;
            vitalSignsContent.innerHTML = vitalHTML;
          } else {
            vitalSignsCard.style.display = 'none';
          }

          const anamnesaCard = document.getElementById('lihatAnamnesaCard');
          const keluhanSection = document.getElementById('lihatKeluhanUtamaSection');
          const riwayatSection = document.getElementById('lihatRiwayatPenyakitSection');
          
          if (data.keluhan_utama || data.riwayat_penyakit) {
            anamnesaCard.style.display = 'block';
            if (data.keluhan_utama) keluhanSection.innerHTML = `<strong>Keluhan Utama:</strong><div class="border rounded p-3 bg-light mt-1">${data.keluhan_utama}</div>`;
            else keluhanSection.innerHTML = '';
            if (data.riwayat_penyakit) riwayatSection.innerHTML = `<strong class="mt-3 d-block">Riwayat Penyakit:</strong><div class="border rounded p-3 bg-light mt-1">${data.riwayat_penyakit}</div>`;
            else riwayatSection.innerHTML = '';
          } else {
            anamnesaCard.style.display = 'none';
          }

          const examCard = document.getElementById('lihatExamCard');
          const fisikSection = document.getElementById('lihatPemeriksaanFisikSection');
          const labSection = document.getElementById('lihatHasilLabSection');
          
          if (data.pemeriksaan_fisik || data.hasil_lab) {
            examCard.style.display = 'block';
            if (data.pemeriksaan_fisik) fisikSection.innerHTML = `<strong>Pemeriksaan Fisik:</strong><div class="border rounded p-3 bg-light mt-1">${data.pemeriksaan_fisik}</div>`;
            else fisikSection.innerHTML = '';
            if (data.hasil_lab) labSection.innerHTML = `<strong class="mt-3 d-block">Hasil Laboratorium:</strong><div class="border rounded p-3 bg-light mt-1">${data.hasil_lab}</div>`;
            else labSection.innerHTML = '';
          } else {
            examCard.style.display = 'none';
          }

          document.getElementById('lihatDiagnosa').textContent = data.diagnosa || '-';
          
          const tindakanSection = document.getElementById('lihatTindakanMedisSection');
          if (data.tindakan_medis) tindakanSection.innerHTML = `<strong><i class="bi bi-procedures me-2"></i>Tindakan Medis:</strong><div class="border rounded p-3 bg-light mt-2">${data.tindakan_medis}</div>`;
          else tindakanSection.innerHTML = '';

          document.getElementById('lihatResepObat').textContent = data.resep_obat || '-';
          
          const anjuranSection = document.getElementById('lihatAnjuranSection');
          if (data.anjuran) anjuranSection.innerHTML = `<strong><i class="bi bi-info-circle me-2"></i>Anjuran:</strong><div class="border rounded p-3 bg-light mt-2">${data.anjuran}</div>`;
          else anjuranSection.innerHTML = '';

          const catatanSection = document.getElementById('lihatCatatanDokterSection');
          if (data.catatan_dokter) catatanSection.innerHTML = `<strong><i class="bi bi-journal-text me-2"></i>Catatan Dokter:</strong><div class="border rounded p-3 bg-light mt-2">${data.catatan_dokter}</div>`;
          else catatanSection.innerHTML = '';

          const filesCard = document.getElementById('lihatFilesCard');
          const filesContent = document.getElementById('lihatFilesContent');
          const hasFiles = (data.foto_pemeriksaan && data.foto_pemeriksaan.length > 0) || 
                           (data.foto_rontgen && data.foto_rontgen.length > 0) || 
                           (data.file_pendukung && data.file_pendukung.length > 0);
          
          if (hasFiles) {
            filesCard.style.display = 'block';
            let filesHTML = '';
            
            if (data.foto_pemeriksaan && data.foto_pemeriksaan.length > 0) {
              filesHTML += `<h6 class="text-muted mb-2"><i class="bi bi-camera me-1"></i>Foto Pemeriksaan</h6><div class="row g-2 mb-3">`;
              data.foto_pemeriksaan.forEach(foto => {
                filesHTML += `<div class="col-3"><a href="/storage/foto_pemeriksaan/${foto}" target="_blank"><img src="/storage/foto_pemeriksaan/${foto}" class="img-thumbnail" style="max-height: 100px;"></a></div>`;
              });
              filesHTML += `</div>`;
            }
            
            if (data.foto_rontgen && data.foto_rontgen.length > 0) {
              filesHTML += `<h6 class="text-muted mb-2"><i class="bi bi-file-medical me-1"></i>Foto Rontgen</h6><div class="row g-2 mb-3">`;
              data.foto_rontgen.forEach(foto => {
                filesHTML += `<div class="col-3"><a href="/storage/foto_rontgen/${foto}" target="_blank"><img src="/storage/foto_rontgen/${foto}" class="img-thumbnail" style="max-height: 100px;"></a></div>`;
              });
              filesHTML += `</div>`;
            }
            
            if (data.file_pendukung && data.file_pendukung.length > 0) {
              filesHTML += `<h6 class="text-muted mb-2"><i class="bi bi-paperclip me-1"></i>File Pendukung</h6><div class="list-group">`;
              data.file_pendukung.forEach(file => {
                const ext = file.split('.').pop().toLowerCase();
                const icon = ['jpg', 'jpeg', 'png', 'gif'].includes(ext) ? 'bi-image' : ext === 'pdf' ? 'bi-file-pdf' : 'bi-file-earmark';
                filesHTML += `<a href="/storage/file_pendukung/${file}" target="_blank" class="list-group-item list-group-item-action"><i class="bi ${icon} me-2"></i>${file}</a>`;
              });
              filesHTML += `</div>`;
            }
            
            filesContent.innerHTML = filesHTML;
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
  </script>

</body>
</html>
