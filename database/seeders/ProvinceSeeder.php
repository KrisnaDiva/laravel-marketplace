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
            'key'=>'c02b93cf40f1b5bc247494c12cae4148'
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
