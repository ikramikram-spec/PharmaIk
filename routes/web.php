<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//login
Route::get('/', function () {
    return redirect() -> route('auth.login');
});
Route::get('/login', [AuthController::class, 'showlogin']) -> name('auth.login');
Route::post('/login', [AuthController::class, 'login']) -> name('auth.login.submit');
Route::post('/logout', [AuthController::class, 'logout']) -> name('logout');

Route::middleware('auth') -> group(function() {
    Route::get('/Dashboard', [DashboardController::class, 'index']) -> name('Dashboard.index');
    Route::get('/Settings', [SettingsController::class, 'index']) -> name('settings.index');

    Route::resource('Categories', CategoryController::class);
    Route::resource('Clients', ClientController::class);
    Route::resource('Products', ProductController::class);
    Route::resource('Purchases', PurchaseController::class);
    Route::resource('Returns', ReturnController::class);
    Route::resource('Sales', SaleController::class);
    Route::resource('Stock', StockController::class);
    Route::resource('Suppliers', SupplierController::class);
    Route::resource('Users', UserController::class);
});