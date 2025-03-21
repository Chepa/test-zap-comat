<?php

namespace App\Jobs;

use App\Models\RecommendedProduct;
use App\Services\RecommendedProductService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SaveRecommendedProductJob implements ShouldQueue
{
    use Queueable;

    public function __construct(protected Collection $products)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(RecommendedProductService $service): void
    {
        foreach ($this->products as $product) {
            $products = $service->recommendedProducts($product);

            DB::table(RecommendedProduct::getModel()->getTable())
                ->upsert($products, ['product_id', 'recommended_product_id']);
        }
    }
}
