<?php

namespace App\Http\Controllers;

use App\Exports\TokoExport;
use App\Models\Toko;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Validation\Rules\Password;

use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class TokoController extends Controller
{
    private function getPagedata()
    {

        // protected $fillable = [
        //     'name',
        //     'kode_toko',
        //     'pass_toko',
        //     'alamat',
        //     'status_toko',
        //     'created_by',
        //     'updated_by',
        //     'deleted_by'
        // ];

        $pagedata = [
            'title' => 'Toko',
            'tablename' => 'tokos',
            'tableaction' => true,
            'canCreate' => false,
            'canDelete' => false,
            'canDownload' => false,
            'columns' => [
                ['name' => 'kode_toko', 'value' => 'kode_toko',  'title' => 'Kode Toko', 'type' => 'text', 'inform' => true, 'intable' => true],
                ['name' => 'name', 'value' => 'name',  'title' => 'Nama Toko', 'type' => 'text', 'inform' => true, 'intable' => true],
                ['name' => 'pass_toko', 'value' => 'pass_toko', 'title' => 'Password Toko', 'type' => 'password', 'inform' => true, 'intable' => false],
                ['name' => 'alamat', 'value' => 'alamat', 'title' => 'Alamat', 'type' => 'text', 'inform' => true, 'intable' => true],
                ['name' => 'telp', 'value' => 'telp', 'title' => 'No Telp', 'type' => 'text', 'inform' => true, 'intable' => true],
                ['name' => 'status_toko', 'value' => 'status_toko', 'title' => 'Status', 'type' => 'select', 'inform' => true, 'intable' => true, 'options' => [

                    ['value' => 'Pusat', 'label' => 'Pusat'],
                    ['value' => 'Cabang', 'label' => 'Cabang'],

                ]],
                ['name' => 'tipe_kasir', 'value' => 'tipe_kasir', 'title' => 'Tipe Kasir', 'type' => 'select', 'inform' => true, 'intable' => true, 'options' => [

                    ['value' => 'Invoice', 'label' => 'Invoice'],
                    ['value' => 'POS', 'label' => 'POS'],

                ]]

            ],
        ];

        return $pagedata;
    }

    public function index(Request $request)
    {
        // dd($request->headers->all());
        if ($request->ajax()) {
            // dd('masuk ajax');
            $tokos = Toko::where('tokos.deleted_at', null)
                ->get();
            // dd($tokos);

            return DataTables::of($tokos)




                ->addColumn('actions', function ($Toko) {
                    $actions = '';

                    if (auth()->user()->hasPermission('show-tokos')) {
                        $actions .= '<a href="' . route('tokos.show', $Toko) . '" class="text-green-600 dark:text-green-400 hover:underline mr-3">View</a>';
                    }

                    if (auth()->user()->hasPermission('edit-tokos')) {
                        $actions .= '<a href="' . route('tokos.edit', $Toko) . '" class="text-blue-600 dark:text-blue-400 hover:underline mr-3">Edit</a>';
                    }

                    // if (auth()->user()->hasPermission('delete-tokos')) {
                    //     $actions .= '<form action="' . route('tokos.destroy', $Toko) . '" method="POST" class="inline" onsubmit="return confirm(\'Are you sure?\')">
                    //         ' . csrf_field() . method_field('DELETE') . '
                    //         <button type="submit" class="text-red-600 dark:text-red-400 hover:underline">Delete</button>
                    //     </form>';
                    // }

                    return $actions;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        $pagedata = $this->getPagedata();

        return view('dynamiccrud.index', $pagedata);
    }





    public function export()
    {
        // return Excel::download(new TokoExport, 'tokos-' . date('Y-m-d') . '.xlsx');
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
            'kode_toko' => $request->input('kode_toko'),
            'pass_toko' => $request->input('pass_toko'),
            'alamat' => $request->input('alamat'),
            'telp' => $request->input('telp'),
            'tipe_kasir' => $request->input('tipe_kasir'),
            'status_toko' => $request->input('status_toko'),

            'created_by' => auth()->id(),
        ];


        $validate = Validator::make($store_data, [
            'name' => ['required', 'string', 'max:255'],
            'kode_toko' => ['required'],
            'pass_toko' => ['required', 'string', 'max:50'],
            'alamat' => ['required', 'string'],
            'telp' => ['required', 'string'],
            'tipe_kasir' => ['required', 'string', 'max:255'],
            'status_toko' => ['required', 'string'],

            'created_by' => ['required', 'integer']
        ]);


        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }



        $Toko = Toko::create($store_data);


        return to_route('tokos.index')->with('status', 'Toko updated successfully.');
    }

    public function show(Toko $Toko): View
    {

        $data = $Toko;


        $pagedata = $this->getPagedata();

        //TO DO: asdfasdfwe



        return view('dynamiccrud.show', compact('data'), $pagedata);
    }

    public function edit(Toko $Toko): View
    {
        $data = $Toko;

        $pagedata = $this->getPagedata();

        return view('dynamiccrud.edit', compact('data'), $pagedata);
    }

    public function update(Request $request, Toko $Toko): RedirectResponse
    {
        // dd($request->all());

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'kode_toko' => ['required', 'string'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'alamat' => ['required', 'string', 'max:255'],
            'telp' => ['required', 'string', 'max:255'],
            'tipe_kasir' => ['required', 'string', 'max:255'],
            'status_toko' => ['required', 'string', 'max:255'],
        ]);

        $store_data = [
            'name' => $request->input('name'),
            'kode_toko' => $request->input('kode_toko'),
            'alamat' => $request->input('alamat'),
            'telp' => $request->input('telp'),
            'tipe_kasir' => $request->input('tipe_kasir'),
            'status_toko' => $request->input('status_toko'),

            'updated_by' => auth()->id(),
        ];

        $Toko->update($store_data);

        if (! empty($validated['password'])) {
            $Toko->update([
                'pass_toko' => Hash::make($validated['password']),
            ]);
        }


        return to_route('tokos.index')->with('status', 'Toko updated successfully.');
    }

    //soft delete
    public function destroy(Toko $Toko): RedirectResponse
    {
        $Toko->update(['deleted_by' => auth()->id()]);

        $Toko->delete();


        return to_route('tokos.index')->with('status', 'Toko deleted successfully.');
    }
}
