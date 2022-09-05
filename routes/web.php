<?php

use App\Http\Controllers\CreateCient;
use App\Http\Controllers\Home;
use App\Models\Edit_client;
use Illuminate\Support\Facades\Route;

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

// Rotas para usuários comuns

Route::get('/', [Home::class, 'index'])->name('home');
Route::get('entrar', [Home::class, 'enterForm'])->middleware('guest')->name('login-form');
Route::post('entrar', [Home::class, 'userAccess']);
Route::post('logout', [Home::class, 'logout']);

Route::get('user/{user:name}', [Home::class, 'showClientDetail'])->name('single-client');


Route::get('create', [CreateCient::class, 'createClientForm']);
Route::post('create', [CreateCient::class, 'createClient']);


Route::get('entrar/update', [Edit_client::class, 'seeClientDetail']);
Route::post('entrar/update', [Edit_client::class, 'editClientDetail']);

