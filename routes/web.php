<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('main');
})->name('main');

Route::get('/catalog', [ProductController::class, 'index'])->name('products.index');;

// Страница конкретного товара
Route::get('/catalog/{product}', [ProductController::class, 'show'])->where('product', '[1-90]+')->name('products.show');
