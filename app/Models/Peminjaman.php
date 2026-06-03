<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Anggota;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $primaryKey = 'kode_peminjaman';

    protected $keyType = 'string';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'kode_peminjaman',
        'id_anggota',
        'id_item',
        'tanggal_peminjaman',
        'tanggal_jatuh_tempo',
        'status'
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'id_anggota');
    }
}
