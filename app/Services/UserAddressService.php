<?php 
namespace App\Services;
use App\Repositories\UserAddressRepository;
use App\Repositories\UserRepository;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class UserAddressService{
    public function __construct(private UserAddressRepository $userAddressRepository,private UserRepository $user){}

    public function getAllAddress(){
        return $this->userAddressRepository->all();
    }
    public function getPaginateAddress($perPage=10){
        return $this->userAddressRepository->paginate($perPage);
    }
    public function createAddress(array $data){
        $data['user_id']=$this->user->getUserId();

        if(count($this->user->getUser()->addresses)==0){
            $data['isMain']=1;
        }else{
            $data['isMain']=0;
        }
        
        return $this->userAddressRepository->create($data);
    }
    public function getAddress($id){
        return $this->userAddressRepository->find($id);
    }
    public function updateAddress($id,array $data){
        return $this->userAddressRepository->update($id,$data);
    }
    public function deleteAddress($id){
        if($this->getAddress($id)->isMain==1){
            abort(403);
        }else{
            return $this->userAddressRepository->delete($id);
        }
    }
    public function setMainAddress($id){
        try{
            DB::beginTransaction();
            $oldMain=$this->userAddressRepository->whereMain('isMain',1,'user_id',$this->user->getUserId());
            $data=['isMain'=>0];
            if($oldMain){
            $this->updateAddress($oldMain->id,$data);
            }
            $data=['isMain'=>1];
            $this->updateAddress($id,$data);
            DB::commit();
        }catch(QueryException $e){
            DB::rollBack();
        }
       
    }
    public function getMainAddress(){
        return $this->userAddressRepository->whereMain('isMain',1,'user_id',$this->user->getUserId());
    }
}