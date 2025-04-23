<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\PengajuanAbsen;
use App\Models\Absensi;

class PengajuanAbsenController extends Controller
{
    public function index()
    {
        $absen_data = PengajuanAbsen::all()->where('status', '=', 'Pending');

        return view('admin.requestAbsen', [
            'absen_data' => $absen_data,
        ]);
    }

    public function history($user_id)
    {
        $history_pengajuan_user = PengajuanAbsen::all()
        ->where('status', '=', 'Pending')
        ->where('id', $user_id);

        return view('client.absensiKhususHistory', [
            'data' => $history_pengajuan_user,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|string',
            'nip_pegawai' => 'required|string',
            'nama_pegawai' => 'required|string',
            'jenis_absen' => 'required|string|in:Dinas,Sakit,WFH',
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

    public function approveOrReject(Request $request, $id)
    {
        // update status menjadi diterima/ditolak
        $attendanceRequest = PengajuanAbsen::where('id', $id)->first();
        $attendanceRequest->update([
            'status' => $request->updatedStatus,
        ]);

        // jika pengajuan absen diterima, buat absen baru
        try {
            if ($request->approval == "Yes") {
                Absensi::create([
                    'user_id' => $attendanceRequest->user_id,
                    'absen_ke' => 1,
                    'keterangan' => "Tepat Waktu",
                    'latitude' => -6.9328394,
                    'longitude' => 107.771067,
                    'scanned_at' => $attendanceRequest->tanggal_pengajuan,
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'failed' => true,
                'error' => $e,
            ]);
        }

        return response()->json([
            'success' => true,
            'id' => $request->attendanceReqId,
            'diterima' => $request->approval,
            'statusTerbaru' => $request->updatedStatus,
        ]);
    }
}
