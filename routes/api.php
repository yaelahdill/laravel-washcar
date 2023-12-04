<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\VehicleController;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/merchants', [MerchantController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/notification', [DashboardController::class, 'notification']);

    Route::prefix('vehicle')->group(function(){
        Route::get('/list', [VehicleController::class, 'index']);
        Route::post('/add', [VehicleController::class, 'store']);
        Route::post('/delete', [VehicleController::class, 'destroy']);
    });

    Route::prefix('account')->group(function(){
        Route::post('/edit-profile', [AccountController::class, 'editProfile']);
        Route::post('/change-password', [AccountController::class, 'changePassword']);
    });

    Route::prefix('order')->group(function(){
        Route::get('/list', [OrderController::class, 'index']);
        Route::post('/get-services', [OrderController::class, 'get_services']);
        Route::post('/create', [OrderController::class, 'store']);
        Route::post('/detail', [OrderController::class, 'detail']);
    });
});
