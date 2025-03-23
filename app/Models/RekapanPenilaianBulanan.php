<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekapanPenilaianBulanan extends Model
{
    //
    protected $table = 'rekapan_penilaian_bulanan';
    protected $fillable = [
        'user_id', 'bulan', 'tahun', 'total_penilaian', 'avg_perilaku_petugas', 'avg_penampilan',
        'avg_kecepatan_pelayanan', 'avg_ketepatan_transparansi'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }
}
