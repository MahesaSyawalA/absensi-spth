<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\PenilaianKhusus;
use App\Models\RekapanAbsensiBulanan;
use App\Models\RekapanNilaiAkhir;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PenilaiController extends Controller
{
    public function index(Request $request)
    {
        // Ambil nilai filter dari request
        $bulanAwal = $request->input('bulan_awal');
        $bulanAkhir = $request->input('bulan_akhir');
        $tahun = $request->input('tahun');

        // Query untuk RekapanNilaiAkhir dengan filter
        $penilaianAkhirQuery = RekapanNilaiAkhir::with(['user' => function ($query) {
            $query->select('id', 'nama', 'status_pegawai');
        }]);

        // Terapkan filter jika ada
        if ($bulanAwal && $bulanAkhir && $tahun) {
            $penilaianAkhirQuery->where(function ($query) use ($bulanAwal, $bulanAkhir, $tahun) {
                $query->where('tahun', $tahun)
                    ->whereBetween('bulan', [$bulanAwal, $bulanAkhir]);
            });
        }

        $penilaianAkhir = $penilaianAkhirQuery->orderByDesc('nilai_akhir')->get() ?? collect();

        // Query untuk RekapanAbsensiBulanan dengan filter
        $rekapanAbsensiQuery = RekapanAbsensiBulanan::with('user');

        if ($bulanAwal && $bulanAkhir && $tahun) {
            $rekapanAbsensiQuery->where(function ($query) use ($bulanAwal, $bulanAkhir, $tahun) {
                $query->where('tahun', $tahun)
                    ->whereBetween('bulan', [$bulanAwal, $bulanAkhir]);
            });
        }

        $rekapanAbsensi = $rekapanAbsensiQuery->get();

        // Query untuk User dengan filter
        $usersQuery = User::where('role', 'pegawai')
            ->select('id', 'slug', 'nama', 'nip', 'jabatan')
            ->with(['penilaianMasyarakat' => function ($query) use ($bulanAwal, $bulanAkhir, $tahun) {
                $query->select(
                    'user_id',
                    DB::raw('ROUND(AVG(avg_perilaku_petugas), 2) as avg_perilaku_petugas'),
                    DB::raw('ROUND(AVG(avg_penampilan), 2) as avg_penampilan'),
                    DB::raw('ROUND(AVG(avg_kecepatan_pelayanan), 2) as avg_kecepatan_pelayanan'),
                    DB::raw('ROUND(AVG(avg_ketepatan_transparansi), 2) as avg_ketepatan_transparansi'),
                    DB::raw('ROUND(AVG((avg_perilaku_petugas + avg_penampilan + avg_kecepatan_pelayanan + avg_ketepatan_transparansi) / 4), 2) as avg_total')
                );

                if ($bulanAwal && $bulanAkhir && $tahun) {
                    $query->where('tahun', $tahun)
                        ->whereBetween('bulan', [$bulanAwal, $bulanAkhir]);
                }

                $query->groupBy('user_id');
            }]);

        $users = $usersQuery->get();

        // Query untuk riwayat penilaian dengan filter
        $userSession = Auth::user();
        $riwayatPenilaianQuery = PenilaianKhusus::where('penilai_id', $userSession->id)
            ->with(['user:id,nama,jabatan,status_pegawai']);

        if ($bulanAwal && $bulanAkhir && $tahun) {
            $riwayatPenilaianQuery->where(function ($query) use ($bulanAwal, $bulanAkhir, $tahun) {
                $query->where('tahun', $tahun)
                    ->whereBetween('bulan', [$bulanAwal, $bulanAkhir]);
            });
        }

        $riwayatPenilaian = $riwayatPenilaianQuery->get();

        $data = [
            'title' => 'Penilaian',
            'users' => $users,
            'riwayatPenilaian' => $riwayatPenilaian,
            'penilaianAkhir' => $penilaianAkhir,
            'rekapanAbsensi' => $rekapanAbsensi,
            'filter' => [
                'bulan_awal' => $bulanAwal,
                'bulan_akhir' => $bulanAkhir,
                'tahun' => $tahun
            ]
        ];

        return view('client.penilai.penilaian', $data);
    }
}
