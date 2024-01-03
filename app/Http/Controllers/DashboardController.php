<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Repositories\UserRepository;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(private UserRepository $user,private ProductService $productService){}
    public function index(Request $request)
    {
        $user = $this->user->getUser();
        return response()->view('dashboard', [
            'user' => $user,
            'products' => Product::where('stock', '!=', 0)
                ->filter(request(['search', 'order','sortBy']))
                ->paginate(24)
                ->appends(['search' => request('search'), 'order' => request('order'), 'sortBy' => request('sortBy')]),
        ]);        
        
    }
}
