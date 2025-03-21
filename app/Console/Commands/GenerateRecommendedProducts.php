<?php

namespace App\Console\Commands;

use App\Models\RecommendedProduct;
use App\Services\RecommendedProductService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateRecommendedProducts extends Command
{
    protected $signature = 'app:generate-recommended-products {--fresh}';
    protected $description = 'Generate recommended products';

    public function handle(RecommendedProductService $service): void
    {
        if ($this->option('fresh')) {
            DB::table(RecommendedProduct::getModel()->getTable())->truncate();
        }

        $service->generate();
    }
}
