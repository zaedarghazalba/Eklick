# Dokumentasi Sistem Klinik PUI

## 📋 Gambaran Sistem

Sistem Manajemen Antrian Klinik dengan 3 role utama: **Pasien**, **Admin**, dan **Dokter**. Dibangun dengan Laravel 11 + MySQL + JWT Authentication.

---

## 🏗️ Arsitektur Sistem

```
┌─────────────────────────────────────────────────────────────────┐
│                         CLIENTS                                  │
├─────────────────┬─────────────────┬─────────────────────────────┤
│     Pasien      │      Admin      │         Dokter                │
│   (Web/Mobile)  │   (Dashboard)   │      (Dashboard)              │
└────────┬────────┴────────┬────────┴────────────┬─────────────┘
         │                    │                       │
         ▼                    ▼                       ▼
┌─────────────────────────────────────────────────────────────────┐
│                        API LAYER                                │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────────┐    │
│  │   Public     │  │   JWT Auth    │  │    Admin/Dokter    │    │
│  │   Routes     │  │   Protected   │  │    Routes         │    │
│  └──────────────┘  └──────────────┘  └──────────────────┘    │
└─────────────────────────────────────────────────────────────────┘
         │                    │                       │
         ▼                    ▼                       ▼
┌─────────────────────────────────────────────────────────────────┐
│                    SERVICE LAYER                                │
│  ┌────────────┐  ┌────────────┐  ┌────────────┐  ┌────────┐ │
│  │AuthService │  │AntrianService│ │DashboardSvc│  │AuditSvc│ │
│  └────────────┘  └────────────┘  └────────────┘  └────────┘ │
└─────────────────────────────────────────────────────────────────┘
         │                    │                       │
         ▼                    ▼                       ▼
┌─────────────────────────────────────────────────────────────────┐
│                    QUEUE SYSTEM                                  │
│  ┌──────────────────┐  ┌──────────────────┐  ┌──────────────┐  │
│  │ Notifications    │  │   Maintenance    │  │   Cleanup   │  │
│  │   Queue          │  │     Queue        │  │    Queue    │  │
│  └──────────────────┘  └──────────────────┘  └──────────────┘  │
└─────────────────────────────────────────────────────────────────┘
         │                    │                       │
         ▼                    ▼                       ▼
┌─────────────────────────────────────────────────────────────────┐
│                      DATABASE                                   │
│  ┌─────────┐  ┌─────────┐  ┌─────────┐  ┌─────────────────┐   │
│  │  Users  │  │Antrians │  │ Audit   │  │     Jobs        │   │
│  │         │  │         │  │  Logs   │  │  (Notifications) │   │
│  └─────────┘  └─────────┘  └─────────┘  └─────────────────┘   │
└─────────────────────────────────────────────────────────────────┘
```

---

## 👥 Role & Akses

| Role | Akses | Authentication |
|------|-------|----------------|
| **Pasien** | Antrian, Registrasi, Google SSO | Session + JWT (API) |
| **Admin** | Dashboard, Users, Doctors, Antrian Management | Session (web) + JWT (API) |
| **Dokter** | Dashboard, Diagnosa, Rekam Medis | Session (web) + JWT (API) |

---

## 🔐 Authentication Flow

### Web (Session-based)
```
Pasien ──► Google OAuth ──► Session Login ──► Dashboard
Admin ──► Form Login ────► Session Login ──► Admin Dashboard
Dokter ──► Form Login ───► Session Login ──► Doctor Dashboard
```

### Mobile/API (JWT-based)
```
Pasien ──► API Login/Register ──► JWT Token ──► API Access
Admin ──► API Login ─────────► JWT Token ──► Admin API
Dokter ──► API Login ─────────► JWT Token ──► Doctor API
```

---

## 📊 API Endpoints

### Public Routes (No Auth Required)
```
POST /api/auth/login          - Login dengan JWT
POST /api/auth/register      - Registrasi user baru
GET  /api/antrian            - List antrian
POST /api/antrian/send       - Create antrian baru
GET  /api/antrian/kuota       - Kuota antrian per poli
GET  /api/antrian/poli/{poli} - Antrian per poli
GET  /api/health             - Health check
```

