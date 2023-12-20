<?php 
namespace App\Repositories;

use App\Models\Store;

class StoreRepository
{
    public function all()
    {
        return Store::all();
    }
    
    public function paginate($perPage=10)
    {
        return Store::paginate($perPage);
    }

    public function find($id)
    {
        return Store::find($id);
    }

    public function create(array $data)
    {
        return Store::create($data);
    }

    public function update($id, array $data)
    {
        $store = $this->find($id);
        $store->update($data);
        return $store;
    }

    public function delete($id)
    {
        $store = $this->find($id);
        $store->delete();
    }
}