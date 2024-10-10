<?php

use App\Http\Controllers\AntrianController;
use App\Http\Controllers\AuthControll;
use App\Http\Controllers\Contencontroll;
use App\Http\Controllers\RegisterController;
use App\Http\Middleware\SsoGoogle;
use Illuminate\Support\Facades\Route;

// Session
Route::get('/sso-google', [AuthControll::class, 'show'])->name('googlesso');
Route::post('/sso-google-manual', [AuthControll::class, 'loginmanual'])->name('aksi-login');
Route::get('/sso-google-redirect', [AuthControll::class, 'redirectToProvider'])->name('googlesso_redirect');
Route::get('/sso-callback', [AuthControll::class, 'handleProviderCallback'])->name('googlesso_callback');
Route::post('/sso-google-auto', [AuthControll::class, 'sso_auto'])->name('googlesso_auto');

// Antrian
Route::get('/antrian', [AntrianController::class, 'daftar'])->name('daftar');
Route::post('/antrian-send', [AntrianController::class, 'store'])->name('antrian.send');
Route::post('/filter-antrian', [AntrianController::class, 'filterAntrian'])->name('filter-antrian');




Route::get('/', [Contencontroll::class, 'index'])->name('index');
Route::get('/home', [Contencontroll::class, 'home'])->name('home')->middleware(SsoGoogle::class);
Route::get('/logout', [AuthControll::class, 'logout'])->name('logout')->middleware(SsoGoogle::class);

//isi data register
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register-send', [RegisterController::class, 'store'])->name('aksi-regist');




// Admin Routes
Route::get('/admin', function () {
    return view('adminItems.loginadmin');
});
// Dashboard Routes
Route::get('/dashboard', function () {
    return view('adminItems.Dasboard');
});
// Route to display antrian by poli
Route::get('/dashboard/antrian/{poli}', [AntrianController::class, 'showAntrianByPoli'])->name('antrian.poli');
// Route to call a specific antrian
Route::get('/panggil/{noAntrian}', [AntrianController::class, 'panggil']); // Route to call a queue number
Route::delete('/dashboard/antrian/{id}', [AntrianController::class, 'destroy'])->name('antrian.destroy');
// Resource routes for AntrianController
Route::resource('/dashboard/antrian', AntrianController::class)
    ->only(['index', 'store', 'edit', 'update', 'destroy']);


// Dokter Routes
Route::get('/dokter', function () {
    return view('doctorItems.logindoc');});
// Dashboard Routes
Route::get('/dashboardoc', function () {
    return view('doctorItems.Doctordashboard');
})->name('dashboardoc'); // Correctly defining the name here
Route::post('/antrian/{id}/upload-rekam-medis', [AntrianController::class, 'uploadRekamMedis'])->name('uploadRekamMedis');







Route::get('/cekcek', [AuthControll::class, 'simpanLogin']);
