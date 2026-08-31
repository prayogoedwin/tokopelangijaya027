<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AndroidPrintController extends Controller
{
    public function test(): JsonResponse
    {
        $data = [];

        /*
        |--------------------------------------------------------------------------
        | Store Name
        |--------------------------------------------------------------------------
        */

        $data[] = [
            'type' => 0,
            'content' => 'MY STORE',
            'bold' => 1,
            'align' => 1,
            'format' => 1,
        ];

        /*
        |--------------------------------------------------------------------------
        | Address
        |--------------------------------------------------------------------------
        */

        $data[] = [
            'type' => 0,
            'content' => '123 Main Street<br />My City',
            'bold' => 0,
            'align' => 1,
            'format' => 0,
        ];

        /*
        |--------------------------------------------------------------------------
        | Empty Line
        |--------------------------------------------------------------------------
        */

        $data[] = [
            'type' => 0,
            'content' => ' ',
            'bold' => 0,
            'align' => 0,
            'format' => 0,
        ];

        /*
        |--------------------------------------------------------------------------
        | Order Number
        |--------------------------------------------------------------------------
        */

        $data[] = [
            'type' => 0,
            'content' => 'Order #: ' . rand(1000, 9999),
            'bold' => 1,
            'align' => 0,
            'format' => 0,
        ];

        /*
        |--------------------------------------------------------------------------
        | Separator
        |--------------------------------------------------------------------------
        */

        $data[] = [
            'type' => 0,
            'content' => '--------------------------------',
            'bold' => 0,
            'align' => 0,
            'format' => 0,
        ];

        /*
        |--------------------------------------------------------------------------
        | Products
        |--------------------------------------------------------------------------
        */

        $data[] = [
            'type' => 0,
            'content' => 'Burger x 2        $20.00<br />Pizza x 1         $15.00',
            'bold' => 0,
            'align' => 0,
            'format' => 0,
        ];

        /*
        |--------------------------------------------------------------------------
        | Total
        |--------------------------------------------------------------------------
        */

        $data[] = [
            'type' => 0,
            'content' => 'TOTAL: $35.00',
            'bold' => 1,
            'align' => 2,
            'format' => 1,
        ];

        /*
        |--------------------------------------------------------------------------
        | QR Code
        |--------------------------------------------------------------------------
        */

        $data[] = [
            'type' => 3,
            'value' => 'https://example.com/order/' . rand(1000, 9999),
            'size' => 40,
            'align' => 1,
        ];

        /*
        |--------------------------------------------------------------------------
        | Thank You
        |--------------------------------------------------------------------------
        */

        $data[] = [
            'type' => 0,
            'content' => 'Thank you for your order!',
            'bold' => 0,
            'align' => 1,
            'format' => 0,
        ];

        /*
        |--------------------------------------------------------------------------
        | Return JSON
        |--------------------------------------------------------------------------
        */

        return response()->json(
            $data,
            200,
            [],
            JSON_FORCE_OBJECT
        );
    }

    public function receipt(int $id): JsonResponse
    {
        $transaction = Penjualan::with([
            'details.produk',
            'toko',
        ])->findOrFail($id);


        $toko = $transaction->toko;

        $invoiceNo = $transaction->no_invoice;

        $dateStr = optional($transaction->created_at)
            ->format('d-m-Y H:i');


        $totalPembelian = $this->formatRupiah(
            $transaction->total ?? 0
        );

        $diskonNominal = $this->formatRupiah(
            $transaction->diskon_nominal ?? 0
        );

        $totalHarusBayar = $this->formatRupiah(
            $transaction->grand_total ?? $transaction->total ?? 0
        );

        $dibayar = $this->formatRupiah(
            $transaction->dibayar ?? 0
        );

        $kembalian = $this->formatRupiah(
            $transaction->kembalian ?? 0
        );

        $metodeBayar = $transaction->metode_bayar ?? 'Cash';



        $dataCetak = [];


        $addText = function (
            string $content,
            int $bold = 0,
            int $align = 0,
            int $format = 0
        ) use (&$dataCetak) {

            $dataCetak[] = [
                'type' => 0,
                'content' => $content,
                'bold' => $bold,
                'align' => $align,
                'format' => $format,
            ];
        };



        $addText(
            $toko->name ?? '',
            1,
            1,
            1
        );

        $addText(
            $toko->alamat ?? '',
            0,
            1,
            0
        );

        $addText(
            'Telp: ' . ($toko->telp ?? '-'),
            0,
            1,
            0
        );

        $addText(
            str_repeat('-', 48)
        );


        $addText(
            'Nota : ' . $invoiceNo
        );

        $addText(
            'Tgl  : ' . $dateStr
        );

        $addText(
            str_repeat('-', 48)
        );


        if (
            $transaction->details &&
            $transaction->details->count() > 0
        ) {

            foreach ($transaction->details as $detail) {


                $namaProduk = $detail->produk->name ?? 'Produk';

                $qtyStr = $detail->jumlah . 'x';

                $hargaStr = $this->formatRupiah(
                    $detail->harga_jual
                );

                $subtotalStr = $this->formatRupiah(
                    $detail->harga_jual * $detail->jumlah
                );


                $addText(
                    $namaProduk
                );

                $detailRow = $this->formatRow80mm(
                    '  ' . $qtyStr . ' ' . $hargaStr,
                    $subtotalStr
                );

                $addText(
                    $detailRow
                );
            }
        }

        $addText(
            str_repeat('-', 48)
        );

        $addText(
            $this->formatRow80mm(
                'Total:',
                $totalPembelian
            )
        );

        if ((float) ($transaction->diskon_nominal ?? 0) > 0) {

            $diskonPersen =
                ($transaction->diskon_percentage ?? 0) . '%';

            $addText(
                $this->formatRow80mm(
                    'Diskon (' . $diskonPersen . '):',
                    '-' . $diskonNominal
                )
            );
        }

        $addText(
            $this->formatRow80mm(
                'Grand Total:',
                $totalHarusBayar
            ),
            1
        );

        $addText(
            $this->formatRow80mm(
                'Bayar (' . $metodeBayar . '):',
                $dibayar
            )
        );

        $addText(
            $this->formatRow80mm(
                'Kembalian:',
                $kembalian
            )
        );

        $addText(
            str_repeat('-', 48)
        );


        /*
        |--------------------------------------------------------------------------
        | FOOTER
        |--------------------------------------------------------------------------
        */

        $addText(
            'Barang yang sudah dibeli tidak dapat dikembalikan<br />' .
            'kecuali ada perjanjian',
            0,
            1
        );

        $addText(
            'TERIMA KASIH',
            1,
            1
        );

        $addText(
            "JUAL SE'ADA NYA BARELA'AN",
            0,
            1
        );


        /*
        |--------------------------------------------------------------------------
        | PAPER FEED
        |--------------------------------------------------------------------------
        */

        $addText(' ');
        $addText(' ');
        $addText(' ');
        $addText(' ');



        return response()->json(
            $dataCetak,
            200,
            [],
            JSON_FORCE_OBJECT
        );
    }

    
    private function formatRupiah($amount): string
    {
        return 'Rp' . number_format(
            (float) $amount,
            0,
            ',',
            '.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORMAT ROW FOR 80MM PRINTER
    |--------------------------------------------------------------------------
    */

    private function formatRow80mm(
        string $left,
        string $right,
        int $width = 48
    ): string {

        $space = $width
            - mb_strlen($left)
            - mb_strlen($right);

        /*
        |--------------------------------------------------------------------------
        | IF TEXT IS TOO LONG
        |--------------------------------------------------------------------------
        */

        if ($space < 1) {

            return $left .
                "\n" .
                str_repeat(
                    ' ',
                    max(
                        0,
                        $width - mb_strlen($right)
                    )
                ) .
                $right;
        }


        return $left .
            str_repeat(' ', $space) .
            $right;
    }
}
