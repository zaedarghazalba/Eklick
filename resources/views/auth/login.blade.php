<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Pages / Login - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- SweetAlert2 -->
  <style>
    body {
        background-image: url('{{ asset('assets/img/hero-bg.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 100vh;
    }

    .section.register {
        position: relative;
        z-index: 2;
    }
</style>

</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your email & password to login</p>
                  </div>

                  @isset($errors)
                  @if($errors->any())
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $errors->first() }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                  @endif
                  @endisset

                  @if(session('error'))
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                  @endif

                  @if(session('success'))
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                  @endif
                
                  <form class="row g-3 needs-validation" action="{{ route('login') }}" method="POST">
                    @csrf <!-- Laravel CSRF Protection -->
                    <div class="col-12">
                        <label for="yourEmail" class="form-label">Email</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                            <input type="email" name="email" class="form-control" id="yourEmail" value="{{ old('email') }}" required>
                            <div class="invalid-feedback">Please enter a valid email.</div>
                        </div>
                    </div>
                
                    <div class="col-12">
                        <label for="yourPassword" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="yourPassword" required>
                        <div class="invalid-feedback">Please enter your password!</div>
                    </div>
                
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                            <label class="form-check-label" for="rememberMe">Remember me</label>
                        </div>
                    </div>
                
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </div>
                
                    <div class="col-12">
                        <p class="small mb-0">Don't have an account? <a href="{{ route('register') }}">Create an account</a></p>
                    </div>
                </form>

                  <!-- Demo Accounts Section -->
                  <div class="col-12 mt-4">
                    <div class="card border-primary border-2">
                      <div class="card-body p-3">
                        <h6 class="card-title text-center mb-3">
                          <i class="bi bi-play-circle-fill text-primary me-1"></i>
                          <span class="text-primary">Demo Accounts</span>
                        </h6>
                        <p class="text-muted small text-center mb-3">Klik untuk login otomatis (tanpa password)</p>
                        
                        <div class="d-grid gap-2">
                          <button type="button" class="btn btn-outline-primary btn-sm" onclick="demoLogin('admin@example.com', 'password')">
                            <i class="bi bi-shield-lock-fill me-2"></i>
                            <strong>Admin</strong>
                            <span class="text-muted ms-2">admin@example.com</span>
                          </button>
                          
                          <button type="button" class="btn btn-outline-success btn-sm" onclick="demoLogin('dr.ahmad@klinik.com', 'password123')">
                            <i class="bi bi-person-badge-fill me-2"></i>
                            <strong>Dokter</strong>
                            <span class="text-muted ms-2">dr.ahmad@klinik.com</span>
                          </button>
                          
                          <button type="button" class="btn btn-outline-info btn-sm" onclick="demoLogin('andi.prasetyo@gmail.com', 'password123')">
                            <i class="bi bi-person-fill me-2"></i>
                            <strong>Pasien</strong>
                            <span class="text-muted ms-2">andi.prasetyo@gmail.com</span>
                          </button>
                        </div>
                        
                        <div class="mt-3 p-2 bg-light rounded">
                          <small class="text-muted d-block text-center">
                            <i class="bi bi-info-circle me-1"></i>
                            Admin: <code class="bg-white px-1">password</code> | Dokter & Pasien: <code class="bg-white px-1">password123</code>
                          </small>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- SSO Google Login -->
                  <div class="col-12 mt-3">
                    <div class="text-center">
                      <span class="text-muted">or</span>
                    </div>
                  </div>

                  <div class="col-12">
                    <button type="button" id="googleSsoBtn" class="btn btn-outline-primary w-100" onclick="redirectToGoogle()">
                      <svg xmlns="http://www.w3.org/2000/svg" width="15" height="16" fill="currentColor" class="bi bi-google me-2" viewBox="0 0 16 16">
                        <path d="M15.545 6.558a9.4 9.4 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.7 7.7 0 0 1 5.352 2.082l-2.284 2.284A4.35 4.35 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.8 4.8 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.7 3.7 0 0 0 1.599-2.431H8v-3.08z"/>
                      </svg>
                      Login with Google
                    </button>
                  </div>

                  <!-- Demo Info for SSO -->
                  <div class="col-12 mt-3">
                    <div class="alert alert-info py-2 px-3 mb-0" style="font-size: 0.8rem;">
                      <i class="bi bi-info-circle me-1"></i>
                      <strong>Demo:</strong> Akun demo di atas hanya untuk login email/password.
                      <br><span class="ms-4">"Login with Google" menggunakan akun Google Anda sendiri.</span>
                    </div>
                  </div>
                </div>
              </div>

              
            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->

  <script>
    // Function untuk demo login otomatis
    function demoLogin(email, password) {
      const emailInput = document.getElementById('yourEmail');
      const passwordInput = document.getElementById('yourPassword');
      
      emailInput.value = email;
      passwordInput.value = password;
      
      // Auto submit form
      const form = emailInput.closest('form');
      form.classList.add('was-validated');
      form.submit();
    }

    // Function untuk redirect ke Google SSO
    function redirectToGoogle() {
      const btn = document.getElementById('googleSsoBtn');
      btn.disabled = true;
      btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Redirecting...';
      window.location.href = "{{ route('googlesso_redirect') }}";
    }

    // Bootstrap form validation
    (function () {
      'use strict';
      const forms = document.querySelectorAll('.needs-validation');
      Array.from(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
          if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });
    })();

    // Prevent form submission interference with SSO button
    document.addEventListener('DOMContentLoaded', function() {
      const ssoBtn = document.getElementById('googleSsoBtn');
      if (ssoBtn) {
        ssoBtn.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();
          redirectToGoogle();
        });
      }
    });
  </script>

</body>

</html>
