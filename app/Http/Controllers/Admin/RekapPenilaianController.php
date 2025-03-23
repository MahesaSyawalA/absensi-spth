<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RekapPenilaianController extends Controller
{

    public function index()
    {
        $topEmployees = DB::table('absensi as a')
        ->join('users as u', 'a.user_id', '=', 'u.id')
        ->select('u.nama', DB::raw('COUNT(a.id) as total_scans'))
        ->groupBy('u.nama')
        ->orderByDesc('total_scans')
        ->get();

        $data = [
            'title' => 'Rekap Penilaian',
            'top_pegawai' => $topEmployees,
        ];
        return view('admin.rekapPenilaian', $data);
    }
}
