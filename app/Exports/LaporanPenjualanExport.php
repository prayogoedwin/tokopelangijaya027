<?php

namespace App\Exports;

use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Produk;
use Maatwebsite\Excel\Concerns\FromArray;
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
    protected $data;
    protected $totalStok;
    protected $totalAsset;
    protected $totalOmset;
    protected $totalPendapatan;
    private $rowCount = 0;

    public function __construct($startdate, $enddate, $toko = null)
    {
        $this->startdate = $startdate;
        $this->enddate = $enddate;
        $this->toko = $toko;
        $this->totalStok = 0;
        $this->totalAsset = 0;
        $this->totalOmset = 0;
        $this->totalPendapatan = 0;

        $this->prepareData();
    }

    private function prepareData()
    {
        $startLocal = $this->startdate . ' 00:00:00';
        $endLocal = $this->enddate . ' 23:59:59';

        $penjualanQuery = Penjualan::whereBetween('created_at', [$startLocal, $endLocal]);
        if ($this->toko) {
            $penjualanQuery->where('toko_id', $this->toko);
        }
        $this->totalOmset = (clone $penjualanQuery)->sum('total_harus_dibayar');

        $penjualandetails = PenjualanDetail::with(['produk.toko'])
            ->whereHas('penjualan', function ($query) use ($startLocal, $endLocal) {
                $query->whereBetween('created_at', [$startLocal, $endLocal]);
                if ($this->toko) {
                    $query->where('toko_id', $this->toko);
                }
            })
            ->get();

        $this->totalPendapatan = $penjualandetails->sum(function ($detail) {
            return ($detail->harga_jual - $detail->harga_beli) * $detail->jumlah;
        });

        $produks = Produk::with('toko')->whereNull('deleted_at')
            ->withSum(['stoks as total_masuk' => function ($query) {
                $query->where('tipe', 'IN');
            }], 'jumlah')
            ->withSum(['stoks as total_keluar' => function ($query) {
                $query->where('tipe', 'OUT');
            }], 'jumlah');

        if ($this->toko) {
            $produks->where('toko_id', $this->toko);
        }

        $produks = $produks->get();

        $totalAsset = 0;
        $totalStok = 0;

        $laporan = [];
        foreach ($produks as $produk) {
            $detailsProduk = $penjualandetails->where('produk_id', $produk->id);
            $terjual = $detailsProduk->sum('jumlah');

            // Pakai harga di detail transaksi, bukan harga katalog sekarang
            $kas_masuk = $detailsProduk->sum(function ($detail) {
                return $detail->sub_total ?? ($detail->harga_jual * $detail->jumlah);
            });
            $pendapatan = $detailsProduk->sum(function ($detail) {
                return ($detail->harga_jual - $detail->harga_beli) * $detail->jumlah;
            });

            $stok_saat_ini = $produk->total_masuk - $produk->total_keluar;

            $totalStok += $stok_saat_ini;
            $totalAsset += $stok_saat_ini * $produk->harga_beli;

            $laporan[] = [
                'toko' => $produk->toko->name ?? '-',
                'produk' => $produk->name,
                'harga_beli' => $produk->harga_beli,
                'harga_jual' => $produk->harga_jual,
                'terjual' => $terjual,
                'kas_masuk' => $kas_masuk,
                'pendapatan' => $pendapatan,
                'stok_saat_ini' => $stok_saat_ini,
            ];
        }

        $sortedLaporan = collect($laporan)->sortByDesc('terjual')->values()->all();

        $this->data = $sortedLaporan;
        $this->rowCount = count($this->data);
        $this->totalStok = $totalStok;
        $this->totalAsset = $totalAsset;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function getRawData()
    {
        return $this->data ?? [];
    }

    public function headings(): array
    {
        return [
            ['Periode Laporan:', $this->startdate . ' s/d ' . $this->enddate],
            ['Total Omset:', $this->totalOmset, 'Total Stok', $this->totalStok],
            ['Total Pendapatan:', $this->totalPendapatan, 'Total Asset', $this->totalAsset],
            [],
            [
                'Toko',
                'Produk',
                'Harga Beli',
                'Harga Jual',
                'Terjual',
                'Kas Masuk (Sub Total)',
                'Keuntungan (Pendapatan)',
                'Stok Saat ini',
            ],
        ];
    }

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

    public function styles(Worksheet $sheet)
    {
        $startDataRow = 6;
        $endDataRow = $startDataRow + $this->rowCount - 1;

        if ($this->rowCount === 0) {
            $endDataRow = $startDataRow;
        }

        $totalRow = $endDataRow + 1;

        $sheet->setCellValue("A{$totalRow}", 'TOTAL');
        $sheet->setCellValue("E{$totalRow}", "=SUM(E{$startDataRow}:E{$endDataRow})");
        $sheet->setCellValue("F{$totalRow}", "=SUM(F{$startDataRow}:F{$endDataRow})");
        $sheet->setCellValue("G{$totalRow}", "=SUM(G{$startDataRow}:G{$endDataRow})");
        $sheet->setCellValue("H{$totalRow}", '');

        $currencyFormat = '#,##0';
        $sheet->getStyle("C{$startDataRow}:D{$totalRow}")->getNumberFormat()->setFormatCode($currencyFormat);
        $sheet->getStyle("F{$startDataRow}:G{$totalRow}")->getNumberFormat()->setFormatCode($currencyFormat);
        $sheet->getStyle('B2:B3')->getNumberFormat()->setFormatCode($currencyFormat);
        $sheet->getStyle('D2:D3')->getNumberFormat()->setFormatCode($currencyFormat);

        return [
            1 => ['font' => ['bold' => true]],
            2 => ['font' => ['bold' => true]],
            3 => ['font' => ['bold' => true]],
            5 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5'],
                ],
            ],
            $totalRow => [
                'font' => ['bold' => true],
                'borders' => [
                    'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE],
                ],
            ],
        ];
    }
}
