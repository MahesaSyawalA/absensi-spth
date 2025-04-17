<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanAbsen extends Model
{
    protected $table = 'pengajuan_absen';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable = [
        'user_id',
        'nip_pegawai',
        'nama_pegawai',
        'jenis_absen',
        'dokumen',
        'status',
        'tanggal_pengajuan',
    ];
}
