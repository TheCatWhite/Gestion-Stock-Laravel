<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/products', ProductController::class);
Route::resource('categories', CategoryController::class);
Route::resource('suppliers', SupplierController::class);
Route::resource('orders', OrderController::class);
Route::resource('order-items', OrderItemController::class);