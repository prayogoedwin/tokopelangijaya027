<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id')->nullable();
            $table->foreignId('toko_id')->constrained('tokos');
            $table->string('no_invoice'); // (generated [kodetoko#tahun#bulan#id])
            $table->foreignId('tipe_pembayaran_id')->constrained('tipe_pembayarans');
            $table->integer('total_pembelian'); // Rupiah
            $table->float('diskon_percentage'); // %
            $table->integer('diskon_nominal');
            $table->integer('total_harus_dibayar'); //  (total_pembelian-diskon)
            $table->integer('dibayar'); 
            $table->integer('kembalian')->default(0); 
            $table->string('keterangan')->nullable(); 
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->foreignId('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};
