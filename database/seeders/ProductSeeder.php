<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Product;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        for($i=0;$i<50;$i++){
            $product=Product::create([
            'name'=>$faker->word(),
            'description'=>$faker->text(),
            'price'=>mt_rand(10000,999999),
            'stock'=>mt_rand(0,100),
            'category_id'=>mt_rand(1,20),
            'condition_id'=>mt_rand(1,2),
            'store_id'=>1,
            ]);
         
                $imagePath = $faker->image(storage_path('app/public/images/product-image'), 1, 1, null, false);  
                $image = Image::create(['url' => $imagePath]);
                $product->images()->attach($image->id);
                $product->images()->attach($image->id);
 
            
        }
    }
}
