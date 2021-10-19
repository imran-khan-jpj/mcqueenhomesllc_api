<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\Helpers;
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
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response(['status' => 'error', 'msg' => 'Invalid Credentials', 'data' => ""]);
        }
    
            return response([   
                'status' => 'success',
                'msg' => 'logged in successfully',
                'data' => [
                        'authentication-token' => $user->createToken('authentication-token')->plainTextToken
                        ]
                    ]);
       
    }

    public function logout(){
        
        if(auth()->user()->tokens()->delete()){
            return response()->json(['status' => 'success', 'msg' => 'Logged Out'], 200);

        }
    }
}
