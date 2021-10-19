<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Helpers;

use App\Models\User;

class UserController extends Controller
{
    
    public function index(){
        if(auth()->user()->role == 'admin'){
            return Helpers::response('success', User::all(), 'users found successfully', 200);
        }else{
            return Helpers::response('error', "Unauthorized", "", 403);
        }
    }

    public function register(Request $request){
        $data = $request->validate([
            'name'     => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:12'
        ]);

        $data['password'] = Hash::make('password');
   

        if($user = User::create($data)){
           
            return Helpers::response('success', 'user created successfully. please login to continues', $user, 200);
        }else{
            
            return Helpers::response('success', 'Something went wrong', "", 401);

        }      
    }

    public function show(){
        return auth()->user();
    }

    public function updateUser(Request $request){
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.auth()->user()->id,
            'password' => 'required|min:6|max:12'
        ]);

        if($user->update($data)){

            return Helpers::response('success', 'User Updated Successfully', 200);
        }
    }

    public function userDetail(){
        return Helpers::response('success', "", auth()->user(), 200);
    }
}
