<?php

namespace App\Http\Controllers;

use App\Exports\PenjualanExport;
use App\Models\Kategori;
use App\Models\Penjualan;
use App\Models\TipePembayaran;
use App\Models\Toko;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class PenjualanController extends Controller
{
    private function getPagedata()
    {
        $tokos = Toko::get();
        $tipe_pembayarans = TipePembayaran::get();

        //     protected $fillable = [
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

        $pagedata = [
            'title' => 'Penjualan',
            'tablename' => 'penjualans',
            'tableaction' => true,
            'canCreate' => false,
            'canEdit' => false,
            'canDownload' => false,
            'columns' => [
                ['name' => 'no_invoice', 'value' => 'no_invoice',  'title' => 'No Invoice', 'type' => 'text', 'inform' => true, 'intable' => true],
                ['name' => 'toko_id', 'value' => 'toko', 'title' => 'Toko', 'type' => 'select', 'inform' => true, 'intable' => true, 'options' => [
                    // Ambil data kategori dari database
                    ['value' => '', 'label' => 'Pilih Toko'],
                    ...$tokos->map(function ($toko) {
                        return ['value' => $toko->id, 'label' => $toko->name];
                    })->toArray(),

                ]],

                ['name' => 'tipe_pembayaran_id', 'value' => 'tipe_pembayaran', 'title' => 'Tipe Pembayaran', 'type' => 'select', 'inform' => true, 'intable' => true, 'options' => [
                    // Ambil data tipe_pembayaran dari database
                    ['value' => '', 'label' => 'Pilih Tipe Pembayaran'],
                    ...$tipe_pembayarans->map(function ($tipe_pembayaran) {
                        return ['value' => $tipe_pembayaran->id, 'label' => $tipe_pembayaran->name];
                    })->toArray(),

                ]],
                ['name' => 'total_harus_dibayar', 'value' => 'total_harus_dibayar', 'title' => 'Total', 'type' => 'number', 'inform' => true, 'intable' => true],
                ['name' => 'diskon_percentage', 'value' => 'diskon_percentage', 'title' => 'Diskon %', 'type' => 'number', 'inform' => true, 'intable' => true],
                ['name' => 'kasir', 'value' => 'kasir', 'title' => 'Kasir', 'type' => 'text', 'inform' => false, 'intable' => true],


            ],
        ];

        return $pagedata;
    }

    public function index(Request $request)
    {
        // dd($request->headers->all());

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

            $penjualans = Penjualan::whereNull('penjualans.deleted_at')
                ->whereBetween('penjualans.created_at', [$startUtc, $endUtc]);


            if ($request->has('toko') && $request->toko != '') {
                $penjualans = $penjualans->where('penjualans.toko_id', $request->toko);
            }


            // hanya dari toko yang dipilih di session
            $penjualans = $penjualans
                ->with(['toko', 'tipePembayaran', 'kasir', 'details.produk'])
                ->orderBy('penjualans.created_at', 'desc');

            return DataTables::of($penjualans)
                ->addColumn('tanggal', function ($penjualan) {
                    return $penjualan->created_at->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s');
                })
                ->addColumn('toko', function ($penjualan) {
                    return $penjualan->toko->name;
                })
                ->addColumn('tipe_pembayaran', function ($penjualan) {
                    return $penjualan->tipePembayaran->name;
                })
                ->addColumn('kasir', function ($penjualan) {
                    return $penjualan->kasir->name;
                })
                ->addColumn('produks', function ($penjualan) {
                    $produkNames = $penjualan->details->map(function ($detail) {
                        return   '[' . $detail->produk->sku . '] ' . $detail->produk->name . ' - ' . $detail->jumlah . ' ' . $detail->satuan;
                    })->toArray();
                    $content = implode('<br>', $produkNames);
                    return '<div style="max-height: 100px; overflow-y: auto; white-space: nowrap;">' . $content . '</div>';
                })
                ->filterColumn('produks', function ($query, $keyword) {
                    $query->whereHas('details.produk', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%")
                            ->orWhere('sku', 'like', "%{$keyword}%");
                    });
                })



                ->addColumn('actions', function ($Penjualan) {
                    $actions = '';

                    if (auth()->user()->hasPermission('show-penjualans')) {
                        $actions .= '<a href="' . route('penjualans.show', $Penjualan) . '" class="text-green-600 dark:text-green-400 hover:underline mr-3">View</a>';
                    }



                    if (auth()->user()->hasPermission('delete-penjualans')) {
                        $actions .= '<form action="' . route('penjualans.destroy', $Penjualan) . '" method="POST" class="inline" onsubmit="return confirm(\'Are you sure?\')">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="text-red-600 dark:text-red-400 hover:underline">Delete</button>
                        </form>';
                    }

                    return $actions;
                })
                ->rawColumns(['actions', 'produks'])
                ->make(true);
        }

        $pagedata = $this->getPagedata();

        $tokos = Toko::get();

        $startdate = $request->startdate ?? Carbon::now('Asia/Jakarta')->toDateString();
        $enddate = $request->enddate ?? Carbon::now('Asia/Jakarta')->toDateString();

        return view('penjualans.index', $pagedata, compact('tokos', 'startdate', 'enddate'));
    }





    public function export()
    {
        // return Excel::download(new PenjualanExport, 'penjualans-' . date('Y-m-d') . '.xlsx');
    }

    public function create(): View
    {

        $pagedata = $this->getPagedata();

        return view('dynamiccrud.create', $pagedata);
    }

    public function store(Request $request): RedirectResponse
    {
        $store_data = [
            'name' => $request->input('name'),
            'toko_id' => $request->input('toko_id'),
            'kategori_id' => $request->input('kategori_id'),
            'harga_beli' => $request->input('harga_beli'),
            'harga_jual' => $request->input('harga_jual'),

            'created_by' => auth()->id(),
        ];


        $validate = Validator::make($store_data, [
            'name' => ['required', 'string', 'max:255'],
            'toko_id' => ['required', 'integer'],
            'kategori_id' => ['required', 'integer'],
            'harga_beli' => ['required', 'integer'],
            'harga_jual' => ['required', 'integer'],

            'created_by' => ['required', 'integer']
        ]);


        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }



        $Penjualan = Penjualan::create($store_data);


        return to_route('penjualans.index')->with('status', 'Penjualan updated successfully.');
    }

    public function show(Penjualan $penjualan): View
    {
        $pagedata = $this->getPagedata();

        return view('penjualans.show', compact('penjualan'), $pagedata);
    }

    public function cetakNota(Penjualan $penjualan)
    {


        // dd($pembelian);

        // Opsional: Atur ukuran kertas (khusus nota thermal biasanya 80mm atau 58mm)
        // Jika kertas A4 gunakan 'a4', jika thermal gunakan array [0, 0, 226.77, 500] (80mm x sesuai panjang)
        $toko = $penjualan->toko;
        $pdf = Pdf::loadView('exports.nota', compact('penjualan', 'toko'))
            ->setPaper('a4', 'portrait');

        // Stream untuk melihat di browser, atau download() untuk langsung unduh
        return $pdf->download('Nota-' . $penjualan->no_invoice . '.pdf');
    }

    public function printThermal(Penjualan $penjualan)
    {


        $toko = $penjualan->toko;

        // Langsung return view HTML biasa, jangan di-render jadi PDF
        return view('exports.printkecil', compact('penjualan', 'toko'));
    }

    public function edit(Penjualan $Penjualan): View
    {
        $data = $Penjualan;

        $pagedata = $this->getPagedata();

        return view('dynamiccrud.edit', compact('data'), $pagedata);
    }

    public function update(Request $request, Penjualan $Penjualan): RedirectResponse
    {
        // dd($request->all());


        // dd("current user id: " . $current_user_id);
        $store_data = [
            'name' => $request->input('name'),
            'toko_id' => $request->input('toko_id'),
            'kategori_id' => $request->input('kategori_id'),
            'harga_beli' => $request->input('harga_beli'),
            'harga_jual' => $request->input('harga_jual'),

            'updated_by' => auth()->id(),
        ];


        $validate = Validator::make($store_data, [
            'name' => ['required', 'string', 'max:255'],
            'toko_id' => ['required', 'integer'],
            'kategori_id' => ['required', 'integer'],
            'harga_beli' => ['required', 'integer'],
            'harga_jual' => ['required', 'integer'],

            'updated_by' => ['required', 'integer']
        ]);


        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }


        // dd("validated data: " . json_encode($validate));




        // dd($data);

        $Penjualan->update($store_data);


        // dd("Penjualan updated: " . json_encode($Penjualan));



        return to_route('penjualans.index')->with('status', 'Penjualan updated successfully.');
    }

    //soft delete
    public function destroy(Penjualan $Penjualan): RedirectResponse
    {
        $Penjualan->update(['deleted_by' => auth()->id()]);

        $Penjualan->delete();


        return to_route('penjualans.index')->with('status', 'Penjualan deleted successfully.');
    }
}
