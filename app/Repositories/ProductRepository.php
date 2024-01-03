<?php 
namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function all()
    {
        return Product::all();
    }
    public function allReadyStock()
    {
    return Product::where('stock', '!=', 0)->get();
    }
    public function paginateReadyStock($perPage=10)
    {
    return Product::where('stock', '!=', 0)->paginate($perPage);
    }
    
    public function paginate($perPage=10)
    {
        return Product::paginate($perPage);
    }

    public function find($id)
    {
        return Product::find($id);
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update($id, array $data)
    {
        $product = $this->find($id);
        $product->update($data);
        return $product;
    }

    public function delete($id)
    {
        $product = $this->find($id);
        $product->delete();
    }
}