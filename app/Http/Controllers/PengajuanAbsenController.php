<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Absensi;

class PengajuanAbsenController extends Controller
{
    public function index()
    {

        $absen_data = DB::table('absensi')
            ->join('users', 'absensi.user_id', '=', 'users.id') // Assuming 'user_id' and 'id' are the columns
            ->select('absensi.*', 'users.nama as nama_pegawai', 'users.nip as nip_pegawai')
            ->get();

        return view('admin.requestAbsen', [
            'absen_data' => $absen_data,
        ]);
    }
}
