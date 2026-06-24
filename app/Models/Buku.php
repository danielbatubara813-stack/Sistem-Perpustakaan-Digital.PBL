<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';

    protected $primaryKey = 'id_buku';

    public $timestamps = true;

    const CREATED_AT = 'tanggal_dibuat';
    const UPDATED_AT = 'tanggal_diubah';

    protected $fillable = [
        'id_tipe',
        'kode_bahasa',
        'id_penerbit',
        'isbn',
        'judul_buku',
        'tanggal_terbit',
        'deskripsi',
        'edisi',
        'cover_buku',
        'no_panggil',
        'no_rak'
    ];

    public function tipe()
    {
        return $this->belongsTo(TipeKoleksi::class, 'id_tipe');
    }

    public function bahasa()
    {
        return $this->belongsTo(
            DokBahasa::class,
            'kode_bahasa',
            'kode_bahasa'
        );
    }

    public function penerbit()
    {
        return $this->belongsTo(
            Penerbit::class,
            'id_penerbit'
        );
    }

    public function penulis()
    {
        return $this->belongsToMany(
            Penulis::class,
            'penulis_buku',
            'id_buku',
            'id_penulis'
        );
    }

    public function subjek()
    {
        return $this->belongsToMany(
            Subjek::class,
            'subjek_buku',
            'id_buku',
            'id_subjek'
        );
    }

    public function items()
    {
        return $this->hasMany(
            ItemBuku::class,
            'id_buku',
            'id_buku'
        );
    }
    public function reservasi()
    {
        return $this->hasMany(
            Reservasi::class,
            'id_buku',
            'id_buku'
        );
    }
}
