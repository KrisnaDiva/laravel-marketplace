<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;


use App\Models\Store;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        $this->call([
            ProvinceSeeder::class,
            CitySeeder::class,
            UserSeeder::class,
            UserAddressSeeder::class,
            StoreSeeder::class,
            StoreAddressSeeder::class,
            CategorySeeder::class,
            ProductConditionSeeder::class,
            ProductSeeder::class,
            CartSeeder::class,
            CartItemSeeder::class,
            OrderSeeder::class
        ]);
    }
}
