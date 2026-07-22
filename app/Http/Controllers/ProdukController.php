<?php

namespace App\Http\Controllers;

use App\Exports\ProdukExport;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Satuan;
use App\Models\Stok;
use App\Models\Toko;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ProdukController extends Controller
{
    private function getPagedata()
    {
        $tokos = Toko::get();
        $kategories = Kategori::get();
        $satuans = Satuan::get()->pluck('name')->toArray();

        //     protected $fillable = [
        //     'toko_id',
        //     'kategori_id',
        //     'name',
        //     'harga_beli',
        //     'harga_jual',
        //     'created_by',
        //     'updated_by',
        //     'deleted_by',

        // ];

        $pagedata = [
            'title' => 'Produk',
            'tablename' => 'produks',
            'tableaction' => true,
            'canDownload' => false,
            'columns' => [
                ['name' => 'name', 'value' => 'name',  'title' => 'Nama Produk', 'type' => 'text', 'inform' => true, 'intable' => true],
                ['name' => 'sku', 'value' => 'sku',  'title' => 'SKU', 'type' => 'text', 'inform' => true, 'intable' => true],
                ['name' => 'toko_id', 'value' => 'toko', 'title' => 'Toko', 'type' => 'select', 'inform' => true, 'intable' => true, 'options' => [
                    // Ambil data kategori dari database
                    ...$tokos->map(function ($toko) {
                        return ['value' => $toko->id, 'label' => $toko->name];
                    })->toArray(),

                ]],

                ['name' => 'kategori_id', 'value' => 'kategori', 'title' => 'Kategori', 'type' => 'select', 'inform' => true, 'intable' => true, 'options' => [
                    // Ambil data kategori dari database
                    ...$kategories->map(function ($kategori) {
                        return ['value' => $kategori->id, 'label' => $kategori->name];
                    })->toArray(),

                ]],
                ['name' => 'harga_beli', 'value' => 'harga_beli', 'title' => 'Harga Beli', 'type' => 'number', 'inform' => true, 'intable' => true],
                ['name' => 'harga_jual', 'value' => 'harga_jual', 'title' => 'Harga Jual', 'type' => 'number', 'inform' => true, 'intable' => true],
                ['name' => 'satuan', 'value' => 'satuan', 'title' => 'Satuan', 'type' => 'select', 'inform' => true, 'intable' => true, 'options' => [
                    ...collect($satuans)->map(function ($satuan) {
                        return ['value' => $satuan, 'label' => $satuan];
                    })->toArray(),

                ]],
                ['name' => 'batas_bawah', 'value' => 'batas_bawah', 'title' => 'Batas Bawah', 'type' => 'number', 'inform' => true, 'intable' => false],
                

            ],
        ];

        return $pagedata;
    }

    public function index(Request $request)
    {
        // dd($request->headers->all());

        if ($request->ajax()) {
            // dd('masuk ajax');
            $produks = Produk::where('produks.deleted_at', null)
                ->with('toko', 'kategori')
                ->select('produks.*');


            if ($request->filled('toko')) {
                $produks->where('toko_id', $request->input('toko'));
            }

            return DataTables::of($produks)
                ->addColumn('toko.name', function ($Produk) {
                    return $Produk->toko->name;
                })
                ->addColumn('kategori.name', function ($Produk) {
                    return $Produk->kategori->name;
                })
                // ->filterColumn('produk', function ($query, $keyword) {
                //     $query->where('produk_produks.name', 'like', "%{$keyword}%");
                // })



                ->addColumn('actions', function ($Produk) {
                    $actions = '';

                    if (auth()->user()->hasPermission('show-produks')) {
                        $actions .= '<a href="' . route('produks.show', $Produk) . '" class="text-green-600 dark:text-green-400 hover:underline mr-3">View</a>';
                    }
                    if (auth()->user()->hasPermission('show-stoks')) {
                        $actions .= '<a href="' . route('stoks.produk', $Produk->id) . '" class="text-green-600 dark:text-green-400 hover:underline mr-3">Stoks</a>';
                    }

                    if (auth()->user()->hasPermission('edit-produks')) {
                        $actions .= '<a href="' . route('produks.edit', $Produk) . '" class="text-blue-600 dark:text-blue-400 hover:underline mr-3">Edit</a>';
                    }

                    if (auth()->user()->hasPermission('delete-produks')) {
                        $actions .= '<form action="' . route('produks.destroy', $Produk) . '" method="POST" class="inline" onsubmit="return confirm(\'Are you sure?\')">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="text-red-600 dark:text-red-400 hover:underline">Delete</button>
                        </form>';
                    }

                    return $actions;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        $pagedata = $this->getPagedata();

        $tokos = Toko::get();

        return view('produks.index', $pagedata, compact('tokos')    );
    }





    public function export()
    {
        // return Excel::download(new ProdukExport, 'produks-' . date('Y-m-d') . '.xlsx');
    }

    public function create(): View
    {

        $pagedata = $this->getPagedata();

        return view('produks.create', $pagedata);
    }

    public function store(Request $request): RedirectResponse
    {
        $store_data = [
            'name' => $request->input('name'),
            'sku' => $request->input('sku'),
            'toko_id' => $request->input('toko_id'),
            'kategori_id' => $request->input('kategori_id'),
            'harga_beli' => $request->input('harga_beli'),
            'harga_jual' => $request->input('harga_jual'),
            'satuan' => $request->input('satuan'),
            'batas_bawah' => $request->input('batas_bawah'),

            'created_by' => auth()->id(),
        ];


        $validate = Validator::make($store_data, [
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['required', 'string', 'max:255'],
            'toko_id' => ['required', 'integer'],
            'kategori_id' => ['required', 'integer'],
            'harga_beli' => ['required', 'integer'],
            'harga_jual' => ['required', 'integer'],
            'satuan' => ['required', 'string'],
            'batas_bawah' => ['required', 'integer'],

            'created_by' => ['required', 'integer']
        ]);

        $validate2 = Validator::make($request->all(), [
            'stok_awal' => ['required', 'integer'],
        ]);


        if ($validate->fails() || $validate2->fails()) {
            return back()->withErrors($validate)->withInput()->withErrors($validate2)->withInput();
        }



        $Produk = Produk::create($store_data);

        $stok = Stok::create([
            'produk_id' => $Produk->id,
            'tipe' => 'IN',
            'jumlah' => $request->input('stok_awal'),
            'created_by' => auth()->id(),
        ]);


        return to_route('produks.index')->with('status', 'Produk updated successfully.');
    }

    public function tambahstokstore(Produk $produk, Request $request): RedirectResponse
    {
        $store_data = [
            'produk_id' => $produk->id,
            'tipe' => $request->input('tipe'),
            'jumlah' => $request->input('jumlah'),

            'created_by' => auth()->id(),
        ];


        $validate = Validator::make($store_data, [
            'tipe' => ['required', 'string', 'max:255'],
            'jumlah' => ['required', 'integer'],

            'created_by' => ['required', 'integer']
        ]);


        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }



        $stok = Stok::create($store_data);


        return redirect()->back()->with('status', 'Stok updated successfully.');
    }

    public function show(Produk $Produk): View
    {

        $data = $Produk;
        $data->kategori = Kategori::find($Produk->kategori_id)->name;
        $data->toko = Toko::find($Produk->toko_id)->name;
        $produk = $data;

        $pagedata = $this->getPagedata();

        //TO DO: asdfasdfwe

        // dd($data, $pagedata);

        return view('produks.show', compact('data', 'produk'), $pagedata);
    }

    public function edit(Produk $Produk): View
    {
        $data = $Produk;

        $pagedata = $this->getPagedata();

        return view('dynamiccrud.edit', compact('data'), $pagedata);
    }

    public function update(Request $request, Produk $Produk): RedirectResponse
    {
        // dd($request->all());


        // dd("current user id: " . $current_user_id);
        $store_data = [
            'name' => $request->input('name'),
            'sku' => $request->input('sku'),
            'toko_id' => $request->input('toko_id'),
            'kategori_id' => $request->input('kategori_id'),
            'harga_beli' => $request->input('harga_beli'),
            'harga_jual' => $request->input('harga_jual'),
            'satuan' => $request->input('satuan'),
            'batas_bawah' => $request->input('batas_bawah'),


            'created_by' => auth()->id(),
        ];


        $validate = Validator::make($store_data, [
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['required', 'string', 'max:255'],
            'toko_id' => ['required', 'integer'],
            'kategori_id' => ['required', 'integer'],
            'harga_beli' => ['required', 'integer'],
            'harga_jual' => ['required', 'integer'],
            'satuan' => ['required', 'string'],
            'batas_bawah' => ['integer'],


            'created_by' => ['required', 'integer']
        ]);

        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }


        // dd("validated data: " . json_encode($validate));




        // dd($data);

        $Produk->update($store_data);


        // dd("Produk updated: " . json_encode($Produk));



        return to_route('produks.index')->with('status', 'Produk updated successfully.');
    }

    //soft delete
    public function destroy(Produk $Produk): RedirectResponse
    {
        $Produk->update(['deleted_by' => auth()->id()]);

        $Produk->delete();


        return to_route('produks.index')->with('status', 'Produk deleted successfully.');
    }
}
