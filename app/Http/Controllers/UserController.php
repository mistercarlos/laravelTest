<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $roles = Role::all();
        return view('',[
            'users' => $users,
            'roles' => $roles
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            //code...
            $user = User::findOrFail($id);
            $input = $request->all();
            $user->update($input);
            $success['user'] =  $user;
            return back();
        } catch (Exception $e) {
            return back();
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            //code...
            $user = User::findOrFail($id);
            $user->delete();
            $success=  [];
            return back();
        } catch (Exception $e) {
            // return  sendError('Server Error.', $e->getMessage());  
            return back();
        }
    }


    

}
