<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokBahasa extends Model
{
    // inisiasi variable untuk model terhubung dengan table dok_bahasa
    protected $table = 'dok_bahasa';

    // inisiasi variable primary key
    protected $primaryKey = 'kode_bahasa';
    protected $keyType = 'string';
    public $incrementing = false;    // menonaktifkan timestamp bawaan
    public $timestamps = false;

    // inisiasi column yang bisa di isi
    protected $fillable = [
        'kode_bahasa',
        'nama_bahasa'
    ];

    // Custom timestamp column
    const CREATED_AT = 'tanggal_dibuat';
    const UPDATED_AT = 'tanggal_diubah';
}
