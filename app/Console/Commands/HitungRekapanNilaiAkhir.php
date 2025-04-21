<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PenilaianKhusus;
use App\Models\RekapanPenilaianBulanan;
use App\Models\RekapanAbsensiBulanan;
use App\Models\RekapanNilaiAkhir;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HitungRekapanNilaiAkhir extends Command
{
    protected $signature = 'rekapan:akhir';
    protected $description = 'Hitung nilai akhir semua user berdasarkan absensi, penilai, dan masyarakat';

    public function handle()
    {
        $bulan = now()->format('m');
        $tahun = now()->format('Y');

        $users = User::whereIn('role', ['pegawai', 'penilai'])->get();

        foreach ($users as $user) {
            $user_id = $user->id;

            // AVG Penilai
            $avg_penilai = PenilaianKhusus::where(compact('user_id', 'bulan', 'tahun'))->exists()
                ? PenilaianKhusus::where(compact('user_id', 'bulan', 'tahun'))
                    ->avg(DB::raw('(perilaku_petugas + penampilan + kecepatan_pelayanan + ketepatan_transparansi) / 4'))
                : 0;

            // AVG Masyarakat
            $nilai_masyarakat = RekapanPenilaianBulanan::where(compact('user_id', 'bulan', 'tahun'))->exists()
                ? RekapanPenilaianBulanan::where(compact('user_id', 'bulan', 'tahun'))
                    ->avg(DB::raw('(avg_perilaku_petugas + avg_penampilan + avg_kecepatan_pelayanan + avg_ketepatan_transparansi) / 4'))
                : 0;

            // Absensi
            $nilai_absensi = RekapanAbsensiBulanan::where(compact('user_id', 'bulan', 'tahun'))->value('total_poin') ?? 0;

            // Hitung total nilai akhir
            $total_nilai = ($nilai_absensi * 0.30)
                + ($nilai_masyarakat * 0.50)
                + ($avg_penilai * 0.20);

            // Simpan atau update
            RekapanNilaiAkhir::updateOrCreate(
                compact('user_id', 'bulan', 'tahun'),
                [
                    'nilai_absensi'    => $nilai_absensi,
                    'nilai_masyarakat' => $nilai_masyarakat,
                    'nilai_penilai'    => $avg_penilai,
                    'nilai_akhir'      => $total_nilai,
                ]
            );

            $this->info("Nilai akhir untuk user_id {$user_id} berhasil dihitung.");
        }
        Log::info("Scheduler berhasil jalan");
        $this->info("Perhitungan nilai akhir selesai untuk semua user.");
    }
}
