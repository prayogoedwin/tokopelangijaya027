<?php

namespace App\Exports;

use App\Models\PenjualanDetail;
use App\Models\Produk;
use Maatwebsite\Excel\Concerns\FromArray; // Mengubah FromQuery menjadi FromArray
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanPenjualanExport implements FromArray, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $startdate;
    protected $enddate;
    protected $toko;
    protected $data; // Menyimpan data yang sudah diproses untuk digunakan di styles()
    protected $totalStok;
    protected $totalAsset;
    private $rowCount = 0;

    // Terima parameter filter dari Controller via Constructor
    public function __construct($startdate, $enddate, $toko = null)
    {
        $this->startdate = $startdate;
        $this->enddate = $enddate;
        $this->totalStok = 0;
        $this->totalAsset = 0;

        $this->prepareData(); // Proses data saat instance dibuat agar bisa digunakan di semua method
    }

    private function prepareData()
    {
        // 1. Ambil data penjualan detail berdasarkan range tanggal (Eager load relasi)
        $penjualandetails = PenjualanDetail::with(['produk.toko'])
            ->whereHas('penjualan', function ($query) {
                $query->whereBetween('created_at', [
                    $this->startdate . ' 00:00:00',
                    $this->enddate . ' 23:59:59'
                ]);
            })->get();

        // 2. Ambil data produk berdasarkan filter toko
        $produks = Produk::with('toko')->whereNull('deleted_at')
            ->withSum(['stoks as total_masuk' => function ($query) {
                $query->where('tipe', 'IN');
            }], 'jumlah')
            ->withSum(['stoks as total_keluar' => function ($query) {
                $query->where('tipe', 'OUT');
            }], 'jumlah');;

        if ($this->toko) {
            $tokoId = $this->toko;
            $produks->whereHas('toko', function ($query) use ($tokoId) {
                $query->where('id', $tokoId);
            });
        }

        $produks = $produks->get();

        // 3. Gabungkan data & Hitung Kalkulasi Finansial
        $totalAsset = 0;
        $totalStok = 0;

        $laporan = [];
        foreach ($produks as $produk) {
            // Hitung total terjual dari collection yang sudah di-load (menghindari N+1 Query)
            $terjual = $penjualandetails->where('produk_id', $produk->id)->sum('jumlah');

            $harga_beli = $produk->harga_beli;
            $harga_jual = $produk->harga_jual;
            $kas_masuk = $terjual * $harga_jual;
            $pendapatan = ($harga_jual - $harga_beli) * $terjual;
            $stok_saat_ini = $produk->total_masuk - $produk->total_keluar;

            $totalStok += $stok_saat_ini;
            $totalAsset += $stok_saat_ini * $produk->harga_beli;

            $laporan[] = [
                'toko' => $produk->toko->name ?? '-',
                'produk' => $produk->name,
                'harga_beli' => $harga_beli,
                'harga_jual' => $harga_jual,
                'terjual' => $terjual,
                'kas_masuk' => $kas_masuk,
                'pendapatan' => $pendapatan,
                'stok_saat_ini' => $stok_saat_ini,

            ];
        }

        $sortedLaporan = collect($laporan)->sortByDesc('terjual')->values()->all();
        
        $this->data = $sortedLaporan; // Simpan data yang sudah diproses untuk digunakan di styles()
        $this->rowCount = count($this->data);
        $this->totalStok = $totalStok;
        $this->totalAsset = $totalAsset;
    }

    /**
     * Mengembalikan data dalam bentuk Array untuk di-export
     */
    public function array(): array
    {
        return $this->data;
    }

    // Tambahkan method ini
    public function getRawData()
    {
        
        return $this->data ?? [];
    }

    public function headings(): array
    {
        $totalOmset = collect($this->getRawData())->sum('kas_masuk');
        $totalPendapatan = collect($this->getRawData())->sum('pendapatan');
        $a = $this->totalAsset;
        $b = $this->totalStok;

        return [
            ['Periode Laporan:', $this->startdate . ' s/d ' . $this->enddate], // Baris 1: Info Tanggal
            ['Total Omset:', $totalOmset, 'Total Stok', $b], // Total Omset dari data yang sudah diproses
            ['Total Pendapatan:', $totalPendapatan, 'Total Asset', $a], // Total Pendapatan dari data yang sudah diproses
            [], // Baris 2: Spasi Kosong
            [
                'Toko',
                'Produk',
                'Harga Beli',
                'Harga Jual',
                'Terjual',
                'Kas Masuk (Sub Total)',
                'Keuntungan (Pendapatan)',
                'Stok Saat ini',
            ] // Baris 3: Header Tabel
        ];
    }

    /**
     * Mapping kolom array ke baris Excel
     */
    public function map($row): array
    {

        return [
            $row['toko'],
            $row['produk'],
            $row['harga_beli'],
            $row['harga_jual'],
            $row['terjual'],
            $row['kas_masuk'],
            $row['pendapatan'],
            $row['stok_saat_ini'],
        ];
    }

    /**
     * Styling dan Menambahkan Rumus SUM Otomatis di Akhir Baris
     */
    public function styles(Worksheet $sheet)
    {
        // Posisi baris awal data dimulai setelah info tanggal dan header (Baris ke-4)
        $startDataRow = 6;
        $endDataRow = $startDataRow + $this->rowCount - 1;

        // Antisipasi jika data kosong agar rumus Excel tidak rusak
        if ($this->rowCount === 0) {
            $endDataRow = $startDataRow;
        }

        $totalRow = $endDataRow + 1;
        // dd($startDataRow, $endDataRow, $totalRow);

        // Tulis teks "TOTAL" dan rumus SUM ke cell Excel
        $sheet->setCellValue("A{$totalRow}", 'TOTAL');
        $sheet->setCellValue("E{$totalRow}", "=SUM(E{$startDataRow}:E{$endDataRow})"); // Total Terjual
        $sheet->setCellValue("F{$totalRow}", "=SUM(F{$startDataRow}:F{$endDataRow})"); // Total Kas Masuk
        $sheet->setCellValue("G{$totalRow}", "=SUM(G{$startDataRow}:G{$endDataRow})"); // Total Keuntungan
        $sheet->setCellValue("H{$totalRow}", "");

        // Format mata uang rupiah untuk kolom harga dan pendapatan (C, D, F, G)
        $currencyFormat = '#,##0';
        $sheet->getStyle("C{$startDataRow}:D{$totalRow}")->getNumberFormat()->setFormatCode($currencyFormat);
        $sheet->getStyle("F{$startDataRow}:G{$totalRow}")->getNumberFormat()->setFormatCode($currencyFormat);

        //untk total omset dan total pendapatan di bawah, format mata uang rupiah
        $sheet->getStyle("B2:B3")->getNumberFormat()->setFormatCode($currencyFormat);
        $sheet->getStyle("D2:D3")->getNumberFormat()->setFormatCode($currencyFormat);


        // Format styling agar terlihat profesional
        return [
            // Tebalkan judul periode tanggal
            1 => ['font' => ['bold' => true]],
            2 => ['font' => ['bold' => true]],
            3 => ['font' => ['bold' => true]],

            // Tebalkan Header Tabel (Baris ke-5)
            5 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5'] // Warna Indigo/Biru Modern
                ]
            ],

            // Tebalkan Baris Total Paling Bawah
            $totalRow => [
                'font' => ['bold' => true],
                'borders' => [
                    'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE] // Garis dua akuntansi
                ]
            ],
        ];
    }
}
