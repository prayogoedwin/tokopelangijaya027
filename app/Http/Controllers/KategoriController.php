<?php

namespace App\Http\Controllers;

use App\Exports\KategoriExport;
use App\Models\Kategori;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    private function getPagedata()
    {
        //     protected $fillable = [
        //     'id_parent',
        //     'name'
        // ];
        $kategories = Kategori::get();


        $pagedata = [
            'title' => 'Kategori',
            'tablename' => 'kategories',
            'tableaction' => true,
            'canDownload' => false,
            'columns' => [
                ['name' => 'name', 'value' => 'name',  'title' => 'Nama Kategori', 'type' => 'text', 'inform' => true, 'intable' => true],
                ['name' => 'id_parent', 'value' => 'parent',  'title' => 'Kategori Parent', 'type' => 'select', 'inform' => true, 'intable' => true, 'options' => [
                    // Ambil data kategori dari database
                    ['value' => '', 'label' => 'Tanpa Parent'],
                    ...$kategories->map(function ($kategori) {
                        return ['value' => $kategori->id, 'label' => $kategori->name];
                    })->toArray(),

                ]],


            ],
        ];

        return $pagedata;
    }

    public function index(Request $request)
    {
        // dd($request->headers->all());
        // $kategories = Kategori::from('kategories as child')
        //     ->leftJoin('kategories as parent', 'parent.id', '=', 'child.id_parent')
        //     ->select([
        //         'child.id as child_id',
        //         'child.name as name',
        //         'parent.id as parent_id',
        //         'parent.name as parent'
        //     ])
        //     ->get();

        // dd($kategories);

        if ($request->ajax()) {
            // dd('masuk ajax');
            $kategories = Kategori::from('kategories as child')
                ->leftJoin('kategories as parent', 'parent.id', '=', 'child.id_parent')
                ->select([
                    'child.id as id',
                    'child.name as name',
                    'parent.id as parent_id',
                    'parent.name as parent'
                ])
                ->get();

            // dd($kategories);
            // dd($kategories);

            return DataTables::of($kategories)



                ->addColumn('actions', function ($Kategori) {
                    $actions = '';

                    if (auth()->user()->hasPermission('show-kategories')) {
                        $actions .= '<a href="' . route('kategories.show', $Kategori) . '" class="text-green-600 dark:text-green-400 hover:underline mr-3">View</a>';
                    }

                    if (auth()->user()->hasPermission('edit-kategories')) {
                        $actions .= '<a href="' . route('kategories.edit', $Kategori) . '" class="text-blue-600 dark:text-blue-400 hover:underline mr-3">Edit</a>';
                    }

                    if (auth()->user()->hasPermission('delete-kategories')) {
                        $actions .= '<form action="' . route('kategories.destroy', $Kategori) . '" method="POST" class="inline" onsubmit="return confirm(\'Are you sure?\')">
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

        return view('dynamiccrud.index', $pagedata);
    }





    public function export()
    {
        // return Excel::download(new KategoriExport, 'kategories-' . date('Y-m-d') . '.xlsx');
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
            'id_parent' => $request->input('id_parent'),

            'created_by' => auth()->id(),
        ];


        $validate = Validator::make($store_data, [
            'name' => ['required', 'string', 'max:255'],
            'id_parent' => [],

            'created_by' => ['required', 'integer']
        ]);


        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }



        $Kategori = Kategori::create($store_data);


        return to_route('kategories.index')->with('status', 'Kategori updated successfully.');
    }

    public function show(Kategori $Kategori): View
    {

        $data = $Kategori;


        $pagedata = $this->getPagedata();

        //TO DO: asdfasdfwe



        return view('dynamiccrud.show', compact('data'), $pagedata);
    }

    public function edit(Kategori $Kategori): View
    {
        $data = $Kategori;

        $pagedata = $this->getPagedata();

        return view('dynamiccrud.edit', compact('data'), $pagedata);
    }

    public function update(Request $request, Kategori $Kategori): RedirectResponse
    {
        // dd($request->all());


        // dd("current user id: " . $current_user_id);
        $store_data = [
            'name' => $request->input('name'),
            'id_parent' => $request->input('id_parent'),

            'updated_by' => auth()->id(),
        ];


        $validate = Validator::make($store_data, [
            'name' => ['required', 'string', 'max:255'],
            'id_parent' => [],

            'updated_by' => ['required', 'integer']
        ]);


        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }


        // dd("validated data: " . json_encode($validate));




        // dd($data);

        $Kategori->update($store_data);


        // dd("Kategori updated: " . json_encode($Kategori));



        return to_route('kategories.index')->with('status', 'Kategori updated successfully.');
    }

    //soft delete
    public function destroy(Kategori $Kategori): RedirectResponse
    {
        // $Kategori->update(['deleted_by' => auth()->id(), 'deleted_at' => now()]);
        $Kategori->delete();


        return to_route('kategories.index')->with('status', 'Kategori deleted successfully.');
    }
}
