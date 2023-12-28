<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $response = Http::withHeaders([
            'key'=>'9f3bea8727a27ab30805a9c7f5c89739'
        ])->get('https://api.rajaongkir.com/starter/province');
        $content = json_decode($response,false);
        $provinces=$content->rajaongkir->results;

        foreach($provinces as $province){
            Province::create([
                'id'=>$province->province_id,
                'name'=>$province->province
            ]);
        }
    }
}
