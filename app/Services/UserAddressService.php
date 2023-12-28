<?php 
namespace App\Services;
use App\Repositories\UserAddressRepository;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class UserAddressService{
    public function __construct(private UserAddressRepository $userAddressRepository){}

    public function getAllAddress(){
        return $this->userAddressRepository->all();
    }
    public function getPaginateAddress($perPage=10){
        return $this->userAddressRepository->paginate($perPage);
    }
    public function createAddress(array $data){
        return $this->userAddressRepository->create($data);
    }
    public function getAddress($id){
        return $this->userAddressRepository->find($id);
    }
    public function getAddressWhere(string $field,$value){
        return $this->userAddressRepository->where($field,$value);
    }
    public function updateAddress($id,array $data){
        return $this->userAddressRepository->update($id,$data);
    }
    public function deleteAddress($id){
        return $this->userAddressRepository->delete($id);
    }
    public function setMainAddress($id){
        try{
            DB::beginTransaction();
            $oldMain=$this->userAddressRepository->whereFirst('isMain',1);
            $data=[
                'isMain'=>0
            ];
            if($oldMain){
            $this->updateAddress($oldMain->id,$data);
            }
            $data=[
                'isMain'=>1
            ];
            $this->updateAddress($id,$data);
            DB::commit();
        }catch(QueryException $e){
            DB::rollBack();
        }
       
    }
}