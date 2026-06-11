<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
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
        'instansi',
        'profile',
        'tanggal_daftar',
        'verifikasi_admin',
        'foto_ktp',
        'tanggal_diubah',
        'password',
    ];

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
