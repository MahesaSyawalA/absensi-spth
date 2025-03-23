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
}
