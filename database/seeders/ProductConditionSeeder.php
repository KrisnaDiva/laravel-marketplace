<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_conditions')->insert([
            [
                'name' => 'Baru',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'name' => 'Bekas',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            // Add more arrays for additional records
        ]);
    }
}
