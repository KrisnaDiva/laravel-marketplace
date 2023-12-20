<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index():Response{
        return response()->view('dashboard',['user'=>Auth::user(),'products'=>Product::all()]);
    }
}
