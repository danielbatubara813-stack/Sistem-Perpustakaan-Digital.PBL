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
        'tanggal_perpanjangan',
        'status'
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'id_anggota');
    }
    public function itemBuku()
    {
        return $this->belongsTo(ItemBuku::class, 'id_item', 'id_item');
    }
    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'kode_peminjaman', 'kode_peminjaman');
    }
}
