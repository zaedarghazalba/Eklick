# Klinik PUI - Sistem Manajemen Antrian Klinik

Aplikasi web untuk manajemen antrian klinik dengan 3 role: Pasien, Admin, dan Dokter.

## 🚀 Quick Start

```bash
# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Database
php artisan migrate --seed

# Run application
php artisan serve
```

Akses aplikasi di `http://localhost:8000`

## 👥 Default Login

- **Admin**: `/admin` → admin@example.com / password
- **Dokter**: `/dokter` → (lihat seeder)
- **Pasien**: `/sso-google` → register atau login dengan Google

## 📚 Dokumentasi Lengkap

Lihat dokumentasi lengkap di folder **[docs/](./docs/README.md)**

## 🧪 Testing

```bash
php artisan test
```

**Status:** ✅ 77 tests passing

### ⚠️ PENTING: Data Development Aman!

Test menggunakan **SQLite in-memory**, BUKAN database development Anda.
Data development **100% AMAN** saat run test.

📖 **Baca:** [TESTING_WARNING.md](./TESTING_WARNING.md) sebelum run test pertama kali!

## 🛠️ Tech Stack

- Laravel 10
- MySQL
- Bootstrap 5
- OAuth Google
- PHPUnit/Pest

## 📁 Struktur Views

```
resources/views/
├── patient/     # Halaman pasien
├── admin/       # Halaman admin
├── doctor/      # Halaman dokter
├── auth/        # Login & register
├── components/  # Komponen shared
├── layouts/     # Layout shared
└── partials/    # Partial shared
```

## 📝 Common Commands

```bash
# Development
php artisan serve
npm run dev

# Testing
php artisan test

# Clear cache
php artisan optimize:clear
```

---

**Dokumentasi lengkap:** [docs/README.md](./docs/README.md)

**Last Updated:** 2025-10-24
