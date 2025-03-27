<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Absensi;
use Illuminate\Support\Facades\DB;

class ScanController extends Controller
{
    public function validateAttendance(Request $request)
    {
        if (!$request->has(['latitude', 'longitude'])) {
            return response()->json(['error' => 'Latitude and longitude are required'], 400);
        }

        $id_pegawai = $request->id_pegawai;

        $currentDate = Carbon::now()->setTimeZone('Asia/Jakarta')->toDateString(); // tanggal hari ini dalam format YYYY-MM-DD
        $attendanceDateTime = Carbon::now()->setTimezone('Asia/Jakarta'); // waktu absen lengkap
        $attendanceTime = Carbon::now()->setTimezone('Asia/Jakarta')->format('H:i'); // waktu absen dalam format 23:59

        $userLatitude = $request->latitude;
        $userLongitude = $request->longitude;

        $officeLatitude = -6.932888;
        $officeLongitude = 107.771096;

        $gapuraLatitude = -6.886094;
        $gapuraLongitude = 107.763140;

        $distanceFromOffice = $this->calculateDistance($officeLatitude, $officeLongitude, $userLatitude, $userLongitude);
        $distanceFromGapura = $this->calculateDistance($gapuraLatitude, $gapuraLongitude, $userLatitude, $userLongitude);
        $radius = 20; // radius 20 meter

        if ($distanceFromOffice <= $radius || $distanceFromGapura <= $radius) {

            $absen1_start = '05:30';
            $absen1_end = '07:00';
            $absen1_max = '08:30';

            $absen2_start = '11:00';
            $absen2_end = '11:15';
            $absen2_max = '11:30';

            $absen3_start = '13:00';
            $absen3_end = '13:15';
            $absen3_max = '13:30';

            $absen4_start = '16:00';
            $absen4_end = '17:30';

            // Pengkondisian absen ke berapa dan keterangan terlambat/tepat waktu
            if ($attendanceTime >= $absen1_start && $attendanceTime <= $absen1_end) {
                $absen_ke = 1;
                $keterangan = 'Tepat Waktu';
            } elseif ($attendanceTime > $absen1_end && $attendanceTime <= $absen1_max) {
                $absen_ke = 1;
                $keterangan = 'Terlambat';
            } elseif ($attendanceTime >= $absen2_start && $attendanceTime <= $absen2_end) {
                $absen_ke = 2;
                $keterangan = 'Tepat Waktu';
            } elseif ($attendanceTime > $absen2_end && $attendanceTime <= $absen2_max) {
                $absen_ke = 2;
                $keterangan = 'Terlambat';
            } elseif ($attendanceTime >= $absen3_start && $attendanceTime <= $absen3_end) {
                $absen_ke = 3;
                $keterangan = 'Tepat Waktu';
            } elseif ($attendanceTime > $absen3_end && $attendanceTime <= $absen3_max) {
                $absen_ke = 3;
                $keterangan = 'Terlambat';
            } elseif ($attendanceTime >= $absen4_start && $attendanceTime <= $absen4_end) {
                $absen_ke = 4;
                $keterangan = 'Tepat Waktu';
            } else {
                return response()->json([
                    'message' => 'Tidak dapat absen, anda diluar jadwal absen!',
                    'time' => $attendanceTime,
                ], 200);
            }

            // pengkondisian kalau absensinya sudah ada atau lebih dari 2x
            $absensi_already_exist = DB::table('absensi')
                ->where('user_id', $id_pegawai)
                ->where('absen_ke', $absen_ke)
                ->whereDate('scanned_at', $currentDate)->get();

            if (count($absensi_already_exist) === 0) {
                $absen = new Absensi;
                $absen->user_id = $id_pegawai;
                $absen->absen_ke = $absen_ke;
                $absen->keterangan = $keterangan;
                $absen->latitude = $request->latitude;
                $absen->longitude = $request->longitude;
                $absen->scanned_at = $attendanceDateTime->toDateTimeString();
                $absen->save();
            } else {
                return response()->json([
                    'message' => "Anda sudah melakukan absen ke-$absen_ke pada hari ini. Silahkan menunggu untuk absen pada jadwal selanjutnya.",
                ], 403);
            }

            return response()->json([
                'message' => "Anda berhasil absen. ($keterangan)",
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'distanceFromOffice' => $distanceFromOffice,
                'distanceFromGapura' => $distanceFromGapura,
                'absen_ke' => $absen_ke ?? null,
                'datetime' => $attendanceDateTime->toDayDateTimeString(),
            ], 200);
        } else {
            return response()->json([
                'message' => 'Tidak dapat absen, anda berada diluar area absen.',
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'distanceFromOffice' => $distanceFromOffice,
                'distanceFromGapura' => $distanceFromGapura,
            ], 403);
        }
    }

    // rumus buat ngitung jarak pegawai dari tempat absen
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

        $distance = $earthRadius * $c;

        return round(($distance * 1000), 1); // jarak dalam meter
    }
}
