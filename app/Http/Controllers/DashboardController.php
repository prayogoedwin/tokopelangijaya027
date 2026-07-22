<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Toko;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // dd(auth()->user()->hasRole('kasir'));
        $isKasir = auth()->user()->hasRole('kasir');

        if ($isKasir) {

            if (session()->has('selected_toko_id') && session()->has('selected_toko_nama')) {
                return to_route('kasir.kasir_dashboard');
            }

            $ishaveToko = (bool) auth()->user()->toko_id;

            if ($ishaveToko) {
                $toko = Toko::find(auth()->user()->toko_id);


                session([
                    'selected_toko_id' => $toko->id,
                    'selected_toko_nama' => $toko->name,
                    'selected_toko_data' => $toko
                ]);

                return to_route('dashboard');
            }

            return to_route('kasir.kasir_pilihToko');
        }

        $tokos = Toko::get();

        $produks = Produk::whereNull('deleted_at')
            ->withSum(['stoks as total_masuk' => function ($query) {
                $query->where('tipe', 'IN');
            }], 'jumlah')
            ->withSum(['stoks as total_keluar' => function ($query) {
                $query->where('tipe', 'OUT');
            }], 'jumlah');


        $produks = $produks->get();

        $tokos->map(function ($toko) use ($produks) {

            // Filter produk yang dimiliki oleh toko ini saja
            $produkToko = $produks->where('toko_id', $toko->id);

            // Proses setiap produk untuk menghitung stok saat ini
            $produkToko->map(function ($produk) {
                $masuk = $produk->total_masuk ?? 0;
                $keluar = $produk->total_keluar ?? 0;

                // Set atribut baru secara dinamis untuk UI
                $produk->current_stok = $masuk - $keluar;
                return $produk;
            });

            // Filter produk yang stoknya menipis (misal: kurang dari 10)
            // Anda bisa mengganti angka 10 sesuai dengan batas minimum bisnis Anda
            $toko->produk_menipis = $produkToko->filter(function ($produk) {
                return $produk->current_stok <= $produk->batas_bawah;
            })->values(); // reset index array agar rapi

            return $toko;
        });



        return view('dashboard', compact('tokos'));
    }

    public function instalasiPrinter()
    {
        return view('docs.instalasi');
    }
}
