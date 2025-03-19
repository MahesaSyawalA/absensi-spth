<?php

use App\Http\Controllers\Admin\KriteriaPenilaianController;
use App\Http\Controllers\Admin\RekapPenilaianController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthSessionController;
use App\Http\Controllers\Client\AbsensiController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\SanitizeInput;
use Illuminate\Support\Facades\Route;

Route::get('/',[HomeController::class,'index']);

Route::get('/login', [AuthSessionController::class, 'index'])->name('auth.index');

// Route::get('/admin', [AdminController::class,'index']);
Route::get('/admin/management-user', [UserController::class, 'index'])->name('user.index');

Route::post('/users', [UserController::class, 'store'])->middleware('sanitize')->name('user.store');
Route::get('/users/{nip}', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{nip}', [UserController::class, 'update'])->middleware('sanitize')->name('users.update');
Route::delete('/users/{nip}', [UserController::class, 'destroy'])->name('users.destroy');

Route::post('/kriteria', [KriteriaPenilaianController::class, 'store'])->middleware('sanitize')->name('kriteria.store');
Route::delete('/kriteria/{id}', [KriteriaPenilaianController::class, 'destroy'])->name('kriteria.destroy');
Route::post('/sub-kriteria', [KriteriaPenilaianController::class, 'storeSubKriteria'])->middleware('sanitize')->name('subKriteria.store');
Route::delete('/sub-kriteria/{id}', [KriteriaPenilaianController::class, 'destroySubKriteria'])->name('subKriteria.destroy');

Route::get('/admin/rekap-penilaian', [RekapPenilaianController::class, 'index']);
Route::get('/admin/kriteria-penilaian', [KriteriaPenilaianController::class, 'index']);

Route::get('/staff/absensi', [AbsensiController::class, 'index']);
Route::get('/staff/absen-scan', [AbsensiController::class, 'absen']);
Route::get('/staff/profile', [ProfileController::class, 'index']);
