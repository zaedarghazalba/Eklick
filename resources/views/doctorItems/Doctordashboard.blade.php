<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard Dokter - Antrian Online Puskesmas</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="Dasboardassets/img/eklick.png" rel="icon">
  <link href="Dasboardassets/img/eklick.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="Dasboardassets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="Dasboardassets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="Dasboardassets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="Dasboardassets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="Dasboardassets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="Dasboardassets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="Dasboardassets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="Dasboardassets/css/style.css" rel="stylesheet">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="Dasboardassets/img/eklick.png" alt="">
        <span class="d-none d-lg-block">Eklick Dasboard</span>
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
          <span>Admin</span>
          <li>
            <a class="dropdown-item d-flex align-items-center" href="/admin">
              <i class="bi bi-box-arrow-right"></i>
              <span>Sign Out</span>
            </a>
          </li>
        </li><!-- End Profile Nav -->
      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed" href="/dashboardoc">
          <i class="bx bxs-home"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="javascript:void(0)">
            <i class="bx bx-bar-chart-square"></i><span>Daftar Antrian</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
            <li>
                <a href="javascript:void(0)" id="Umum" onclick="loadPoli('Umum')">
                    <i class="bi bi-circle"></i><span>Poli Umum</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0)" id="Tht" onclick="loadPoli('Tht')">
                    <i class="bi bi-circle"></i><span>Poli THT</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0)" id="Syaraf" onclick="loadPoli('Syaraf')">
                    <i class="bi bi-circle"></i><span>Poli Syaraf</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0)" id="Balita" onclick="loadPoli('Balita')">
                    <i class="bi bi-circle"></i><span>Poli Balita</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0)" id="Kulit" onclick="loadPoli('Kulit')">
                    <i class="bi bi-circle"></i><span>Poli Kulit dan Kelamin</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0)" id="Mata" onclick="loadPoli('Mata')">
                    <i class="bi bi-circle"></i><span>Poli Mata</span>
                </a>
            </li>
        </ul>
    </li><!-- End Components Nav -->
    

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
     <!-- Date Filter Section -->
     <div class="date-filter mt-3">
      <label for="filterDate" class="form-label">Filter by Date:</label>
      <input type="date" id="filterDate" class="form-control" onchange="filterByDate()">
    </div>

    <!-- Tambahkan tempat untuk menampilkan data poli -->
    <div id="poliData" class="container mt-5">
      <h3>Data Poli yang Dipilih:</h3>
      <div id="poliContent">
        <p>Silakan pilih poli dari menu di sebelah untuk melihat data antrian.</p>
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
  <script src="Dasboardassets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="Dasboardassets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="Dasboardassets/vendor/chart.js/chart.umd.js"></script>
  <script src="Dasboardassets/vendor/echarts/echarts.min.js"></script>
  <script src="Dasboardassets/vendor/quill/quill.js"></script>
  <script src="Dasboardassets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="Dasboardassets/vendor/tinymce/tinymce.min.js"></script>
  <script src="Dasboardassets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="Dasboardassets/js/main.js"></script>

  
  <script>
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
      // Tambahkan console.log untuk memeriksa nilai rekam_medis
    data.forEach(antrian => {
        console.log(`ID Antrian: ${antrian.id}, Rekam Medis: ${antrian.rekam_medis}`);
    });
    let tableRows = data.map((antrian, index) => `
        <tr>
          <td>${index + 1}</td>
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
           <!-- Upload Rekam Medis Form -->
          <form action="/antrian/${antrian.id}/upload-rekam-medis" method="POST" enctype="multipart/form-data">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="form-group">
                  <input type="file" name="rekam_medis" class="form-control" required>
              </div>
              <button type="submit" class="btn btn-warning btn-sm mt-2">Unggah Rekam Medis</button>
          </form>

          <!-- Check if Rekam Medis exists -->
          ${antrian.rekam_medis ? `
              <a href="/storage/rekam_medis/${antrian.rekam_medis}" target="_blank" class="btn btn-success btn-sm mt-2">Lihat Rekam Medis</a>
          ` : `
              <p class="text-danger mt-2">Belum ada rekam medis</p>
          `}

          </td>
        </tr>
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


    // Check for session flash messages
    @if (session('success'))
        console.log("{{ session('success') }}"); // Log success message
    @endif

    @if (session('error'))
        console.log("{{ session('error') }}"); // Log error message
    @endif
  </script>
</body>

</html>
