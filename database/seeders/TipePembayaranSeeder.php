<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipePembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $data = [
            'Tunai',
            'Transfer',
            'QRIS'
        ];

        foreach ($data as $item) {
            \App\Models\TipePembayaran::create([
                'name' => $item,
            ]);
        }
    }
}
