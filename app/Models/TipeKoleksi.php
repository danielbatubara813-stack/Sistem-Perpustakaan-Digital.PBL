<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipeKoleksi extends Model
{
    // inisiasi variable untuk model terhubung dengan table tipe_koleksi
    protected $table = 'tipe_koleksi';

    // inisiasi variable primary key
    protected $primaryKey = 'id_tipe';

    // menonaktifkan timestamp bawaan
    public $timestamps = false;

    // inisiasi column yang bisa di isi
    protected $fillable = [
        'nama_tipe'
    ];

    // Custom timestamp column
    const CREATED_AT = 'tanggal_dibuat';
    const UPDATED_AT = 'tanggal_diubah';
}
