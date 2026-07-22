<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // protected $fillable = [
        // 'toko_id',
        // 'kategori_id',
        // 'name',
        // 'harga_beli',
        // 'harga_jual',
        // 'created_by',
        // 'updated_by',
        // 'deleted_by',
        // ];

        $data = [
            // Genset & Kelistrikan (category_id = 1)
            ['sku' => 'GEN-1000W', 'name' => 'Genset 1000 Watt', 'category_id' => 1, 'satuan' => 'unit', 'harga_beli' => 1500000, 'harga_jual' => 1750000],
            ['sku' => 'GEN-3000W', 'name' => 'Genset 3000 Watt', 'category_id' => 1, 'satuan' => 'unit', 'harga_beli' => 2800000, 'harga_jual' => 3250000],
            ['sku' => 'GEN-STB500', 'name' => 'Stabilizer 500 VA', 'category_id' => 1, 'satuan' => 'pcs', 'harga_beli' => 250000, 'harga_jual' => 300000],
            ['sku' => 'GEN-MCB10A', 'name' => 'MCB 10 Ampere', 'category_id' => 1, 'satuan' => 'pcs', 'harga_beli' => 25000, 'harga_jual' => 35000],

            // Kabel & Aksesoris (category_id = 2)
            ['sku' => 'KBL-NYY215', 'name' => 'Kabel NYY 2x1.5 mm', 'category_id' => 2, 'satuan' => 'meter', 'harga_beli' => 3500, 'harga_jual' => 5000],
            ['sku' => 'KBL-NYA115', 'name' => 'Kabel NYA 1.5 mm', 'category_id' => 2, 'satuan' => 'meter', 'harga_beli' => 1800, 'harga_jual' => 2500],
            ['sku' => 'KBL-STPIN', 'name' => 'Stop Kontak Industri', 'category_id' => 2, 'satuan' => 'pcs', 'harga_beli' => 15000, 'harga_jual' => 22000],
            ['sku' => 'KBL-ROL20M', 'name' => 'Kabel Rol 20 meter', 'category_id' => 2, 'satuan' => 'pcs', 'harga_beli' => 120000, 'harga_jual' => 150000],

            // Penyedot Debu & Kebersihan (category_id = 3)
            ['sku' => 'VAC-600W', 'name' => 'Vacuum Cleaner 600W', 'category_id' => 3, 'satuan' => 'unit', 'harga_beli' => 350000, 'harga_jual' => 450000],
            ['sku' => 'VAC-WD', 'name' => 'Vacuum Cleaner Basah & Kering', 'category_id' => 3, 'satuan' => 'unit', 'harga_beli' => 650000, 'harga_jual' => 800000], // WD = Wet & Dry
            ['sku' => 'VAC-BLWIND', 'name' => 'Blower Debu Industri', 'category_id' => 3, 'satuan' => 'unit', 'harga_beli' => 250000, 'harga_jual' => 320000],
            ['sku' => 'VAC-FLTHEPA', 'name' => 'Filter HEPA Vacuum', 'category_id' => 3, 'satuan' => 'pcs', 'harga_beli' => 45000, 'harga_jual' => 60000],

            // Power Tools (category_id = 4)
            ['sku' => 'POW-BOR10', 'name' => 'Bor Listrik 10 mm', 'category_id' => 4, 'satuan' => 'unit', 'harga_beli' => 180000, 'harga_jual' => 240000],
            ['sku' => 'POW-GRD4', 'name' => 'Gerinda Tangan 4"', 'category_id' => 4, 'satuan' => 'unit', 'harga_beli' => 220000, 'harga_jual' => 290000],
            ['sku' => 'POW-AMP', 'name' => 'Mesin Amplas', 'category_id' => 4, 'satuan' => 'unit', 'harga_beli' => 150000, 'harga_jual' => 200000],
            ['sku' => 'POW-BBK', 'name' => 'Mesin Bor Bobok', 'category_id' => 4, 'satuan' => 'unit', 'harga_beli' => 400000, 'harga_jual' => 520000],

            // Aksesoris & Perlengkapan (category_id = 5)
            ['sku' => 'AKS-TIE10', 'name' => 'Kabel Ties 10 cm', 'category_id' => 5, 'satuan' => 'pak', 'harga_beli' => 5000, 'harga_jual' => 8000],
            ['sku' => 'AKS-MLTDIG', 'name' => 'Multimeter Digital', 'category_id' => 5, 'satuan' => 'pcs', 'harga_beli' => 85000, 'harga_jual' => 120000],
            ['sku' => 'AKS-STGLAS', 'name' => 'Sarung Tangan Las', 'category_id' => 5, 'satuan' => 'pasang', 'harga_beli' => 25000, 'harga_jual' => 35000],
            ['sku' => 'AKS-KCMSFT', 'name' => 'Kacamata Safety', 'category_id' => 5, 'satuan' => 'pcs', 'harga_beli' => 15000, 'harga_jual' => 22000],
        ];

        foreach ($data as $item) {
            \App\Models\Produk::create([
                'toko_id' => 1,
                'name' => $item['name'],
                'kategori_id' => $item['category_id'],
                'satuan' => $item['satuan'],
                'sku' => $item['sku'],
                'harga_beli' => $item['harga_beli'],
                'harga_jual' => $item['harga_jual'],
            ]);
        }

        $data2 = [
            // ==================== SISTEM BAHAN BAKAR (category_id = 7) ====================
            ['sku' => 'FUE-FLTDSL', 'name' => 'Fuel Filter Genset Diesel (Percik)', 'category_id' => 7, 'satuan' => 'pcs', 'harga_beli' => 45000, 'harga_jual' => 75000],
            ['sku' => 'FUE-WTRSEP', 'name' => 'Water Separator Fuel Filter Assembly', 'category_id' => 7, 'satuan' => 'unit', 'harga_beli' => 185000, 'harga_jual' => 250000],
            ['sku' => 'FUE-LFTPMP', 'name' => 'Fuel Lift Pump Mekanik (Injection Pump)', 'category_id' => 7, 'satuan' => 'pcs', 'harga_beli' => 120000, 'harga_jual' => 175000],
            ['sku' => 'FUE-SLGSLR8', 'name' => 'Selang Bahan Bakar Tahan Solar 8mm', 'category_id' => 7, 'satuan' => 'meter', 'harga_beli' => 12000, 'harga_jual' => 20000],
            ['sku' => 'FUE-FLCOCK', 'name' => 'Klep Bensin (Fuel Cock) Genset Kecil', 'category_id' => 7, 'satuan' => 'pcs', 'harga_beli' => 25000, 'harga_jual' => 40000],
            ['sku' => 'FUE-NZLPMP', 'name' => 'Nozzle Injection Pump (Pompa Injeksi)', 'category_id' => 7, 'satuan' => 'pcs', 'harga_beli' => 450000, 'harga_jual' => 700000],
            ['sku' => 'FUE-KRB3500', 'name' => 'Karburator Genset 2000-3500 Watt', 'category_id' => 7, 'satuan' => 'pcs', 'harga_beli' => 130000, 'harga_jual' => 175000],

            // ==================== SISTEM PELUMASAN (category_id = 8) ====================
            ['sku' => 'LUB-FLTUMM', 'name' => 'Filter Oli Genset (Spesifikasi Umum)', 'category_id' => 8, 'satuan' => 'pcs', 'harga_beli' => 35000, 'harga_jual' => 55000],
            ['sku' => 'LUB-FLTCMP', 'name' => 'Filter Oli Engine Cummins/Perkins', 'category_id' => 8, 'satuan' => 'pcs', 'harga_beli' => 95000, 'harga_jual' => 135000],
            ['sku' => 'LUB-SAE15W1', 'name' => 'Oli Mesin SAE 15W-40 (1 Liter)', 'category_id' => 8, 'satuan' => 'liter', 'harga_beli' => 45000, 'harga_jual' => 65000],
            ['sku' => 'LUB-SAE404', 'name' => 'Oli Mesin SAE 40 (4 Liter)', 'category_id' => 8, 'satuan' => 'pcs', 'harga_beli' => 140000, 'harga_jual' => 185000],
            ['sku' => 'LUB-PRSSWT', 'name' => 'Oil Pressure Switch (Saklar Tekanan Oli)', 'category_id' => 8, 'satuan' => 'pcs', 'harga_beli' => 55000, 'harga_jual' => 80000],
            ['sku' => 'LUB-DPSTCK', 'name' => 'Dipstick Oli (Tongkat Ukur)', 'category_id' => 8, 'satuan' => 'pcs', 'harga_beli' => 25000, 'harga_jual' => 40000],

            // ==================== SISTEM PENDINGIN (category_id = 9) ====================
            ['sku' => 'CLR-RAD3000', 'name' => 'Radiator Genset Portable 3000W', 'category_id' => 9, 'satuan' => 'unit', 'harga_beli' => 250000, 'harga_jual' => 350000],
            ['sku' => 'CLR-RADFAN12', 'name' => 'Kipas Radiator Elektrik 12 Inch', 'category_id' => 9, 'satuan' => 'pcs', 'harga_beli' => 95000, 'harga_jual' => 125000],
            ['sku' => 'CLR-HSEUPR', 'name' => 'Selang Radiator Atas (Upper Hose)', 'category_id' => 9, 'satuan' => 'pcs', 'harga_beli' => 45000, 'harga_jual' => 70000],
            ['sku' => 'CLR-HSELWR', 'name' => 'Selang Radiator Bawah (Lower Hose)', 'category_id' => 9, 'satuan' => 'pcs', 'harga_beli' => 45000, 'harga_jual' => 70000],
            ['sku' => 'CLR-CLN1L', 'name' => 'Coolant Radiator (1 Liter)', 'category_id' => 9, 'satuan' => 'pcs', 'harga_beli' => 35000, 'harga_jual' => 55000],
            ['sku' => 'CLR-WTRPMP', 'name' => 'Water Pump Engine Diesel Kecil', 'category_id' => 9, 'satuan' => 'pcs', 'harga_beli' => 190000, 'harga_jual' => 250000],
            ['sku' => 'CLR-CAP13', 'name' => 'Pressure Cap Radiator (13 PSI)', 'category_id' => 9, 'satuan' => 'pcs', 'harga_beli' => 20000, 'harga_jual' => 35000],

            // ==================== ENGINE & MEKANIK (category_id = 10) ====================
            ['sku' => 'ENG-PSTSET', 'name' => 'Set Piston + Ring + Liner (Cylinder Kit)', 'category_id' => 10, 'satuan' => 'set', 'harga_beli' => 450000, 'harga_jual' => 650000],
            ['sku' => 'ENG-CONROD', 'name' => 'Connecting Rod (Stang Piston)', 'category_id' => 10, 'satuan' => 'pcs', 'harga_beli' => 180000, 'harga_jual' => 250000],
            ['sku' => 'ENG-MTLJL', 'name' => 'Metal Jalan (Bearing Crankshaft)', 'category_id' => 10, 'satuan' => 'set', 'harga_beli' => 120000, 'harga_jual' => 170000],
            ['sku' => 'ENG-MTLDK', 'name' => 'Metal Duduk (Bearing Conrod)', 'category_id' => 10, 'satuan' => 'set', 'harga_beli' => 105000, 'harga_jual' => 135000],
            ['sku' => 'ENG-GSKHD', 'name' => 'Gasket Head Cylinder (Per Gasket)', 'category_id' => 10, 'satuan' => 'pcs', 'harga_beli' => 60000, 'harga_jual' => 100000],
            ['sku' => 'ENG-GSKFULL', 'name' => 'Full Gasket Set Engine (Complete)', 'category_id' => 10, 'satuan' => 'set', 'harga_beli' => 250000, 'harga_jual' => 350000],
            ['sku' => 'ENG-TMGBELT', 'name' => 'Timing Belt Genset Diesel', 'category_id' => 10, 'satuan' => 'pcs', 'harga_beli' => 110000, 'harga_jual' => 160000],
            ['sku' => 'ENG-VBELT', 'name' => 'V-Belt (Fan Belt) Alternator', 'category_id' => 10, 'satuan' => 'pcs', 'harga_beli' => 30000, 'harga_jual' => 50000],
            ['sku' => 'ENG-STRTMTR', 'name' => 'Starter Motor Genset 12V', 'category_id' => 10, 'satuan' => 'unit', 'harga_beli' => 350000, 'harga_jual' => 410000],
            ['sku' => 'ENG-ALTCHG', 'name' => 'Dinamo Ampere (Alternator Pengisi Aki)', 'category_id' => 10, 'satuan' => 'unit', 'harga_beli' => 280000, 'harga_jual' => 390000],

            // ==================== SISTEM KONTROL & KELISTRIKAN (category_id = 11) ====================
            ['sku' => 'CTR-AVRUNIV', 'name' => 'AVR Genset (Universal 3kW-10kW)', 'category_id' => 11, 'satuan' => 'pcs', 'harga_beli' => 120000, 'harga_jual' => 175000],
            ['sku' => 'CTR-AVRSX460', 'name' => 'AVR Stamford/Mecc Alte SX460', 'category_id' => 11, 'satuan' => 'pcs', 'harga_beli' => 380000, 'harga_jual' => 520000],
            ['sku' => 'CTR-DSE3110', 'name' => 'Control Module Deep Sea DSE 3110', 'category_id' => 11, 'satuan' => 'unit', 'harga_beli' => 1450000, 'harga_jual' => 1890000],
            ['sku' => 'CTR-SGM6120', 'name' => 'Modul Kontrol Smartgen HGM6120', 'category_id' => 11, 'satuan' => 'unit', 'harga_beli' => 1650000, 'harga_jual' => 2150000],
            ['sku' => 'CTR-ATS63A', 'name' => 'Automatic Transfer Switch (ATS) 2P 63A', 'category_id' => 11, 'satuan' => 'unit', 'harga_beli' => 850000, 'harga_jual' => 1150000],
            ['sku' => 'CTR-PKPRPM', 'name' => 'Magnetic Pickup Sensor RPM', 'category_id' => 11, 'satuan' => 'pcs', 'harga_beli' => 95000, 'harga_jual' => 135000],
            ['sku' => 'CTR-HRMTR', 'name' => 'Hour Meter Digital (Penunjuk Jam Operasi)', 'category_id' => 11, 'satuan' => 'pcs', 'harga_beli' => 65000, 'harga_jual' => 95000],
            ['sku' => 'CTR-PNLAC', 'name' => 'Multimeter Panel AC (Volt + Freq)', 'category_id' => 11, 'satuan' => 'pcs', 'harga_beli' => 75000, 'harga_jual' => 110000],
            ['sku' => 'CTR-EMGSTOP', 'name' => 'Emergency Stop Button (Push Button Red)', 'category_id' => 11, 'satuan' => 'pcs', 'harga_beli' => 25000, 'harga_jual' => 40000],
            ['sku' => 'CTR-CHG12V', 'name' => 'Battery Charger Otomatis 12V 10A', 'category_id' => 11, 'satuan' => 'unit', 'harga_beli' => 150000, 'harga_jual' => 210000],

            // ==================== KNALPOT & AIR FILTER (category_id = 12) ====================
            ['sku' => 'EXH-FLTUNIV', 'name' => 'Air Filter Genset (Tipe Kering) Universal', 'category_id' => 12, 'satuan' => 'pcs', 'harga_beli' => 55000, 'harga_jual' => 85000],
            ['sku' => 'EXH-FLTPPR', 'name' => 'Air Filter Element (Saringang Kertas)', 'category_id' => 12, 'satuan' => 'pcs', 'harga_beli' => 30000, 'harga_jual' => 50000],
            ['sku' => 'EXH-MFLPORT', 'name' => 'Knalpot Muffler Genset Portable', 'category_id' => 12, 'satuan' => 'pcs', 'harga_beli' => 85000, 'harga_jual' => 125000],
            ['sku' => 'EXH-FLX15', 'name' => 'Flexible Exhaust Pipe 1.5 Inch (1 Meter)', 'category_id' => 12, 'satuan' => 'meter', 'harga_beli' => 65000, 'harga_jual' => 95000],
            ['sku' => 'EXH-TRBREP', 'name' => 'Turbocharger Repair Kit (Seal & Bearing)', 'category_id' => 12, 'satuan' => 'set', 'harga_beli' => 750000, 'harga_jual' => 990000],

            // ==================== AKSESORIS GENSET (category_id = 13) ====================
            ['sku' => 'ACC-AKIMF40', 'name' => 'Aki Kering MF 12V 40Ah (Untuk Starting)', 'category_id' => 13, 'satuan' => 'unit', 'harga_beli' => 550000, 'harga_jual' => 730000],
            ['sku' => 'ACC-JMPAKI', 'name' => 'Kabel Jumper Aki (2 Meter + Clamp)', 'category_id' => 13, 'satuan' => 'set', 'harga_beli' => 85000, 'harga_jual' => 125000],
            ['sku' => 'ACC-WHLSET', 'name' => 'Set Roda (Wheel Set) Genset Portable', 'category_id' => 13, 'satuan' => 'set', 'harga_beli' => 120000, 'harga_jual' => 175000],
            ['sku' => 'ACC-SHKABS', 'name' => 'Shock Absorber / Anti Vibration Mount', 'category_id' => 13, 'satuan' => 'pcs', 'harga_beli' => 40000, 'harga_jual' => 60000],
            ['sku' => 'ACC-DRNVALV', 'name' => 'Oil Drain Valve Plastic (Klep Buang Oli)', 'category_id' => 13, 'satuan' => 'pcs', 'harga_beli' => 15000, 'harga_jual' => 25000],
            ['sku' => 'ACC-CVRGNS', 'name' => 'Cover / Sarung Genset (Waterproof)', 'category_id' => 13, 'satuan' => 'pcs', 'harga_beli' => 95000, 'harga_jual' => 140000],
        ];

        foreach ($data2 as $item) {
            \App\Models\Produk::create([
                'toko_id' => 2,
                'name' => $item['name'],
                'kategori_id' => $item['category_id'],
                'satuan' => $item['satuan'],
                'sku' => $item['sku'],
                'harga_beli' => $item['harga_beli'],
                'harga_jual' => $item['harga_jual'],
            ]);
        }
    }
}
