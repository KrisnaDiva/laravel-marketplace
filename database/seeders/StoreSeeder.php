<?php

namespace Database\Seeders;

use App\Models\Store;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        Store::create([
            'name' => $faker->word(),
            'description' => $faker->text(),
            'user_id' => 1
        ]);
    }
}
