<?php

namespace Database\Seeders;

use App\Models\Review;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        Review::create([
            'comment'=>$faker->text(),
            'detail_id'=>1,
            'rating_id'=>5
        ]);
        Review::create([
            'comment'=>$faker->text(),
            'detail_id'=>2,
            'rating_id'=>4
        ]);
    }
}
