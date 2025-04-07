<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RekapanNilaiAkhir extends Model
{
    protected $table = 'rekapan_nilai_akhir';

    protected $fillable = [
        'user_id',
        'bulan',
        'tahun',
        'nilai_absensi',
        'nilai_masyarakat',
        'nilai_penilai',
        'nilai_akhir',
    ];

    /**
     * Relasi ke model User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
