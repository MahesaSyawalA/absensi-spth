<?php

use App\Http\Controllers\Admin\KriteriaPenilaianController;
use App\Http\Controllers\Admin\RekapPenilaianController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthSessionController;
use App\Http\Controllers\Client\AbsensiController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Middleware\SanitizeInput;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthSessionController::class, 'index'])->name('auth.index');

// Route::get('/admin', [AdminController::class,'index']);
Route::get('/admin/management-user', [UserController::class, 'index'])->name('user.index');
Route::post('/users', [UserController::class, 'store'])->middleware('sanitize')->name('user.store');
Route::put('/users/{nip}', [UserController::class, 'update'])->middleware('sanitize')->name('users.update');
Route::get('/users/{nip}', [UserController::class, 'edit'])->name('users.edit');
Route::delete('/users/{nip}', [UserController::class, 'destroy'])->name('users.destroy');

Route::get('/admin/rekap-penilaian', [RekapPenilaianController::class, 'index']);
Route::get('/admin/kriteria-penilaian', [KriteriaPenilaianController::class, 'index']);


Route::get('/staff/absensi', [AbsensiController::class, 'index']);
Route::get('/staff/profile', [ProfileController::class, 'index']);
