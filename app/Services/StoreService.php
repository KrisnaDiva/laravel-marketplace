<?php 
namespace App\Services;

use App\Models\Image;
use App\Repositories\StoreRepository;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StoreService{
    public function __construct(private StoreRepository $storeRepository){}

    public function getAllStore(){
        return $this->storeRepository->all();
    }
    public function getPaginateStore($perPage=10){
        return $this->storeRepository->paginate($perPage);
    }
    public function createStore(array $data){
        $data['user_id']=Auth::id();
        return $this->storeRepository->create($data);
    }
    public function getStore($id){
        return $this->storeRepository->find($id);
    }
    public function updateStore($id,array $data){
        try {
            DB::beginTransaction();
            $store=$this->getStore($id);
        if(isset($data['image'])){
            if($store->image){
                Storage::delete($store->image->url);
                $image=Image::where('url',$store->image->url);
                $image->delete();
            }
            $imagePath = $data['image']->store('images/store-image');
            $image = Image::create(['url' => $imagePath]);
            $data['image_id'] = $image->id;           
        }
        $result=$this->storeRepository->update($id,$data);
            DB::commit();
            return $result;
        } catch (QueryException $error) {
            DB::rollBack();
        }      
    }
    public function deleteStore($id){
        return $this->storeRepository->delete($id);
    }
}