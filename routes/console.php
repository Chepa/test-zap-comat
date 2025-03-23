<?php

use App\Console\Commands\GenerateRecommendedProducts;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
    Schedule::call(GenerateRecommendedProducts::class, ['--fresh'])->daily();
})->purpose('Display an inspiring quote')->hourly();
