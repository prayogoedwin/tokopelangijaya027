<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $satuans = config('helper.satuans');

        foreach ($satuans as $satuan) {
            \App\Models\Satuan::create([
                'name' => $satuan,
            ]);
        }
    }
}
