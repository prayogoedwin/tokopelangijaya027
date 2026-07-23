<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Produk;
use App\Models\TipePembayaran;
use App\Models\Toko;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class KasirController extends Controller
{
    public function index()
    {
        // Cek session
        if (session()->has('selected_toko_id')) {
            return redirect()->route('kasir.dashboard');
        }

        return redirect()->route('kasir.pilihtoko');
    }


    // Halaman pilih toko
    public function pilihToko()
    {

        $tokos = Toko::all();
        return view('kasir.pilihtoko', compact('tokos'));
    }

    // Proses simpan pilihan toko ke session
    public function simpanPilihanToko(Request $request)
    {
        $request->validate([
            'toko_id' => 'required|exists:tokos,id'
        ]);

        $toko = Toko::find($request->toko_id);

        // Simpan ke session
        session([
            'selected_toko_id' => $toko->id,
            'selected_toko_nama' => $toko->name,
            'selected_toko_data' => $toko
        ]);



        return to_route('kasir.dashboard')->with('status', 'Berhasil memilih toko: ' . $toko->name);
    }

    // Halaman utama kasir (setelah pilih toko)
    public function dashboard()
    {
        // Ambil data dari session
        $tokoId = session('selected_toko_id');
        $tokoNama = session('selected_toko_nama');
        $toko_tipe_kasir = Toko::find($tokoId)->tipe_kasir;

        // Load data yang diperlukan untuk kasir
        $produks = Produk::where('produks.toko_id', $tokoId)
            ->get();

        $tipe_pembayarans = TipePembayaran::get();

        // dd($toko_tipe_kasir);

        if ($toko_tipe_kasir === "POS") {
            return view('kasir.kasirtipe1', compact('tokoId', 'tokoNama', 'produks', 'tipe_pembayarans'));
        }

        return view('kasir.kasirtipe2', compact('tokoId', 'tokoNama', 'produks', 'tipe_pembayarans'));
    }

    public function processPayment(Request $request)
    {
        // dd($request->all()); 

        $validated = $request->validate([
            'cart_items' => 'required|json',
            'subtotal_before_discount' => 'required|numeric',
            'discount_percent' => 'required|numeric',
            'discount_amount' => 'required|numeric',
            'payment_method_id' => 'required|numeric',
            'total_payment' => 'required|numeric',
            'payment_amount' => 'required|numeric',
            'change_amount' => 'required|numeric',
            // 'transaction_id' => 'required|string'
        ]);
        $cartItems = json_decode($request->cart_items, true);

        // $fillable = [
        //     'customer_id',
        //     'toko_id',
        //     'no_invoice',
        //     'tipe_pembayaran_id',
        //     'total_pembelian',
        //     'diskon_percentage',
        //     'diskon_nominal',
        //     'total_harus_dibayar',
        //     'dibayar',
        //     'kembalian',
        //     'keterangan',

        //     'created_by',
        //     'updated_by',
        //     'deleted_by',
        // ];
        // dd("here");

        // Create penjualan record
        $penjualan = Penjualan::create([
            'toko_id' =>  session('selected_toko_id'),
            // 'no_invoice' => nanti di model
            'tipe_pembayaran_id' => $validated['payment_method_id'],
            'diskon_percentage' => $validated['discount_percent'],
            'diskon_nominal' => $validated['discount_amount'],
            'total_pembelian' => $validated['subtotal_before_discount'],
            'total_harus_dibayar' => $validated['total_payment'],
            'dibayar' => $validated['payment_amount'],
            'kembalian' => $validated['change_amount'],
            'keterangan' => 'completed',

            'created_by' => auth()->user()->id,
        ]);

        foreach ($cartItems as $item) {
            PenjualanDetail::create([
                'penjualan_id' => $penjualan->id,
                'produk_id' => $item['id'],
                'harga_jual' => $item['price'],
                'harga_beli' => $item['harga_beli'],
                'jumlah' => $item['quantity'],
                'satuan' => $item['unit'],
                'sub_total' => $item['total'],

                'created_by' => auth()->user()->id,
            ]);
        }
        $timezone = 'Asia/Jakarta';

        // penyediain data untuk ditampilkan di modal setelah pembayaran karena tidak bisa langsung dengan relasi
        $penjualan->penjualan_id = $penjualan->id;
        $penjualan->tipe_pembayaran = $penjualan->tipePembayaran;
        $penjualan->tipe_pembayaran_name = $penjualan->tipePembayaran->name;
        $penjualan->toko_telp = $penjualan->toko->telp;
        $penjualan->details = $penjualan->details;
        foreach ($penjualan->details as $detail) {
            $detail->name = $detail->produk->name;
        }

        return to_route('kasir.dashboard')
            ->with('status', 'Berhasil Melakukan Transaksi: ')
            ->with('show_payment_modal', true)
            ->with('transaction_data', $penjualan);
    }

    // Fitur exit toko (clear session tapi tidak logout)
    public function exitToko()
    {
        // Hapus session toko
        session()->forget(['selected_toko_id', 'selected_toko_nama', 'selected_toko_data']);

        return redirect()->route('kasir.pilihtoko')
            ->with('success', 'Berhasil keluar dari toko');
    }


    //--------KASIR ONLY-----------//

    public function kasir_dashboard()
    {
        // Ambil data dari session
        $tokoId = session('selected_toko_id');
        $tokoNama = session('selected_toko_nama');
        $toko_tipe_kasir = Toko::find($tokoId)->tipe_kasir;

        // Load data yang diperlukan untuk kasir
        $produks = Produk::where('produks.toko_id', $tokoId)
            ->get();

        $tipe_pembayarans = TipePembayaran::get();

        // dd($produks);
        // dd($toko_tipe_kasir);


        if ($toko_tipe_kasir == "Invoice") {
            return view('kasir.kasironlytipe2', compact('tokoId', 'tokoNama', 'produks', 'tipe_pembayarans'));
        }

        return view('kasir.kasironlytipe1', compact('tokoId', 'tokoNama', 'produks', 'tipe_pembayarans'));
    }

    public function kasir_pilihToko()
    {
        // dd('here');
        $tokos = Toko::all(); // Ambil semua toko
        return view('kasir.kasir_pilihtoko', compact('tokos'));
    }

    public function kasir_simpanPilihanToko(Request $request)
    {
        $request->validate([
            'toko_id' => 'required|exists:tokos,id',
            'kode_toko' => 'required'
        ]);

        $toko = Toko::find($request->toko_id);

        if ($request->kode_toko != $toko->kode_toko) {
            return back()->with('status', 'Kode salah');
        }

        // Simpan ke session
        session([
            'selected_toko_id' => $toko->id,
            'selected_toko_nama' => $toko->name,
            'selected_toko_data' => $toko
        ]);



        return to_route('kasir.kasir_dashboard')->with('status', 'Berhasil memilih toko: ' . $toko->name);
    }

    public function kasir_processPayment(Request $request)
    {
        // dd($request->all()); 

        $validated = $request->validate([
            'cart_items' => 'required|json',
            'subtotal_before_discount' => 'required|numeric',
            'discount_percent' => 'required|numeric',
            'discount_amount' => 'required|numeric',
            'payment_method_id' => 'required|numeric',
            'total_payment' => 'required|numeric',
            'payment_amount' => 'required|numeric',
            'change_amount' => 'required|numeric',
            // 'transaction_id' => 'required|string'
        ]);
        $cartItems = json_decode($request->cart_items, true);

        // $fillable = [
        //     'customer_id',
        //     'toko_id',
        //     'no_invoice',
        //     'tipe_pembayaran_id',
        //     'total_pembelian',
        //     'diskon_percentage',
        //     'diskon_nominal',
        //     'total_harus_dibayar',
        //     'dibayar',
        //     'kembalian',
        //     'keterangan',

        //     'created_by',
        //     'updated_by',
        //     'deleted_by',
        // ];
        // dd("here");

        // Create penjualan record
        $penjualan = Penjualan::create([
            'toko_id' =>  session('selected_toko_id'),
            // 'no_invoice' => nanti di model
            // 'tipe_pembayaran_id' => $validated['discount_percent'],
            'tipe_pembayaran_id' => $validated['payment_method_id'],
            'diskon_percentage' => $validated['discount_percent'],
            'diskon_nominal' => $validated['discount_amount'],
            'total_pembelian' => $validated['subtotal_before_discount'],
            'total_harus_dibayar' => $validated['total_payment'],
            'dibayar' => $validated['payment_amount'],
            'kembalian' => $validated['change_amount'],
            'keterangan' => 'completed',

            'created_by' => auth()->user()->id,
        ]);

        // dd($penjualan);

        // $fillable = [
        //     'penjualan_id',
        //     'produk_id',
        //     'harga_beli',
        //     'harga_jual',
        //     'jumlah',
        //     'satuan',
        //     'sub_total',
        //     'created_by',
        //     'updated_by',
        //     'deleted_by',
        // ];
        // Create penjualan details
        foreach ($cartItems as $item) {
            PenjualanDetail::create([
                'penjualan_id' => $penjualan->id,
                'produk_id' => $item['id'],
                'harga_jual' => $item['price'],
                'harga_beli' => $item['harga_beli'],
                'jumlah' => $item['quantity'],
                'satuan' => $item['unit'],
                'sub_total' => $item['total'],

                'created_by' => auth()->user()->id,
            ]);
        }

        // penyediain data untuk ditampilkan di modal setelah pembayaran karena tidak bisa langsung dengan relasi
        $penjualan->penjualan_id = $penjualan->id;
        $penjualan->tipe_pembayaran = $penjualan->tipePembayaran;
        $penjualan->tipe_pembayaran_name = $penjualan->tipePembayaran->name;
        $penjualan->details = $penjualan->details;
        $penjualan->toko_telp = $penjualan->toko->telp;
        foreach ($penjualan->details as $detail) {
            $detail->name = $detail->produk->name;
        }

        return to_route('kasir.kasir_dashboard')
            ->with('status', 'Berhasil Melakukan Transaksi: ')
            ->with('show_payment_modal', true)
            ->with('transaction_data', $penjualan);
    }

    public function kasir_cekstok(Request $request)
    {

        if ($request->ajax()) {
            $produks = Produk::whereNull('produks.deleted_at') // Tip: whereNull is cleaner!
                ->where('produks.toko_id', session('selected_toko_id'))
                ->join('kategories', 'produks.kategori_id', '=', 'kategories.id')
                ->select(
                    'produks.*',
                    'kategories.name as kategori',
                );



            return DataTables::of($produks)
                ->addColumn('stok', function ($produk) {
                    // Menghitung stok lewat method model secara dinamis
                    return $produk->currentStok();
                })
                ->filterColumn('kategori', function ($query, $keyword) {
                    $sql = "LOWER(kategories.name) LIKE ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->make(true); // Tambahkan make(true) di akhir untuk format JSON DataTables
        }

        $kategories = Kategori::get();
        $satuans = config('helper.satuans');

        $pagedata = [
            'title' => 'Cek Stok Produk',
            'tablename' => 'produks',
            'tableaction' => false,

            'columns' => [
                ['name' => 'name', 'value' => 'name',  'title' => 'Nama Produk', 'type' => 'text', 'inform' => true, 'intable' => true],
                ['name' => 'sku', 'value' => 'sku',  'title' => 'SKU', 'type' => 'text', 'inform' => true, 'intable' => true],


                ['name' => 'kategori_id', 'value' => 'kategori', 'title' => 'Kategori', 'type' => 'select', 'inform' => true, 'intable' => true, 'options' => [
                    // Ambil data kategori dari database
                    ...$kategories->map(function ($kategori) {
                        return ['value' => $kategori->id, 'label' => $kategori->name];
                    })->toArray(),

                ]],
                
                ['name' => 'harga_jual', 'value' => 'harga_jual', 'title' => 'Harga Jual', 'type' => 'number', 'inform' => true, 'intable' => true],
                ['name' => 'satuan', 'value' => 'satuan', 'title' => 'Satuan', 'type' => 'select', 'inform' => true, 'intable' => true, 'options' => [
                    ...collect($satuans)->map(function ($satuan) {
                        return ['value' => $satuan, 'label' => $satuan];
                    })->toArray(),

                ]],
                ['name' => 'stok', 'value' => 'stok', 'title' => 'Stok', 'type' => 'number', 'inform' => false, 'intable' => true],

            ],
        ];

        return view('kasir.kasironly_cekstok', $pagedata);
    }

    public function kasir_cekpenjualan(Request $request)
    //bisa juga dibilang history penjualan, history transaksi
    {

        if ($request->ajax()) {
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

            



            // hanya dari toko yang dipilih di session
            $penjualans = Penjualan::where('penjualans.deleted_at', null)
                ->where('penjualans.toko_id', session('selected_toko_id'))
                ->whereBetween('penjualans.created_at', [
                    $startUtc,
                    $endUtc
                ])
                ->with(['details.produk', 'tipePembayaran', 'toko']);
            // dd($penjualans);

            return DataTables::of($penjualans)
                ->addColumn('tanggal', function ($penjualan) {
                    return Carbon::parse($penjualan->created_at)->translatedFormat('d M Y H:i:s');
                })
                
                ->addColumn('tipe_pembayaran', function ($penjualan) {
                    return $penjualan->tipePembayaran->name ?? 'N/A';
                })
                
                
                ->addColumn('produks', function ($penjualan) {
                    $produkNames = $penjualan->details->map(function ($detail) {
                        return   '[' . $detail->produk->sku . '] ' . $detail->produk->name . ' - ' . $detail->jumlah . ' ' . $detail->satuan;
                    })->toArray();
                    return implode('<br>', $produkNames);
                })
                ->filterColumn('produks', function ($query, $keyword) {
                    $query->whereHas('details.produk', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%")
                            ->orWhere('sku', 'like', "%{$keyword}%");
                    });
                })
                ->addColumn('action', function ($penjualan) {
                    return '<a href="' . route('kasir.kasir_showpenjualan', $penjualan->id) . '" class="text-green-600 dark:text-green-400 hover:underline mr-3">Detail</a>';
                })
                ->rawColumns(['produks', 'action']) // Agar HTML di kolom action tidak di-escape
                ->make(true);
        }


        $startdate = $request->startdate ?? Carbon::now()->toDateString();
        $enddate = $request->enddate ?? Carbon::now()->toDateString();

        return view('kasir.kasironly_penjualan', compact('startdate', 'enddate'));
    }

    public function kasir_showpenjualan(Penjualan $penjualan)
    {
        // Pastikan penjualan ini milik toko yang sedang dipilih
        if ($penjualan->toko_id != session('selected_toko_id')) {
            abort(403, 'Unauthorized action.');
        }

        $penjualan->load('details.produk', 'tipePembayaran', 'toko');

        return view('kasir.kasironly_showpenjualan', compact('penjualan'));
    }

    public function kasir_ceklaporan(Request $request)
    {

        $timezone = 'Asia/Jakarta';

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
                $query->whereBetween('created_at', [$startUtc, $endUtc])
                    ->where('toko_id', session('selected_toko_id'));
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


        $toko = session('selected_toko_id');
        $produks->whereHas('toko', function ($query) use ($toko) {
            $query->where('id', $toko);
        });



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




        // dd($request->all(), $start->toDateString(), $end->toDateString(), $totalOmset, $totalPendapatan, $jumlahTransaksi, $totalBarangTerjual, $stokHabisCount, $totalStok, $totalAsset);



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


        return view('kasir.kasironly_ceklaporan', compact('tokos'), $pagedata);
    }


    // Fitur exit toko (clear session tapi tidak logout) kalo punya toko maka logout
    public function kasir_exitToko()
    {
        // Hapus session toko
        session()->forget(['selected_toko_id', 'selected_toko_nama', 'selected_toko_data']);

        $ishaveToko = (bool) auth()->user()->toko_id;
        if ($ishaveToko) {

            auth()->logout();
            session()->invalidate();
            session()->regenerateToken();


            return redirect('/dashboard')->with('success', 'Berhasil logout');
        }

        return redirect()->route('kasir.kasir_pilihToko')
            ->with('success', 'Berhasil keluar dari toko');
    }
}
