<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Antrian Saya - Electronic Klinik</title>

    <!-- Vendor CSS -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <style>
        body {
            padding-top: 100px !important;
            background-color: #f8f9fa;
        }

        #header {
            z-index: 9998;
        }

        #main {
            position: relative;
            z-index: 1;
            min-height: calc(100vh - 100px);
            padding-bottom: 60px;
        }

        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 0;
            color: white;
            margin-bottom: 40px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .antrian-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s, box-shadow 0.3s;
            border-left: 5px solid #667eea;
        }

        .antrian-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 25px rgba(0,0,0,0.15);
        }

        .antrian-card.status-menunggu {
            border-left-color: #ffc107;
        }

        .antrian-card.status-dipanggil {
            border-left-color: #17a2b8;
        }

        .antrian-card.status-selesai {
            border-left-color: #28a745;
        }

        .antrian-card.status-skip {
            border-left-color: #dc3545;
        }

        .antrian-number {
            font-size: 48px;
            font-weight: bold;
            color: #667eea;
            text-align: center;
            margin-bottom: 10px;
        }

        .status-badge {
            padding: 8px 20px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 14px;
            display: inline-block;
        }

        .status-menunggu {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-dipanggil {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .status-selesai {
            background-color: #d4edda;
            color: #155724;
        }

        .status-skip {
            background-color: #f8d7da;
            color: #721c24;
        }

        .info-row {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }

        .info-row i {
            font-size: 20px;
            margin-right: 12px;
            color: #667eea;
            min-width: 25px;
        }

        .info-label {
            font-weight: 600;
            color: #495057;
            min-width: 150px;
        }

        .info-value {
            color: #6c757d;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.08);
        }

        .empty-state i {
            font-size: 80px;
            color: #dee2e6;
            margin-bottom: 20px;
        }

        .detail-section {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }

        .detail-section h6 {
            color: #667eea;
            font-weight: bold;
            margin-bottom: 15px;
        }

        @media (max-width: 768px) {
            body {
                padding-top: 80px !important;
            }

            .antrian-number {
                font-size: 36px;
            }

            .info-label {
                min-width: 100px;
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top">
        <div class="container d-flex align-items-center">
            <h1 class="logo me-auto"><a href="{{ route('home') }}">Electronic Klinik</a></h1>
            <nav id="navbar" class="navbar order-last order-lg-0">
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('daftarAntrianUser') }}" class="active">Antrian Saya</a></li>
                    <li><a href="{{ route('patient.about') }}">About</a></li>
                    <li><a href="{{ route('patient.contact') }}">Contact</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav>
            <a href="{{ route('logout') }}" class="appointment-btn scrollto">Logout</a>
        </div>
    </header><!-- End Header -->

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <h1 class="mb-2"><i class="bi bi-list-check me-2"></i>Antrian Saya</h1>
            <p class="mb-0">Pantau status antrian dan hasil pemeriksaan Anda</p>
        </div>
    </div>

    <!-- ======= Main Section ======= -->
    <main id="main">
        <section id="cek-antrian" class="cek-antrian">
            <div class="container">

                @if(isset($antrianUser) && $antrianUser->isNotEmpty())
                    <!-- Info Total Antrian -->
                    <div class="alert alert-primary d-flex align-items-center mb-4" style="border-radius: 15px;">
                        <i class="bi bi-info-circle fs-4 me-3"></i>
                        <div>
                            <strong>Total Antrian Anda:</strong> {{ $antrianUser->count() }} antrian terdaftar
                        </div>
                    </div>

                    <!-- Antrian Cards -->
                    <div class="row">
                        @foreach($antrianUser as $antrian)
                            @php
                                $statusClass = 'status-' . strtolower($antrian->status ?? 'menunggu');
                                $statusText = $antrian->status ?? 'menunggu';
                                $statusIcon = match(strtolower($statusText)) {
                                    'menunggu' => 'bi-hourglass-split',
                                    'dipanggil' => 'bi-megaphone',
                                    'selesai' => 'bi-check-circle',
                                    'skip' => 'bi-x-circle',
                                    default => 'bi-hourglass-split'
                                };
                            @endphp

                            <div class="col-lg-6 mb-4">
                                <div class="antrian-card {{ $statusClass }}">
                                    <!-- Header Card -->
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <h5 class="mb-1">
                                                <i class="bi bi-hospital me-2"></i>{{ $antrian->poli }}
                                            </h5>
                                            <small class="text-muted">
                                                <i class="bi bi-calendar3 me-1"></i>
                                                {{ \Carbon\Carbon::parse($antrian->tanggal_daftar)->isoFormat('dddd, D MMMM Y') }}
                                            </small>
                                        </div>
                                        <div class="antrian-number">
                                            #{{ str_pad($antrian->no_antrian, 3, '0', STR_PAD_LEFT) }}
                                        </div>
                                    </div>

                                    <!-- Status Badge -->
                                    <div class="text-center mb-3">
                                        <span class="status-badge {{ $statusClass }}">
                                            <i class="bi {{ $statusIcon }} me-2"></i>{{ ucfirst($statusText) }}
                                        </span>
                                    </div>

                                    <!-- Patient Info -->
                                    <div class="info-row">
                                        <i class="bi bi-person-fill"></i>
                                        <span class="info-label">Nama Pasien:</span>
                                        <span class="info-value">{{ $antrian->nama }}</span>
                                    </div>

                                    <div class="info-row">
                                        <i class="bi bi-credit-card-2-front"></i>
                                        <span class="info-label">No. KTP:</span>
                                        <span class="info-value">{{ $antrian->no_ktp }}</span>
                                    </div>

                                    <div class="info-row">
                                        <i class="bi bi-phone"></i>
                                        <span class="info-label">No. HP:</span>
                                        <span class="info-value">{{ $antrian->no_hp }}</span>
                                    </div>

                                    <div class="info-row">
                                        <i class="bi bi-geo-alt"></i>
                                        <span class="info-label">Alamat:</span>
                                        <span class="info-value">{{ $antrian->alamat }}</span>
                                    </div>

                                    @if(strtolower($statusText) === 'selesai' && $antrian->tanggal_periksa)
                                        <div class="info-row">
                                            <i class="bi bi-clock-history"></i>
                                            <span class="info-label">Waktu Periksa:</span>
                                            <span class="info-value">{{ \Carbon\Carbon::parse($antrian->tanggal_periksa)->isoFormat('D MMM Y, HH:mm') }}</span>
                                        </div>
                                    @endif

                                    <!-- Medical Results (if completed) -->
                                    @if(strtolower($statusText) === 'selesai' && ($antrian->diagnosa || $antrian->resep_obat))
                                        <div class="detail-section">
                                            <h6><i class="bi bi-file-medical me-2"></i>Rekam Medis Elektronik</h6>

                                            <!-- Doctor Info -->
                                            @if($antrian->nama_dokter || $antrian->dokter_poli)
                                                <div class="mb-3 p-2 bg-white rounded">
                                                    <div class="d-flex align-items-center">
                                                        <i class="bi bi-person-badge fs-4 text-primary me-2"></i>
                                                        <div>
                                                            @if($antrian->nama_dokter)
                                                                <strong class="d-block">{{ $antrian->nama_dokter }}</strong>
                                                            @endif
                                                            @if($antrian->dokter_poli)
                                                                <small class="text-muted">Dokter {{ $antrian->dokter_poli }}</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Vital Signs -->
                                            @if($antrian->tekanan_darah || $antrian->nadi || $antrian->suhu_tubuh || $antrian->tinggi_badan || $antrian->berat_badan)
                                                <div class="mb-3">
                                                    <strong class="text-primary d-block mb-2"><i class="bi bi-activity me-2"></i>Tanda-Tanda Vital:</strong>
                                                    <div class="row g-2">
                                                        @if($antrian->tekanan_darah)
                                                            <div class="col-6 col-md-4">
                                                                <div class="p-2 bg-white rounded">
                                                                    <small class="text-muted d-block">Tekanan Darah</small>
                                                                    <strong>{{ $antrian->tekanan_darah }}</strong>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if($antrian->nadi)
                                                            <div class="col-6 col-md-4">
                                                                <div class="p-2 bg-white rounded">
                                                                    <small class="text-muted d-block">Nadi</small>
                                                                    <strong>{{ $antrian->nadi }}</strong>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if($antrian->suhu_tubuh)
                                                            <div class="col-6 col-md-4">
                                                                <div class="p-2 bg-white rounded">
                                                                    <small class="text-muted d-block">Suhu Tubuh</small>
                                                                    <strong>{{ $antrian->suhu_tubuh }}</strong>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if($antrian->tinggi_badan)
                                                            <div class="col-6 col-md-4">
                                                                <div class="p-2 bg-white rounded">
                                                                    <small class="text-muted d-block">Tinggi Badan</small>
                                                                    <strong>{{ $antrian->tinggi_badan }} cm</strong>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if($antrian->berat_badan)
                                                            <div class="col-6 col-md-4">
                                                                <div class="p-2 bg-white rounded">
                                                                    <small class="text-muted d-block">Berat Badan</small>
                                                                    <strong>{{ $antrian->berat_badan }} kg</strong>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Keluhan Utama -->
                                            @if($antrian->keluhan_utama)
                                                <div class="mb-3">
                                                    <strong class="text-primary"><i class="bi bi-chat-left-text me-2"></i>Keluhan Utama:</strong>
                                                    <p class="mb-0 mt-1">{{ $antrian->keluhan_utama }}</p>
                                                </div>
                                            @endif

                                            <!-- Riwayat Penyakit -->
                                            @if($antrian->riwayat_penyakit)
                                                <div class="mb-3">
                                                    <strong class="text-primary"><i class="bi bi-clock-history me-2"></i>Riwayat Penyakit:</strong>
                                                    <p class="mb-0 mt-1">{{ $antrian->riwayat_penyakit }}</p>
                                                </div>
                                            @endif

                                            <!-- Pemeriksaan Fisik -->
                                            @if($antrian->pemeriksaan_fisik)
                                                <div class="mb-3">
                                                    <strong class="text-primary"><i class="bi bi-heart-pulse me-2"></i>Pemeriksaan Fisik:</strong>
                                                    <p class="mb-0 mt-1">{{ $antrian->pemeriksaan_fisik }}</p>
                                                </div>
                                            @endif

                                            <!-- Hasil Lab -->
                                            @if($antrian->hasil_lab)
                                                <div class="mb-3">
                                                    <strong class="text-primary"><i class="bi bi-clipboard2-pulse me-2"></i>Hasil Laboratorium:</strong>
                                                    <p class="mb-0 mt-1">{{ $antrian->hasil_lab }}</p>
                                                </div>
                                            @endif

                                            <!-- Diagnosa -->
                                            @if($antrian->diagnosa)
                                                <div class="mb-3">
                                                    <strong class="text-primary"><i class="bi bi-file-medical-fill me-2"></i>Diagnosa:</strong>
                                                    <p class="mb-0 mt-1">{{ $antrian->diagnosa }}</p>
                                                </div>
                                            @endif

                                            <!-- Tindakan Medis -->
                                            @if($antrian->tindakan_medis)
                                                <div class="mb-3">
                                                    <strong class="text-primary"><i class="bi bi-bandaid me-2"></i>Tindakan Medis:</strong>
                                                    <p class="mb-0 mt-1">{{ $antrian->tindakan_medis }}</p>
                                                </div>
                                            @endif

                                            <!-- Resep Obat -->
                                            @if($antrian->resep_obat)
                                                <div class="mb-3">
                                                    <strong class="text-primary"><i class="bi bi-capsule me-2"></i>Resep Obat:</strong>
                                                    <pre class="mb-0 mt-1 p-2 bg-white rounded" style="white-space: pre-wrap; font-family: inherit;">{{ $antrian->resep_obat }}</pre>
                                                </div>
                                            @endif

                                            <!-- Anjuran -->
                                            @if($antrian->anjuran)
                                                <div class="mb-3">
                                                    <strong class="text-primary"><i class="bi bi-info-circle me-2"></i>Anjuran:</strong>
                                                    <p class="mb-0 mt-1">{{ $antrian->anjuran }}</p>
                                                </div>
                                            @endif

                                            <!-- Catatan Dokter -->
                                            @if($antrian->catatan_dokter)
                                                <div class="mb-3">
                                                    <strong class="text-primary"><i class="bi bi-journal-text me-2"></i>Catatan Dokter:</strong>
                                                    <p class="mb-0 mt-1">{{ $antrian->catatan_dokter }}</p>
                                                </div>
                                            @endif

                                            <!-- Medical Images/Files Gallery -->
                                            @php
                                                $fotoPemeriksaan = $antrian->foto_pemeriksaan ? json_decode($antrian->foto_pemeriksaan, true) : [];
                                                $fotoRontgen = $antrian->foto_rontgen ? json_decode($antrian->foto_rontgen, true) : [];
                                                $filePendukung = $antrian->file_pendukung ? json_decode($antrian->file_pendukung, true) : [];
                                                $hasImages = !empty($fotoPemeriksaan) || !empty($fotoRontgen) || !empty($filePendukung);
                                            @endphp

                                            @if($hasImages)
                                                <div class="mt-4">
                                                    <strong class="text-primary d-block mb-3"><i class="bi bi-images me-2"></i>Dokumen Pemeriksaan:</strong>

                                                    <!-- Foto Pemeriksaan -->
                                                    @if(!empty($fotoPemeriksaan))
                                                        <div class="mb-3">
                                                            <h6 class="mb-2"><i class="bi bi-camera me-2"></i>Foto Pemeriksaan</h6>
                                                            <div class="row g-2">
                                                                @foreach($fotoPemeriksaan as $foto)
                                                                    <div class="col-4 col-md-3">
                                                                        <a href="{{ asset('storage/foto_pemeriksaan/' . $foto) }}" target="_blank">
                                                                            <img src="{{ asset('storage/foto_pemeriksaan/' . $foto) }}"
                                                                                 class="img-fluid rounded shadow-sm"
                                                                                 style="width: 100%; height: 120px; object-fit: cover; cursor: pointer; transition: transform 0.3s;"
                                                                                 onmouseover="this.style.transform='scale(1.05)'"
                                                                                 onmouseout="this.style.transform='scale(1)'">
                                                                        </a>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <!-- Foto Rontgen -->
                                                    @if(!empty($fotoRontgen))
                                                        <div class="mb-3">
                                                            <h6 class="mb-2"><i class="bi bi-file-medical me-2"></i>Foto Rontgen/Radiologi</h6>
                                                            <div class="row g-2">
                                                                @foreach($fotoRontgen as $foto)
                                                                    <div class="col-4 col-md-3">
                                                                        <a href="{{ asset('storage/foto_rontgen/' . $foto) }}" target="_blank">
                                                                            <img src="{{ asset('storage/foto_rontgen/' . $foto) }}"
                                                                                 class="img-fluid rounded shadow-sm"
                                                                                 style="width: 100%; height: 120px; object-fit: cover; cursor: pointer; transition: transform 0.3s;"
                                                                                 onmouseover="this.style.transform='scale(1.05)'"
                                                                                 onmouseout="this.style.transform='scale(1)'">
                                                                        </a>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <!-- File Pendukung -->
                                                    @if(!empty($filePendukung))
                                                        <div class="mb-3">
                                                            <h6 class="mb-2"><i class="bi bi-paperclip me-2"></i>File Pendukung Lainnya</h6>
                                                            <div class="row g-2">
                                                                @foreach($filePendukung as $file)
                                                                    @php
                                                                        $fileExt = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                                                        $isImage = in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif']);
                                                                    @endphp
                                                                    <div class="col-4 col-md-3">
                                                                        @if($isImage)
                                                                            <a href="{{ asset('storage/file_pendukung/' . $file) }}" target="_blank">
                                                                                <img src="{{ asset('storage/file_pendukung/' . $file) }}"
                                                                                     class="img-fluid rounded shadow-sm"
                                                                                     style="width: 100%; height: 120px; object-fit: cover; cursor: pointer; transition: transform 0.3s;"
                                                                                     onmouseover="this.style.transform='scale(1.05)'"
                                                                                     onmouseout="this.style.transform='scale(1)'">
                                                                            </a>
                                                                        @else
                                                                            <a href="{{ asset('storage/file_pendukung/' . $file) }}" target="_blank" class="text-decoration-none">
                                                                                <div class="p-3 bg-white rounded text-center shadow-sm" style="height: 120px; display: flex; flex-direction: column; justify-content: center;">
                                                                                    <i class="bi bi-file-earmark-pdf fs-1 text-danger"></i>
                                                                                    <small class="text-muted mt-2">{{ strtoupper($fileExt) }}</small>
                                                                                </div>
                                                                            </a>
                                                                        @endif
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    <!-- Rekam Medis -->
                                    @if($antrian->rekam_medis)
                                        <div class="mt-3 text-center">
                                            <a href="{{ asset('storage/rekam_medis/' . $antrian->rekam_medis) }}" target="_blank" class="btn btn-success">
                                                <i class="bi bi-file-earmark-text me-2"></i>Lihat Rekam Medis
                                            </a>
                                        </div>
                                    @else
                                        @if(strtolower($statusText) === 'menunggu' || strtolower($statusText) === 'dipanggil')
                                            <div class="alert alert-warning mt-3 mb-0 text-center">
                                                <i class="bi bi-exclamation-triangle me-2"></i>
                                                Rekam medis akan tersedia setelah pemeriksaan selesai
                                            </div>
                                        @endif
                                    @endif

                                    <!-- Queue Info for waiting status -->
                                    @if(strtolower($statusText) === 'menunggu')
                                        <div class="alert alert-info mt-3 mb-0">
                                            <i class="bi bi-lightbulb me-2"></i>
                                            <strong>Tips:</strong> Silakan datang 15 menit sebelum nomor antrian Anda dipanggil. Pantau terus status antrian Anda!
                                        </div>
                                    @endif

                                    @if(strtolower($statusText) === 'dipanggil')
                                        <div class="alert alert-danger mt-3 mb-0">
                                            <i class="bi bi-megaphone-fill me-2"></i>
                                            <strong>Perhatian!</strong> Nomor antrian Anda sedang dipanggil. Silakan segera menuju ruang pemeriksaan.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Additional Info -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card" style="border-radius: 15px; border: none; box-shadow: 0 3px 15px rgba(0,0,0,0.08);">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="bi bi-info-circle me-2"></i>Keterangan Status</h5>
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            <span class="status-badge status-menunggu">
                                                <i class="bi bi-hourglass-split me-2"></i>Menunggu
                                            </span>
                                            <p class="small text-muted mt-1 mb-0">Antrian terdaftar, menunggu giliran</p>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <span class="status-badge status-dipanggil">
                                                <i class="bi bi-megaphone me-2"></i>Dipanggil
                                            </span>
                                            <p class="small text-muted mt-1 mb-0">Nomor Anda sedang dipanggil</p>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <span class="status-badge status-selesai">
                                                <i class="bi bi-check-circle me-2"></i>Selesai
                                            </span>
                                            <p class="small text-muted mt-1 mb-0">Pemeriksaan telah selesai</p>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <span class="status-badge status-skip">
                                                <i class="bi bi-x-circle me-2"></i>Skip
                                            </span>
                                            <p class="small text-muted mt-1 mb-0">Pasien tidak hadir</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                @else
                    <!-- Empty State -->
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <h4 class="mb-3">Belum Ada Antrian</h4>
                        <p class="text-muted mb-4">Anda belum memiliki antrian terdaftar. Silakan ambil antrian terlebih dahulu.</p>
                        <a href="{{ route('home') }}" class="btn btn-primary btn-lg" style="border-radius: 50px; padding: 12px 40px;">
                            <i class="bi bi-calendar-plus me-2"></i>Ambil Antrian Sekarang
                        </a>
                    </div>
                @endif

            </div>
        </section>
    </main><!-- End Main Section -->

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

    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Auto refresh setiap 30 detik untuk update status -->
    <script>
        // Auto refresh page every 30 seconds to get latest queue status
        setTimeout(function() {
            location.reload();
        }, 30000); // 30 seconds
    </script>
</body>

</html>
