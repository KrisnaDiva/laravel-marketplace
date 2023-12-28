<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreAddressUpdateRequest;
use App\Models\StoreAddress;
use App\Services\StoreAddressService;
use Illuminate\Http\Request;

class StoreAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(private StoreAddressService $storeAddressService){}
    public function index()
    {
        //
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
    public function show(StoreAddress $storeAddress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StoreAddress $storeAddress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAddressUpdateRequest $request, $id)
    {
        $this->authorize('update',$this->storeAddressService->getAddress($id));
        $data=$request->validated();
        $this->storeAddressService->updateAddress($id,$data);
        return redirect()->route('store.index')->with('success','Store address updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StoreAddress $storeAddress)
    {
        //
    }
}
