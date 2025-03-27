<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

        static::creating(function ($penilaian) {
            // Cek apakah sudah ada data untuk user_id, bulan, dan tahun yang sama
            $existing = PenilaianKhusus::where('user_id', $penilaian->user_id)
                ->where('bulan', $penilaian->bulan)
                ->where('tahun', $penilaian->tahun)
                ->first();

            if ($existing) {
                // Jika ada, update data lama
                $existing->update($penilaian->toArray());
                return false; // Batalkan create baru, hanya update data lama
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
