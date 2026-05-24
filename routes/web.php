<?php

use App\Http\Controllers\AntrianController;
use App\Http\Controllers\AuthControll;
use App\Http\Controllers\Contencontroll;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Api\UnifiedAuthController;
use App\Http\Middleware\JwtAuthenticate;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

// Public Routes (No Auth Required)
Route::get('/', [Contencontroll::class, 'index'])->name('index');
Route::get('/about', [Contencontroll::class, 'about'])->name('patient.about');
Route::get('/contact', [Contencontroll::class, 'contact'])->name('patient.contact');

// Auth Routes (JWT-based - Single login page for all roles)
Route::get('/login', [UnifiedAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UnifiedAuthController::class, 'webLogin']);
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->middleware('throttle:3,1');
Route::post('/logout', [UnifiedAuthController::class, 'logout'])->name('logout');
Route::get('/logout', function () {
    session()->forget(['jwt_token', 'user_id', 'user_role', 'user_name']);
    return redirect()->route('login')->with('success', 'Logout berhasil!');
})->name('admin.logout');

Route::get('/dokter-logout', function () {
    session()->forget(['jwt_token', 'user_id', 'user_role', 'user_name']);
    return redirect()->route('login')->with('success', 'Logout berhasil!');
})->name('dokter.logout');

// Google SSO
Route::get('/sso-google', [AuthControll::class, 'show'])->name('googlesso');
Route::get('/sso-google-redirect', [AuthControll::class, 'redirectToProvider'])->name('googlesso_redirect');
Route::get('/sso-callback', [AuthControll::class, 'handleProviderCallback'])->name('googlesso_callback');
Route::post('/sso-google-auto', [AuthControll::class, 'sso_auto'])->name('googlesso_auto');

// Authenticated User Routes (JWT Required)
Route::middleware([JwtAuthenticate::class])->group(function () {
    // Home - accessible by all authenticated users
    Route::get('/home', [Contencontroll::class, 'home'])->name('home');

    // Patient - accessible by all authenticated users
    Route::get('/antrian', [AntrianController::class, 'daftar'])->name('daftar');
    Route::post('/antrian-send', [AntrianController::class, 'store'])->name('antrian.send');
    Route::post('/filter-antrian', [AntrianController::class, 'filterAntrian'])->name('filter-antrian');
    Route::get('/antrianmu', [AntrianController::class, 'daftarAntrianUser'])->name('daftarAntrianUser');
});

// Public Queue Call - No Auth Required (for display monitors)
Route::get('/panggil/{noAntrian}', [AntrianController::class, 'panggil'])->name('panggil');

// Admin Routes (JWT + Admin Role)
Route::prefix('admin')->middleware([JwtAuthenticate::class, RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('/', fn() => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
    Route::delete('/users/{id}', [App\Http\Controllers\AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::get('/doctors', [App\Http\Controllers\AdminController::class, 'doctors'])->name('admin.doctors');
    Route::get('/doctors/create', [App\Http\Controllers\AdminController::class, 'createDoctor'])->name('admin.doctors.create');
    Route::post('/doctors', [App\Http\Controllers\AdminController::class, 'storeDoctor'])->name('admin.doctors.store');
    Route::get('/doctors/{id}/edit', [App\Http\Controllers\AdminController::class, 'editDoctor'])->name('admin.doctors.edit');
    Route::put('/doctors/{id}', [App\Http\Controllers\AdminController::class, 'updateDoctor'])->name('admin.doctors.update');
    Route::delete('/doctors/{id}', [App\Http\Controllers\AdminController::class, 'deleteDoctor'])->name('admin.doctors.delete');
    Route::get('/antrian', [App\Http\Controllers\AdminController::class, 'antrian'])->name('admin.antrian');
    Route::post('/antrian/{id}/panggil', [App\Http\Controllers\AdminController::class, 'panggilAntrian'])->name('admin.antrian.panggil');
    Route::post('/antrian/{id}/skip', [App\Http\Controllers\AdminController::class, 'skipAntrian'])->name('admin.antrian.skip');
    Route::post('/antrian/{id}/selesai', [App\Http\Controllers\AdminController::class, 'selesaiAntrian'])->name('admin.antrian.selesai');
    Route::post('/antrian/{id}/reset', [App\Http\Controllers\AdminController::class, 'resetAntrian'])->name('admin.antrian.reset');
    Route::delete('/antrian/{id}', [App\Http\Controllers\AdminController::class, 'deleteAntrian'])->name('admin.antrian.delete');
    Route::get('/antrian/{id}', [App\Http\Controllers\AdminController::class, 'getAntrian'])->name('admin.antrian.get');
    Route::get('/data-pasien', [App\Http\Controllers\AdminController::class, 'dataPasien'])->name('admin.data-pasien');
    Route::get('/data-pasien/arsip', [App\Http\Controllers\AdminController::class, 'dataPasienArchive'])->name('admin.data-pasien.archive');
    Route::get('/rekam-medis/view/{filename}', [AntrianController::class, 'viewRekamMedis'])->name('admin.rekammedis.view');
    Route::get('/rekam-medis/download/{filename}', [AntrianController::class, 'downloadRekamMedis'])->name('admin.rekammedis.download');
});

// Doctor Routes (JWT + Doctor Role)
Route::prefix('dokter')->middleware([JwtAuthenticate::class, RoleMiddleware::class . ':dokter'])->group(function () {
    Route::get('/', fn() => redirect()->route('dashboardoc'));
    Route::get('/dashboard', [AntrianController::class, 'showDoctorDashboard'])->name('dashboardoc');
    Route::get('/dashboard/ajax/antrian', [AntrianController::class, 'getAntrianDataAjax'])->name('dashboardoc.ajax');
    Route::get('/arsip', [AntrianController::class, 'showDoctorArchive'])->name('dokter.archive');
    Route::post('/antrian/{id}/upload-rekam-medis', [AntrianController::class, 'uploadRekamMedis'])->name('uploadRekamMedis');
    Route::get('/antrian/{id}/diagnosa', [AntrianController::class, 'getDiagnosa'])->name('dokter.diagnosa.get');
    Route::post('/antrian/{id}/diagnosa', [AntrianController::class, 'saveDiagnosa'])->name('dokter.diagnosa.save');
    Route::get('/rekam-medis/view/{filename}', [AntrianController::class, 'viewRekamMedis'])->name('rekammedis.view');
    Route::get('/rekam-medis/download/{filename}', [AntrianController::class, 'downloadRekamMedis'])->name('rekammedis.download');
});

// Legacy routes - redirect to prevent breaking old links
Route::get('/dashboard', fn() => redirect()->route('home'));
Route::get('/dashboard/antrian/{poli}', [AntrianController::class, 'showAntrianByPoli'])->name('antrian.poli');
Route::delete('/dashboard/antrian/{id}', [AntrianController::class, 'destroy'])->name('antrian.destroy');
Route::get('/dashboard/antrian/edit/{id}', [AntrianController::class, 'edit'])->name('antrian.edit');
Route::put('/dashboard/antrian/update/{id}', [AntrianController::class, 'updateAntrian']);
Route::resource('/dashboard/antrian', AntrianController::class)
    ->only(['index', 'store', 'edit', 'update', 'destroy']);