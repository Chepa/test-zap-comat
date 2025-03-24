<?php

namespace App\Services;

use App\Jobs\SaveRecommendedProductJob;
use App\Models\Product;
use App\Models\RecommendedProduct;
use Illuminate\Database\Eloquent\Builder as Eloquent;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RecommendedProductService
{
    const CHUNK_COUNT = 10;

    /**
     * Start processing of saving recommendations
     * @param $productId
     * @return void
     */
    public function generate($productId = null): void
    {
        Product::select(['id', 'name'])
            ->when(
                !$productId,
                fn(Eloquent $query) => $query->whereDoesntHave('recommended'),
                fn(Eloquent $query) => $query->where('id', $productId)
            )->chunkById(self::CHUNK_COUNT, function (Collection $chunk) {
                SaveRecommendedProductJob::dispatch($chunk)->delay(5);
            });
    }

    /**
     * Generate recommended products
     * @param Product $product
     * @return array
     */
    public function recommendedProducts(Product $product): array
    {
        $productPartName = explode(' ', $product->name);
        $sql = 'select *, ';
        $parts = $productPartName;
        foreach ($productPartName as $key => $part) {
            $sql .= 'IF((`name` like "%' . implode('%" and `name` like "%', $parts) . '%"), ' . count($parts)
                . ', ';
            unset($parts[$key]);
        }
        $sql .= '0' . str_repeat(')', count($productPartName)) . ' as matches';
        $sql .= ' from products';
        $sql .= ' where id != ' . $product->id . ' having matches != 0';
        $sql .= ' ORDER BY matches * frequency * ROUND((RAND() * (2-1))+1) DESC';
        $sql .= ' LIMIT 20';

        return array_map(fn($object) => [
            'product_id' => $product->id,
            'recommended_product_id' => $object->id
        ], DB::select($sql));
    }

    public function linkedCount(
        $productId
    ): int {
        return DB::table(RecommendedProduct::getModel()->getTable())
            ->where(
                'recommended_product_id',
                $productId
            )->count();
    }
}
