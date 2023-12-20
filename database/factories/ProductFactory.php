<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=>$this->faker->word(),
            'description'=>$this->faker->text(),
            'price'=>mt_rand(10000,999999),
            'stock'=>mt_rand(0,100),
            'category_id'=>mt_rand(1,20),
            'subcategory_id'=>mt_rand(1,20),
            'condition_id'=>mt_rand(1,2),
            'store_id'=>1,
        ];
    }
}
