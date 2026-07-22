<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenjualanDetail extends Model
{
    //
    // Schema::create('penjualan_details', function (Blueprint $table) {
    //     $table->id();
    //     $table->foreignId('penjualan_id')->constrained('penjualans');
    //     $table->foreignId('produk_id')->constrained('produks');
    //     $table->integer('harga_beli');
    //     $table->integer('harga_jual');
    //     $table->integer('jumlah');
    //     $table->string('satuan');
    //     $table->integer('sub_total');
    //     $table->timestamps();
    //     $table->softDeletes();
    //     $table->foreignId('created_by')->nullable();
    //     $table->foreignId('updated_by')->nullable();
    //     $table->foreignId('deleted_by')->nullable();
    // });

    use SoftDeletes;
    protected $fillable = [
        'penjualan_id',
        'produk_id',
        'harga_beli',
        'harga_jual',
        'jumlah',
        'satuan',
        'sub_total',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected static function booted()
    {
        static::created(function ($detail) {
            // Otomatis tambah data ke table Stok dengan tipe 'OUT' saat detail penjualan dibuat
            Stok::create([
                'produk_id'  => $detail->produk_id,
                'tipe'       => 'OUT',
                'jumlah'     => $detail->jumlah,
                'created_by' => auth()->id(),
            ]);
        });
    }

    public function penjualan(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Penjualan::class);
    }
    public function produk(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Produk::class);
    }
}
