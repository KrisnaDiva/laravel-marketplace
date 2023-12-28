<?php 
namespace App\Repositories;
use App\Models\Province;


class ProvinceRepository
{
    public function all()
    {
        return Province::all();
    }

}