<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        DB::connection()->disableQueryLog();

        $clothes = ['Кофта', 'Туника', 'Куртка', 'Пижама', 'Шуба', 'Рубашка', 'Толстовка', 'Майка', 'Футболка', 'Кепка', 'Панамка', 'Косынка', 'Шапка'];
        $gender  = ['мужская', 'женская', 'унисекс'];
        $colors  = ['красная', 'желтая', 'синяя', 'белая', 'черная', 'серая', 'коричневая', 'оранжевая', 'фиолетовая', 'розовая', 'голубая'];
        $sizes   = ['XXXS', 'XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'];

        $now = now()->toDateTimeString();
        echo "Начальное потребление: " . memory_get_usage() . " bytes\n";

        $batchSize = 500;

        for ($z = 0; $z < 1; $z++) {
            echo "Цикл ".$z.": " . memory_get_usage() . " bytes\n";
            $products = [];

            for ($i = 0; $i < 10000; $i++) {
                $randomName = sprintf(
                    '%s %s %s %s',
                    $clothes[array_rand($clothes)],
                    $gender[array_rand($gender)],
                    $colors[array_rand($colors)],
                    $sizes[array_rand($sizes)]
                );

                $randFloat = mt_rand() / mt_getrandmax();
                $frequency = (int) floor(1000 * pow($randFloat, 5));

                $products[] = [
                    $randomName,
                    $frequency,
                    $now,
                ];

                if (count($products) >= $batchSize) {
                    $this->bulkInsert($products);
                    $products = [];
                }
            }

            if (!empty($products)) {
                $this->bulkInsert($products);
            }

            unset($products);
            gc_collect_cycles();
        }
    }

    private function bulkInsert(array $batch)
    {
        $placeholders = rtrim(str_repeat('(?, ?, ?),', count($batch)), ',');
        $flatValues = [];
        foreach ($batch as $row) {
            $flatValues = array_merge($flatValues, $row);
        }

        DB::insert("INSERT INTO products (name, frequency, created_at) VALUES $placeholders", $flatValues);
    }
}
