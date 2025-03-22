<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;

        Carbon::setLocale('id');
        $currentDate = Carbon::now()->setTimeZone('Asia/Jakarta')->toDateString();
        $currentMonth = Carbon::now()->timezone('Asia/Jakarta')->translatedFormat('F');
        $startDate = Carbon::now()->timezone('Asia/Jakarta')->startOfMonth();
        $endDate = Carbon::now()->timezone('Asia/Jakarta')->endOfMonth();
        $period = CarbonPeriod::create($startDate, $endDate); // seluruh tanggal pada bulan itu
        $absensi_today = DB::table('absensi')->whereDate('scanned_at', $currentDate)->get(); // absensi per hari ini
        $list_absensi = [];

        // cek setiap absensi per hari ini apakah ada
        $check_absensi_today = array_fill(0, 4, false);
        foreach ($absensi_today as $at) {
            $check_absensi_today[$at->absen_ke - 1] = true;
        }

        $all_absensi_user = DB::table('absensi')
            ->whereBetween('scanned_at', [$startDate, $endDate])
            ->where('user_id', $user_id)
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->scanned_at)->toDateString();
            });

        foreach ($period as $date) {
            $formatted_date = $date->format('Y-m-d');
            $list_absensi[$formatted_date] = $all_absensi_user[$formatted_date] ?? [];
        }

        $data = [
            'title' => 'Absensi',
            'period' => $period,
            'month' => $currentMonth,
            'list_absensi' => $list_absensi,
            'absensi_1' => $check_absensi_today[0],
            'absensi_2' => $check_absensi_today[1],
            'absensi_3' => $check_absensi_today[2],
            'absensi_4' => $check_absensi_today[3],
        ];
        return view('client.absensi', $data);
    }

    public function absen()
    {
        return view('client.scanqr', [
            'user' => Auth::user(),
        ]);
    }
}
