<?php

use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\KriteriaPenilaianController;
use App\Http\Controllers\Admin\RekapPenilaianController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthSessionController;
use App\Http\Controllers\Client\AbsensiController;
use App\Http\Controllers\Client\PenilaiController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Api\ScanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PengajuanAbsenController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/penilaian-staff/{slug}', [HomeController::class, 'indexPenilaian'])->name('index.penilaian');
Route::post('/penilaian-staff', [HomeController::class, 'storePenilaian'])->middleware('sanitize')->name('store.penilaian');

Route::get('/login', [AuthSessionController::class, 'index'])->name('login');

// Route untuk proses login
Route::post('/login', [AuthSessionController::class, 'login'])->name('login.post');

// Route untuk proses logout
Route::post('/logout', [AuthSessionController::class, 'logout'])->name('logout');
Route::get('/check-login', [AuthSessionController::class, 'checkLoginStatus']);


// Route yang dilindungi auth
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/profile', [AdminProfileController::class, 'index'])->name('admin.profile');

    Route::get('/admin/management-user', [UserController::class, 'index'])->name('management-user');
    Route::post('/users', [UserController::class, 'store'])->middleware('sanitize')->name('user.store');
    Route::get('/users/{nip}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{nip}', [UserController::class, 'update'])->middleware('sanitize')->name('users.update');
    Route::delete('/users/{nip}', [UserController::class, 'destroy'])->name('users.destroy');


    Route::post('/kriteria', [KriteriaPenilaianController::class, 'store'])->middleware('sanitize')->name('kriteria.store');
    Route::delete('/kriteria/{id}', [KriteriaPenilaianController::class, 'destroy'])->name('kriteria.destroy');
    Route::post('/sub-kriteria', [KriteriaPenilaianController::class, 'storeSubKriteria'])->middleware('sanitize')->name('subKriteria.store');
    Route::delete('/sub-kriteria/{id}', [KriteriaPenilaianController::class, 'destroySubKriteria'])->name('subKriteria.destroy');

    Route::get('/admin/rekap-penilaian', [RekapPenilaianController::class, 'index'])->name('admin.index');
    Route::get('/admin/kriteria-penilaian', [KriteriaPenilaianController::class, 'index']);

    Route::get('/admin/pengajuan-absen', [PengajuanAbsenController::class, 'index'])->name('admin.pengajuan-absen');
    Route::put('/admin/pengajuan-absen/{id}', [PengajuanAbsenController::class, 'approveOrReject'])->name('admin.pengajuan-acc-atau-tolak');
});

Route::middleware(['auth', 'is_pegawai'])->group(function () {
    Route::get('/staff/absensi', [AbsensiController::class, 'index'])->name('staff.index');
    Route::get('/staff/absen-khusus', [AbsensiController::class, 'absenKhusus']);
    Route::get('/staff/absen-scan', [AbsensiController::class, 'absen']);
    Route::get('/staff/profile', [ProfileController::class, 'index']);
    Route::post('/attendance', [ScanController::class, 'validateAttendance'])->name('absen.scan');
    Route::post('/attendance/absen-khusus', [PengajuanAbsenController::class, 'store'])->name('absen_khusus.store');
    Route::get('/attendance/absen-khusus/history/{user_id}', [PengajuanAbsenController::class, 'history'])->name('absen_khusus.history');
});

Route::get('/penilai', [PenilaiController::class, 'index'])->middleware('is_penilai')->name('penilai.index');
Route::get('/print', [HomeController::class, 'print'])->name('print-rekap-penilaian');
