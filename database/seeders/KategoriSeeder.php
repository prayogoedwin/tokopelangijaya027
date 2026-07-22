<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $data = [
            ['name' => 'Genset & Kelistrikan'],
            ['name' => 'Kabel & Aksesoris'],
            ['name' => 'Penyedot Debu & Kebersihan'],
            ['name' => 'Power Tools', 'id_parent' => 1],
            ['name' => 'Aksesoris & Perlengkapan', 'id_parent' => 2],
            ['name' => 'Spare-Part', 'id_parent' => 2],
            ['name' => 'Sistem Bahan Bakar', 'id_parent' => 6],
            ['name' => 'Sistem Pelumasan', 'id_parent' => 6],
            ['name' => 'Sistem Pendingin', 'id_parent' => 6],
            ['name' => 'Engine & Mekanik', 'id_parent' => 6],
            ['name' => 'Sistem Kontrol & Kelistrikan', 'id_parent' => 6],
            ['name' => 'Knalpot & Air Filter', 'id_parent' => 6],
            ['name' => 'Aksesoris Genset', 'id_parent' => 6],
        ];

        foreach ($data as $item) {
            \App\Models\Kategori::create($item);
        }
    }
}
