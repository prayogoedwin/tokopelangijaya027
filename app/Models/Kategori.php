<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    //
    protected $table = 'kategories';
    protected $fillable = [
        'id_parent',
        'name'
    ];

    public function parentt()
    {
        return $this->belongsTo(Kategori::class);
    }


    
}
