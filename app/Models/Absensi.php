<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Absensi extends Model
{
    protected $table = 'absensi';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable = [
        'user_id',
        'latitude',
        'longitude',
        'absen_ke',
        'scanned_at',
        'keterangan'
    ];

    protected static function booted()
    {
        static::created(function ($absensi) {
            $bulan = Carbon::now()->month;
            $tahun = Carbon::now()->year;

            // Tentukan poin berdasarkan keterangan
            $poin = ($absensi->keterangan === 'Terlambat') ? 3 : 5;

            // Cek apakah sudah ada rekapan untuk user ini
            $rekapan = DB::table('rekapan_absensi_bulanan')
                ->where('user_id', $absensi->user_id)
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->first();

            if ($rekapan) {
                // Update jumlah absensi dan total poin
                $total_absen = $rekapan->total_absen + 1;
                $total_poin = $rekapan->total_poin + $poin;
                $avg_poin = $total_poin / $total_absen;

                DB::table('rekapan_absensi_bulanan')
                    ->where('id', $rekapan->id)
                    ->update([
                        'total_absen' => $total_absen,
                        'total_poin' => $total_poin,
                        'avg_poin' => $avg_poin,
                        'updated_at' => now(),
                    ]);
            } else {
                // Insert data baru jika belum ada rekapan
                DB::table('rekapan_absensi_bulanan')->insert([
                    'user_id' => $absensi->user_id,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'total_absen' => 1,
                    'total_poin' => $poin,
                    'avg_poin' => $poin, // Karena hanya ada 1 data pertama
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
    }
}
