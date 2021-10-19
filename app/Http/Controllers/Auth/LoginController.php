<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
  

    public function login(Request $request){
        
        $data = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        if (Auth::attempt($data)) {
            return response()->json(['status' => 'success', 'msg' => 'logged in successfully'], 200);
        }
  
        return response()->json(['status' => 'error', 'msg' => 'Invalid Email or Password'], 401);
    }

    public function logout(){
        // return 'we are here';
        if(Auth::logout()){
            return response()->json(['status' => 'success', 'msg' => 'Logged Out'], 200);

        }
    }
}
