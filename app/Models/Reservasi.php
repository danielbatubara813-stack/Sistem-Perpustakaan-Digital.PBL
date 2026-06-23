<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Reservasi extends Model
{
    protected $table = 'reservasi';

    protected $primaryKey = 'nomor_reservasi';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'nomor_reservasi',
        'id_anggota',
        'id_buku',
        'id_item',
        'status',
        'tanggal_diajukan',
        'tanggal_konfirmasi',
        'tanggal_diajukan',
        'tanggal_diterima',
        'tanggal_expired',
        'tanggal_selesai',
    ];

    protected $casts = [
        'tanggal_diajukan' => 'datetime',
        'tanggal_konfirmasi' => 'datetime',
        'tanggal_diterima' => 'datetime',
        'tanggal_expired' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($reservasi) {
            if (!$reservasi->nomor_reservasi) {
                $reservasi->nomor_reservasi =
                    'RS' . date('Ymd') . strtoupper(Str::random(5));
            }
            if (!$reservasi->tanggal_diajukan) {
                $reservasi->tanggal_diajukan = now();
            }

        });

    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'id_anggota');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }

    public function itemBuku()
    {
        return $this->belongsTo(ItemBuku::class, 'id_item', 'id_item');
    }
}