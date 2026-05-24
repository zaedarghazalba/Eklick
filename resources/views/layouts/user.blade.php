<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>{{ $title ?? 'Eklick - Electronic Klinik' }}</title>
  <meta content="{{ $description ?? 'Sistem Antrian Online Klinik PUI - Daftar online, pantau nomor antrian real-time, layanan kesehatan yang efisien' }}" name="description">
  <meta content="{{ $keywords ?? 'klinik online, antrian online, layanan kesehatan, puskesmas, klinik pui' }}" name="keywords">

  <!-- Favicons -->
  <link href="/assets/img/favicon.png" rel="icon">
  <link href="/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- DNS Prefetch & Preconnect -->
  <link rel="dns-prefetch" href="https://fonts.googleapis.com">
  <link rel="dns-prefetch" href="https://fonts.gstatic.com">
  <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <!-- Critical CSS - Bootstrap for layout -->
  <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Preload Critical CSS -->
  <link rel="preload" href="/assets/css/style.css" as="style">
  <link rel="preload" href="/assets/css/custom-layout.css" as="style">

  <!-- Google Fonts with display swap -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i&display=swap" rel="stylesheet">

  <!-- Template Main CSS Files -->
  <link href="/assets/css/style.css" rel="stylesheet">
  <link href="/assets/css/custom-layout.css" rel="stylesheet">
  <link href="/assets/css/accessibility-fixes.css" rel="stylesheet">

  <!-- Deferred Non-Critical CSS -->
  <link href="/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" media="print" onload="this.media='all'; this.onload=null;">
  <link href="/assets/vendor/animate.css/animate.min.css" rel="stylesheet" media="print" onload="this.media='all'; this.onload=null;">
  <link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" media="print" onload="this.media='all'; this.onload=null;">
  <link href="/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet" media="print" onload="this.media='all'; this.onload=null;">
  <link href="/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet" media="print" onload="this.media='all'; this.onload=null;">
  <link href="/assets/vendor/remixicon/remixicon.css" rel="stylesheet" media="print" onload="this.media='all'; this.onload=null;">
  <link href="/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet" media="print" onload="this.media='all'; this.onload=null;">

  <!-- Fallback for browsers without JS -->
  <noscript>
    <link href="/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="/assets/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  </noscript>

  @stack('styles')
</head>

<body>

  <!-- Top Bar -->
  <x-topbar />

  <!-- Navbar -->
  <x-user-navbar :title="$navTitle ?? 'Electronik Klinik'" :logoutText="$logoutText ?? 'Logout'" />

  <!-- Flash Messages -->
  <x-flash-messages />

  <!-- Main Content -->
  {{ $slot }}

  <!-- Footer -->
  @include('partials.footer')

  <!-- Scroll Top Button -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center" aria-label="Kembali ke atas"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files - Deferred for performance -->
  <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js" defer></script>
  <script src="/assets/vendor/purecounter/purecounter_vanilla.js" defer></script>
  <script src="/assets/vendor/glightbox/js/glightbox.min.js" defer></script>
  <script src="/assets/vendor/swiper/swiper-bundle.min.js" defer></script>
  <script src="/assets/vendor/php-email-form/validate.js" defer></script>

  <!-- Template Main JS File -->
  <script src="/assets/js/main.js" defer></script>

  @stack('scripts')

</body>
</html>
