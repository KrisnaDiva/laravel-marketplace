<?php 
namespace App\Repositories;

use App\Models\UserAddress;

class UserAddressRepository
{
    public function all()
    {
        return UserAddress::all();
    }
    
    public function paginate($perPage=10)
    {
        return UserAddress::paginate($perPage);
    }

    public function find($id)
    {
        return UserAddress::find($id);
    }
    public function whereFirst(string $field,$value)
    {
        return UserAddress::where($field,$value)->first();
    }

    public function create(array $data)
    {
        return UserAddress::create($data);
    }

    public function update($id, array $data)
    {
        $userAddress = $this->find($id);
        $userAddress->update($data);
        return $userAddress;
    }

    public function delete($id)
    {
        $userAddress = $this->find($id);
        $userAddress->delete();
    }
}