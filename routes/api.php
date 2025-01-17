<?php

use App\Http\Controllers\DespesasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EnderecoController;
use App\Http\Controllers\ReceitasController;
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
    Route::get('search','search');
});

Route::controller(EnderecoController::class)->group(function () {
    Route::get('enderecoIndex','enderecoIndex');
    Route::post('storeEndereco','storeEndereco'); 
    Route::delete('enderecoDestroy/{id}','enderecoDestroy');

});

/*
Route::get('/users/login', [UserController::class, 'login'])->name('users.login');
//Route::middleware('api')->group(function () {
    //Users.
    Route::post('/users/register', [UserController::class, 'register'])->name('users.register');
    Route::get('/users/index', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/show/{id}', [UserController::class, 'show'])->name('users.show');
    Route::put('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    //Receitas.
    Route::get('/receitas/index', [ReceitasController::class, 'index']);
    Route::post('/receitas/store', [ReceitasController::class, 'store']);
    Route::get('/receitas/show/{id}', [ReceitasController::class, 'show'])->name('receitas.show');
    Route::put('/receitas/update/{id}', [ReceitasController::class, 'update'])->name('receitas.update');
    Route::delete('/receitas/destroy/{id}', [ReceitasController::class, 'destroy'])->name('receitas.destroy');

    // Despesas .
    Route::get('/despesas/index', [DespesasController::class, 'index']);
    Route::get('/despesas/store', [DespesasController::class, 'store']);
    Route::get('/despesas/show/{id}', [DespesasController::class, 'show'])->name('despesas.show');
    Route::put('/despesas/update/{id}', [DespesasController::class, 'update'])->name('despesas.update');
    Route::delete('/despesas/destroy/{id}', [DespesasController::class, 'destroy'])->name('despesas.destroy');
   
   
    Route::controller(EnderecoController::class)->group(function () {
        Route::get('enderecoIndex','enderecoIndex');
        Route::post('storeEndereco','storeEndereco'); 
        Route::delete('enderecoDestroy/{id}','enderecoDestroy');
    
    });
//});
*/