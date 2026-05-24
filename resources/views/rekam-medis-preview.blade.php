<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Preview Rekam Medis</title>

  <!-- Bootstrap CSS -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

  <style>
    body {
      margin: 0;
      padding: 0;
      overflow: hidden;
      background-color: #2c3e50;
    }

    .preview-header {
      background-color: #34495e;
      color: white;
      padding: 15px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    .preview-container {
      width: 100%;
      height: calc(100vh - 70px);
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #2c3e50;
    }

    .preview-content {
      width: 100%;
      height: 100%;
      background-color: white;
    }

    .preview-content iframe,
    .preview-content embed {
      width: 100%;
      height: 100%;
      border: none;
    }

    .preview-content img {
      max-width: 95%;
      max-height: 95%;
      object-fit: contain;
      box-shadow: 0 4px 6px rgba(0,0,0,0.3);
    }

    .image-container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100%;
      background-color: #2c3e50;
    }

    .btn-action {
      margin-left: 10px;
    }
  </style>
</head>
<body>

  <!-- Header -->
  <div class="preview-header">
    <div>
      <h5 class="mb-0">
        <i class="bi bi-file-earmark-medical me-2"></i>
        Preview Rekam Medis: <span class="text-info">{{ $filename }}</span>
      </h5>
    </div>
    <div>
      <a href="{{ route($downloadRoute, $filename) }}" class="btn btn-success btn-sm btn-action">
        <i class="bi bi-download me-1"></i>Download
      </a>
      <button onclick="window.print()" class="btn btn-primary btn-sm btn-action">
        <i class="bi bi-printer me-1"></i>Print
      </button>
      <button onclick="window.close()" class="btn btn-secondary btn-sm btn-action">
        <i class="bi bi-x-circle me-1"></i>Tutup
      </button>
    </div>
  </div>

  <!-- Preview Container -->
  <div class="preview-container">
    <div class="preview-content">
      @if($fileType === 'pdf')
        <!-- PDF Preview -->
        <embed src="{{ $fileUrl }}" type="application/pdf" width="100%" height="100%">
      @elseif(in_array($fileType, ['jpg', 'jpeg', 'png']))
        <!-- Image Preview -->
        <div class="image-container">
          <img src="{{ $fileUrl }}" alt="Rekam Medis">
        </div>
      @else
        <!-- Unsupported File Type -->
        <div class="d-flex justify-content-center align-items-center h-100 bg-light">
          <div class="text-center p-5">
            <i class="bi bi-file-earmark-x" style="font-size: 5rem; color: #e74c3c;"></i>
            <h4 class="mt-3">File Tidak Dapat Ditampilkan</h4>
            <p class="text-muted">Format file {{ strtoupper($fileType) }} tidak didukung untuk preview.</p>
            <a href="{{ route($downloadRoute, $filename) }}" class="btn btn-success mt-3">
              <i class="bi bi-download me-2"></i>Download File
            </a>
          </div>
        </div>
      @endif
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <script>
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
      // ESC to close
      if (e.key === 'Escape') {
        window.close();
      }
      // Ctrl+P to print
      if (e.ctrlKey && e.key === 'p') {
        e.preventDefault();
        window.print();
      }
    });
  </script>

</body>
</html>
