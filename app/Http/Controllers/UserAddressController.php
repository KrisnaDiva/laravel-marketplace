<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAddressRequest;
use App\Models\UserAddress;
use App\Repositories\ProvinceRepository;
use App\Repositories\UserRepository;
use App\Services\UserAddressService;
use Illuminate\Http\Request;

class UserAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(private UserRepository $user,private UserAddressService $userAddressService,private ProvinceRepository $province){}
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
        return view('profile.address.create',[
            'user'=>$this->user->getUser(),
            'provinces'=>$this->province->all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserAddressRequest $request)
    {
        $data=$request->validated();
        $this->userAddressService->createAddress($data);
        return redirect()->route('address.index')->with('success','New address has been added');
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
    public function edit($id)
    {
        $this->authorize('update',$this->userAddressService->getAddress($id));
        return view('profile.address.edit',[
            'user'=>$this->user->getUser(),
            'address'=>$this->userAddressService->getAddress($id),
            'provinces'=>$this->province->all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserAddressRequest $request, $id)
    {
        $this->authorize('update',$this->userAddressService->getAddress($id));
        $data=$request->validated();
        $this->userAddressService->updateAddress($id,$data);
        return redirect()->route('address.index')->with('success','Address has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->authorize('delete',$this->userAddressService->getAddress($id));
        $this->userAddressService->deleteAddress($id);
        return back()->with('success','Address Has Been Deleted');
    }
    public function setMain($id)
    {
        $this->authorize('update',$this->userAddressService->getAddress($id));
        $this->userAddressService->setMainAddress($id);
        return back()->with('success','Main Address Has Changed');
    }
    public function setMainWithoutParam(Request $request)
    {
        $this->authorize('update',$this->userAddressService->getAddress($request->address));
        $this->userAddressService->setMainAddress($request->address);
        return back()->with('success','Main Address Has Changed');
    }
}
