<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\MasterProduct;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BuyerController extends Controller
{
    //'price','proposal','favorite'
    private $active_dir = "buyer";

    public function index()
    {
        $data =  Buyer::with('product')->get();
        return view($this->active_dir.'.index',[
            'active_dir' => $this->active_dir,
            'data' => $data,
        ]);
    }


    public function index_ajax(Request $request)
    {

        if ($request->ajax()) {
            $data = Buyer::with('product')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $editUrl = route("$this->active_dir.edit", $row->id);
                    $deleteUrl = route("$this->active_dir.delete", $row->id);
                    $actionBtn = '<a role="button" class="btn btn-info" href="'.$editUrl.'">Edit</a> <a role="button" class="btn btn-danger" href="'.$deleteUrl.'">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

    }


    
    public function store(Request $request)
    {
        try {
            $input = $request->all();
            unset($input['token']);
            // Manage image and docs
            if($request->hasFile('image'))
            {
                $file = $request->file('image');
                $originalname = uniqid().$file->getClientOriginalName();
                $filepath1 = 'uploads/images/'.$originalname;
                $path = $file->storeAs('public/', $filepath1);
                $input['image'] = $filepath1;

            }

            if($request->hasFile('document'))
            {
                $file = $request->file('document');
                $originalname = uniqid().$file->getClientOriginalName();
                $filepath2 = 'uploads/documents/'.$originalname;
                $path = $file->storeAs('public/', $filepath2);
                $input['document'] = $filepath2;
            }
            $input['user_id'] = Auth::user()->id;

            $buyer = Buyer::create($input);
            
            return redirect(url($this->active_dir.'/index'));
        
        } catch (Exception $e) {
            return back();
        } 
    }

    public function create()
    {
        $products =  MasterProduct::all();
        return view($this->active_dir.'.create',[
            'active_dir' => $this->active_dir,
            'products' => $products,
        ]);
    }


    public function edit($id)
    {
        $data = Buyer::with('product')->find($id);
        
        $products =  MasterProduct::all();
        return view($this->active_dir.'.edit',[
            'active_dir' => $this->active_dir,
            'products' => $products,
            'data' => $data,
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            //code...
            $buyer = Buyer::findOrFail($id);
            $input = $request->all();

            unset($input['token']);
            // Manage image and docs
            if($request->hasFile('image'))
            {
                $file = $request->file('image');
                $originalname = uniqid().$file->getClientOriginalName();
                $filepath1 = $buyer->image;
                $path = $file->storeAs('public/', $filepath1);
                $input['image'] = $filepath1;

            }

            if($request->hasFile('document'))
            {
                $file = $request->file('document');
                $originalname = uniqid().$file->getClientOriginalName();
                $filepath2 = $buyer->document;
                $path = $file->storeAs('public/', $filepath2);
                $input['document'] = $filepath2;
            }

            $buyer->update($input);
            return back();
        } catch (Exception $e) {
            return back();
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            //code...
            $buyer = Buyer::findOrFail($id);
            $buyer->delete();
            return back();
        } catch (Exception $e) {
            return back();
        }
    }
}
