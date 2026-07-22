<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TokoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => "Toko Pusat",
                'kode_toko' => "PST-001",
                'pass_toko' => "12345678",
                'alamat' => "Jl.Semarang Bali No.20, Yogyakarta",
                'telp' => '089089008984',
                'status_toko' => 'Pusat',
                'tipe_kasir' => 'Invoice',
            ],
            [
                'name' => "Toko Cabang 1",
                'kode_toko' => "CBG-002",
                'pass_toko' => "12345678",
                'alamat' => "Jl.Semarang Solo No.10, Jakarta",
                'telp' => '089123456789',
                'status_toko' => 'Cabang',
                'tipe_kasir' => 'POS',

            ],

        ];

        foreach ($data as $item) {
            \App\Models\Toko::create($item);
        }
    }
}
