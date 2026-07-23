<?php

namespace App\Http\Controllers;

use App\Exports\AbsensiExport;
use App\Exports\LaporanPenjualanExport;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Produk;
use App\Models\Toko;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class LaporanPenjualanController extends Controller
{
    private function getPagedata()
    {

        $pagedata = [
            'title' => 'Laporan Penjualan',
            'tableaction' => false,
            'canCreate' => false,
            'columns' => [
                ['name' => 'toko_id', 'value' => 'toko',  'title' => 'Toko', 'type' => 'text', 'intable' => true],
                ['name' => 'produk_id', 'value' => 'produk',  'title' => 'Produk', 'type' => 'text', 'intable' => true],
                ['name' => 'harga_beli', 'value' => 'harga_beli',  'title' => 'Harga Beli', 'type' => 'number', 'intable' => true],
                ['name' => 'harga_jual', 'value' => 'harga_jual',  'title' => 'Harga Jual', 'type' => 'number', 'intable' => true],
                ['name' => 'terjual', 'value' => 'terjual',  'title' => 'Terjual', 'type' => 'number', 'intable' => true],


            ],
        ];

        return $pagedata;
    }

    public function index(Request $request)
    {
        $pagedata = $this->getPagedata();


        $timezone = 'Asia/Jakarta'; // Timezone lokal user

        if ($request->filled(['startdate', 'enddate'])) {
            // Parse tanggal input sebagai waktu WIB
            $start = Carbon::parse($request->startdate, $timezone)->startOfDay();
            $end   = Carbon::parse($request->enddate, $timezone)->endOfDay();
        } else {
            // Default: Hari ini dalam WIB (dari jam 00:00:00 WIB s/d 23:59:59 WIB)
            $start = Carbon::now($timezone)->startOfDay();
            $end   = Carbon::now($timezone)->endOfDay();
        }

        // Convert Carbon instance ke UTC agar sesuai dengan record di Database
        $startUtc = $start->setTimezone('UTC')->toDateTimeString();
        $endUtc   = $end->setTimezone('UTC')->toDateTimeString();




        $totalOmset = 0;
        $totalPendapatan = 0;

        $penjualandetails = PenjualanDetail::with(['produk.toko'])
            ->whereHas('penjualan', function ($query) use ($startUtc, $endUtc) {
                // Filter based on the parent sale's transaction date
                $query->whereBetween('created_at', [
                    $startUtc,
                    $endUtc
                ])
                    ->where('deleted_at', null)
                ;
            });

        $jumlahTransaksi = $penjualandetails->distinct('penjualan_id')->count('penjualan_id');



        $penjualandetails = $penjualandetails->get();

        $produks = Produk::where('deleted_at', null)
            ->withSum(['stoks as total_masuk' => function ($query) {
                $query->where('tipe', 'IN');
            }], 'jumlah')
            ->withSum(['stoks as total_keluar' => function ($query) {
                $query->where('tipe', 'OUT');
            }], 'jumlah');

        if ($request->has('toko') && $request->toko != '') {
            $toko = $request->toko;
            $produks->whereHas('toko', function ($query) use ($toko) {
                $query->where('id', $toko);
            });
        }

        $produks = $produks->get();

        $laporan = [];
        $totalStok = 0;
        $totalAsset = 0;
        $stokHabisCount = 0;
        foreach ($produks as $produk) {
            $terjual = $penjualandetails->where('produk_id', $produk->id)->sum('jumlah');
            $harga_beli = $produk->harga_beli;
            $harga_jual = $produk->harga_jual;
            $stok_saat_ini = $produk->total_masuk - $produk->total_keluar;

            $totalStok += $stok_saat_ini;
            $totalAsset += $stok_saat_ini * $produk->harga_beli;

            if ($stok_saat_ini <= 0) {
                // dd($produk, $stok_saat_ini);
                $stokHabisCount++;
            }

            $laporan[] = [
                'toko' => $produk->toko->name,
                'produk' => $produk->name,
                'harga_beli' => $harga_beli,
                'harga_jual' => $harga_jual,
                'terjual' => $terjual,
                'stok_saat_ini' => $stok_saat_ini,
            ];


            $totalOmset += $harga_jual * $terjual;
            $totalPendapatan += ($harga_jual - $harga_beli) * $terjual;
        }

        $totalBarangTerjual = $penjualandetails->sum('jumlah');




        // dd($request->all(), $startUtc, $endUtc);

        if ($request->ajax()) {


            #max 10 data untuk ditampilkan di halaman, diambil dari yang penjualan paling banyak
            $laporan = collect($laporan)->sortByDesc('terjual')->values()->all();
            $laporan = array_slice($laporan, 0, 10);
            return DataTables::of($laporan)->make(true);
        }



        $tokos = Toko::where('deleted_at', null)->get();
        $pagedata['startdate'] = $start->toDateString();
        $pagedata['enddate'] = $end->toDateString();



        $pagedata['totalOmset'] = $totalOmset;
        $pagedata['totalPendapatan'] = $totalPendapatan;
        $pagedata['jumlahTransaksi'] = $jumlahTransaksi;
        $pagedata['totalBarangTerjual'] = $totalBarangTerjual;
        $pagedata['stokHabisCount'] = $stokHabisCount;
        $pagedata['totalStok'] = $totalStok;
        $pagedata['totalAsset'] = $totalAsset;



        // dd($pagedata);


        return view('laporans.penjualan', compact('tokos'), $pagedata);
    }






    public function export(Request $request)
    {
        // return Excel::download(new AbsensiExport, 'absensis-' . date('Y-m-d') . '.xlsx');
        // Mengambil filter tanggal dengan default bulan ini (sama seperti index dataTables)
        $startdate = $request->startdate ?: Carbon::now()->startOfMonth()->toDateString();
        $enddate = $request->enddate ?: Carbon::now()->endOfMonth()->toDateString();
        $toko = $request->toko ?: null;

        // Generate nama file dinamis agar tidak tertukar
        $filename = 'Laporan_Penjualan_' . $startdate . '_to_' . $enddate . '.xlsx';

        // Lempar parameter ke dalam Class Export
        return Excel::download(new LaporanPenjualanExport($startdate, $enddate, $toko), $filename);
    }
}
