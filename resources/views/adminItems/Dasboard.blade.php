<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - Antrian Online Puskesmas</title>
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
        <a class="nav-link collapsed" href="/dashboard">
          <i class="bx bxs-home"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bx bx-bar-chart-square"></i><span>Daftar Antrian</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
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

      <li class="nav-item">
        <a class="nav-link collapsed" href="/dashboard/laporan/index">
          <i class="bx bx-task"></i>
          <span>Laporan</span>
        </a>
      </li><!-- End laporan Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="/dashboard/laporan/index">
          <i class="bx bx-task"></i>
          <span>Pengumuman</span>
        </a>
      </li><!-- End Pengumuman Nav -->

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

    <!-- Modal untuk Edit Data -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit Data Antrian</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="editForm">
              <div class="mb-3">
                <label for="editNama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="editNama">
              </div>
              <div class="mb-3">
                <label for="editNoKtp" class="form-label">No. KTP</label>
                <input type="text" class="form-control" id="editNoKtp">
              </div>
              <div class="mb-3">
                <label for="editAlamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="editAlamat">
              </div>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
          </div>
        </div>
      </div>
    </div>
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
      // Mengambil data antrian dan menampilkan di modal edit
      fetch(`/dashboard/antrian/edit/${id}`)
        .then(response => response.json())
        .then(data => {
          document.getElementById("editNama").value = data.nama;
          document.getElementById("editNoKtp").value = data.no_ktp;
          document.getElementById("editAlamat").value = data.alamat;
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




  </script>


</body>

</html>
