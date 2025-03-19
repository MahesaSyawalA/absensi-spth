<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ScanController extends Controller
{
    public function validateAttendance(Request $request) {
        if (!$request->has(['latitude', 'longitude'])) {
            return response()->json(['error' => 'Latitude and longitude are required'], 400);
        }

        $attendanceTime = Carbon::now();
        $attendanceTime->setTimezone('Asia/Jakarta');

        return response()->json([
            'message' => 'Anda berhasil absen!',
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'time' => $attendanceTime->toDayDateTimeString(),
        ]);
    }
}
