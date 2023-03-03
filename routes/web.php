<?php

use App\Http\Controllers\CreateCient;
use App\Http\Controllers\EditClient;
use App\Http\Controllers\Home;
use App\Http\Controllers\ProductInsert;
use App\Http\Controllers\User;
use App\Http\Controllers\Payments;
use App\Http\Middleware\CheckPermission;

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

// users route
Route::get('/', [Home::class, 'index'])->name('home');
Route::get('entrar', [Home::class, 'enterForm'])->name('login');
Route::post('entrar', [Home::class, 'userAccess']);

                ##3#########################################

// admin routes

// create clients
Route::get('create', [CreateCient::class, 'createClientForm'])
       ->middleware(CheckPermission::class)->name('create-client');
Route::post('create', [CreateCient::class, 'createClient'])
       ->middleware(CheckPermission::class);
/// create client end

                ###################################3###########

//// managing user1s purshases
Route::get('autenticado', [User::class, 'index'])->name('user-area')->middleware('auth');
Route::post('logout', [User::class, 'destroy']);

Route::get('user/{user:id}', [User::class, 'show'])
       ->name('single-client');
Route::get('/insertproducts/{user:id}', [User::class, 'create'])
        ->name('insertproducts');
Route::post('/insertproducts/{user:user_id}', [User::class, 'edit'])
       ->name('insertproducts-post');
Route::post('/finish-sale', [User::class, 'store'])
       ->name('finish-sale');
Route::post('/data', [User::class, 'purshaseDetail'])
       ->name('purshase-detail');
Route::post('/destroysale', [User::class, 'destroysale']);
Route::post('/destoydate', [User::class, 'destoydate']);

Route::get('/updatepassword', [EditClient::class, 'index'])
        ->middleware('auth')->name('update-password');
Route::post('newpassword', [EditClient::class, 'editClientPassword']);


##### rotas de pagamentos
Route::get('/pagamentos/{id}', [Payments::class, 'index']);
Route::post('/pagamentos', [Payments::class, 'create']);

///// managing products
Route::get('addproduct', [ProductInsert::class, 'index'])
       ->middleware(CheckPermission::class);
Route::post('addproduct', [ProductInsert::class, 'create']);
Route::get('checkstorage', [ProductInsert::class, 'show'])
       ->middleware(CheckPermission::class)->name('checkstorage');


       /////criar view para edição de produtos
Route::get('/editproduct/{product:product_id}', [ProductInsert::class, 'edit'])
      ->middleware(CheckPermission::class)->name('editproducts');
Route::get('product-detail/{product:product_id}', [ProductInsert::class, 'edit'])
       ->middleware('auth');
Route::get('product-delete/{product:product_id}', [ProductInsert::class, 'destroy'])
       ->middleware('auth');
