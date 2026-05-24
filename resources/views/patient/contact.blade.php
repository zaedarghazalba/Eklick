<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Hubungi Kami - Eklick</title>
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
          <li><a class="nav-link scrollto" href="{{ route('patient.about') }}">About</a></li>
          <li><a class="nav-link scrollto active" href="{{ route('patient.contact') }}">Contact</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav>

      <a href="{{ route('logout') }}" class="appointment-btn scrollto">Logout</a>

    </div>
  </header>

  <!-- Page Header -->
  <div class="page-header">
    <div class="container">
      <h1>Hubungi Kami</h1>
      <p class="lead">Kami siap melayani Anda dengan ramah dan profesional</p>
    </div>
  </div>

  <main id="main">

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact" style="padding: 60px 0;">
      <div class="container">

        <div class="section-title">
          <h2>Informasi Kontak</h2>
          <p>Untuk informasi lebih lanjut tentang layanan kami atau untuk membuat janji konsultasi, jangan ragu untuk menghubungi kami. Tim kami siap membantu Anda dengan ramah dan profesional.</p>
        </div>

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
                <p>
                  <strong>Senin - Jumat:</strong> 08:00 - 20:00<br>
                  <strong>Sabtu:</strong> 08:00 - 16:00<br>
                  <strong>Minggu & Hari Libur:</strong> Tutup<br><br>
                  <span class="badge bg-success" style="font-size: 14px;">UGD 24 Jam</span>
                </p>
              </div>

            </div>

          </div>

          <div class="col-lg-8 mt-5 mt-lg-0">
            <div class="info">
              <h4 style="margin-bottom: 20px;">
                <i class="bi bi-calendar-plus me-2"></i>Ambil Antrian Online
              </h4>
              <p style="font-size: 16px; line-height: 1.8; margin-bottom: 30px;">
                Untuk kenyamanan Anda, kami menyediakan sistem antrian online. Ambil antrian sekarang dan hindari antrian panjang di klinik!
              </p>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <div class="card h-100" style="border: 2px solid #667eea; border-radius: 10px;">
                    <div class="card-body text-center">
                      <i class="bi bi-clock-history" style="font-size: 48px; color: #667eea;"></i>
                      <h5 class="mt-3">Hemat Waktu</h5>
                      <p>Tidak perlu menunggu lama di klinik</p>
                    </div>
                  </div>
                </div>

                <div class="col-md-6 mb-3">
                  <div class="card h-100" style="border: 2px solid #667eea; border-radius: 10px;">
                    <div class="card-body text-center">
                      <i class="bi bi-phone" style="font-size: 48px; color: #667eea;"></i>
                      <h5 class="mt-3">Mudah & Praktis</h5>
                      <p>Ambil antrian kapan saja, dimana saja</p>
                    </div>
                  </div>
                </div>

                <div class="col-md-6 mb-3">
                  <div class="card h-100" style="border: 2px solid #667eea; border-radius: 10px;">
                    <div class="card-body text-center">
                      <i class="bi bi-shield-check" style="font-size: 48px; color: #667eea;"></i>
                      <h5 class="mt-3">Aman & Nyaman</h5>
                      <p>Hindari kerumunan di ruang tunggu</p>
                    </div>
                  </div>
                </div>

                <div class="col-md-6 mb-3">
                  <div class="card h-100" style="border: 2px solid #667eea; border-radius: 10px;">
                    <div class="card-body text-center">
                      <i class="bi bi-cash-coin" style="font-size: 48px; color: #667eea;"></i>
                      <h5 class="mt-3">100% Gratis</h5>
                      <p>Tanpa biaya tambahan apapun</p>
                    </div>
                  </div>
                </div>
              </div>

              <div class="text-center mt-4">
                <a href="{{ route('home') }}#hero" class="btn btn-primary btn-lg" style="padding: 15px 50px; font-size: 18px; border-radius: 50px;">
                  <i class="bi bi-calendar-check me-2"></i>Ambil Antrian Sekarang
                </a>
              </div>
            </div>
          </div>

        </div>

      </div>
    </section>

    <!-- ======= Map Section (Optional) ======= -->
    <section class="map-section" style="padding: 0;">
      <div class="container-fluid p-0">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.266827935947!2d104.74571931475394!3d-2.9760683977216447!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e3b75f8fc327055%3A0x30217206b8d2930!2sJl.%20Jenderal%20Sudirman%2C%20Palembang%2C%20Sumatera%20Selatan!5e0!3m2!1sen!2sid!4v1234567890123"
          width="100%"
          height="350"
          style="border:0;"
          allowfullscreen=""
          loading="lazy">
        </iframe>
      </div>
    </section>

    <!-- ======= FAQ Section ======= -->
    <section class="faq-section section-bg" style="padding: 60px 0;">
      <div class="container">
        <div class="section-title">
          <h2>Pertanyaan yang Sering Diajukan</h2>
          <p>Temukan jawaban atas pertanyaan umum seputar layanan kami</p>
        </div>

        <div class="row">
          <div class="col-lg-8 offset-lg-2">
            <div class="accordion" id="faqAccordion">

              <div class="accordion-item">
                <h2 class="accordion-header" id="faq1">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                    Bagaimana cara mengambil antrian online?
                  </button>
                </h2>
                <div id="collapse1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                    Klik tombol "Ambil Antrian" di halaman utama, pilih poli yang diinginkan, tentukan tanggal kunjungan, dan isi data diri Anda. Anda akan langsung mendapatkan nomor antrian.
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header" id="faq2">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                    Apakah ada biaya untuk antrian online?
                  </button>
                </h2>
                <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                    Tidak ada biaya untuk menggunakan layanan antrian online kami. Layanan ini 100% gratis untuk semua pasien.
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header" id="faq3">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                    Kapan saya harus datang ke klinik?
                  </button>
                </h2>
                <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                    Anda bisa datang 15-30 menit sebelum nomor antrian Anda dipanggil. Anda dapat memantau antrian melalui halaman "Antrian Saya" di website kami.
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header" id="faq4">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4">
                    Apakah bisa membatalkan antrian?
                  </button>
                </h2>
                <div id="collapse4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                    Ya, Anda dapat membatalkan antrian dengan menghubungi kami melalui telepon atau datang langsung ke klinik. Untuk pembatalan melalui website, hubungi customer service kami.
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header" id="faq5">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5">
                    Apa saja poli yang tersedia?
                  </button>
                </h2>
                <div id="collapse5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                    Kami memiliki 6 poli spesialis: Poli Umum, Poli Mata, Poli THT, Poli Syaraf, Poli Ibu dan Anak, serta Poli Kulit dan Kelamin.
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ======= CTA Section ======= -->
    <section style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); padding: 60px 0;">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-8 text-white">
            <h2 style="color: white; font-size: 32px; font-weight: bold; margin-bottom: 15px;">
              <i class="bi bi-headset me-2"></i>Butuh Bantuan?
            </h2>
            <p style="color: white; font-size: 18px; margin-bottom: 0;">
              Tim customer service kami siap membantu Anda. Hubungi kami melalui telepon atau email untuk informasi lebih lanjut.
            </p>
          </div>
          <div class="col-lg-4 text-center text-lg-end mt-4 mt-lg-0">
            <a href="tel:+62123456890" class="btn btn-light btn-lg" style="padding: 15px 40px; font-weight: bold; border-radius: 50px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
              <i class="bi bi-telephone-fill me-2"></i>Hubungi Kami
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
