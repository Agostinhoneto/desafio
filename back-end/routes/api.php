<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\EnderecoController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(UserController::class)->group(function () {
    Route::get('index','index');
    Route::get('show/{id}','show');
    Route::post('store','store'); 
    Route::put('update/{id}','update');  
    Route::delete('destroy/{id}','destroy');
  //  Route::get('search/{request}','search');
    Route::get('/search', function (Request $request) {
        return User::search($request->input('query'))->paginate(10);
    });
});


Route::controller(EnderecoController::class)->group(function () {
    Route::get('enderecoIndex','enderecoIndex');
    Route::delete('enderecoDestroy/{id}','enderecoDestroy');

});

