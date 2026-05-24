<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subjek extends Model
{
    // inisiasi variable untuk model terhubung dengan table subjek
    protected $table = 'subjek';

    // inisiasi variable primary key
    protected $primaryKey = 'id_subjek';

    // menonaktifkan timestamp bawaan
    public $timestamps = false;

    // inisiasi column yang bisa di isi
    protected $fillable = [
        'nama_subjek'
    ];

    // Custom timestamp column
    const CREATED_AT = 'tanggal_dibuat';
    const UPDATED_AT = 'tanggal_diubah';
}
