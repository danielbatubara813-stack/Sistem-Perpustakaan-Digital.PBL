<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    protected $table = 'pengembalian';

    protected $primaryKey = 'id_pengembalian';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'kode_peminjaman',
        'tanggal_pengembalian',
        'total_denda',
    ];

    const CREATED_AT = 'tanggal_dibuat';
    const UPDATED_AT = 'tanggal_diubah';

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'kode_peminjaman', 'kode_peminjaman');
    }
}
