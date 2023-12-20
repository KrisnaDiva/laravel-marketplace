<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create():Response{
        return response()->view('auth.login');
    }
    public function store(Request $request): RedirectResponse{
        $credentials=$request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);
        $remember = $request->remember ? true:false;
        
            if(!Auth::attempt($credentials,$remember)){
                return back()->with('loginError',"Email And Password Doesn't Match");
            }
            $request->session()->regenerate();
            return redirect()->intended(RouteServiceProvider::HOME);
            
                
    }
}
