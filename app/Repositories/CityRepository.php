<?php 
namespace App\Repositories;
use App\Models\City;


class CityRepository
{
    public function all()
    {
        return City::all();
    }
    public function where(string $field,$value)
    {
        return City::where($field,$value)->get();
    }

}