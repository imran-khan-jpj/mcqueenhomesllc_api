<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PropertyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// return "we are web.php";

//tested apis
Route::post("login", [LoginController::class, 'login']);
Route::post("logout", [LoginController::class, 'logout']);
// Authenticated Routes
// Admin Routes
Route::get('users', [UserController::class, 'index']);
Route::delete('user/{user}', [UserController::class, "destroy"]);

// //User Routes
Route::post("register", [UserController::class, 'register']);

// //Property Routes
Route::get('/property', [PropertyController::class, 'index']);
Route::get('/property/{property}', [PropertyController::class, 'show']);
Route::post('/property/store', [PropertyController::class, 'store']);
Route::post('/property/update/{property}', [PropertyController::class, 'update']);
Route::delete('/property/delete/{property}', [PropertyController::class, 'destroy']);
Route::delete('/property/{property}/image/delete/{image}', [PropertyController::class, 'imageDelete']);





Route::get('/csrf', function(){
    return csrf_token();
});
