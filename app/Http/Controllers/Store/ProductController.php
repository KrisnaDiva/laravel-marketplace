<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\ProductCreateRequest;
use App\Http\Requests\Store\ProductUpdateRequest;
use App\Models\Image;
use App\Models\ProductCondition;
use App\Repositories\UserRepository;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(private ProductService $productService,private UserRepository $user,private CategoryService $categoryService){}
    public function index()
    {
        return view('store.product.index',[
            'user'=>$this->user->getUser(),
            'products'=>$this->user->getUser()->store->products()->paginate(10)
        ]);        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():View
    {
        return view('store.product.create',[
            'user'=>$this->user->getUser(),
            'categories'=>$this->categoryService->getAllCategory(),
            'conditions'=>ProductCondition::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductCreateRequest $request):RedirectResponse
    {      
        $data=$request->validated();
        $this->productService->createProduct($data);
        return redirect()->route('products.index')->with('success','Product deleted!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('store.product.show',[
            'user'=>$this->user->getUser(),
            'product'=>$this->productService->getProduct($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorize('update',$this->productService->getProduct($id));
        return view('store.product.edit',[
            'user'=>$this->user->getUser(),
            'product'=>$this->productService->getProduct($id),
            'categories'=>$this->categoryService->getAllCategory(),
            'conditions'=>ProductCondition::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request,$id)
    {
        $this->authorize('update',$this->productService->getProduct($id));
        $data=$request->validated();
        $this->productService->updateProduct($id,$data);
        return redirect()->route('products.index')->with('success','Product updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete',$this->productService->getProduct($id));
        $this->productService->deleteProduct($id);
        return redirect()->route('products.index')->with('success','Product deleted!');
    }
    
    public function destroyImage($product,Image $image){
        $this->authorize('delete',$this->productService->getProduct($product));
        try{
            DB::beginTransaction();
            Storage::delete($image->url);
            $image->products()->detach($product);
            $image->delete();
            DB::commit();
        }catch(QueryException $e){
            DB::rollBack();
        }
        return redirect()->route('products.edit',$product);
    }
}
