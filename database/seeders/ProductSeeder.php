<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $clothes = ['Кофта', 'Туника', 'Куртка', 'Пижама', 'Шуба', 'Рубашка', 'Толстовка', 'Майка', 'Футболка', 'Кепка', 'Панамка', 'Косынка', 'Шапка'];
        $gender  = ['мужская', 'женская', 'унисекс'];
        $colors  = ['красная', 'желтая', 'синяя', 'белая', 'черная', 'серая', 'коричневая', 'оранжевая', 'фиолетовая', 'розовая', 'голубая'];
        $sizes   = ['XXXS', 'XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'];

        $products = [];

        for ($i = 0; $i < 10000; $i++) {
            // Случайный выбор каждого компонента названия
            $randomName = sprintf(
                '%s %s %s %s',
                $clothes[array_rand($clothes)],
                $gender[array_rand($gender)],
                $colors[array_rand($colors)],
                $sizes[array_rand($sizes)]
            );

            // Генерация частотности со смещённым распределением
            // чем меньше значение, тем выше вероятность
            $randFloat = mt_rand() / mt_getrandmax();
            $frequency = (int) floor(1000 * pow($randFloat, 5));
            //                                      ^ здесь pow($randFloat, 5) сдвигает распределение к нулю

            $products[] = [
                'name'      => $randomName,
                'frequency' => $frequency,
            ];
        }

        // Можно делать вставку пакетно ради оптимизации
        // либо по одному – как вам удобнее
        DB::table('products')->insert($products);
    }
}
