<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Tentang Kami - Eklick</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/animate.css/animate.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

  <style>
    body {
      padding-top: 140px !important;
    }

    #topbar {
      z-index: 9997 !important;
    }

    #header {
      z-index: 9998 !important;
    }

    .page-header {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      padding: 80px 0;
      color: white;
      margin-top: -140px;
      padding-top: 220px;
    }

    @media (max-width: 992px) {
      body {
        padding-top: 120px !important;
      }

      .page-header {
        margin-top: -120px;
        padding-top: 200px;
      }
    }

    @media (max-width: 768px) {
      body {
        padding-top: 100px !important;
      }

      .page-header {
        margin-top: -100px;
        padding-top: 180px;
      }
    }
  </style>
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

      <h1 class="logo me-auto"><a href="{{ route('home') }}">Electronic Klinik</a></h1>

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a class="nav-link scrollto" href="{{ route('home') }}">Home</a></li>
          <li><a class="nav-link scrollto" href="{{ route('daftarAntrianUser') }}">Antrian</a></li>
          <li><a class="nav-link scrollto active" href="{{ route('patient.about') }}">About</a></li>
          <li><a class="nav-link scrollto" href="{{ route('patient.contact') }}">Contact</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav>

      <a href="{{ route('logout') }}" class="appointment-btn scrollto">Logout</a>

    </div>
  </header>

  <!-- Page Header -->
  <div class="page-header">
    <div class="container">
      <h1>Tentang Electronic Klinik</h1>
      <p class="lead">Pelayanan kesehatan berkualitas dengan sentuhan modern</p>
    </div>
  </div>

  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about section-bg" style="padding: 60px 0;">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <img src="{{ asset('assets/img/about.jpg') }}" class="img-fluid rounded" alt="About EKlick">
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0">
            <h3>Tentang Electronic Klinik (EKlick)</h3>
            <p>
              EKlick adalah klinik modern yang menyediakan layanan kesehatan komprehensif dengan didukung oleh tim medis profesional dan fasilitas kesehatan terkini. Kami berkomitmen untuk memberikan pelayanan kesehatan berkualitas tinggi dengan pendekatan yang ramah dan humanis.
            </p>

            <div class="icon-box mt-4">
              <div class="icon"><i class="bx bx-shield-plus"></i></div>
              <h4 class="title">Fasilitas Modern</h4>
              <p class="description">Dilengkapi dengan peralatan medis modern dan ruang pemeriksaan yang nyaman untuk memberikan diagnosis dan perawatan terbaik bagi pasien.</p>
            </div>

            <div class="icon-box mt-4">
              <div class="icon"><i class="bx bx-user-check"></i></div>
              <h4 class="title">Dokter Profesional</h4>
              <p class="description">Tim dokter spesialis dan umum yang berpengalaman dan berkomitmen memberikan pelayanan kesehatan terbaik untuk Anda dan keluarga.</p>
            </div>

            <div class="icon-box mt-4">
              <div class="icon"><i class="bx bx-calendar-check"></i></div>
              <h4 class="title">Sistem Antrian Online</h4>
              <p class="description">Kemudahan mengambil antrian secara online tanpa perlu menunggu lama di klinik, hemat waktu dan lebih efisien.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ======= Counts Section ======= -->
    <section id="counts" class="counts" style="padding: 60px 0;">
      <div class="container">

        <div class="section-title">
          <h2>Pencapaian Kami</h2>
          <p>EKlick terus berkembang untuk memberikan pelayanan kesehatan terbaik bagi masyarakat</p>
        </div>

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
    </section>

    <!-- ======= Services Section ======= -->
    <section id="services" class="services section-bg" style="padding: 60px 0;">
      <div class="container">

        <div class="section-title">
          <h2>Poli Klinik Kami</h2>
          <p>Klinik Electronic Klinik (EKlick) memiliki 6 poli kesehatan yang siap melayani Anda dengan dokter-dokter profesional dan berpengalaman.</p>
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
    </section>

    <!-- ======= Doctors Section ======= -->
    <section id="doctors" class="doctors" style="padding: 60px 0;">
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
                    $imageNumber = ($index % 4) + 1;
                  @endphp
                  <img src="{{ asset('assets/img/doctors/doctors-' . $imageNumber . '.jpg') }}" class="img-fluid" alt="{{ $doctor->name }}">
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
    </section>

    <!-- ======= CTA Section ======= -->
    <section style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); padding: 80px 0;">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-8">
            <h2 style="color: white; font-size: 36px; font-weight: bold; margin-bottom: 20px;">
              Siap Untuk Konsultasi Kesehatan?
            </h2>
            <p style="color: white; font-size: 20px; margin-bottom: 0;">
              Tim dokter profesional kami siap membantu Anda. Ambil antrian sekarang dan dapatkan pelayanan kesehatan terbaik!
            </p>
          </div>
          <div class="col-lg-4 text-center text-lg-end mt-4 mt-lg-0">
            <a href="{{ route('home') }}#hero" class="btn btn-light btn-lg" style="padding: 15px 40px; font-weight: bold; border-radius: 50px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
              <i class="bi bi-calendar-plus me-2"></i>Ambil Antrian
            </a>
          </div>
        </div>
      </div>
    </section>

  </main>

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
  </footer>

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>
