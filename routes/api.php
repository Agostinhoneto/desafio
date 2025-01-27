<?php

use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\DespesasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EnderecoController;
use App\Http\Controllers\FinancasController;
use App\Http\Controllers\ReceitasController;
use App\Models\Categorias;
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


Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

Route::controller(UserController::class)->group(function () {
    Route::get('index', 'index');
    Route::get('show/{id}', 'show');
    Route::post('store', 'store');
    Route::put('update/{id}', 'update');
    Route::delete('destroy/{id}', 'destroy');
    Route::get('search', 'search');
});

Route::controller(ReceitasController::class)->group(function () {
    Route::get('indexReceitas', 'indexReceitas');
    Route::get('showReceita/{id}', 'showReceita'); 
    Route::post('storeReceitas', 'storeReceitas');
    Route::put('updateReceita/{id}', 'updateReceita'); 
    Route::delete('ReceitasDestroy/{id}', 'ReceitasDestroy');
});

Route::controller(DespesasController::class)->group(function () {
    Route::get('indexDespesas', 'indexDespesas');
    Route::post('storeDespesas', 'storeDespesas');
    Route::delete('DespesasDestroy/{id}', 'DespesasDestroy');
});

Route::controller(CategoriasController::class)->group(function () {
    Route::get('indexCategorias', 'indexCategorias');
    Route::post('storeCategorias', 'storeCategorias');
    Route::delete('CategoriasDestroy/{id}', 'CategoriasDestroy');
});

Route::controller(FinancasController::class)->group(function () {
    Route::get('indexFinancas', 'indexFinancas');
    Route::post('storeCategorias', 'storeCategorias');
    Route::delete('CategoriasDestroy/{id}', 'CategoriasDestroy');
});

Route::controller(EnderecoController::class)->group(function () {
    Route::get('enderecoIndex', 'enderecoIndex');
    Route::post('storeEndereco', 'storeEndereco');
    Route::delete('enderecoDestroy/{id}', 'enderecoDestroy');
});




