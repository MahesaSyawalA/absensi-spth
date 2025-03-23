<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RekapanPenilaianBulanan;
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


        $rekapan = RekapanPenilaianBulanan::with('user:id,nama') // Ambil hanya id dan nama dari users
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'nama' => $item->user->nama, // Ambil nama user dari relasi
                    'bulan' => $item->bulan,
                    'tahun' => $item->tahun,
                    'total_penilaian' => $item->total_penilaian,
                    'avg_perilaku_petugas' => $item->avg_perilaku_petugas,
                    'avg_penampilan' => $item->avg_penampilan,
                    'avg_kecepatan_pelayanan' => $item->avg_kecepatan_pelayanan,
                    'avg_ketepatan_transparansi' => $item->avg_ketepatan_transparansi,
                ];
            });

            $topAsn = RekapanPenilaianBulanan::with('user:id,nama,status_pegawai')
            ->whereHas('user', function ($query) {
                $query->where('status_pegawai', 'ASN');
            })
            ->get()
            ->map(function ($item) {
                return [
                    'nama' => $item->user->nama,
                    'total_penilaian' => $item->total_penilaian,
                    'total_avg' => ($item->avg_perilaku_petugas + $item->avg_penampilan + $item->avg_kecepatan_pelayanan + $item->avg_ketepatan_transparansi) / 4
                ];
            })
            ->sortByDesc('total_avg') // Urutkan berdasarkan total_avg dari terbesar
            ->take(1); // Ambil 10 besar

        $topNonAsn = RekapanPenilaianBulanan::with('user:id,nama,status_pegawai')
            ->whereHas('user', function ($query) {
                $query->where('status_pegawai', 'Non ASN');
            })
            ->get()
            ->map(function ($item) {
                return [
                    'nama' => $item->user->nama,
                    'total_penilaian' => $item->total_penilaian,
                    'total_avg' => ($item->avg_perilaku_petugas + $item->avg_penampilan + $item->avg_kecepatan_pelayanan + $item->avg_ketepatan_transparansi) / 4
                ];
            })
            ->sortByDesc('total_avg') // Urutkan berdasarkan total_avg dari terbesar
            ->take(1); // Ambil 10 besar


        $data = [
            'title' => 'Rekap Penilaian',
            'top_pegawai' => $topEmployees,
            'rekapan' => $rekapan,
            'topAsn'=>$topAsn,
            'topNonAsn' => $topNonAsn
        ];
        return view('admin.rekapPenilaian', $data);
    }
}
