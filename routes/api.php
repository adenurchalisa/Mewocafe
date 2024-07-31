<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\Public\PublicController;

Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/dashboard/sales-overview', [DashboardController::class, 'salesOverview'])->middleware('auth:sanctum');
Route::get('/dashboard/daily-sales', [DashboardController::class, 'dailySales'])->middleware('auth:sanctum');

Route::apiResource('products', ProductController::class)->middleware('auth:sanctum');
Route::apiResource('categories', CategoryController::class)->middleware('auth:sanctum');
Route::get('/orders', [OrderController::class, 'index'])->middleware('auth:sanctum');
Route::put('/orders/{id}', [OrderController::class, 'completeOrder'])->middleware('auth:sanctum');

Route::get('/public/product-count', [PublicController::class, 'productCount']);
Route::get('/public/food', [PublicController::class, 'food']);
Route::get('/public/drink', [PublicController::class, 'drink']);
Route::post('/public/order', [PublicController::class, 'createOrder']);