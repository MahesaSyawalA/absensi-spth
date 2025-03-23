<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\PenilaianMasyarakat;
use App\Models\SubKriteria;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $staffs = User::select('slug','nip', 'nama', 'jabatan', 'foto')->get();
        $data = [
            'staffs' => $staffs,
        ];
        return view('home', $data);
    }

    public function indexPenilaian($slug)
    {
        $selectedUser = User::select('nama', 'nip', 'jabatan', 'jenis_kelamin', 'status_pegawai', 'foto')->where('slug', $slug)->firstOrFail();
        $kriteriaWithSub = Kriteria::with('subKriteria')->get();
        $data = [
            'kriteriaWithSub' => $kriteriaWithSub,
            'selectedUser' => $selectedUser,
            'slug'=>$slug,
        ];
        return view('penilaian', $data);
    }

    public function storePenilaian(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'tujuan' => 'required|string|max:255',
            'pelayanan' => 'required|string|max:255',
            'subKriteria' => 'required|array',
            'subKriteria.*' => 'required|integer|min:10|max:50',
        ]);


        // Cari user berdasarkan slug
        $selectedUser = User::select('id')->where('slug', $request->slug)->firstOrFail();

        DB::beginTransaction();
        try {
            // Simpan data ke tabel `penilaian_masyarakat`
            $penilaian = PenilaianMasyarakat::create([
                'user_id' => $selectedUser->id,
                'nama' => $request->nama,
                'email' => $request->email,
                'tujuan' => $request->tujuan,
                'pelayanan' => $request->pelayanan,
                'perilaku_petugas' => $request->subKriteria[5] ?? null,
                'penampilan' => $request->subKriteria[6] ?? null,
                'kecepatan_pelayanan' => $request->subKriteria[7] ?? null,
                'ketepatan_transparansi' => $request->subKriteria[8] ?? null,
            ]);

            DB::commit();
            return response()->json(['message' => 'Penilaian berhasil disimpan'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan', 'error' => $e->getMessage()], 500);
        }
    }
}
