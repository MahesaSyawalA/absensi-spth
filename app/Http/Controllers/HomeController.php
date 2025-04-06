<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\PenilaianKhusus;
use App\Models\PenilaianMasyarakat;
use App\Models\RekapanPenilaianBulanan;
use App\Models\SubKriteria;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {

        $topAsn = RekapanPenilaianBulanan::with('user:id,nama,status_pegawai,foto')
            ->whereHas('user', function ($query) {
                $query->where('status_pegawai', 'ASN');
            })
            ->get()
            ->map(function ($item) {
                return [
                    'foto' => $item->user->foto,
                    'nama' => $item->user->nama,
                    'total_penilaian' => $item->total_penilaian,
                    'total_avg' => ($item->avg_perilaku_petugas + $item->avg_penampilan + $item->avg_kecepatan_pelayanan + $item->avg_ketepatan_transparansi) / 4
                ];
            })
            ->sortByDesc('total_avg') // Urutkan berdasarkan total_avg dari terbesar
            ->take(1); // Ambil 10 besar

        $topNonAsn = RekapanPenilaianBulanan::with('user:id,nama,status_pegawai,foto')
            ->whereHas('user', function ($query) {
                $query->where('status_pegawai', 'Non ASN');
            })
            ->get()
            ->map(function ($item) {
                return [
                    'foto' => $item->user->foto,
                    'nama' => $item->user->nama,
                    'total_penilaian' => $item->total_penilaian,
                    'total_avg' => ($item->avg_perilaku_petugas + $item->avg_penampilan + $item->avg_kecepatan_pelayanan + $item->avg_ketepatan_transparansi) / 4
                ];
            })
            ->sortByDesc('total_avg') // Urutkan berdasarkan total_avg dari terbesar
            ->take(1);

        // dd($topAsn);

        $staffs = User::select('slug', 'nip', 'nama', 'jabatan', 'foto')->where('role', 'pegawai')->get();
        $data = [
            'staffs' => $staffs,
            'topAsn' => $topAsn,
            'topNonAsn' => $topNonAsn
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
            'slug' => $slug,
        ];
        return view('penilaian', $data);
    }

    public function storePenilaian(Request $request)
    {
        $user = Auth::user();
        $role = $user ? $user->role : null;

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'tujuan' => 'required|string|max:255',
            'pelayanan' => 'required|string|max:255',
            'subKriteria' => 'required|array',
            'subKriteria.*' => 'required|integer|min:10|max:50',
        ]);

        $selectedUser = User::select('id')->where('slug', $request->slug)->firstOrFail();

        $bulan = date('m');
        $tahun = date('Y');

        DB::beginTransaction();
        try {
            if ($role === 'penilai') {
                // Perhatikan perubahan di query ini: tambah where penilai_id
                $penilaian = PenilaianKhusus::where('user_id', $selectedUser->id)
                    ->where('penilai_id', $user->id)
                    ->where('bulan', $bulan)
                    ->where('tahun', $tahun)
                    ->first();

                $data = [
                    'penilai_id' => $user->id,
                    'user_id' => $selectedUser->id,
                    'nama' => $request->nama,
                    'email' => $request->email,
                    'tujuan' => $request->tujuan,
                    'pelayanan' => $request->pelayanan,
                    'perilaku_petugas' => $request->subKriteria[5] ?? null,
                    'penampilan' => $request->subKriteria[6] ?? null,
                    'kecepatan_pelayanan' => $request->subKriteria[7] ?? null,
                    'ketepatan_transparansi' => $request->subKriteria[8] ?? null,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                ];

                if ($penilaian) {
                    $penilaian->update($data);
                } else {
                    PenilaianKhusus::create($data);
                }
            } else {
                PenilaianMasyarakat::create([
                    'user_id' => $selectedUser->id,
                    'nama' => $request->nama,
                    'email' => $request->email,
                    'tujuan' => $request->tujuan,
                    'pelayanan' => $request->pelayanan,
                    'perilaku_petugas' => $request->subKriteria[5] ?? null,
                    'penampilan' => $request->subKriteria[6] ?? null,
                    'kecepatan_pelayanan' => $request->subKriteria[7] ?? null,
                    'ketepatan_transparansi' => $request->subKriteria[8] ?? null,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'Penilaian berhasil disimpan'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan', 'error' => $e->getMessage()], 500);
        }
    }
}
