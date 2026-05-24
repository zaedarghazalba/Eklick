<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Electronic Klinik - Cek Antrian</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <style>
        /* Fix untuk konten tidak tertutup navbar */
        body {
            padding-top: 100px !important;
            /* Space for navbar (70px) + extra (30px) */
        }

        /* Ensure header is on top */
        #header {
            z-index: 9998;
        }

        /* Main content spacing */
        #main {
            position: relative;
            z-index: 1;
            min-height: calc(100vh - 100px);
        }

        /* Section title spacing */
        .section-title {
            margin-top: 20px;
            margin-bottom: 30px;
        }

        .section-title h2 {
            margin-top: 0;
            padding-top: 0;
        }

        .antrian-table {
            margin-top: 30px;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding-top: 80px !important;
            }
        }
    </style>
</head>

<body>
    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top">
        <div class="container d-flex align-items-center">
            <h1 class="logo me-auto"><a href="/">Electronic Klinik</a></h1>
            <nav id="navbar" class="navbar order-last order-lg-0">
                <ul>
                    <li><a href="/home">Home</a></li>
                    <li><a href="/antrianmu">Antrian</a></li>
                    <li><a href="/home">About</a></li>
                    <li><a href="/home">Contact</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->
            <a href="/logout" class="appointment-btn scrollto">Logout</a>
        </div>
    </header><!-- End Header -->

    <!-- ======= Main Section ======= -->
    <main id="main">
        <section id="cek-antrian" class="cek-antrian">
            <div class="container">
                <div class="section-title">
                    <h2>Cek Antrian</h2>
                </div>
                <!-- Filter Form -->
                <div class="form-container">
                    <form id="filterForm">
                        <div class="mb-3">
                            <label for="poli" class="form-label">Pilih Poli:</label>
                            <select class="form-select" id="poli" name="poli">
                                <option selected disabled>Pilih Poli</option>
                                <option value="Umum">Umum</option>
                                <option value="Mata">Mata</option>
                                <option value="THT">THT</option>
                                <option value="Ibu Dan Anak">Ibu Dan Anak</option>
                                <option value="Syaraf">Syaraf</option>
                                <option value="Kulit Dan Kelamin">Kulit Dan Kelamin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Pilih Tanggal Daftar:</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </form>
                </div>

                <!-- Table Section -->
                <div class="antrian-table">
                    <h3>Data Antrian</h3>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Poli</th>
                                    <th>Nama</th>
                                    <th>No. KTP</th>
                                    <th>No Antrian</th>
                                </tr>
                            </thead>
                            <tbody id="antrianTable">
                                <!-- Data antrian akan diisi di sini melalui JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
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

    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Filter Logic -->
    <script>
        document.getElementById('filterForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent form submission

            // Ambil nilai input dari form
            const poli = document.getElementById('poli').value;
            const tanggal = document.getElementById('tanggal').value;

            if (!poli || !tanggal) {
                alert('Harap pilih poli dan tanggal!');
                return;
            }

            // Kirim data ke backend menggunakan Fetch API
            fetch('/filter-antrian', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token untuk Laravel
                },
                body: JSON.stringify({ poli, tanggal })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Terjadi kesalahan saat memproses filter');
                }
                return response.json();
            })
            .then(data => {
                // Kosongkan tabel terlebih dahulu
                const tableBody = document.getElementById('antrianTable');
                tableBody.innerHTML = '';

                // Tambahkan data baru ke tabel
                if (data.length === 0) {
                    const emptyRow = document.createElement('tr');
                    emptyRow.innerHTML = `
                        <td colspan="3" class="text-center">Data tidak ditemukan</td>
                    `;
                    tableBody.appendChild(emptyRow);
                } else {
                    data.forEach(item => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${item.poli}</td>
                            <td>${item.nama}</td>
                            <td>${item.no_ktp}</td>
                            <td>${item.no_antrian}</td>
                        `;
                        tableBody.appendChild(row);
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal memuat data, silakan coba lagi.');
            });
        });
    </script>
</body>

</html>
