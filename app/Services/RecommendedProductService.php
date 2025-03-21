<?php

namespace App\Services;

use App\Jobs\SaveRecommendedProductJob;
use App\Models\Product;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder as Eloquent;

class RecommendedProductService
{
    const PRODUCT_LIMIT = 20;
    const CHUNK_COUNT = 100;

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
                SaveRecommendedProductJob::dispatch($chunk);
            });
    }

    /**
     * Generate recommended products
     * @param Product $product
     * @return array
     */
    public function recommendedProducts(Product $product): array
    {
        $nameParts = explode(' ', $product->name);
        $category = $nameParts[0] ?? '';
        $gender = $nameParts[1] ?? '';
        $size = $nameParts[count($nameParts) - 1];

        return DB::table(Product::getModel()->getTable())
            ->select(['id'])
            ->where(function (Builder $query) use ($nameParts, $category, $gender, $size) {
                if ($category && $gender && $size) {
                    $query->where('name', 'like', "%$category%")
                        ->where('name', 'like', "%$gender%")
                        ->where('name', 'like', "% $size%");
                } elseif ($gender && $size) {
                    $query->where('name', 'like', "%$gender%")
                        ->where('name', 'like', "% $size%");
                } else {
                    $query->where('name', 'like', "%$nameParts[0]%");
                }
            })
            ->where('id', '!=', $product->id)
            ->orderBy('frequency', 'desc')
            ->limit(self::PRODUCT_LIMIT)
            ->get()
            ->pluck('id')
            ->map(fn(int $id) => [
                'product_id' => $product->id,
                'recommended_product_id' => $id,
            ])
            ->toArray();
    }
}
