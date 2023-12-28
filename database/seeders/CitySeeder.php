<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $response = Http::withHeaders([
            'key'=>'9f3bea8727a27ab30805a9c7f5c89739'
        ])->get('https://api.rajaongkir.com/starter/city');
        $content = json_decode($response,false);
        $cities=$content->rajaongkir->results;

        foreach($cities as $city){
            if($city->type=="Kabupaten"){
                $cityName="Kab. $city->city_name";
            }else{
                $cityName="Kota $city->city_name";
            }
            City::create([
                'id'=>$city->city_id,
                'name'=>$cityName,
                'province_id'=>$city->province_id
            ]);
        }
    }
}
