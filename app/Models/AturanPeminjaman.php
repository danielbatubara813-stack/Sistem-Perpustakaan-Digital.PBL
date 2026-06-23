<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AturanPeminjaman extends Model
{
    protected $table = 'aturan_peminjaman';

    protected $primaryKey = 'id_aturan';

    public $timestamps = false;

    protected $fillable = [
        'id_jenis',
        'id_tipe',
        'periode_peminjaman',
        'batas_peminjaman',
    ];

    protected $casts = [
        'id_jenis' => 'integer',
        'id_tipe' => 'integer',
        'periode_peminjaman' => 'integer',
        'batas_peminjaman' => 'integer',
    ];

    public function jenisKeanggotaan()
    {
        return $this->belongsTo(
            JenisKeanggotaan::class,
            'id_jenis',
            'id_jenis'
        );
    }

    public function tipeKoleksi()
    {
        return $this->belongsTo(
            TipeKoleksi::class,
            'id_tipe',
            'id_tipe'
        );
    }
}
