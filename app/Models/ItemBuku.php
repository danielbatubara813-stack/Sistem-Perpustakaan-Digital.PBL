<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemBuku extends Model
{
    protected $table = 'item_buku';

    protected $primaryKey = 'id_item';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;

    const CREATED_AT = 'tanggal_dibuat';
    const UPDATED_AT = 'tanggal_diubah';

    protected $fillable = [
        'id_item',
        'id_buku',
        'status_item'
    ];

    public function buku()
    {
        return $this->belongsTo(
            Buku::class,
            'id_buku',
            'id_buku'
        );
    }
}
