<?php

use App\Models\RecommendedProduct;
use Illuminate\Support\Facades\Cache;

if (!function_exists('getLinkedProductsCount')) {
    function getLinkedProductsCount(int $productId)
    {
        $count = Cache::get("inked_products_count.$productId");

        if (!$count) {
            $count = RecommendedProduct::where('product_id', $productId)->count();
            Cache::rememberForever("inked_products_count.$productId", fn () => $count);
        }

        return $count;
    }
}
