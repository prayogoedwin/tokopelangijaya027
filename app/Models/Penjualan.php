<?php

namespace App\Models;

use Carbon\Carbon;

use App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penjualan extends Model
{
    //
    // Schema::create('penjualans', function (Blueprint $table) {
    //     $table->id();
    //     $table->integer('customer_id')->default(0);
    //     $table->foreignId('toko_id')->constrained('tokos');
    //     $table->string('no_invoice'); // (generated [kodetoko#tahun#bulan#id])
    //     $table->foreignId('tipe_pembayaran_id')->constrained('tipe_pembayaran');
    //     $table->integer('total_pembelian'); // Rupiah
    //     $table->float('diskon_percentage'); // %
    //     $table->integer('diskon_nominal');
    //     $table->integer('total_harus_dibayar'); //  (total_pembelian-diskon)
    //     $table->integer('dibayar'); 
    //     $table->integer('kembalian')->default(0); 
    //     $table->string('keterangan')->nullable(); 
    //     $table->timestamps();
    //     $table->softDeletes();
    //     $table->foreignId('created_by')->nullable();
    //     $table->foreignId('updated_by')->nullable();
    //     $table->foreignId('deleted_by')->nullable();
    // });
    use SoftDeletes;
    protected $fillable = [
        'customer_id',
        'toko_id',
        'no_invoice',
        'tipe_pembayaran_id',
        'total_pembelian',
        'diskon_percentage',
        'diskon_nominal',
        'total_harus_dibayar',
        'dibayar',
        'kembalian',
        'keterangan',

        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected static function booted()
    {
        static::creating(function ($penjualan) {

            // 1. Get the store code (assuming a relationship exists)
            $kodeToko = $penjualan->toko->kode_toko ?? 'UNK';

            // 2. Get the next ID (or use a count for the current month)
            // Note: Using the raw ID can be tricky on 'creating' because it doesn't exist yet.
            // A common workaround is to get the latest ID and add 1.
            $nextId = (static::max('id') ?? 0) + 1;

            // 3. Format the components
            $tahun = date('Y');
            $bulan = date('m');

            // 4. Combine into [kodetoko#tahun#bulan#id]
            $penjualan->no_invoice = "{$kodeToko}#{$tahun}#{$bulan}#{$nextId}";

            // Optional: Set creator ID
            $penjualan->created_by = auth()->id();
        });
    }


    public function toko(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Toko::class);
    }
    public function tipePembayaran(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TipePembayaran::class);
    }
    public function details(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PenjualanDetail::class);
    }

    public function kasir(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return Carbon::instance($date)->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s');
    }
}
