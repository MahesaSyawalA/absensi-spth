<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    public function index(){
        $user_id = Auth::user()->id;
        
        Carbon::setLocale('id');
        $currentMonth = Carbon::now()->timezone('Asia/Jakarta')->translatedFormat('F');
        $startDate = Carbon::now()->timezone('Asia/Jakarta')->startOfMonth();
        $endDate = Carbon::now()->timezone('Asia/Jakarta')->endOfMonth();
        $period = CarbonPeriod::create($startDate, $endDate); // seluruh tanggal pada bulan itu
        $list_absensi = [];

        $all_absensi_user = DB::table('absensi')
        ->whereBetween('scanned_at', [$startDate, $endDate])
        ->where('user_id', $user_id)
        ->get()
        ->groupBy(function($item) {
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
        ];
        return view('client.absensi',$data);
    }

    public function absen() {
        return view('client.scanqr', [
            'user' => Auth::user(),
        ]);
    }
}
