<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PenilaianKhusus;
use App\Models\RekapanAbsensiBulanan;
use App\Models\RekapanNilaiAkhir;
use App\Models\RekapanPenilaianBulanan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class RekapPenilaianController extends Controller
{

    public function index(Request $request)
    {
        // Ambil bulan dari request
        $bulanAwal = $request->input('bulan_awal');
        $bulanAkhir = $request->input('bulan_akhir');

        // penilaian akhir
        $penilaianAkhirQuery = RekapanNilaiAkhir::with('user');

        if ($bulanAwal && $bulanAkhir) {
            $penilaianAkhirQuery->whereBetween('bulan', [$bulanAwal, $bulanAkhir]);
        }

        $penilaianAkhir = $penilaianAkhirQuery->orderByDesc('nilai_akhir')->get();
        // end penilian akhir

        $topEmployeesAttendanceQuery = RekapanAbsensiBulanan::with('user');

        if ($bulanAwal && $bulanAkhir) {
            $topEmployeesAttendanceQuery->whereBetween('bulan', [$bulanAwal, $bulanAkhir]);
        }

        $topEmployeesAttendance = $topEmployeesAttendanceQuery->orderByDesc('total_poin')->get();


        $topEmployees = DB::table('absensi as a')
            ->join('users as u', 'a.user_id', '=', 'u.id')
            ->select('u.nama', DB::raw('COUNT(a.id) as total_scans'))
            ->groupBy('u.nama')
            ->orderByDesc('total_scans')
            ->get();


        // ASN
        $top1ASNEmployeeAttendance = RekapanAbsensiBulanan::whereHas('user', function ($query) {
            $query->where('status_pegawai', 'ASN');
        })
            ->with('user')
            ->orderByDesc('total_poin')
            ->limit(1)
            ->get();

        // Non ASN
        $top1NonASNEmployeeAttendance = RekapanAbsensiBulanan::whereHas('user', function ($query) {
            $query->where('status_pegawai', 'Non ASN');
        })
            ->with('user')
            ->orderByDesc('total_poin')
            ->limit(1)
            ->get();


        $rekapanQuery = RekapanPenilaianBulanan::with('user:id,nama');

        if ($bulanAwal && $bulanAkhir) {
            $rekapanQuery->whereBetween('bulan', [$bulanAwal, $bulanAkhir]);
        }

        $rekapan = $rekapanQuery
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'nama' => $item->user->nama,
                    'bulan' => $item->bulan,
                    'tahun' => $item->tahun,
                    'total_penilaian' => $item->total_penilaian,
                    'avg_perilaku_petugas' => $item->avg_perilaku_petugas,
                    'avg_penampilan' => $item->avg_penampilan,
                    'avg_kecepatan_pelayanan' => $item->avg_kecepatan_pelayanan,
                    'avg_ketepatan_transparansi' => $item->avg_ketepatan_transparansi,
                ];
            });

        $rekapPenilaianKhususQuery = PenilaianKhusus::with(['user', 'penilai']);

        if ($bulanAwal && $bulanAkhir) {
            $rekapPenilaianKhususQuery->whereBetween('bulan', [$bulanAwal, $bulanAkhir]);
        }

        $rekapPenilaianKhusus = $rekapPenilaianKhususQuery
            ->orderByDesc(DB::raw('perilaku_petugas + penampilan + kecepatan_pelayanan + ketepatan_transparansi'))
            ->get();


        // dd($rekapPenilaianKhususQuery);

        $topAsn = $penilaianAkhir
            ->filter(function ($item) {
                return $item->user && $item->user->status_pegawai === 'ASN';
            })
            ->sortByDesc('nilai_akhir')
            ->take(1);

        $topNonAsn = $penilaianAkhir
            ->filter(function ($item) {
                return $item->user && $item->user->status_pegawai === 'Non ASN';
            })
            ->sortByDesc('nilai_akhir')
            ->take(1); // Ambil 10 besar
            // dd($topNonAsn);


        $data = [
            'title' => 'Rekap Penilaian',
            'topEmployeesAttendance' => $topEmployeesAttendance,
            'top_pegawai' => $topEmployees,
            'top1_asn' => $top1ASNEmployeeAttendance,
            'top1_nonasn' => $top1NonASNEmployeeAttendance,
            'rekapan' => $rekapan,
            'topAsn' => $topAsn,
            'topNonAsn' => $topNonAsn->values(),
            'penilaianAkhir' => $penilaianAkhir->values(),
            'rekapPenilaianKhusus' => $rekapPenilaianKhusus,
        ];
        return view('admin.rekapPenilaian', $data);
    }
}
