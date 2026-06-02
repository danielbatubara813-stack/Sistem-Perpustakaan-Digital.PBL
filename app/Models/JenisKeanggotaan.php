<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisKeanggotaan extends Model
{
    protected $table = 'jenis_keanggotaan';

    protected $primaryKey = 'id_jenis';

    public $timestamps = false;

    protected $fillable = [
        'nama_jenis',
    ];

    public function anggota()
    {
        return $this->hasMany(
            Anggota::class,
            'id_jenis',
            'id_jenis'
        );
    }
}
