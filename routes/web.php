<?php

use App\Http\Controllers\Website\CustomerController;
use App\Http\Controllers\Website\DashboardController;
use App\Http\Controllers\Website\MerchantController;
use App\Http\Controllers\Website\ServiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('dashboard', [DashboardController::class, 'index']);

Route::prefix('customer')->group(function(){
    Route::get('/',[CustomerController::class, 'index'])->name('customer');
    Route::get('/data',[CustomerController::class, 'data'])->name('customer.data');
});

Route::prefix('merchant')->group(function(){
    Route::get('/',[MerchantController::class, 'index'])->name('merchant');
    Route::get('/data',[MerchantController::class, 'data'])->name('merchant.data');
    Route::get('/add', [MerchantController::class, 'add'])->name('merchant.add');
    Route::post('/store', [MerchantController::class, 'store'])->name('merchant.store');
    Route::get('/view/{merchant}', [MerchantController::class, 'view'])->name('merchant.view');
    Route::get('/data/order', [MerchantController::class, 'data_order'])->name('merchant.data_order');
});

Route::prefix('service')->group(function(){
    Route::get('/',[ServiceController::class, 'index'])->name('service');
    Route::get('/data',[ServiceController::class, 'data'])->name('service.data');
    Route::get('/add', [ServiceController::class, 'add'])->name('service.add');
    Route::post('/store', [ServiceController::class, 'store'])->name('service.store');
});