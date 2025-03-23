<?php

use App\Http\Controllers\Api\ScanController;
use App\Http\Controllers\Client\AbsensiController;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/attendance', [ScanController::class, 'validateAttendance']);