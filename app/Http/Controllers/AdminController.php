<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\MasterProduct;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    //
    private $active_dir = "admin";

    public function index()
    {
        $data =  Admin::with('product')->get();
        return view($this->active_dir.'.index',[
            'data' => $data,
            'active_dir' => $this->active_dir,
        ]);
    }


    public function index_ajax(Request $request)
    {

        if ($request->ajax()) {
            $data = Admin::with('product')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    // $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    $editUrl = route("$this->active_dir.edit", $row->id);
                    $deleteUrl = route("$this->active_dir.delete", $row->id);
                    $actionBtn = '<a role="button" class="btn btn-info" href="'.$editUrl.'">Edit</a> <a role="button" class="btn btn-danger" href="'.$deleteUrl.'">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

    }


    public function user_list()
    {
        $users = User::all();
        $roles = Role::all();
        return view($this->active_dir.'.index-user',[
            'active_dir' => $this->active_dir,
            'users' => $users,
            'roles' => $roles
        ]);
    }

    
    public function update_user_role(Request $request, $id)
    {
        try {
            //code...
            $user = User::findOrFail($id);
            $input = $request->all();
            unset($input['token']);
            $user->update($input);
            return redirect()->back();
        } catch (Exception $e) {
            dd($e);
            return back();
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

            $admin = Admin::create($input);
            
            return redirect(url($this->active_dir.'/index'));
        
        } catch (Exception $e) {
            dd($e);
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
        $data = Admin::with('product')->find($id);
        
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
            $admin = Admin::findOrFail($id);
            $input = $request->all();

            unset($input['token']);
            // Manage image and docs
            if($request->hasFile('image'))
            {
                $file = $request->file('image');
                $originalname = uniqid().$file->getClientOriginalName();
                $filepath1 = $admin->image;
                $path = $file->storeAs('public/', $filepath1);
                $input['image'] = $filepath1;

            }

            if($request->hasFile('document'))
            {
                $file = $request->file('document');
                $originalname = uniqid().$file->getClientOriginalName();
                $filepath2 = $admin->document;
                $path = $file->storeAs('public/', $filepath2);
                $input['document'] = $filepath2;
            }

            $admin->update($input);
            return back();
        } catch (Exception $e) {
            return back();
        }
    }


    public function delete(Request $request, $id)
    {
        try {
            //code...
            $admin = Admin::findOrFail($id);
            $admin->delete();
            return back();
        } catch (Exception $e) {
            return back();
        }
    }


}
