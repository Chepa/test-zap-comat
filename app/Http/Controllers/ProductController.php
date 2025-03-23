<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\RecommendedProductService;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    public function __construct(private readonly RecommendedProductService $service)
    {
    }

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
        $linkedCount = $this->service->linkedCount($product->id);
        $recommended = $product->recommended->sortByDesc(function ($recommended) {
            return $recommended->product->frequency;
        });

        return view('products.show', compact('product', 'recommended', 'linkedCount'));
    }
}
