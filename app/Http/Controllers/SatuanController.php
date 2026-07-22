<?php

namespace App\Http\Controllers;

use App\Exports\SatuanExport;
use App\Models\Satuan;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class SatuanController extends Controller
{
    private function getPagedata()
    {

        $pagedata = [
            'title' => 'Satuan',
            'tablename' => 'satuans',
            'tableaction' => true,
            'columns' => [
                ['name' => 'name', 'value' => 'name',  'title' => 'Nama Satuan', 'type' => 'text', 'inform' => true, 'intable' => true],
                

            ],
        ];

        return $pagedata;
    }

    public function index(Request $request)
    {
        // dd($request->headers->all());
        if ($request->ajax()) {
            // dd('masuk ajax');
            $satuans = Satuan::get();
            // dd($satuans);

            return DataTables::of($satuans)
                // ->filterColumn('name', function ($query, $keyword) {
                //     $query->where('satuans.name_Satuan', 'like', "%{$keyword}%");
                // })
                // ->filterColumn('satuan', function ($query, $keyword) {
                //     $query->where('satuan_satuans.name', 'like', "%{$keyword}%");
                // })



                ->addColumn('actions', function ($Satuan) {
                    $actions = '';

                    if (auth()->user()->hasPermission('show-satuans')) {
                        $actions .= '<a href="' . route('satuans.show', $Satuan) . '" class="text-green-600 dark:text-green-400 hover:underline mr-3">View</a>';
                    }

                    if (auth()->user()->hasPermission('edit-satuans')) {
                        $actions .= '<a href="' . route('satuans.edit', $Satuan) . '" class="text-blue-600 dark:text-blue-400 hover:underline mr-3">Edit</a>';
                    }

                    if (auth()->user()->hasPermission('delete-satuans')) {
                        $actions .= '<form action="' . route('satuans.destroy', $Satuan) . '" method="POST" class="inline" onsubmit="return confirm(\'Are you sure?\')">
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
        // return Excel::download(new SatuanExport, 'satuans-' . date('Y-m-d') . '.xlsx');
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
            

            'created_by' => auth()->id(),
        ];


        $validate = Validator::make($store_data, [
            'name' => ['required', 'string', 'max:255'],
            

            'created_by' => ['required', 'integer']
        ]);


        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }



        $Satuan = Satuan::create($store_data);
        

        return to_route('satuans.index')->with('status', 'Satuan updated successfully.');
    }

    public function show(Satuan $Satuan): View
    {

        $data = $Satuan;


        $pagedata = $this->getPagedata();

        //TO DO: asdfasdfwe



        return view('dynamiccrud.show', compact('data'), $pagedata);
    }

    public function edit(Satuan $Satuan): View
    {
        $data = $Satuan;

        $pagedata = $this->getPagedata();

        return view('dynamiccrud.edit', compact('data'), $pagedata);
    }

    public function update(Request $request, Satuan $Satuan): RedirectResponse
    {
        // dd($request->all());


        // dd("current user id: " . $current_user_id);
        $store_data = [
            'name' => $request->input('name'),
           

            'updated_by' => auth()->id(),
        ];


        $validate = Validator::make($store_data, [
            'name' => ['required', 'string', 'max:255'],
            

            'updated_by' => ['required', 'integer']
        ]);


        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }


        // dd("validated data: " . json_encode($validate));




        // dd($data);

        $Satuan->update($store_data);


        // dd("Satuan updated: " . json_encode($Satuan));



        return to_route('satuans.index')->with('status', 'Satuan updated successfully.');
    }

    //soft delete
    public function destroy(Satuan $Satuan): RedirectResponse
    {
        // $Satuan->update(['deleted_by' => auth()->id(), 'deleted_at' => now()]);
        $Satuan->delete();


        return to_route('satuans.index')->with('status', 'Satuan deleted successfully.');
    }
}
