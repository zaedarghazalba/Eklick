<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Eklick - Electronic Klinik</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- Custom CSS for Fixed Header -->
  <style>
    /* Fix untuk konten tidak tertutup topbar + navbar */
    body {
      padding-top: 140px !important;
      /* Topbar (40px) + Navbar (70px) + Extra (30px) = 140px */
    }

    /* Ensure topbar and header are on top */
    #topbar {
      z-index: 9997 !important;
    }

    #header {
      z-index: 9998 !important;
    }

    /* Flash messages above navbar */
    .alert.fixed-top,
    .alert[style*="position: fixed"] {
      top: 100px !important;
      z-index: 10000 !important;
    }

    /* Main content spacing */
    #main {
      position: relative;
      z-index: 1;
    }

    /* Hero section adjustment */
    #hero {
      margin-top: -140px;
      padding-top: 140px;
      min-height: 100vh;
    }

    /* Section spacing */
    section:not(#hero) {
      margin-top: 0;
    }

    .section-title {
      margin-top: 20px;
    }

    /* Responsive */
    @media (max-width: 992px) {
      body {
        padding-top: 120px !important;
      }

      #hero {
        margin-top: -120px;
        padding-top: 120px;
      }
    }

    @media (max-width: 768px) {
      body {
        padding-top: 100px !important;
      }

      #hero {
        margin-top: -100px;
        padding-top: 100px;
      }
    }
  </style>

  <!-- =======================================================
  * Template Name: Medilab
  * Template URL: https://bootstrapmade.com/medilab-free-medical-bootstrap-theme/
  * Updated: Mar 17 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Top Bar ======= -->
  <div id="topbar" class="d-flex align-items-center fixed-top">
    <div class="container d-flex justify-content-between">
      <div class="contact-info d-flex align-items-center">
        <i class="bi bi-envelope"></i> <a href="mailto:info@electronic-klinik.com">info@electronic-klinik.com</a>
        <i class="bi bi-phone"></i> +62 123 4567 890
      </div>
      <div class="d-none d-lg-flex social-links align-items-center">
        <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
        <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
      </div>
    </div>
  </div>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

      <h1 class="logo me-auto"><a href="index.html">Electronik Klinik</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a class="nav-link scrollto active" href="{{ route('home') }}">Home</a></li>
          <li><a class="nav-link scrollto" href="{{ route('daftarAntrianUser') }}">Antrian</a></li>
          <li><a class="nav-link scrollto" href="{{ route('patient.about') }}">About</a></li>
          <li><a class="nav-link scrollto" href="{{ route('patient.contact') }}">Contact</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

      <a href="/logout" class="appointment-btn scrollto">Logout</a>

    </div>
  </header><!-- End Header -->

  <!-- ======= Flash Messages ======= -->
  @if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 80px; right: 20px; z-index: 9999; min-width: 300px;">
    <i class="bi bi-check-circle-fill me-2"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  @if(session('error'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert" style="position: fixed; top: 80px; right: 20px; z-index: 9999; min-width: 300px;">
    <i class="bi bi-exclamation-triangle-fill me-2"></i>
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  @if($errors->any())
  <div class="alert alert-danger alert-dismissible fade show" role="alert" style="position: fixed; top: 80px; right: 20px; z-index: 9999; min-width: 300px;">
    <i class="bi bi-exclamation-triangle-fill me-2"></i>
    @foreach ($errors->all() as $error)
      {{ $error }}<br>
    @endforeach
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">
    <div class="container">
      {{-- //masukkan if else jika pake sso atau manual --}}
      {{-- <h1>Selamat Datang {{request()->user()->name }}</h1> --}}
      @if(session()->has('sso'))
    <h1>Selamat datang, {{ session('sso')->name }}</h1>
@else
<h1>Selamat Datang {{request()->user()->name }}</h1>
@endif



      {{-- <h1>Selamat Datang {{session('sso')->name }}</h1> --}}
      <h2>Layanan Online dalam pendaftaran sebelum konsultasi dan periksa</h2>
      <p style="font-size: 18px; margin-top: 20px; margin-bottom: 30px;">
        <strong>Ambil antrian online sekarang!</strong> Hemat waktu Anda, hindari antrian panjang, dan dapatkan pelayanan kesehatan lebih cepat.
      </p>
      <button type="button" class="btn-get-started scrollto border-0" data-bs-toggle="modal" data-bs-target="#ambilAntrian" style="margin-right: 15px;">
        <i class="bi bi-calendar-plus me-2"></i>Ambil Antrian Sekarang
      </button>
      <a href="/antrian" class="btn-get-started scrollto">
        <i class="bi bi-clock-history me-2"></i>Cek Kuota Antrian
      </a>
    </div>
  </section><!-- End Hero -->
  <div class="modal fade" id="ambilAntrian" tabindex="-1" aria-labelledby="ambilAntrianLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
        <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px 15px 0 0; padding: 25px;">
          <div>
            <h4 class="modal-title text-white mb-1" id="ambilAntrianLabel">
              <i class="bi bi-calendar-plus me-2"></i>Pendaftaran Antrian Online
            </h4>
            <p class="text-white mb-0" style="font-size: 14px; opacity: 0.9;">Lengkapi data di bawah untuk mendapatkan nomor antrian</p>
          </div>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="padding: 30px;">
          <form id="antrianForm" action="{{ route('antrian.send') }}" method="POST" enctype="multipart/form-data">
              @csrf

              <!-- Info Alert -->
              <div class="alert alert-info d-flex align-items-center mb-4" style="border-radius: 10px; border-left: 4px solid #667eea;">
                <i class="bi bi-info-circle fs-4 me-3"></i>
                <div>
                  <strong>Info:</strong> Pastikan data yang Anda masukkan sudah benar. Nomor antrian akan dikirim setelah pendaftaran berhasil.
                </div>
              </div>

              <!-- Section 1: Pilih Poli & Tanggal -->
              <div class="mb-4">
                <h6 class="text-primary mb-3">
                  <i class="bi bi-hospital me-2"></i>Pilih Layanan
                </h6>
                <div class="row g-3">
                  <div class="col-md-6">
                    <label for="poli" class="form-label">
                      <i class="bi bi-building me-1"></i>Poli <span class="text-danger">*</span>
                    </label>
                    <select class="form-select" id="poli" name="poli" required style="border-radius: 10px; padding: 12px;">
                        <option value="" selected disabled>-- Pilih Poli --</option>
                        <option value="Umum">🩺 Poli Umum</option>
                        <option value="Mata">👁️ Poli Mata</option>
                        <option value="Tht">👂 Poli THT</option>
                        <option value="Ibu Dan Anak">👶 Poli Ibu Dan Anak</option>
                        <option value="Syaraf">🧠 Poli Syaraf</option>
                        <option value="Kulit Dan Kelamin">🩹 Poli Kulit Dan Kelamin</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="tanggal_daftar" class="form-label">
                      <i class="bi bi-calendar-event me-1"></i>Tanggal Kunjungan <span class="text-danger">*</span>
                    </label>
                    <input type="date" class="form-control" id="tanggal_daftar" name="tanggal_daftar" required min="{{ date('Y-m-d') }}" style="border-radius: 10px; padding: 12px;">
                    <small class="text-muted">Pilih tanggal kunjungan Anda</small>
                  </div>
                </div>
              </div>

              <hr style="border-top: 2px dashed #e0e0e0; margin: 25px 0;">

              <!-- Section 2: Data Diri -->
              <div class="mb-4">
                <h6 class="text-primary mb-3">
                  <i class="bi bi-person-circle me-2"></i>Data Diri Pasien
                </h6>
                <div class="row g-3">
                  <div class="col-md-6">
                    <label for="nama" class="form-label">
                      <i class="bi bi-person me-1"></i>Nama Lengkap <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" id="nama" name="nama" required placeholder="Masukkan nama lengkap" style="border-radius: 10px; padding: 12px;">
                  </div>
                  <div class="col-md-6">
                    <label for="no_ktp" class="form-label">
                      <i class="bi bi-credit-card me-1"></i>Nomor KTP <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" id="no_ktp" name="no_ktp" required placeholder="16 digit nomor KTP" maxlength="16" pattern="[0-9]{16}" style="border-radius: 10px; padding: 12px;">
                    <small class="text-muted">Masukkan 16 digit nomor KTP</small>
                  </div>
                  <div class="col-md-6">
                    <label for="jenis_kelamin" class="form-label">
                      <i class="bi bi-gender-ambiguous me-1"></i>Jenis Kelamin <span class="text-danger">*</span>
                    </label>
                    <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required style="border-radius: 10px; padding: 12px;">
                        <option value="" selected disabled>-- Pilih Jenis Kelamin --</option>
                        <option value="Laki Laki">👨 Laki-laki</option>
                        <option value="Perempuan">👩 Perempuan</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="tgl_lahir" class="form-label">
                      <i class="bi bi-calendar-heart me-1"></i>Tanggal Lahir <span class="text-danger">*</span>
                    </label>
                    <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" required max="{{ date('Y-m-d') }}" style="border-radius: 10px; padding: 12px;">
                  </div>
                  <div class="col-md-12">
                    <label for="alamat" class="form-label">
                      <i class="bi bi-geo-alt me-1"></i>Alamat Lengkap <span class="text-danger">*</span>
                    </label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required placeholder="Masukkan alamat lengkap sesuai KTP" style="border-radius: 10px; padding: 12px;"></textarea>
                  </div>
                </div>
              </div>

              <hr style="border-top: 2px dashed #e0e0e0; margin: 25px 0;">

              <!-- Section 3: Kontak -->
              <div class="mb-4">
                <h6 class="text-primary mb-3">
                  <i class="bi bi-telephone me-2"></i>Informasi Kontak
                </h6>
                <div class="row g-3">
                  <div class="col-md-6">
                    <label for="no_hp" class="form-label">
                      <i class="bi bi-phone me-1"></i>Nomor HP/WA <span class="text-danger">*</span>
                    </label>
                    <input type="tel" class="form-control" id="no_hp" name="no_hp" required placeholder="08xxxxxxxxxx" pattern="[0-9]{10,13}" style="border-radius: 10px; padding: 12px;">
                    <small class="text-muted">Nomor yang dapat dihubungi</small>
                  </div>
                  <div class="col-md-6">
                    <label for="pekerjaan" class="form-label">
                      <i class="bi bi-briefcase me-1"></i>Pekerjaan <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" required placeholder="Contoh: Pegawai Swasta" style="border-radius: 10px; padding: 12px;">
                  </div>
                </div>
              </div>

              <div class="modal-footer border-0" style="padding: 20px 0 0 0;">
                  <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal" style="border-radius: 10px; padding: 12px 30px;">
                    <i class="bi bi-x-circle me-2"></i>Batal
                  </button>
                  <button type="submit" class="btn btn-primary btn-lg" style="border-radius: 10px; padding: 12px 30px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                    <i class="bi bi-check-circle me-2"></i>Daftar Antrian
                  </button>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <style>
    /* Custom styling for better form appearance */
    .form-control:focus, .form-select:focus {
      border-color: #667eea;
      box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .form-label {
      font-weight: 600;
      color: #495057;
      margin-bottom: 8px;
    }

    .modal-body {
      max-height: 70vh;
      overflow-y: auto;
    }

    .modal-body::-webkit-scrollbar {
      width: 8px;
    }

    .modal-body::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 10px;
    }

    .modal-body::-webkit-scrollbar-thumb {
      background: #667eea;
      border-radius: 10px;
    }

    .modal-body::-webkit-scrollbar-thumb:hover {
      background: #555;
    }
  </style>
  <main id="main">
    <!-- ======= Services Section ======= -->
    <section id="services" class="services">
      <div class="container">

        <div class="section-title">
          <h2>Poli Klinik Kami</h2>
          <p>
            Klinik Electronic Klinik (EKlick) memiliki 6 poli kesehatan yang siap melayani Anda dengan dokter-dokter profesional dan berpengalaman.
          </p>
        </div>

        <div class="row">
          <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
            <div class="icon-box">
              <div class="icon"><i class="fas fa-heartbeat"></i></div>
              <h4><a href="">Poli Ibu Dan Anak</a></h4>
              <p>Layanan kesehatan untuk ibu hamil, melahirkan, dan kesehatan anak. Termasuk imunisasi, tumbuh kembang anak, dan konsultasi kehamilan.</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0">
            <div class="icon-box">
              <div class="icon"><i class="fas fa-brain"></i></div>
              <h4><a href="">Poli Syaraf</a></h4>
              <p>Layanan pemeriksaan dan pengobatan gangguan sistem saraf seperti stroke, epilepsi, migrain, dan penyakit neurodegeneratif lainnya.</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-lg-0">
            <div class="icon-box">
              <div class="icon"><i class="fas fa-hand-sparkles"></i></div>
              <h4><a href="">Poli Kulit Dan Kelamin</a></h4>
              <p>Pelayanan kesehatan kulit dan kelamin, termasuk perawatan jerawat, eksim, infeksi kulit, dan penyakit menular seksual.</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
            <div class="icon-box">
              <div class="icon"><i class="fas fa-eye"></i></div>
              <h4><a href="">Poli Mata</a></h4>
              <p>Pemeriksaan kesehatan mata, penanganan gangguan penglihatan, katarak, glaukoma, dan penyakit mata lainnya dengan peralatan modern.</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
            <div class="icon-box">
              <div class="icon"><i class="fas fa-ear-listen"></i></div>
              <h4><a href="">Poli THT</a></h4>
              <p>Layanan pemeriksaan dan pengobatan telinga, hidung, dan tenggorokan. Termasuk sinusitis, gangguan pendengaran, dan infeksi THT.</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
            <div class="icon-box">
              <div class="icon"><i class="fas fa-stethoscope"></i></div>
              <h4><a href="">Poli Umum</a></h4>
              <p>Pelayanan kesehatan umum untuk berbagai keluhan seperti demam, flu, hipertensi, diabetes, dan pemeriksaan kesehatan rutin.</p>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Services Section -->

    <!-- ======= CTA Section ======= -->
    <section class="cta-section" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 60px 0;">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-8 text-white">
            <h2 style="color: white; font-size: 32px; font-weight: bold; margin-bottom: 15px;">
              <i class="bi bi-alarm me-2"></i>Jangan Buang Waktu Menunggu!
            </h2>
            <p style="color: white; font-size: 18px; margin-bottom: 0;">
              Ambil antrian online sekarang juga dan dapatkan nomor antrian Anda. Cukup datang 15 menit sebelum giliran Anda dipanggil. Mudah, cepat, dan efisien!
            </p>
          </div>
          <div class="col-lg-4 text-center text-lg-end mt-4 mt-lg-0">
            <button type="button" class="btn btn-light btn-lg" data-bs-toggle="modal" data-bs-target="#ambilAntrian" style="padding: 15px 40px; font-weight: bold; border-radius: 50px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
              <i class="bi bi-calendar-check me-2"></i>Ambil Antrian Gratis
            </button>
          </div>
        </div>
      </div>
    </section><!-- End CTA Section -->

    <!-- ======= Why Us Section ======= -->
    <section id="why-us" class="why-us">
      <div class="container">

        <div class="row">
          <div class="col-lg-4 d-flex align-items-stretch">
            <div class="content">
              <h3>Layanan Kami</h3>
              <p>
                Electronic Klinik (EKlick) berkomitmen memberikan pelayanan kesehatan terbaik dengan fasilitas modern dan tenaga medis profesional.
              </p>
              <p>
                Kami menyediakan berbagai layanan kesehatan untuk memenuhi kebutuhan Anda dan keluarga dengan sistem antrian online yang mudah dan efisien.
              </p>
              <p>
                Untuk informasi lebih lanjut, silakan hubungi kami atau langsung ambil antrian online melalui website ini.
              </p>
            </div>
          </div>
          <div class="col-lg-8 d-flex align-items-stretch mb-4">
            <div class="icon-boxes d-flex flex-column justify-content-center">
              <div class="row">
                <div class="col-xl-4 d-flex align-items-stretch mb-4">
                  <div class="icon-box mt-4 mt-xl-0">
                    <i class="bx bx-conversation"></i>
                    <h4>Konsultasi Kesehatan</h4>
                    <p>Layanan konsultasi kesehatan dengan dokter spesialis dan umum</p>
                  </div>
                </div>
                <div class="col-xl-4 d-flex align-items-stretch mb-4">
                  <div class="icon-box mt-4 mt-xl-0">
                    <i class="bx bx-plus-medical"></i>
                    <h4>Gawat Darurat</h4>
                    <p>Layanan UGD 24 jam untuk penanganan kasus darurat</p>
                  </div>
                </div>
                <div class="col-xl-4 d-flex align-items-stretch mb-4">
                  <div class="icon-box mt-4 mt-xl-0">
                    <i class="bx bx-capsule"></i>
                    <h4>Apotek</h4>
                    <p>Apotek lengkap dengan obat-obatan berkualitas dan farmasis profesional</p>
                  </div>
                </div>
                <div class="col-xl-4 d-flex align-items-stretch mb-4">
                  <div class="icon-box mt-4 mt-xl-0">
                    <i class="bx bx-home-heart"></i>
                    <h4>Home Care</h4>
                    <p>Layanan pemeriksaan kesehatan dan perawatan di rumah pasien</p>
                  </div>
                </div>
                <div class="col-xl-4 d-flex align-items-stretch mb-4">
                  <div class="icon-box mt-4 mt-xl-0">
                    <i class="bx bx-handicap"></i>
                    <h4>Ramah Disabilitas</h4>
                    <p>Fasilitas aksesibilitas untuk penyandang disabilitas</p>
                  </div>
                </div>
                <div class="col-xl-4 d-flex align-items-stretch mb-4">
                  <div class="icon-box mt-4 mt-xl-0">
                    <i class="bx bx-time-five"></i>
                    <h4>Antrian Online</h4>
                    <p>Sistem antrian online untuk kenyamanan pasien</p>
                  </div>
                </div>

              </div>
            </div><!-- End .content-->
          </div>
        </div>

      </div>
    </section><!-- End Why Us Section -->

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container-fluid">

        <div class="row">
          <div class="col-xl-5 col-lg-6 video-box d-flex justify-content-center align-items-stretch position-relative">
            <a href="https://www.youtube.com/watch?v=jDDaplaOz7Q" class="glightbox play-btn mb-4"></a>
          </div>

          <div class="col-xl-7 col-lg-6 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5">
            <h3>Tentang Electronic Klinik (EKlick)</h3>
            <p>EKlick adalah klinik modern yang menyediakan layanan kesehatan komprehensif dengan didukung oleh tim medis profesional dan fasilitas kesehatan terkini. Kami berkomitmen untuk memberikan pelayanan kesehatan berkualitas tinggi dengan pendekatan yang ramah dan humanis.</p>

            <div class="icon-box">
              <div class="icon"><i class="bx bx-shield-plus"></i></div>
              <h4 class="title"><a href="">Fasilitas Modern</a></h4>
              <p class="description">Dilengkapi dengan peralatan medis modern dan ruang pemeriksaan yang nyaman untuk memberikan diagnosis dan perawatan terbaik bagi pasien.</p>
            </div>

            <div class="icon-box">
              <div class="icon"><i class="bx bx-user-check"></i></div>
              <h4 class="title"><a href="">Dokter Profesional</a></h4>
              <p class="description">Tim dokter spesialis dan umum yang berpengalaman dan berkomitmen memberikan pelayanan kesehatan terbaik untuk Anda dan keluarga.</p>
            </div>

            <div class="icon-box">
              <div class="icon"><i class="bx bx-calendar-check"></i></div>
              <h4 class="title"><a href="">Sistem Antrian Online</a></h4>
              <p class="description">Kemudahan mengambil antrian secara online tanpa perlu menunggu lama di klinik, hemat waktu dan lebih efisien.</p>
            </div>

          </div>
        </div>

      </div>
    </section><!-- End About Section -->

    <!-- ======= Counts Section ======= -->
    <section id="counts" class="counts">
      <div class="container">

        <div class="row">

          <div class="col-lg-4 col-md-6">
            <div class="count-box">
              <i class="fas fa-user-md"></i>
              <span data-purecounter-start="0" data-purecounter-end="{{ $totalDoctors ?? 0 }}" data-purecounter-duration="1" class="purecounter"></span>
              <p>Dokter Profesional</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 mt-5 mt-md-0">
            <div class="count-box">
              <i class="far fa-hospital"></i>
              <span data-purecounter-start="0" data-purecounter-end="6" data-purecounter-duration="1" class="purecounter"></span>
              <p>Poli Spesialis</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 mt-5 mt-lg-0">
            <div class="count-box">
              <i class="fas fa-users"></i>
              <span data-purecounter-start="0" data-purecounter-end="{{ $totalPatients ?? 0 }}" data-purecounter-duration="1" class="purecounter"></span>
              <p>Pasien Terdaftar</p>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Counts Section -->

    <!-- ======= Benefits CTA Section ======= -->
    <section style="background-color: #f8f9fa; padding: 60px 0;">
      <div class="container">
        <div class="text-center mb-5">
          <h2 style="font-size: 32px; font-weight: bold; color: #333; margin-bottom: 20px;">
            Kenapa Harus Ambil Antrian Online?
          </h2>
          <p style="font-size: 18px; color: #666;">
            Nikmati berbagai kemudahan dengan sistem antrian online kami
          </p>
        </div>

        <div class="row">
          <div class="col-lg-3 col-md-6 mb-4">
            <div class="text-center p-4" style="background: white; border-radius: 15px; height: 100%; box-shadow: 0 3px 10px rgba(0,0,0,0.1);">
              <div style="font-size: 48px; color: #667eea; margin-bottom: 15px;">
                <i class="bi bi-clock-history"></i>
              </div>
              <h4 style="font-weight: bold; margin-bottom: 10px;">Hemat Waktu</h4>
              <p style="color: #666;">Tidak perlu menunggu lama di klinik. Datang sesuai nomor antrian Anda.</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 mb-4">
            <div class="text-center p-4" style="background: white; border-radius: 15px; height: 100%; box-shadow: 0 3px 10px rgba(0,0,0,0.1);">
              <div style="font-size: 48px; color: #667eea; margin-bottom: 15px;">
                <i class="bi bi-phone"></i>
              </div>
              <h4 style="font-weight: bold; margin-bottom: 10px;">Mudah & Praktis</h4>
              <p style="color: #666;">Ambil antrian kapan saja, dimana saja melalui smartphone Anda.</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 mb-4">
            <div class="text-center p-4" style="background: white; border-radius: 15px; height: 100%; box-shadow: 0 3px 10px rgba(0,0,0,0.1);">
              <div style="font-size: 48px; color: #667eea; margin-bottom: 15px;">
                <i class="bi bi-shield-check"></i>
              </div>
              <h4 style="font-weight: bold; margin-bottom: 10px;">Aman & Nyaman</h4>
              <p style="color: #666;">Hindari kerumunan dan tunggu di tempat yang nyaman.</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 mb-4">
            <div class="text-center p-4" style="background: white; border-radius: 15px; height: 100%; box-shadow: 0 3px 10px rgba(0,0,0,0.1);">
              <div style="font-size: 48px; color: #667eea; margin-bottom: 15px;">
                <i class="bi bi-cash-coin"></i>
              </div>
              <h4 style="font-weight: bold; margin-bottom: 10px;">100% Gratis</h4>
              <p style="color: #666;">Layanan antrian online tanpa biaya tambahan apapun.</p>
            </div>
          </div>
        </div>

        <div class="text-center mt-4">
          <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#ambilAntrian" style="padding: 15px 50px; font-size: 18px; border-radius: 50px;">
            <i class="bi bi-arrow-right-circle me-2"></i>Mulai Ambil Antrian
          </button>
        </div>
      </div>
    </section><!-- End Benefits CTA Section -->

    <!-- ======= Doctors Section ======= -->
    <section id="doctors" class="doctors">
      <div class="container">

        <div class="section-title">
          <h2>Tim Dokter Kami</h2>
          <p>Tim dokter profesional dan berpengalaman di Electronic Klinik siap melayani Anda dengan sepenuh hati. Setiap dokter kami memiliki keahlian khusus di bidangnya untuk memberikan perawatan kesehatan terbaik.</p>
        </div>

        <div class="row">
          @forelse($doctors as $index => $doctor)
            <div class="col-lg-6 {{ $index > 1 ? 'mt-4' : ($index == 1 ? 'mt-4 mt-lg-0' : '') }}">
              <div class="member d-flex align-items-start">
                <div class="pic">
                  @php
                    // Cycle through doctor images
                    $imageNumber = ($index % 4) + 1;
                  @endphp
                  <img src="assets/img/doctors/doctors-{{ $imageNumber }}.jpg" class="img-fluid" alt="{{ $doctor->name }}">
                </div>
                <div class="member-info">
                  <h4>{{ $doctor->name }}</h4>
                  <span>Dokter Spesialis {{ $doctor->poli_spesialisasi }}</span>
                  <p>
                    @switch($doctor->poli_spesialisasi)
                      @case('Umum')
                        Ahli dalam menangani berbagai keluhan kesehatan umum dan penyakit tidak menular.
                        @break
                      @case('Mata')
                        Spesialis dalam mendiagnosis dan merawat gangguan penglihatan dan penyakit mata.
                        @break
                      @case('Tht')
                        Ahli dalam penanganan penyakit telinga, hidung, dan tenggorokan.
                        @break
                      @case('Syaraf')
                        Spesialis dalam menangani gangguan sistem saraf dan penyakit neurologis.
                        @break
                      @case('Balita')
                      @case('Ibu Dan Anak')
                        Spesialis kesehatan ibu, bayi, dan tumbuh kembang anak.
                        @break
                      @case('Kulit')
                      @case('Kulit Dan Kelamin')
                        Ahli dalam perawatan dan pengobatan penyakit kulit dan kelamin.
                        @break
                      @default
                        Dokter profesional yang siap melayani kesehatan Anda dengan sepenuh hati.
                    @endswitch
                  </p>
                  <div class="social">
                    <a href="#"><i class="ri-twitter-fill"></i></a>
                    <a href="#"><i class="ri-facebook-fill"></i></a>
                    <a href="#"><i class="ri-instagram-fill"></i></a>
                    <a href="#"><i class="ri-linkedin-box-fill"></i></a>
                  </div>
                </div>
              </div>
            </div>
          @empty
            <div class="col-12">
              <div class="alert alert-info text-center">
                <i class="bi bi-info-circle me-2"></i>
                Belum ada data dokter yang tersedia. Silakan hubungi admin untuk informasi lebih lanjut.
              </div>
            </div>
          @endforelse
        </div>

      </div>
    </section><!-- End Doctors Section -->

    <!-- ======= Final CTA Section ======= -->
    <section style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); padding: 80px 0;">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-7">
            <h2 style="color: white; font-size: 36px; font-weight: bold; margin-bottom: 20px;">
              Siap Untuk Konsultasi Kesehatan?
            </h2>
            <p style="color: white; font-size: 20px; margin-bottom: 20px;">
              Tim dokter profesional kami siap membantu Anda. Ambil antrian sekarang dan dapatkan pelayanan kesehatan terbaik!
            </p>
            <ul style="color: white; font-size: 16px; list-style: none; padding: 0;">
              <li style="margin-bottom: 10px;"><i class="bi bi-check-circle-fill me-2"></i>Pilih poli sesuai kebutuhan Anda</li>
              <li style="margin-bottom: 10px;"><i class="bi bi-check-circle-fill me-2"></i>Tentukan tanggal kunjungan</li>
              <li style="margin-bottom: 10px;"><i class="bi bi-check-circle-fill me-2"></i>Dapatkan nomor antrian instant</li>
              <li style="margin-bottom: 10px;"><i class="bi bi-check-circle-fill me-2"></i>Datang sesuai jadwal tanpa mengantri</li>
            </ul>
          </div>
          <div class="col-lg-5 text-center mt-4 mt-lg-0">
            <div style="background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
              <h3 style="color: #333; font-weight: bold; margin-bottom: 20px;">Ambil Antrian Online</h3>
              <p style="color: #666; margin-bottom: 25px;">Gratis, cepat, dan mudah!</p>
              <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="modal" data-bs-target="#ambilAntrian" style="padding: 15px; font-size: 20px; font-weight: bold; border-radius: 50px; margin-bottom: 15px;">
                <i class="bi bi-calendar-plus me-2"></i>Ambil Antrian Sekarang
              </button>
              <a href="/antrianmu" class="btn btn-outline-secondary w-100" style="padding: 12px; border-radius: 50px;">
                <i class="bi bi-list-check me-2"></i>Lihat Antrian Saya
              </a>
            </div>
          </div>
        </div>
      </div>
    </section><!-- End Final CTA Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container">

        <div class="section-title">
          <h2>Hubungi Kami</h2>
          <p>Untuk informasi lebih lanjut tentang layanan kami atau untuk membuat janji konsultasi, jangan ragu untuk menghubungi kami. Tim kami siap membantu Anda dengan ramah dan profesional.</p>
        </div>
      <div class="container">
        <div class="row mt-5">

          <div class="col-lg-4">
            <div class="info">
              <div class="address">
                <i class="bi bi-geo-alt"></i>
                <h4>Lokasi:</h4>
                <p>Jl. Sudirman No. 10, Palembang, Indonesia</p>
              </div>

              <div class="email">
                <i class="bi bi-envelope"></i>
                <h4>Email:</h4>
                <p>info@electronic-klinik.com</p>
              </div>

              <div class="phone">
                <i class="bi bi-phone"></i>
                <h4>Telepon:</h4>
                <p>+62 123 4567 890</p>
              </div>

              <div class="mt-4">
                <i class="bi bi-clock"></i>
                <h4>Jam Operasional:</h4>
                <p>Senin - Jumat: 08:00 - 20:00<br>
                Sabtu: 08:00 - 16:00<br>
                Minggu & Hari Libur: Tutup<br>
                <strong>UGD 24 Jam</strong></p>
              </div>

            </div>

          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->

 <!-- ======= Footer ======= -->
 <footer id="footer">
  <div class="footer-top">
      <div class="container">
          <div class="row">
              <div class="col-lg-3 col-md-6 footer-contact">
                  <h3>Electronic Klinik</h3>
                  <p>
                      Jl. Sudirman No. 10<br>
                      Palembang, Indonesia<br><br>
                      <strong>Phone:</strong> +62 123 4567 890<br>
                      <strong>Email:</strong> info@electronic-klinik.com<br>
                  </p>
              </div>
          </div>
      </div>
  </div>
  <div class="container py-4">
      <div class="text-center">
          &copy; Copyright <strong><span>Electronic Klinik</span></strong>. All Rights Reserved
      </div>
  </div>
</footer><!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  <!-- Auto-hide alerts after 5 seconds -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const alerts = document.querySelectorAll('.alert');
      alerts.forEach(function(alert) {
        setTimeout(function() {
          const bsAlert = new bootstrap.Alert(alert);
          bsAlert.close();
        }, 5000); // 5000ms = 5 seconds
      });
    });
  </script>

</body>

</html>