<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 20; $i++) {
            DB::table('subcategories')->insert([
                'name' => $faker->word,
                'category_id'=>mt_rand(1,20),
                'created_at'=>now(),
                'updated_at'=>now()
            ]);
        }
    }
}
