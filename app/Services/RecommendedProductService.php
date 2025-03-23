<?php

namespace App\Services;

use App\Jobs\SaveRecommendedProductJob;
use App\Models\Product;
use App\Models\RecommendedProduct;
use Illuminate\Database\Eloquent\Builder as Eloquent;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RecommendedProductService
{
    const PRODUCT_LIMIT = 20;
    const CHUNK_COUNT = 100;

    private array $genders = [
        'мужская',
        'женская',
        'унисекс'
    ];

    private array $sizes = [
        'XXXS',
        'XXS',
        'XS',
        'S',
        'M',
        'L',
        'XL',
        'XXL',
        'XXXL',
        'XXXXL'
    ];

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
        $productGender = array_values(
            array_filter($this->genders, fn($gender) => str_contains($product->name, $gender))
        )[0];
        $size = array_values(
            array_filter($this->sizes, fn($size) => str_contains($product->name, $size))
        )[0];

        $subQuery = DB::table(Product::getModel()->getTable())
            ->select(['id'])
            ->where(function (Builder $query) use ($product, $productGender, $size) {
                $query->where(fn() => $query
                    ->where('name', 'like', "%$productGender%")
                    ->where('name', 'like', "% $size%"))
                    ->whereNot('id', $product->id);
            })
            ->orderBy('frequency', 'desc');

        return DB::query()->fromSub($subQuery, 't')
            ->orderBy(DB::raw('RAND()'))
            ->limit(self::PRODUCT_LIMIT)
            ->get()
            ->pluck('id')
            ->map(fn(int $id) => [
                'product_id' => $product->id,
                'recommended_product_id' => $id,
            ])
            ->toArray();
    }

    public function linkedCount($productId): int
    {
        return DB::table(RecommendedProduct::getModel()->getTable())
            ->where(
                'recommended_product_id',
                $productId
            )->count();
    }
}
