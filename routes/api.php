<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PropertyController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Un authenticated routes;
Route::post("login", [LoginController::class, 'login']);
Route::post("register", [UserController::class, 'register']);
Route::get('/property', [PropertyController::class, 'index']);
Route::get('/property/{property}', [PropertyController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    // dd('we are here');
    //tested apis
    Route::post("logout", [LoginController::class, 'logout']);
    // Authenticated Routes
    // Admin Routes
    Route::get('users', [UserController::class, 'index']);
    Route::get('user', [UserController::class, 'show']);
    Route::delete('user/{user}', [UserController::class, "destroy"]);

    // //User Routes

    // //Property Routes
    Route::post('/property/store', [PropertyController::class, 'store']);
    Route::post('/property/update/{property}', [PropertyController::class, 'update']);
    Route::delete('/property/delete/{property}', [PropertyController::class, 'destroy']);
    Route::delete('/property/{property}/image/delete/{image}', [PropertyController::class, 'imageDelete']);


});



// axios.defaults.withCredentials = true;
