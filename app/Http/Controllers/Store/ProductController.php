<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\ProductCreateRequest;
use App\Models\ProductCondition;
use App\Repositories\UserRepository;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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
        return redirect()->route('products.index')->with('success','Product deleted!');;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->productService->deleteProduct($id);
        return redirect()->route('products.index')->with('success','Product deleted!');
    }
}
