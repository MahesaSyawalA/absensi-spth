<?php

use App\Http\Controllers\Api\ScanController;
use App\Http\Controllers\Client\AbsensiController;
use App\Http\Controllers\PengajuanAbsenController;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'is_pegawai'])->group(function () {
    Route::post('/attendance', [ScanController::class, 'validateAttendance']);
    Route::post('/attendance/absen-khusus', [PengajuanAbsenController::class, 'store'])->name('absen_khusus.store');
});
