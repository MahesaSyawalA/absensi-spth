<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Absensi;
use App\Models\PengajuanAbsen;
use Illuminate\Validation\Rule;

class PengajuanAbsenController extends Controller
{
    public function index()
    {

        $absen_data = PengajuanAbsen::all();

        dd($absen_data);

        return view('admin.requestAbsen', [
            'absen_data' => $absen_data,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|string',
            'nip_pegawai' => 'required|string',
            'nama_pegawai' => 'required|string',
            'jenis_absen' => [Rule::enum(PengajuanAbsen::class)],
            'dokumen' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $tanggal_pengajuan = Carbon::now()->setTimezone('Asia/Jakarta');
        $dokumen_path = '';

        if ($request->hasFile('dokumen')) {
            $file = $request->file('dokumen');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('dokumen/absen-khusus'), $filename);
            $dokumen_path = 'dokumen/absen-khusus/' . $filename;
        }

        $absen_diajukan = PengajuanAbsen::create([
            'user_id' => $request->user_id,
            'nip_pegawai' => $request->nip_pegawai,
            'nama_pegawai' => $request->nama_pegawai,
            'jenis_absen' => $request->jenis_absen,
            'dokumen' => $dokumen_path,
            'status' => 'Pending',
            'tanggal_pengajuan' => $tanggal_pengajuan,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Absen khusus berhasil diajukan.',
            'absen_diajukan' => $absen_diajukan,
        ]);
    }
}