### Protected Routes (JWT Required)
```
GET  /api/profile            - Profile user
PUT  /api/profile            - Update profile
POST /api/logout             - Logout

GET  /api/antrianmu          - Antrian saya
GET  /api/antrianmu/{id}     - Detail antrian

GET  /api/doctor/dashboard   - Dashboard dokter
GET  /api/doctor/antrian     - Antrian dokter
POST /api/doctor/antrian/{id}/diagnosa - Save diagnosa

GET  /api/admin/dashboard    - Dashboard admin
GET  /api/admin/users        - List users
GET  /api/admin/doctors      - List doctors
POST /api/admin/doctors     - Create doctor
PUT  /api/admin/doctors/{id} - Update doctor
DELETE /api/admin/doctors/{id} - Delete doctor
GET  /api/admin/antrian      - List all antrian
POST /api/admin/antrian/{id}/panggil - Panggil antrian
POST /api/admin/antrian/{id}/selesai - Selesai antrian
```

---

## 🔄 Alur Antrian Pasien

```
┌─────────────┐
│ Pasien      │
│Registrasi   │
└──────┬──────┘
       │
       ▼
┌─────────────┐     ┌─────────────┐
│ Pilih Poli  │────►│ Cek Kuota   │
│ & Tanggal   │     │ (API)       │
└──────┬──────┘     └─────────────┘
       │
       ▼
┌─────────────┐
│ Form Data   │──── Validation (FormRequest)
│ Pasien      │
└──────┬──────┘
       │
       ▼
┌─────────────┐
│ Submit      │──── Queue Job (async)
│ Antrian     │
└──────┬──────┘
       │
       ▼
┌─────────────┐     ┌─────────────┐
│ No. Antrian │     │ Email       │
│ Diberikan   │     │ Notification│
└──────┬──────┘     └─────────────┘
       │
       ▼
┌─────────────┐
│ Cek Antrian │
│ /antrianmu  │
└─────────────┘
```

---

## 🔄 Alur Admin Antrian Management

```
┌─────────────┐
│ Login       │
│ Admin       │
└──────┬──────┘
       │
       ▼
┌─────────────┐
│ Dashboard   │──── Statistics (cached 5 min)
└──────┬──────┘
       │
       ▼
┌─────────────┐     ┌─────────────┐
│ List        │────►│ Filter by   │
│ Antrian     │     │ Poli/Date   │
└──────┬──────┘     └─────────────┘
       │
       ▼
┌─────────────┐
│ Actions:    │──── Panggil / Skip / Selesai
│             │     │
└──────┬──────┘     │
       │            ▼
       │     ┌─────────────┐     ┌─────────────┐
       │     │ Observer    │────►│ Queue Job   │
       │     │ (status chg)│     │ (Email)     │
       │     └─────────────┘     └─────────────┘
       │
       ▼
┌─────────────┐
│ Audit Log   │──── Logged to AuditLogs table
│ Created     │
└─────────────┘
```

---

## 🧩 Komponen Sistem

### 1. Form Requests (Clean Architecture)
```
app/Http/Requests/
├── StoreAntrianRequest.php     # Validasi buat antrian
├── UpdateAntrianRequest.php     # Validasi update antrian
├── LoginRequest.php            # Validasi login
├── SaveDiagnosaRequest.php     # Validasi diagnosa dokter
├── Api/
│   ├── ApiLoginRequest.php     # API login validation
│   └── ApiRegisterRequest.php  # API register validation
└── Admin/
    ├── StoreDoctorRequest.php # Validasi create doctor
    └── UpdateDoctorRequest.php # Validasi update doctor
```

### 2. Services (Business Logic)
```
app/Services/
├── AuthService.php      # Login, JWT, role validation
├── AntrianService.php    # Antrian operations (cached)
├── DashboardService.php  # Dashboard stats (cached)
└── AuditService.php      # Audit logging
```

### 3. Jobs (Queue-based Processing)
```
app/Jobs/
├── SendAntrianDipanggilNotification.php  # Email notification (queue)
├── SendAntrianSelesaiNotification.php    # Email notification (queue)
└── CleanupOldAntrians.php                # Scheduled cleanup (weekly)
```

### 4. Observers (Event-driven)
```
app/Observers/
├── AntrianObserver.php   # Auto-dispatch notifications
└── UserObserver.php     # Auto-audit user changes
```

---

## 📁 Struktur File Utama

