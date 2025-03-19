<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kriteria extends Model
{
    //
    use HasFactory;

    protected $table = 'kriteria';
    protected $primaryKey = 'uuid';
    protected $fillable = ['name', 'bobot', 'type'];

}
