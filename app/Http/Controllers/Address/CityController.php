<?php

namespace App\Http\Controllers\Address;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Repositories\CityRepository;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function __construct(private CityRepository $city){}
    public function getCities($province)
    {
        $cities = $this->city->where('province_id',$province);
        return response()->json($cities);
    }
}
