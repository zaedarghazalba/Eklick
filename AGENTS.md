# Klinik PUI - Agent Instructions

## Quick Start

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
php artisan migrate
php artisan db:seed --class=AdminSeeder
php artisan db:seed --class=DokterSeeder
php artisan serve
```

## Default Accounts

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@example.com | password |
| Doctor | dr.ahmad@klinik.com | password123 |

## Tech Stack

- Laravel 11 (PHP 8.2+)
- MySQL (database: klinik_pui)
- JWT Auth (tymon/jwt-auth)
- Bootstrap 5

## Key Commands

```bash
# Development
php artisan serve
npm run dev

# Testing
php artisan test

# Clear cache
php artisan optimize:clear
```

## API Endpoints

### Public
- `POST /api/auth/login` - JWT login
- `POST /api/auth/register` - JWT register
- `GET /api/antrian` - List antrian
- `POST /api/antrian/send` - Create antrian

### Protected (JWT Required)
- `GET /api/profile` - User profile
- `POST /api/logout` - Logout
- `GET /api/antrianmu` - User's antrian

## Configuration Notes

- Database uses MySQL (configured in `.env`)
- Mail configured for Mailtrap (update credentials in `.env`)
- Google OAuth configured (set `SSO_ID` and `SSO_SECRET` in `.env`)
- JWT token TTL: 60 minutes

## Completed Work

### Styling & Assets
- Created `layouts/admin.blade.php` and `layouts/doctor.blade.php` with consistent structure
- Created header/sidebar components: `admin-header.blade.php`, `admin-sidebar.blade.php`, `doctor-header.blade.php`, `doctor-sidebar.blade.php`
- Created footer partials: `partials/admin-footer.blade.php`, `partials/doctor-footer.blade.php`
- Created custom CSS: `public/assets/css/clinic-dashboard.css` with medical blue theme
- Fixed 136 blade files from `Dasboardassets` to `assets` paths
- Fixed all `$errors->any()` to `@isset()` in dashboard views
- Downloaded `animate.min.css` from CDN (71KB)
- Copied purecounter, glightbox, swiper from node_modules to public/vendor

### Testing
- All 113 E2E tests passing (admin, dokter, auth, pasien-antrian, homepage, api)
- All 90 PHP unit/feature tests passing
- Playwright config updated with 60s timeout

### Logout Routes
- Added GET `/logout` route for admin
- Added GET `/dokter-logout` route for doctors
- Routes named `admin.logout` and `dokter.logout`

### Login/Register Pages
- Fixed login.blade.php: removed Bootstrap `@error()` classes
- Fixed register.blade.php: changed route to `register`, removed Bootstrap `@error()` classes

## Known Issues

- API tests for JWT endpoints may need updates to match new response format
- Carbon::subDay() deprecated, use subDays(1) instead

## File Structure

```
app/
├── Http/Controllers/Api/    # JWT-enabled API controllers
├── Http/Middleware/        # JWT and role middleware
├── Http/Resources/         # API resources
├── Notifications/          # Email notifications
└── Services/               # Business logic
routes/
├── web.php    # Web routes (session auth)
└── api.php    # API routes (JWT auth)
resources/views/
├── layouts/               # Admin and doctor layouts
├── components/            # Header and sidebar components
├── partials/              # Footer partials
└── admin/                 # Admin dashboard pages
└── dokter/                # Doctor dashboard pages
public/assets/
├── css/clinic-dashboard.css   # Custom medical theme
└── vendor/                    # All vendor assets
```

## Test Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@example.com | password |
| Doctor | dr.ahmad@klinik.com | password123 |
| User | api@example.com | password123 |