<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    /**
     * Список товаров с пагинацией по 100.
     */
    public function index(): View
    {
        $products = Product::paginate(100);

        return view('products.index', compact('products'));
    }

    /**
     * Страница конкретного товара.
     */
    public function show(Product $product): View
    {
        $product->load('recommended.product');
        $linkedProducts = getLinkedProductsCount($product->id);

        return view('products.show', compact('product','linkedProducts'));
    }
}
