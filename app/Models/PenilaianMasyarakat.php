<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianMasyarakat extends Model
{
    //
    protected $table='penilaian_masyarakat';
    protected $fillable = [
        'user_id',
        'nama',
        'email',
        'tujuan',
        'pelayanan',
        'perilaku_petugas',
        'penampilan',
        'kecepatan_pelayanan',
        'ketepatan_transparansi',
    ];
    protected $hidden = [
        'user_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($penilaian) {
            self::updateRekapanBulanan($penilaian);
        });
    }

    public static function updateRekapanBulanan($penilaian)
    {
        $bulan = date('m', strtotime($penilaian->created_at));
        $tahun = date('Y', strtotime($penilaian->created_at));

        $rekapan = RekapanPenilaianBulanan::firstOrNew([
            'user_id' => $penilaian->user_id,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);

        // Hitung ulang jumlah penilaian dan rata-rata
        $rekapan->total_penilaian += 1;
        $rekapan->avg_perilaku_petugas = self::hitungRataRata($penilaian->user_id, $bulan, $tahun, 'perilaku_petugas');
        $rekapan->avg_penampilan = self::hitungRataRata($penilaian->user_id, $bulan, $tahun, 'penampilan');
        $rekapan->avg_kecepatan_pelayanan = self::hitungRataRata($penilaian->user_id, $bulan, $tahun, 'kecepatan_pelayanan');
        $rekapan->avg_ketepatan_transparansi = self::hitungRataRata($penilaian->user_id, $bulan, $tahun, 'ketepatan_transparansi');

        $rekapan->save();
    }

    private static function hitungRataRata($user_id, $bulan, $tahun, $kolom)
    {
        return self::where('user_id', $user_id)
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->avg($kolom);
    }
}
