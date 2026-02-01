<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;

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


Route::get('/', [ProductsController::class, 'index']);

Route::get('/products', [ProductsController::class, 'index'])->name('products.index');

Route::get('/products/register', [ProductsController::class, 'create'])->name('products.create');

Route::post('/products/store', [ProductsController::class, 'store'])->name('products.store');

Route::get('/products/detail/{productId}', [ProductsController::class, 'detail'])->name('products.detail');

Route::patch('/products/update/{productId}', [ProductsController::class, 'update'])->name('products.update');

Route::delete('/products/destroy/{productId}', [ProductsController::class, 'destroy'])->name('products.destroy');