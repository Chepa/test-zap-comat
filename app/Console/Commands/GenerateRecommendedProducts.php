<?php

namespace App\Console\Commands;

use App\Models\RecommendedProduct;
use App\Services\RecommendedProductService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateRecommendedProducts extends Command
{
    protected $signature = 'app:generate-recommended-products {--fresh} {--product=}';
    protected $description = 'Generate recommended products';

    public function handle(RecommendedProductService $service): void
    {
        if ($this->option('fresh')) {
            DB::table(RecommendedProduct::getModel()->getTable())->truncate();
        }

        $id = $this->option('product');
        if ($id) {
            DB::table(RecommendedProduct::getModel()->getTable())
                ->where('product_id', $id)
                ->delete();
        }

        $service->generate((int) $id);
    }
}
