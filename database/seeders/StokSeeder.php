<?php

namespace Database\Seeders;

use App\Models\Produk;
use App\Models\Stok;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $data = [
        //     // Stok masuk pertama kali (pembelian awal) untuk semua produk
        //     ['product_id' => 1, 'type' => 'in', 'quantity' => 50, 'reference_type' => 'purchase_order', 'reference_id' => 1, 'created_at' => '2025-03-01 08:00:00', 'updated_at' => '2025-03-01 08:00:00'],
        //     ['product_id' => 2, 'type' => 'in', 'quantity' => 50, 'reference_type' => 'purchase_order', 'reference_id' => 1, 'created_at' => '2025-03-01 08:00:00', 'updated_at' => '2025-03-01 08:00:00'],
        //     ['product_id' => 3, 'type' => 'in', 'quantity' => 30, 'reference_type' => 'purchase_order', 'reference_id' => 1, 'created_at' => '2025-03-01 08:00:00', 'updated_at' => '2025-03-01 08:00:00'],
        //     ['product_id' => 4, 'type' => 'in', 'quantity' => 40, 'reference_type' => 'purchase_order', 'reference_id' => 1, 'created_at' => '2025-03-01 08:00:00', 'updated_at' => '2025-03-01 08:00:00'],
        //     ['product_id' => 5, 'type' => 'in', 'quantity' => 35, 'reference_type' => 'purchase_order', 'reference_id' => 1, 'created_at' => '2025-03-01 08:00:00', 'updated_at' => '2025-03-01 08:00:00'],
        //     ['product_id' => 6, 'type' => 'in', 'quantity' => 60, 'reference_type' => 'purchase_order', 'reference_id' => 1, 'created_at' => '2025-03-01 08:00:00', 'updated_at' => '2025-03-01 08:00:00'],
        //     ['product_id' => 7, 'type' => 'in', 'quantity' => 45, 'reference_type' => 'purchase_order', 'reference_id' => 1, 'created_at' => '2025-03-01 08:00:00', 'updated_at' => '2025-03-01 08:00:00'],
        //     ['product_id' => 8, 'type' => 'in', 'quantity' => 70, 'reference_type' => 'purchase_order', 'reference_id' => 1, 'created_at' => '2025-03-01 08:00:00', 'updated_at' => '2025-03-01 08:00:00'],
        //     ['product_id' => 9, 'type' => 'in', 'quantity' => 25, 'reference_type' => 'purchase_order', 'reference_id' => 1, 'created_at' => '2025-03-01 08:00:00', 'updated_at' => '2025-03-01 08:00:00'],
        //     ['product_id' => 10, 'type' => 'in', 'quantity' => 20, 'reference_type' => 'purchase_order', 'reference_id' => 1, 'created_at' => '2025-03-01 08:00:00', 'updated_at' => '2025-03-01 08:00:00'],
        //     ['product_id' => 11, 'type' => 'in', 'quantity' => 15, 'reference_type' => 'purchase_order', 'reference_id' => 1, 'created_at' => '2025-03-01 08:00:00', 'updated_at' => '2025-03-01 08:00:00'],
        //     ['product_id' => 12, 'type' => 'in', 'quantity' => 15, 'reference_type' => 'purchase_order', 'reference_id' => 1, 'created_at' => '2025-03-01 08:00:00', 'updated_at' => '2025-03-01 08:00:00'],
        //     ['product_id' => 13, 'type' => 'in', 'quantity' => 40, 'reference_type' => 'purchase_order', 'reference_id' => 1, 'created_at' => '2025-03-01 08:00:00', 'updated_at' => '2025-03-01 08:00:00'],
        //     ['product_id' => 14, 'type' => 'in', 'quantity' => 25, 'reference_type' => 'purchase_order', 'reference_id' => 1, 'created_at' => '2025-03-01 08:00:00', 'updated_at' => '2025-03-01 08:00:00'],
        //     ['product_id' => 15, 'type' => 'in', 'quantity' => 20, 'reference_type' => 'purchase_order', 'reference_id' => 1, 'created_at' => '2025-03-01 08:00:00', 'updated_at' => '2025-03-01 08:00:00'],
        //     ['product_id' => 16, 'type' => 'in', 'quantity' => 30, 'reference_type' => 'purchase_order', 'reference_id' => 1, 'created_at' => '2025-03-01 08:00:00', 'updated_at' => '2025-03-01 08:00:00'],
        //     ['product_id' => 17, 'type' => 'in', 'quantity' => 100, 'reference_type' => 'purchase_order', 'reference_id' => 1, 'created_at' => '2025-03-01 08:00:00', 'updated_at' => '2025-03-01 08:00:00'],
        //     ['product_id' => 18, 'type' => 'in', 'quantity' => 25, 'reference_type' => 'purchase_order', 'reference_id' => 1, 'created_at' => '2025-03-01 08:00:00', 'updated_at' => '2025-03-01 08:00:00'],
        //     ['product_id' => 19, 'type' => 'in', 'quantity' => 60, 'reference_type' => 'purchase_order', 'reference_id' => 1, 'created_at' => '2025-03-01 08:00:00', 'updated_at' => '2025-03-01 08:00:00'],
        //     ['product_id' => 20, 'type' => 'in', 'quantity' => 20, 'reference_type' => 'purchase_order', 'reference_id' => 1, 'created_at' => '2025-03-01 08:00:00', 'updated_at' => '2025-03-01 08:00:00'],
            
        //     // Transaksi penjualan (stok keluar) beberapa hari kemudian
        //     ['product_id' => 1, 'type' => 'out', 'quantity' => 3, 'reference_type' => 'transaction', 'reference_id' => 101, 'created_at' => '2025-03-03 10:15:00', 'updated_at' => '2025-03-03 10:15:00'],
        //     ['product_id' => 3, 'type' => 'out', 'quantity' => 2, 'reference_type' => 'transaction', 'reference_id' => 101, 'created_at' => '2025-03-03 10:15:00', 'updated_at' => '2025-03-03 10:15:00'],
        //     ['product_id' => 6, 'type' => 'out', 'quantity' => 4, 'reference_type' => 'transaction', 'reference_id' => 101, 'created_at' => '2025-03-03 10:15:00', 'updated_at' => '2025-03-03 10:15:00'],
        //     ['product_id' => 8, 'type' => 'out', 'quantity' => 2, 'reference_type' => 'transaction', 'reference_id' => 101, 'created_at' => '2025-03-03 10:15:00', 'updated_at' => '2025-03-03 10:15:00'],
            
        //     ['product_id' => 2, 'type' => 'out', 'quantity' => 5, 'reference_type' => 'transaction', 'reference_id' => 102, 'created_at' => '2025-03-04 14:30:00', 'updated_at' => '2025-03-04 14:30:00'],
        //     ['product_id' => 10, 'type' => 'out', 'quantity' => 2, 'reference_type' => 'transaction', 'reference_id' => 102, 'created_at' => '2025-03-04 14:30:00', 'updated_at' => '2025-03-04 14:30:00'],
        //     ['product_id' => 13, 'type' => 'out', 'quantity' => 1, 'reference_type' => 'transaction', 'reference_id' => 102, 'created_at' => '2025-03-04 14:30:00', 'updated_at' => '2025-03-04 14:30:00'],
            
        //     ['product_id' => 4, 'type' => 'out', 'quantity' => 6, 'reference_type' => 'transaction', 'reference_id' => 103, 'created_at' => '2025-03-05 09:45:00', 'updated_at' => '2025-03-05 09:45:00'],
        //     ['product_id' => 7, 'type' => 'out', 'quantity' => 3, 'reference_type' => 'transaction', 'reference_id' => 103, 'created_at' => '2025-03-05 09:45:00', 'updated_at' => '2025-03-05 09:45:00'],
        //     ['product_id' => 17, 'type' => 'out', 'quantity' => 10, 'reference_type' => 'transaction', 'reference_id' => 103, 'created_at' => '2025-03-05 09:45:00', 'updated_at' => '2025-03-05 09:45:00'],
        //     ['product_id' => 19, 'type' => 'out', 'quantity' => 5, 'reference_type' => 'transaction', 'reference_id' => 103, 'created_at' => '2025-03-05 09:45:00', 'updated_at' => '2025-03-05 09:45:00'],
            
        //     // Pembelian stok tambahan (restock) untuk produk laris
        //     ['product_id' => 1, 'type' => 'in', 'quantity' => 25, 'reference_type' => 'purchase_order', 'reference_id' => 2, 'created_at' => '2025-03-06 11:00:00', 'updated_at' => '2025-03-06 11:00:00'],
        //     ['product_id' => 3, 'type' => 'in', 'quantity' => 15, 'reference_type' => 'purchase_order', 'reference_id' => 2, 'created_at' => '2025-03-06 11:00:00', 'updated_at' => '2025-03-06 11:00:00'],
        //     ['product_id' => 6, 'type' => 'in', 'quantity' => 30, 'reference_type' => 'purchase_order', 'reference_id' => 2, 'created_at' => '2025-03-06 11:00:00', 'updated_at' => '2025-03-06 11:00:00'],
        // ];

        $produks = Produk::get();

        foreach ($produks as $produk) {
            Stok::create([
                'produk_id' => $produk->id,
                'tipe' => 'IN',
                'jumlah' => rand(10,100),
            ]);
        }
    }
}
