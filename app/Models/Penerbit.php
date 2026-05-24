<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penerbit extends Model
{
    // inisiasi variable untuk model terhubung dengan table penerbit
    protected $table = 'penerbit';

    // inisiasi variable primary key
    protected $primaryKey = 'id_penerbit';

    // menonaktifkan timestamp bawaan
    public $timestamps = false;

    // inisiasi column yang bisa di isi
    protected $fillable = [
        'nama_penerbit'
    ];

    // Custom timestamp column
    const CREATED_AT = 'tanggal_dibuat';
    const UPDATED_AT = 'tanggal_diubah';
}
