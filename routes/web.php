<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Front\LandingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/check-dashboard-updates', [DashboardController::class, 'checkDashboardUpdates'])->name('check-dashboard-updates');
    Route::resource('products', ProductController::class);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::put('/orders/{id}', [OrderController::class, 'complete'])->name('orders.complete');
    Route::post('/check-new-orders', [OrderController::class, 'checkNewOrders'])->name('check-new-orders');
});

Route::get('/login', [AuthController::class, 'loginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::middleware(['guest'])->group(function () {
    Route::get('/', [LandingController::class, 'index'])->name('home');
    Route::post('/order', [LandingController::class, 'createOrder'])->name('order.store');
    // Route::get('/drink', [LandingController::class, 'drink'])->name('drink');
});
