<?php

namespace App\Observers;

use App\Models\Product;
use App\Services\RecommendedProductService;

readonly class ProductObserver
{
    public function __construct(private RecommendedProductService $recommendationProductService)
    {
    }

    public function created(Product $product): void
    {
        $this->recommendationProductService->generate($product->id);
    }
}
