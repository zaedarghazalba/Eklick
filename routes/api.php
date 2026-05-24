<?php

use App\Http\Controllers\AntrianController;
use App\Http\Controllers\Api\UnifiedAuthController;
use App\Http\Middleware\JwtAuthenticate;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

// Public API Routes (No JWT required)
Route::prefix('auth')->group(function () {
    Route::post('/login', [UnifiedAuthController::class, 'login']);
    Route::post('/register', [UnifiedAuthController::class, 'register']);
    Route::post('/refresh', [UnifiedAuthController::class, 'refreshToken']);
});

// Public Antrian Routes (No Auth Required - for public viewing)
Route::prefix('antrian')->group(function () {
    Route::get('/', [AntrianController::class, 'daftarAPI']);
    Route::post('/send', [AntrianController::class, 'store']);
    Route::get('/kuota', [AntrianController::class, 'getAntrianByPoliAndDate']);
    Route::get('/poli/{poli}', [AntrianController::class, 'showAntrianByPoli']);
    Route::post('/filter', [AntrianController::class, 'filterAntrian']);
});

// Protected Routes (JWT Required)
Route::middleware(['jwt.auth'])->group(function () {
    // User Profile - accessible by all authenticated users
    Route::get('/profile', [UnifiedAuthController::class, 'profile']);
    Route::put('/profile', [UnifiedAuthController::class, 'updateProfile']);
    Route::get('/me', [UnifiedAuthController::class, 'me']);
    Route::post('/logout', [UnifiedAuthController::class, 'logout']);

    // User's Antrian - accessible by all authenticated users
    Route::get('/antrianmu', [AntrianController::class, 'daftarAntrianAPI']);
    Route::get('/antrianmu/{id}', [AntrianController::class, 'getAntrianDetail']);

    // Doctor Routes (JWT + Doctor Role)
    Route::prefix('doctor')->middleware([RoleMiddleware::class . ':dokter'])->group(function () {
        Route::get('/dashboard', [AntrianController::class, 'showDoctorDashboard']);
        Route::get('/antrian', [AntrianController::class, 'getDoctorAntrian']);
        Route::post('/antrian/{id}/diagnosa', [AntrianController::class, 'saveDiagnosa']);
        Route::post('/antrian/{id}/upload-rekam-medis', [AntrianController::class, 'uploadRekamMedis']);
        Route::get('/antrian/{id}', [AntrianController::class, 'getDiagnosa']);
    });

    // Admin Routes (JWT + Admin Role)
    Route::prefix('admin')->middleware([RoleMiddleware::class . ':admin'])->group(function () {
        Route::get('/dashboard', [UnifiedAuthController::class, 'adminDashboard']);
        Route::get('/users', [UnifiedAuthController::class, 'getUsers']);
        Route::get('/doctors', [UnifiedAuthController::class, 'getDoctors']);
        Route::post('/doctors', [UnifiedAuthController::class, 'createDoctor']);
        Route::put('/doctors/{id}', [UnifiedAuthController::class, 'updateDoctor']);
        Route::delete('/doctors/{id}', [UnifiedAuthController::class, 'deleteDoctor']);
        Route::get('/antrian', [AntrianController::class, 'getAllAntrian']);
        Route::post('/antrian/{id}/panggil', [AntrianController::class, 'panggilAntrian']);
        Route::post('/antrian/{id}/skip', [AntrianController::class, 'skipAntrian']);
        Route::post('/antrian/{id}/selesai', [AntrianController::class, 'selesaiAntrian']);
        Route::post('/antrian/{id}/reset', [AntrianController::class, 'resetAntrian']);
        Route::delete('/antrian/{id}', [AntrianController::class, 'deleteAntrian']);
        Route::get('/antrian/{id}', [AntrianController::class, 'getAntrian']);
        Route::get('/pasien', [AntrianController::class, 'getAllPasien']);
        Route::get('/pasien/{id}', [AntrianController::class, 'getPasienDetail']);
    });
});

// Health Check - Public
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'message' => 'API is running',
        'timestamp' => now()->toIso8601String()
    ]);
});