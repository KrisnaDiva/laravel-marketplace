<?php

namespace Database\Seeders;

use App\Models\UserAddress;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $city = [15, 52, 70, 110, 112, 137, 146, 173, 217, 218, 219, 229, 268, 278, 307, 308, 309, 310, 319, 320, 323, 325, 353, 389, 404, 407, 413, 459, 463, 464, 465, 470, 481];

        for ($i = 0; $i < 10; $i++) {
            $randomIndex = mt_rand(0, count($city) - 1);
            $randomCityId = $city[$randomIndex];
            $faker = Factory::create();
            UserAddress::create([
                'full_name' => $faker->name(),
                'phone_number' => '08' . mt_rand(1111111111, 9999999999),
                'province_id' => 34,
                'city_id' => $randomCityId,
                'district' => $faker->word(),
                'zip' => mt_rand(11111, 33333),
                'street' => $faker->address(),
                'others' => $faker->text(),
                'isMain' => false,
                'user_id' => 1
            ]);
        }
    }
}
