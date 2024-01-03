<?php 
namespace App\Services;

use App\Models\Image;
use App\Models\ProductImage;
use App\Repositories\ProductRepository;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductService{
    public function __construct(private ProductRepository $productRepository){}

    public function getAllProduct(){
        return $this->productRepository->all();
    }
    public function getAllReadyStockProduct(){
        return $this->productRepository->allReadyStock();
    }
    public function getPaginateProduct($perPage=10){
        return $this->productRepository->paginate($perPage);
    }
    public function getPaginateReadyStockProduct($perPage=10){
        return $this->productRepository->paginateReadyStock($perPage);
    }
    public function createProduct(array $data){
        $data['store_id']=Auth::user()->store->id;
        try {
            DB::beginTransaction();
            $product=$this->productRepository->create($data);
            for($i=0;$i<count($data['image']);$i++){
                $imagePath = $data["image"][$i]->store('images/product-image');
                $image = Image::create(['url' => $imagePath]);
                $product->images()->attach($image->id);
            }
            DB::commit();
        } catch (QueryException $error) {
            DB::rollBack();
        }  


    }
    public function getProduct($id){
        return $this->productRepository->find($id);
    }
    public function updateProduct($id,array $data){    
        $product = $this->getProduct($id);
        try {
            DB::beginTransaction();
            $this->productRepository->update($id,$data);
            if(isset($data['image'])){
                for($i=0;$i<count($data['image']);$i++){
                    $imagePath = $data["image"][$i]->store('images/product-image');
                    $image = Image::create(['url' => $imagePath]);
                    $product->images()->attach($image->id);
                }         
            }
            DB::commit();
        } catch (QueryException $error) {
            DB::rollBack();
        }      
        return $this->productRepository->update($id,$data);
    }
    public function deleteProduct($id)
    {
        $productModel = $this->getProduct($id);
        try {
            DB::beginTransaction();
            foreach($productModel->cartItems as $item){
                $item->delete();
            }
            foreach($productModel->orderDetails as $detail){
                if($detail->order){
                    if($detail->order->has_paid==0){
                        $detail->order->delete();
                    }
                }
            }
            // foreach ($productModel->images as $image) {
            //     Storage::delete($image->url);
            //     $imageModel = Image::where('url', $image->url)->first();
            //     $imageModel->products()->detach($id);
            //     $imageModel->delete();
            // }    
            $this->productRepository->delete($id);
            DB::commit();
        } catch (QueryException $error) {
            DB::rollBack();
        }        
    }
    
}