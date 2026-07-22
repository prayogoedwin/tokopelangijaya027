<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    // Schema::create('tokos', function (Blueprint $table) {
    //         $table->id();
    //         $table->string('name');
    //         $table->string('kode_toko');
    //         $table->string('pass_toko');
    //         $table->string('alamat');
    //         $table->string('status_toko'); //(Cabang / Pusat)
    //         $table->timestamps();
    //         $table->softDeletes();
    //         $table->foreignId('created_by')->nullable();
    //         $table->foreignId('updated_by')->nullable();
    //         $table->foreignId('deleted_by')->nullable();
    //     });
    
    protected $fillable = [
        'name',
        'kode_toko',
        'pass_toko',
        'alamat',
        'telp',
        'tipe_kasir',
        'status_toko',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
}
