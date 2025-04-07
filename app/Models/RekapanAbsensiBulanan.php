<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RekapanAbsensiBulanan extends Model
{
    //
    protected $table = 'rekapan_absensi_bulanan';
    protected $fillable = [
        'user_id',
        'bulan',
        'tahun',
        'total_absen',
        'total_poin',
        'avg_poin',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
