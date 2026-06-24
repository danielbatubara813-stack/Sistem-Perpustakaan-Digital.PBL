<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Anggota extends Authenticatable
{
    use Notifiable;

    protected $table = 'anggota';

    protected $primaryKey = 'id_anggota';

    public $timestamps = false;

    protected $fillable = [
        'id_jenis',
        'nomor_identitas',
        'jenis_nomor_identitas',
        'email',
        'nama',
        'no_hp',
        'status_anggota',
        'jenis_kelamin',
        'tanggal_lahir',
        'profile',
        'tanggal_daftar',
        'verifikasi_admin',
        'foto_ktp',
        'tanggal_diubah',
        'password',
    ];
    public function getFotoProfileUrlAttribute()
    {
        if ($this->profile) {
            return asset('storage/' . $this->profile);
        }

        return asset('images/default-avatar.svg');
    }

    protected $hidden = ['password'];

    public function jenisKeanggotaan()
    {
        return $this->belongsTo(
            JenisKeanggotaan::class,
            'id_jenis',
            'id_jenis'
        );
    }

    public function peminjaman()
    {
    return $this->hasMany(Peminjaman::class, 'id_anggota', 'id_anggota');
    }

}
