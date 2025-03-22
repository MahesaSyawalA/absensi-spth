<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ScanController extends Controller
{
    public function validateAttendance(Request $request)
    {
        if (!$request->has(['latitude', 'longitude'])) {
            return response()->json(['error' => 'Latitude and longitude are required'], 400);
        }

        $attendanceTime = Carbon::now();
        $attendanceTime->setTimezone('Asia/Jakarta');

        $userLatitude = $request->latitude;
        $userLongitude = $request->longitude;

        $officeLatitude = -6.92972;
        $officeLongitude = 107.76972;

        $distance = $this->calculateDistance($officeLatitude, $officeLongitude, $userLatitude, $userLongitude);
        $radius = 0.005; // radius 5 meter

        if ($distance <= $radius) {
            return response()->json([
                'message' => 'Anda berhasil absen!',
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'time' => $attendanceTime->toDayDateTimeString(),
            ], 200);
        } else {
            return response()->json([
                'message' => 'Tidak dapat absen, anda berada diluar area absen.',
            ], 403);
        }
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371;

        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        $latDiff = $lat2 - $lat1;
        $lonDiff = $lon2 - $lon1;

        $a = sin($latDiff / 2) * sin($latDiff / 2) +
            cos($lat1) * cos($lat2) *
            sin($lonDiff / 2) * sin($lonDiff / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c; // jarak dalam kilometer
    }
}
