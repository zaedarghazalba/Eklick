<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Kelola Antrian - Admin Dashboard</title>
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
    .skipped-row { background-color: #fff3cd; }
    .calling-row { background-color: #d1ecf1; animation: pulse-calling 1.5s ease-in-out infinite; }
    @keyframes pulse-calling { 0%, 100% { opacity: 1; } 50% { opacity: 0.7; } }
    .btn-calling { position: relative; pointer-events: none; }
    .btn-calling::after { content: ''; position: absolute; width: 16px; height: 16px; top: 50%; left: 50%; margin-left: -8px; margin-top: -8px; border: 2px solid #fff; border-radius: 50%; border-top-color: transparent; animation: spinner 0.6s linear infinite; }
    @keyframes spinner { to { transform: rotate(360deg); } }
    @media (max-width: 991.98px) { .sidebar { transform: translateX(-100%); } .sidebar.active { transform: translateX(0); } #main, .footer { margin-left: 0; } .toggle-sidebar-btn { display: block !important; } }
    @media (min-width: 992px) { .toggle-sidebar-btn { display: none; } }
    @media (min-width: 1200px) { .table-wrapper { max-width: 100%; } }
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
        <a class="nav-link active" href="{{ route('admin.antrian') }}">
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
      <h1>Kelola Antrian</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Kelola Antrian</li>
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

          <!-- Filter Section -->
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Filter Antrian</h5>

              <form method="GET" action="{{ route('admin.antrian') }}" class="row g-3">
                <div class="col-md-3">
                  <label for="poli" class="form-label">Poli</label>
                  <select class="form-select" id="poli" name="poli">
                    <option value="">Semua Poli</option>
                    <option value="Umum" {{ request('poli') == 'Umum' ? 'selected' : '' }}>Poli Umum</option>
                    <option value="Tht" {{ request('poli') == 'Tht' ? 'selected' : '' }}>Poli THT</option>
                    <option value="Syaraf" {{ request('poli') == 'Syaraf' ? 'selected' : '' }}>Poli Syaraf</option>
                    <option value="Balita" {{ request('poli') == 'Balita' ? 'selected' : '' }}>Poli Balita</option>
                    <option value="Kulit" {{ request('poli') == 'Kulit' ? 'selected' : '' }}>Poli Kulit dan Kelamin</option>
                    <option value="Mata" {{ request('poli') == 'Mata' ? 'selected' : '' }}>Poli Mata</option>
                  </select>
                </div>

                <div class="col-md-3">
                  <label for="tanggal" class="form-label">Tanggal</label>
                  <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ request('tanggal') }}">
                </div>

                <div class="col-md-3">
                  <label for="status" class="form-label">Status</label>
                  <select class="form-select" id="status" name="status">
                    <option value="">Semua Status</option>
                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="dipanggil" {{ request('status') == 'dipanggil' ? 'selected' : '' }}>Dipanggil</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                  </select>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                  <button type="submit" class="btn btn-primary me-2"><i class="bi bi-search me-1"></i>Filter</button>
                  <a href="{{ route('admin.antrian') }}" class="btn btn-secondary"><i class="bi bi-x-circle me-1"></i>Reset</a>
                </div>
              </form>

            </div>
          </div>

          <!-- Antrian Table -->
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Daftar Antrian <span>| {{ count($antrian) }} antrian</span></h5>

              <div class="table-wrapper">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th style="width: 90px;">No. Antrian</th>
                      <th>Nama Pasien</th>
                      <th style="width: 100px;">Poli</th>
                      <th style="width: 100px;">Tanggal</th>
                      <th style="width: 90px;">Status</th>
                      <th style="width: 80px;">Dipanggil</th>
                      <th style="width: 180px;">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($antrian as $item)
                      <tr class="{{ $item->skipped ? 'skipped-row' : '' }}">
                        <td><span class="badge bg-primary">#{{ $item->no_antrian }}</span></td>
                        <td>
                          <div class="fw-semibold">{{ $item->nama }}</div>
                          @if($item->skipped)
                            <span class="badge bg-warning text-dark">Skipped</span>
                          @endif
                        </td>
                        <td><span class="badge bg-info">{{ $item->poli }}</span></td>
                        <td class="text-nowrap small">{{ \Carbon\Carbon::parse($item->tanggal_daftar)->format('d M Y') }}</td>
                        <td>
                          @if($item->status == 'menunggu')
                            <span class="badge bg-warning text-dark">Menunggu</span>
                          @elseif($item->status == 'dipanggil')
                            <span class="badge bg-info">Dipanggil</span>
                          @else
                            <span class="badge bg-success">Selesai</span>
                          @endif
                        </td>
                        <td class="text-nowrap small">{{ $item->dipanggil_at ? $item->dipanggil_at->format('H:i') : '-' }}</td>
                        <td>
                          @if($item->status !== 'selesai')
                            <div class="action-group">
                              @if($item->status !== 'dipanggil')
                                <button type="button" class="action-btn btn-success" id="btn-panggil-{{ $item->id }}" onclick="panggilAntrian({{ $item->id }})" title="Panggil">
                                  <i class="bi bi-megaphone-fill"></i>
                                </button>
                              @endif

                              @if($item->status == 'dipanggil')
                                <button type="button" class="action-btn btn-primary" onclick="selesaiAntrian({{ $item->id }})" title="Selesai">
                                  <i class="bi bi-check-circle-fill"></i>
                                </button>
                              @endif

                              <button type="button" class="action-btn btn-warning" onclick="skipAntrian({{ $item->id }})" title="Skip">
                                <i class="bi bi-skip-forward-fill"></i>
                              </button>

                              <button type="button" class="action-btn btn-secondary" onclick="resetAntrian({{ $item->id }})" title="Reset">
                                <i class="bi bi-arrow-clockwise"></i>
                              </button>

                              <button type="button" class="action-btn btn-delete" onclick="deleteAntrian({{ $item->id }})" title="Hapus">
                                <i class="bi bi-trash-fill"></i>
                              </button>
                            </div>
                          @else
                            <span class="text-muted small"><i class="bi bi-check-circle me-1"></i>Selesai</span>
                          @endif
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                          <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                          Tidak ada antrian
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
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function panggilAntrian(id) {
      const btn = document.getElementById(`btn-panggil-${id}`);
      const row = btn.closest('tr');

      btn.classList.add('btn-calling');
      btn.innerHTML = '<i class="bi bi-megaphone-fill"></i> Memanggil...';
      row.classList.add('calling-row');

      fetch(`/admin/antrian/${id}`, { method: 'GET', headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json' } })
      .then(response => response.json())
      .then(result => {
        if (!result.data) { alert('Data antrian tidak ditemukan'); btn.classList.remove('btn-calling'); row.classList.remove('calling-row'); btn.innerHTML = '<i class="bi bi-megaphone"></i> Panggil'; return; }

        const antrianData = result.data;

        return fetch(`/admin/antrian/${id}/panggil`, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json' } })
          .then(response => response.json())
          .then(data => {
            if (data.message) {
              playSound(antrianData.no_antrian, antrianData.poli, antrianData.nama);
              showNotification(`Memanggil antrian #${antrianData.no_antrian} - ${antrianData.nama}`);
              setTimeout(() => { location.reload(); }, 8000);
            } else if (data.error) { alert(data.error); btn.classList.remove('btn-calling'); row.classList.remove('calling-row'); btn.innerHTML = '<i class="bi bi-megaphone"></i> Panggil'; }
          });
      })
      .catch(error => { console.error('Error:', error); alert('Terjadi kesalahan.'); btn.classList.remove('btn-calling'); row.classList.remove('calling-row'); btn.innerHTML = '<i class="bi bi-megaphone"></i> Panggil'; });
    }

    function playSound(noAntrian, poli, namaPasien) {
      const poliAudioMap = { 'Umum': 'Umum', 'Mata': 'Mata', 'THT': 'Tht', 'Tht': 'Tht', 'Syaraf': 'Syaraf', 'Balita': 'Balita', 'Ibu Dan Anak': 'Balita', 'Kulit': 'Kulit', 'Kulit dan Kelamin': 'Kulit' };
      const nomorAudio = parseInt(noAntrian);
      if (nomorAudio < 1 || nomorAudio > 15) { console.error(`Nomor antrian ${nomorAudio} tidak memiliki file audio`); alert(`Audio untuk nomor antrian ${nomorAudio} tidak tersedia. Hanya tersedia untuk nomor 1-15.`); return; }
      const poliAudioName = poliAudioMap[poli] || 'Umum';
      const audioPath = `/assets/audio/${nomorAudio}.mp3`;
      const audioPath2 = `/assets/audio/${poliAudioName}.mp3`;

      const audio = new Audio(audioPath);
      audio.play().then(() => {
        audio.addEventListener('ended', () => {
          const audio2 = new Audio(audioPath2);
          audio2.play().catch(error => { console.error('Error playing poli sound:', error); });
        });
      }).catch(error => { console.error('Error playing queue sound:', error); alert(`File audio tidak ditemukan: ${audioPath}`); });
    }

    function showNotification(message) {
      const notification = document.createElement('div');
      notification.className = 'alert alert-info alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3';
      notification.style.zIndex = '9999';
      notification.innerHTML = `<i class="bi bi-megaphone-fill me-2"></i><strong>${message}</strong><button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
      document.body.appendChild(notification);
      setTimeout(() => { notification.remove(); }, 7000);
    }

    function skipAntrian(id) {
      if (confirm('Skip antrian ini?')) {
        fetch(`/admin/antrian/${id}/skip`, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json' } })
        .then(response => response.json()).then(data => { if (data.message) { alert(data.message); location.reload(); } else if (data.error) { alert(data.error); } })
        .catch(error => { console.error('Error:', error); alert('Terjadi kesalahan.'); });
      }
    }

    function selesaiAntrian(id) {
      if (confirm('Tandai antrian ini sebagai selesai?')) {
        fetch(`/admin/antrian/${id}/selesai`, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json' } })
        .then(response => response.json()).then(data => { if (data.message) { alert(data.message); location.reload(); } else if (data.error) { alert(data.error); } })
        .catch(error => { console.error('Error:', error); alert('Terjadi kesalahan.'); });
      }
    }

    function resetAntrian(id) {
      if (confirm('Reset status antrian ini ke menunggu?')) {
        fetch(`/admin/antrian/${id}/reset`, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json' } })
        .then(response => response.json()).then(data => { if (data.message) { alert(data.message); location.reload(); } else if (data.error) { alert(data.error); } })
        .catch(error => { console.error('Error:', error); alert('Terjadi kesalahan.'); });
      }
    }

    function deleteAntrian(id) {
      if (confirm('Apakah Anda yakin ingin menghapus antrian ini?')) {
        fetch(`/admin/antrian/${id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json' } })
        .then(response => response.json()).then(data => { if (data.message) { alert(data.message); location.reload(); } else if (data.error) { alert(data.error); } })
        .catch(error => { console.error('Error:', error); alert('Terjadi kesalahan.'); });
      }
    }
  </script>

</body>

</html>