```
app/
├── Enums/
│   ├── UserRole.php      # ADMIN, DOKTER, USER
│   └── AntrianStatus.php # MENUNGGU, DIPANGGIL, SELESAI
├── Http/
│   ├── Controllers/
│   │   ├── Api/AuthController.php     # JWT Auth API
│   │   ├── AdminController.php        # Admin dashboard
│   │   ├── AntrianController.php       # Antrian CRUD
│   │   └── DokterAuthController.php    # Doctor auth
│   ├── Middleware/
│   │   ├── JwtAuthenticate.php        # JWT validation
│   │   ├── AdminMiddleware.php        # Admin access
│   │   └── DokterMiddleware.php        # Doctor access
│   ├── Requests/                      # Form validation
│   └── Resources/                     # API resources
├── Jobs/                              # Queue jobs
├── Models/
│   ├── User.php
│   ├── Antrians.php
│   └── AuditLog.php
├── Observers/                         # Model observers
├── Providers/
│   └── AppServiceProvider.php        # Observer registration
└── Services/                         # Business logic

config/
├── auth.php     # JWT guard config
├── jwt.php      # JWT settings
├── queue.php    # Queue connections
└── cache.php   # Cache config

database/migrations/
├── 2026_05_14_000000_create_audit_logs_table.php
└── ... (existing migrations)
```

---

## ⏰ Scheduled Tasks

| Task | Schedule | Description |
|------|----------|-------------|
| `CleanupOldAntrians` | Weekly (Monday 02:00) | Hapus soft-deleted antrian >90 hari |
| `cache:prune-stale-tags` | Hourly | Bersihkan stale cache tags |

---

## 📧 Notification Flow

```
┌─────────────┐
│ Status      │
│ Berubah     │
└──────┬──────┘
       │
       ▼
┌─────────────┐
│ Observer    │
│ Triggered   │
└──────┬──────┘
       │
       ▼
┌─────────────┐
│ Dispatch    │──── Queue (notifications)
│ Job         │
└──────┬──────┘
       │
       ▼
┌─────────────┐
│ Queue       │
│ Worker      │
└──────┬──────┘
       │
       ▼
┌─────────────┐
│ Email       │
│ Sent        │
└─────────────┘
```

---

## 🧪 Testing

### PHPUnit Tests (73 passed, 4 failed)
```
tests/
├── Unit/
│   ├── AntrianModelTest.php
│   ├── UserModelTest.php
│   └── ExampleTest.php
└── Feature/
    ├── AntrianTest.php
    ├── AuthenticationTest.php
    ├── RegistrationTest.php
    └── ExampleTest.php
```

### Playwright E2E Tests (27 passed, 12 skipped)
```
tests/e2e/
├── homepage.spec.js
├── admin.spec.js
├── dokter.spec.js
├── antrian.spec.js
├── pasien-antrian.spec.js
├── api.spec.js
└── antrian-workflow.spec.js
```

---

## 🚀 Quick Commands

```bash
# Start Development
php artisan serve
npm run dev

# Queue Worker
php artisan queue:work --queue=notifications,maintenance

# Schedule (production)
php artisan schedule:work

# Run Tests
php artisan test
npx playwright test

# Clear Cache
php artisan cache:clear
php artisan config:clear
```

---

## 📝 Default Accounts

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@example.com | password |
| Admin | admin@klinik.com | admin123 |
| Admin | superadmin@klinik.com | super123 |
| Dokter | dr.ahmad@klinik.com | password123 |
| Dokter | dr.siti@klinik.com | password123 |
| Dokter | dr.budi@klinik.com | password123 |
| Dokter | dr.rina@klinik.com | password123 |

---

## ⚙️ Configuration

### Environment Variables (.env)
```env
# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=klinik_pui
DB_USERNAME=root
DB_PASSWORD=

# JWT
JWT_SECRET=your_secret_key
JWT_TTL=60
JWT_TTL_REFRESH=20160

# Mail (Mailtrap)
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password

# Google OAuth
SSO_ID=your_google_client_id
SSO_SECRET=your_google_client_secret
SSO_REDIRECT=http://localhost:8000/sso-callback
```

---

## 🔒 Security Features

- [x] JWT Authentication untuk API
- [x] Session Authentication untuk Web
- [x] Google OAuth (SSO)
- [x] Rate Limiting (throttle)
- [x] Form Request Validation
- [x] Audit Logging
- [x] Password Hashing (bcrypt)
- [x] CSRF Protection (web)
- [x] Soft Deletes
- [x] Queue-based notifications

---

## 📈 Performance Features

- [x] Dashboard caching (5 min TTL)
- [x] Queue-based notifications
- [x] Database queue driver
- [x] Optimized queries (indexes)
- [x] Lazy loading prevention (eager load)

---

*Last Updated: 2026-05-14*