<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'name' => 'krisna',
            'email' => 'krisnadiva04@gmail.com',
            'phone_number'=>'089658444101',
            'email_verified_at'=>now(),
            'password'=>Hash::make('12345678'),
        ]);

        $this->call([
            CategorySeeder::class,
            ProductConditionSeeder::class
        ]);
        Store::factory(1)->create();
        Product::factory(20)->create();
    }
}
