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
        // Inisialisasi tahun sekarang
        $tahunSekarang = date('Y');

        // Ambil bulan dari request dengan default null
        $bulanAwal = $request->input('bulan_awal');
        $bulanAkhir = $request->input('bulan_akhir');

        // Query untuk penilaian akhir dengan default empty collection
        $penilaianAkhirQuery = RekapanNilaiAkhir::with(['user' => function ($query) {
            $query->select('id', 'nama', 'status_pegawai');
        }])->where('tahun', $tahunSekarang);

        if ($bulanAwal && $bulanAkhir) {
            $penilaianAkhirQuery->whereBetween('bulan', [$bulanAwal, $bulanAkhir]);
        }

        $penilaianAkhir = $penilaianAkhirQuery->orderByDesc('nilai_akhir')->get() ?? collect();

        // Query untuk absensi dengan default empty collection
        $topEmployeesAttendanceQuery = RekapanAbsensiBulanan::with(['user' => function ($query) {
            $query->select('id', 'nama');
        }])->where('tahun', $tahunSekarang);

        if ($bulanAwal && $bulanAkhir) {
            $topEmployeesAttendanceQuery->whereBetween('bulan', [$bulanAwal, $bulanAkhir]);
        }

        $topEmployeesAttendance = $topEmployeesAttendanceQuery->orderByDesc('total_poin')->get() ?? collect();

        // Query untuk top employees dengan default empty collection
        $topEmployees = DB::table('absensi as a')
            ->join('users as u', 'a.user_id', '=', 'u.id')
            ->select('u.nama', DB::raw('COUNT(a.id) as total_scans'))
            ->groupBy('u.nama')
            ->orderByDesc('total_scans')
            ->get() ?? collect();

        // Query untuk top ASN dengan default empty collection
        $top1ASNEmployeeAttendance = RekapanAbsensiBulanan::whereHas('user', function ($query) {
            $query->where('status_pegawai', 'ASN');
        })
            ->with(['user' => function ($query) {
                $query->select('id', 'nama');
            }])
            ->orderByDesc('total_poin')
            ->limit(1)
            ->get() ?? collect();

        // Query untuk top Non ASN dengan default empty collection
        $top1NonASNEmployeeAttendance = RekapanAbsensiBulanan::whereHas('user', function ($query) {
            $query->where('status_pegawai', 'Non ASN');
        })
            ->with(['user' => function ($query) {
                $query->select('id', 'nama');
            }])
            ->orderByDesc('total_poin')
            ->limit(1)
            ->get() ?? collect();

        // Query untuk rekapan penilaian dengan default empty collection
        $rekapanQuery = RekapanPenilaianBulanan::with(['user' => function ($query) {
            $query->select('id', 'nama');
        }])->where('tahun', $tahunSekarang);

        if ($bulanAwal && $bulanAkhir) {
            $rekapanQuery->whereBetween('bulan', [$bulanAwal, $bulanAkhir]);
        }

        $rekapan = $rekapanQuery
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'nama' => optional($item->user)->nama ?? 'N/A',
                    'bulan' => $item->bulan ?? 'N/A',
                    'tahun' => $item->tahun ?? 'N/A',
                    'total_penilaian' => $item->total_penilaian ?? 0,
                    'avg_perilaku_petugas' => $item->avg_perilaku_petugas ?? 0,
                    'avg_penampilan' => $item->avg_penampilan ?? 0,
                    'avg_kecepatan_pelayanan' => $item->avg_kecepatan_pelayanan ?? 0,
                    'avg_ketepatan_transparansi' => $item->avg_ketepatan_transparansi ?? 0,
                ];
            }) ?? collect();

        // Query untuk penilaian khusus dengan default empty collection
        $rekapPenilaianKhususQuery = PenilaianKhusus::with([
            'user' => function ($query) {
                $query->select('id', 'nama');
            },
            'penilai' => function ($query) {
                $query->select('id', 'nama');
            }
        ])->where('tahun', $tahunSekarang);

        if ($bulanAwal && $bulanAkhir) {
            $rekapPenilaianKhususQuery->whereBetween('bulan', [$bulanAwal, $bulanAkhir]);
        }

        $rekapPenilaianKhusus = $rekapPenilaianKhususQuery
            ->orderByDesc(DB::raw('perilaku_petugas + penampilan + kecepatan_pelayanan + ketepatan_transparansi'))
            ->get()
            ->map(function ($item) {
                return [
                    'penilai' => [
                        'nama' => optional($item->penilai)->nama ?? 'N/A'
                    ],
                    'user' => [
                        'nama' => optional($item->user)->nama ?? 'N/A'
                    ],
                    'bulan' => $item->bulan ?? 'N/A',
                    'tahun' => $item->tahun ?? 'N/A',
                    'perilaku_petugas' => $item->perilaku_petugas ?? 0,
                    'penampilan' => $item->penampilan ?? 0,
                    'kecepatan_pelayanan' => $item->kecepatan_pelayanan ?? 0,
                    'ketepatan_transparansi' => $item->ketepatan_transparansi ?? 0,
                ];
            }) ?? collect();

        // Filter untuk top ASN dan Non ASN
        $topAsn = $penilaianAkhir
            ->filter(function ($item) {
                return optional($item->user)->status_pegawai === 'ASN';
            })
            ->sortByDesc('nilai_akhir')
            ->take(1)
            ->values() ?? collect();

        $topNonAsn = $penilaianAkhir
            ->filter(function ($item) {
                return optional($item->user)->status_pegawai === 'Non ASN';
            })
            ->sortByDesc('nilai_akhir')
            ->take(1)
            ->values() ?? collect();

        return view('admin.rekapPenilaian', [
            'title' => 'Rekap Penilaian',
            'topEmployeesAttendance' => $topEmployeesAttendance,
            'top_pegawai' => $topEmployees,
            'top1_asn' => $top1ASNEmployeeAttendance,
            'top1_nonasn' => $top1NonASNEmployeeAttendance,
            'rekapan' => $rekapan,
            'topAsn' => $topAsn,
            'topNonAsn' => $topNonAsn,
            'penilaianAkhir' => $penilaianAkhir,
            'rekapPenilaianKhusus' => $rekapPenilaianKhusus,
        ]);
    }
}
