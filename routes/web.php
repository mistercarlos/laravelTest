<?php

use Illuminate\Support\Facades\Artisan;
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

Route::get('/', function () {
    return view('index');//index
});

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/config-clear', function() {
    $exitCode = Artisan::call('config:clear');
    return "Done";
});
Route::get('/cache-clear', function() {
    $exitCode = Artisan::call('cache:clear');
    return "Done";
});
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return "Done";
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Will add role checker middleware
Route::group(['prefix' => 'admin', 'middleware' => ['check_role:Admin']], function(){
    Route::get('/index', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
    Route::get('/index/ajax', [App\Http\Controllers\AdminController::class, 'index_ajax'])->name('admin.index.ajax');
    Route::get('/create', [App\Http\Controllers\AdminController::class, 'create'])->name('admin.create');
    Route::post('/store', [App\Http\Controllers\AdminController::class, 'store'])->name('admin.store');
    Route::get('/edit/{id}', [App\Http\Controllers\AdminController::class, 'edit'])->name('admin.edit');
    Route::post('/update/{id}', [App\Http\Controllers\AdminController::class, 'update'])->name('admin.update');
    Route::get('/delete/{id}', [App\Http\Controllers\AdminController::class, 'delete'])->name('admin.delete');
    
    Route::get('/index/users', [App\Http\Controllers\AdminController::class, 'user_list'])->name('admin.user.list');
    Route::post('/update/role/{user}', [App\Http\Controllers\AdminController::class, 'update_user_role'])->name('admin.update.role');

});

Route::group(['prefix' => 'seller', 'middleware' => ['check_role:Seller'] ], function(){
    Route::get('/index', [App\Http\Controllers\SellerController::class, 'index'])->name('seller.index');
    Route::get('/index/ajax', [App\Http\Controllers\SellerController::class, 'index_ajax'])->name('seller.index.ajax');

    Route::get('/create', [App\Http\Controllers\SellerController::class, 'create'])->name('seller.create');
    Route::post('/store', [App\Http\Controllers\SellerController::class, 'store'])->name('seller.store');

    Route::get('/edit/{id}', [App\Http\Controllers\SellerController::class, 'edit'])->name('seller.edit');
    Route::post('/update/{id}', [App\Http\Controllers\SellerController::class, 'update'])->name('seller.update');
    Route::get('/delete/{id}', [App\Http\Controllers\SellerController::class, 'delete'])->name('seller.delete');
});

Route::group(['prefix' => 'buyer', 'middleware' => ['check_role:Buyer']], function(){
    Route::get('/index', [App\Http\Controllers\BuyerController::class, 'index'])->name('buyer.index');
    Route::get('/index/ajax', [App\Http\Controllers\BuyerController::class, 'index_ajax'])->name('buyer.index.ajax');

    Route::get('/create', [App\Http\Controllers\BuyerController::class, 'create'])->name('buyer.create');
    Route::post('/store', [App\Http\Controllers\BuyerController::class, 'store'])->name('buyer.store');

    Route::get('/edit/{id}', [App\Http\Controllers\BuyerController::class, 'edit'])->name('buyer.edit');
    Route::post('/update/{id}', [App\Http\Controllers\BuyerController::class, 'update'])->name('buyer.update');
    Route::get('/delete/{id}', [App\Http\Controllers\BuyerController::class, 'delete'])->name('buyer.delete');

});

