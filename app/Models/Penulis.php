<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penulis extends Model
{
    // inisiasi variable untuk model terhubung dengan table penulis
    protected $table = 'penulis';

    // inisiasi variable primary key
    protected $primaryKey = 'id_penulis';

    // menonaktifkan timestamp bawaan
    public $timestamps = false;

    // inisiasi column yang bisa di isi
    protected $fillable = [
        'nama_penulis',
        'tipe_penulis'
    ];

    // Custom timestamp column
    const CREATED_AT = 'tanggal_dibuat';
    const UPDATED_AT = 'tanggal_diubah';

    public function buku()
    {
        return $this->belongsToMany(
            Buku::class,
            'penulis_buku',
            'id_penulis',
            'id_buku'
        );
    }
}
