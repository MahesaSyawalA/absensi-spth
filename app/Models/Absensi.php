<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];
}
