<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKriteria extends Model
{
    use HasFactory;

    protected $table = 'sub_kriteria';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_kriteria',
        'name',
        'nilai',
    ];

    /**
     * Relasi dengan model Kriteria (Many to One).
     */
    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'id_kriteria', 'uuid');
    }
}
