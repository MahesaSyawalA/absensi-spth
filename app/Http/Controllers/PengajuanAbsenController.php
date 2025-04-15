<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;

class PengajuanAbsenController extends Controller
{
    public function index()
    {
        $absen_data = Absensi::orderBy('scanned_at')->get();
        
        return view('admin.requestAbsen', [
            'absen_data' => $absen_data,
        ]);
    }
}
