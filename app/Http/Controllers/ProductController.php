<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Список товаров с пагинацией по 100.
     */
    public function index()
    {
        $products = Product::paginate(100);

        return view('products.index', compact('products'));
    }

    /**
     * Страница конкретного товара.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}
