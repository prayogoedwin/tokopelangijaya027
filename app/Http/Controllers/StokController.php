<?php

namespace App\Http\Controllers;

use App\Exports\StokExport;
use App\Models\Produk;
use App\Models\Stok;
use App\Models\Toko;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class StokController extends Controller
{
    private function getPagedata()
    {
        // protected $fillable = [
        // 'produk_id',
        // 'tipe',
        // 'jumlah',

        // 'created_by',
        // 'updated_by',
        // 'deleted_by',
        // ];
        $produks = Produk::get();

        $pagedata = [
            'title' => 'Stok',
            'tablename' => 'stoks',
            'tableaction' => true,
            'canCreate' => false,
            'canDownload' => false,
            'columns' => [
                ['name' => 'produk_id', 'value' => 'produk', 'title' => 'Produk', 'type' => 'select', 'inform' => true, 'intable' => true, 'options' => [
                    // Ambil data kategori dari database
                    // ['value' => '', 'label' => 'Pilih Toko'],
                    ...$produks->map(function ($produk) {
                        return ['value' => $produk->id, 'label' => $produk->name];
                    })->toArray(),

                ]],
                ['name' => 'toko', 'value' => 'toko',  'title' => 'Toko', 'type' => 'text', 'inform' => false, 'intable' => true],
                ['name' => 'tipe', 'value' => 'tipe', 'title' => 'Tipe', 'type' => 'select', 'inform' => true, 'intable' => true, 'options' => [

                    ['value' => 'IN', 'label' => 'IN'],
                    ['value' => 'OUT', 'label' => 'OUT'],

                ]],
                ['name' => 'jumlah', 'value' => 'jumlah',  'title' => 'Jumlah', 'type' => 'number', 'inform' => true, 'intable' => true],
                ['name' => 'tanggal', 'value' => 'tanggal',  'title' => 'Tanggal', 'type' => 'text', 'inform' => false, 'intable' => true],


            ],
        ];

        return $pagedata;
    }

    public function index(Request $request)
    {



        if ($request->ajax()) {
            // dd('masuk ajax');
            $query = Stok::where('stoks.deleted_at', null)
                ->with(['produk', 'produk.toko'])
                ->select('stoks.*');


            // Memeriksa apakah ada parameter produk_id di dalam request
            if ($request->filled('produk_id')) {
                $query->where('produk_id', $request->input('produk_id'));
            }

            if ($request->filled('toko')) {
                $query->whereHas('produk.toko', function ($q) use ($request) {
                    $q->where('id', $request->input('toko'));
                });
            }

            $stoks = $query;

            return DataTables::of($stoks)
                ->editColumn('tanggal', function ($Stok) {
                    // Format tgl-bln-thn jam:menit:detik, misal: 18-05-2026 13:45:00
                    return \Carbon\Carbon::parse($Stok->created_at)->format('d-m-Y');
                })
                ->filterColumn('tanggal', function ($query, $keyword) {
                    // Mengubah created_at di MySQL menjadi format 'dd-mm-yyyy' agar cocok dengan ketikan user
                    $sql = "DATE_FORMAT(stoks.created_at, '%d-%m-%Y') like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->addColumn('toko', function ($Stok) {
                    return $Stok->produk->toko->name ?? '';
                })



                ->addColumn('actions', function ($Stok) {
                    $actions = '';

                    if (auth()->user()->hasPermission('show-stoks')) {
                        $actions .= '<a href="' . route('stoks.show', $Stok) . '" class="text-green-600 dark:text-green-400 hover:underline mr-3">View</a>';
                    }



                    return $actions;
                })
                ->order(function ($query) {
                    $query->orderBy('id', 'desc');
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        $pagedata = $this->getPagedata();
        $tokos = Toko::get();

        return view('stoks.index', $pagedata, compact('tokos'));
    }


    public function stokproduk(Produk $produk, Request $request)
    {
        // dd($produk, $request->all());
        $query = Stok::where('stoks.deleted_at', null)
            ->join('produks', 'stoks.produk_id', '=', 'produks.id')
            ->join('tokos', 'produks.toko_id', '=', 'tokos.id')
            ->select(
                'stoks.*',
                'produks.name as produk',
                'tokos.name as toko',
            );


        // ambil dari produk ini saja

        $query->where('stoks.produk_id', $produk->id);

        $stoks = $query->get();



        if ($request->ajax()) {
            // dd('masuk ajax');
            $query = Stok::where('stoks.deleted_at', null)
                ->join('produks', 'stoks.produk_id', '=', 'produks.id')
                ->join('tokos', 'produks.toko_id', '=', 'tokos.id')
                ->select(
                    'stoks.*',
                    'produks.name as produk',
                    'tokos.name as toko',
                );


            // ambil dari produk ini saja

            $query->where('stoks.produk_id', $produk->id);


            $stoks = $query->get();

            return DataTables::of($stoks)
                ->editColumn('tanggal', function ($Stok) {
                    // Format tgl-bln-thn
                    return \Carbon\Carbon::parse($Stok->created_at)->format('d-m-Y');
                })



                ->addColumn('actions', function ($Stok) {
                    $actions = '';

                    if (auth()->user()->hasPermission('show-stoks')) {
                        $actions .= '<a href="' . route('stoks.show', $Stok) . '" class="text-green-600 dark:text-green-400 hover:underline mr-3">View</a>';
                    }



                    return $actions;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        $stokMasuk = $stoks->where('tipe', 'IN')->sum('jumlah');

        $stokKeluar = $stoks->where('tipe', 'OUT')->sum('jumlah');

        $stokSaatIni = $stokMasuk - $stokKeluar;



        $pagedata = $this->getPagedata();

        return view('stoks.product', compact('produk', 'stokMasuk', 'stokKeluar', 'stokSaatIni'), $pagedata);
    }





    public function export()
    {
        // return Excel::download(new StokExport, 'stoks-' . date('Y-m-d') . '.xlsx');
    }

    public function create(): View
    {

        $pagedata = $this->getPagedata();

        return view('dynamiccrud.create', $pagedata);
    }

    public function store(Request $request): RedirectResponse
    {
        //     protected $fillable = [
        //     'produk_id',
        //     'tipe',
        //     'jumlah',

        //     'created_by',
        //     'updated_by',
        //     'deleted_by',
        // ];
        $store_data = [
            'produk_id' => $request->input('produk_id'),
            'tipe' => $request->input('tipe'),
            'jumlah' => $request->input('jumlah'),


            'created_by' => auth()->id(),
        ];


        $validate = Validator::make($store_data, [
            'produk_id' => ['required', 'integer'],
            'tipe' => ['required', 'string'],
            'jumlah' => ['required', 'integer'],


            'created_by' => ['required', 'integer']
        ]);


        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }



        $Stok = Stok::create($store_data);


        return to_route('stoks.index')->with('status', 'Stok updated successfully.');
    }

    public function show(Stok $Stok): View
    {

        $data = $Stok;
        $data->produk = $Stok->produk->name;


        $pagedata = $this->getPagedata();

        //TO DO: asdfasdfwe



        return view('dynamiccrud.show', compact('data'), $pagedata);
    }

    public function edit(Stok $Stok): View
    {
        $data = $Stok;

        $pagedata = $this->getPagedata();

        return view('dynamiccrud.edit', compact('data'), $pagedata);
    }

    public function update(Request $request, Stok $Stok): RedirectResponse
    {
        // dd($request->all());


        // dd("current user id: " . $current_user_id);
        $store_data = [
            'produk_id' => $request->input('produk_id'),
            'tipe' => $request->input('tipe'),
            'jumlah' => $request->input('jumlah'),


            'updated_by' => auth()->id(),
        ];


        $validate = Validator::make($store_data, [
            'produk_id' => ['required', 'integer'],
            'tipe' => ['required', 'string'],
            'jumlah' => ['required', 'integer'],


            'updated_by' => ['required', 'integer']
        ]);


        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }


        // dd("validated data: " . json_encode($validate));




        // dd($data);

        $Stok->update($store_data);


        // dd("Stok updated: " . json_encode($Stok));



        return to_route('stoks.index')->with('status', 'Stok updated successfully.');
    }

    //soft delete
    public function destroy(Stok $Stok): RedirectResponse
    {
        $Stok->update(['deleted_by' => auth()->id(), 'deleted_at' => now()]);
        // $Stok->delete();


        return to_route('stoks.index')->with('status', 'Stok deleted successfully.');
    }
}
