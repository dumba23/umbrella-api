<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
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

Route::get('products', [ProductController::class, 'index'])->name('index_products');
Route::get('products/{product}', [ProductController::class, 'show'])->name('show_products');
Route::post('products', [ProductController::class, 'store'])->name('store_products');
Route::put('products/{product}', [ProductController::class, 'update'])->name('update_products');
Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('destroy_products');

Route::get('categories', [CategoryController::class, 'index'])->name('index_categories');
Route::post('categories', [CategoryController::class, 'store'])->name('store_categories');
