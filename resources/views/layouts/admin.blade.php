<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>{{ $title ?? 'Admin Dashboard - Klinik PUI' }}</title>
  <meta content="{{ $description ?? 'Admin Dashboard Klinik PUI' }}" name="description">

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

  @stack('styles')
</head>

<body>

  <!-- Header -->
  <x-admin-header :title="$headerTitle ?? 'Eklick Admin'" />

  <!-- Sidebar -->
  <x-admin-sidebar />

  <main id="main" class="main">

    <!-- Page Title -->
    @if(isset($pageTitle))
    <div class="pagetitle">
      <h1>{{ $pageTitle }}</h1>
      <nav>
        <ol class="breadcrumb">
          @if(isset($breadcrumbs))
            @foreach($breadcrumbs as $crumb)
              <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
                @if(!$loop->last && isset($crumb['url']))
                  <a href="{{ $crumb['url'] }}">{{ $crumb['label'] }}</a>
                @else
                  {{ $crumb['label'] ?? $crumb }}
                @endif
              </li>
            @endforeach
          @else
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">{{ $pageTitle }}</li>
          @endif
        </ol>
      </nav>
    </div>
    @endif

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle me-1"></i>
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="bi bi-exclamation-triangle me-1"></i>
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Main Content -->
    {{ $slot }}

  </main><!-- End #main -->

  <!-- Footer -->
  @include('partials.admin-footer')

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/js/main.js') }}"></script>

  @stack('scripts')

</body>
</html>