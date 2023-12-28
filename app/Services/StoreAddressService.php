<?php 
namespace App\Services;
use App\Repositories\StoreAddressRepository;
use App\Repositories\UserRepository;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class StoreAddressService{
    public function __construct(private StoreAddressRepository $storeAddressRepository,private UserRepository $user){}

    public function getAllAddress(){
        return $this->storeAddressRepository->all();
    }
    public function getPaginateAddress($perPage=10){
        return $this->storeAddressRepository->paginate($perPage);
    }
    public function createAddress(array $data){
        $data['user_id']=$this->user->getUserId();
        return $this->storeAddressRepository->create($data);
    }
    public function getAddress($id){
        return $this->storeAddressRepository->find($id);
    }
    public function updateAddress($id,array $data){
        return $this->storeAddressRepository->update($id,$data);
    }
   
}