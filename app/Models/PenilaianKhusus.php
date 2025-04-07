<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PenilaianKhusus extends Model
{
    protected $table = 'penilaian_khusus';
    protected $fillable = [
        'penilai_id',
        'user_id',
        'nama',
        'email',
        'tujuan',
        'pelayanan',
        'perilaku_petugas',
        'penampilan',
        'kecepatan_pelayanan',
        'ketepatan_transparansi',
        'bulan',
        'tahun',
    ];
    protected $hidden = [
        'user_id',
        'penilai_id'
    ];

    public static function boot()
    {
        parent::boot();

        static::created(function ($penilaian) {
            static::updateRekapanPenilaianAkhir($penilaian);
        });

        static::updated(function ($penilaian) {
            static::updateRekapanPenilaianAkhir($penilaian);
        });
    }


    private static function updateRekapanPenilaianAkhir(PenilaianKhusus $penilaian)
    {
        $user_id = $penilaian->user_id;
        $bulan   = $penilaian->bulan;
        $tahun   = $penilaian->tahun;

        // AVG Penilaian Khusus (default 0 jika belum ada)
        $avg_penilai = PenilaianKhusus::where(compact('user_id', 'bulan', 'tahun'))
            ->exists()
            ? PenilaianKhusus::where(compact('user_id', 'bulan', 'tahun'))
            ->avg(DB::raw('(perilaku_petugas + penampilan + kecepatan_pelayanan + ketepatan_transparansi) / 4'))
            : 0;

        // AVG Masyarakat
        $nilai_masyarakat = RekapanPenilaianBulanan::where(compact('user_id', 'bulan', 'tahun'))
            ->exists()
            ? RekapanPenilaianBulanan::where(compact('user_id', 'bulan', 'tahun'))
            ->avg(DB::raw('(avg_perilaku_petugas + avg_penampilan + avg_kecepatan_pelayanan + avg_ketepatan_transparansi) / 4'))
            : 0;

        // Absensi (default 0)
        $nilai_absensi = RekapanAbsensiBulanan::where(compact('user_id', 'bulan', 'tahun'))
            ->value('total_poin') ?? 0;

        // Hitung total
        $total_nilai = ($nilai_absensi * 0.30)
            + ($nilai_masyarakat * 0.50)
            + ($avg_penilai * 0.20);
            // dd($total_nilai);

        // Buat atau update rekapan akhir
        RekapanNilaiAkhir::updateOrCreate(
            compact('user_id', 'bulan', 'tahun'),
            [
                'nilai_absensi'    => $nilai_absensi,
                'nilai_masyarakat' => $nilai_masyarakat,
                'nilai_penilai'    => $avg_penilai,
                'nilai_akhir'      => $total_nilai,
            ]
        );
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function penilai()
    {
        return $this->belongsTo(User::class, 'penilai_id', 'id');
    }

}
