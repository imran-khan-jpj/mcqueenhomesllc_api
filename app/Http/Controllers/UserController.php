<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserController extends Controller
{
    public function index(){
        
        return response()->json(['status' => 'success', 'data' => User::all()], 200);
        // return "we are here always";
    }

    public function register(Request $request){
        $data = $request->validate([
            'name'     => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:12'
        ]);

        $data['password'] = Hash::make('password');
   

        if($user = User::create($data)){
            return response()->json(['status' => 'success', 'data' => $user, 'msg' => 'user created successfull.'], 200);
        }else{
            return response()->json(['status' => 'error', 'data' => "", 'msg' => 'Something went wrong please try again'], 401);

        }      
    }

    public function updateUser(Request $request){
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.auth()->user()->id,
            'password' => 'required|min:6|max:12'
        ]);

        if($user->update($data)){

            return response()->json(['status' => 'success', 'msg' => 'User updated successfully'], 200);
        }
    }

    public function userDetail(){
        return response()->json(['status' => 'success', 'data' => auth()->user()], 200);
    }
}
