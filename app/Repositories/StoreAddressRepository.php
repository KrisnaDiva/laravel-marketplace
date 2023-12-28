<?php 
namespace App\Repositories;

use App\Models\StoreAddress;

class StoreAddressRepository
{
    public function all()
    {
        return StoreAddress::all();
    }
    
    public function paginate($perPage=10)
    {
        return StoreAddress::paginate($perPage);
    }

    public function find($id)
    {
        return StoreAddress::find($id);
    }

    public function create(array $data)
    {
        return StoreAddress::create($data);
    }

    public function update($id, array $data)
    {
        $storeAddress = $this->find($id);
        $storeAddress->update($data);
        return $storeAddress;
    }

    public function delete($id)
    {
        $storeAddress = $this->find($id);
        $storeAddress->delete();
    }
}