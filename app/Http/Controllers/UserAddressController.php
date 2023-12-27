<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use App\Repositories\UserRepository;
use App\Services\UserAddressService;
use Illuminate\Http\Request;

class UserAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(private UserRepository $user,private UserAddressService $userAddressService){}
    public function index()
    {
        $user=$this->user->getUser();
        return view('profile.address.index',[
            'user'=>$user,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UserAddress $userAddress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserAddress $userAddress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserAddress $userAddress)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserAddress $userAddress)
    {
        //
    }
    public function setMain($id)
    {
        $this->userAddressService->setMainAddress($id);
        return back()->with('success','Main Address Has Changed');
    }
}
