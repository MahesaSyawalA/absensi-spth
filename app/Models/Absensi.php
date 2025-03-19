<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable = [
        'id',
        'user_id',
        'latitude',
        'longitude',
        'scanned_at',
    ];
}
