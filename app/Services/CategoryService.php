<?php 
namespace App\Services;
use App\Repositories\CategoryRepository;

class CategoryService{
    public function __construct(private CategoryRepository $categoryRepository){}

    public function getAllCategory(){
        return $this->categoryRepository->all();
    }
    public function getPaginateCategory($perPage=10){
        return $this->categoryRepository->paginate($perPage);
    }
    public function createCategory(array $data){
        return $this->categoryRepository->create($data);
    }
    public function getCategory($id){
        return $this->categoryRepository->find($id);
    }
    public function updateCategory($id,array $data){
        return $this->categoryRepository->update($id,$data);
    }
    public function deleteCategory($id){
        return $this->categoryRepository->delete($id);
    }
}