<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stok extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'produk_id',
        'tipe', // IN or OUT
        'jumlah',

        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function produk(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Produk::class);
    }
}
