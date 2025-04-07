<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $primaryKey = 'nip';
    public $incrementing = false;
    protected $fillable = [
        'nip',
        'nama',
        'slug',
        'jabatan',
        'barcode',
        'jabatan',
        'tanggal_lahir',
        'status_pegawai',
        'foto',
        'role',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isSuperAdmin()
    {
        return $this->role === 'super-admin';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isPegawai()
    {
        return $this->role === 'pegawai';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->id = Str::uuid(); // Menggunakan UUID
            $user->slug = User::generateSlug($user->nama, $user->nip);
        });

    }

    public static function generateSlug($name, $nip)
    {
        $nip_last3 = substr($nip, -3); // Ambil 3 angka terakhir dari NIP
        $slug = Str::slug($name) . '-' . $nip_last3;

        // Pastikan slug unik
        $count = User::where('slug', 'LIKE', "$slug%")->count();
        return $count ? "{$slug}-{$count}" : $slug;
    }

    // relasi penilaian
    public function penilaianMasyarakat(){
        return $this->hasMany(RekapanPenilaianBulanan::class,'user_id','id');
    }
}
