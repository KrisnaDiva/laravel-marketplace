<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreCreateRequest;
use App\Http\Requests\Store\StoreUpdateRequest;
use App\Models\Store;
use App\Repositories\UserRepository;
use App\Services\StoreService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class StoreController extends Controller
{
    public function __construct(private StoreService $storeService,private UserRepository $user){}
    /**
     * Display a listing of the resource.
     */
    public function index():View{
        return view('store.index',[
            'user'=>$this->user->getUser()
        ]);
    }
    
    public function onboardingIndex():View{
        return view('store.onboarding.index',[
            'user'=>$this->user->getUser()            
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():View
    {
        return view('store.create',[
            'user'=>$this->user->getUser(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCreateRequest $request):RedirectResponse
    {
        $data=$request->validated();
        $this->storeService->createStore($data);
        return redirect()->route('store.index')->with('success','Store created. Now you can continue adding your first products!');
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id):View
    {
        $this->authorize('view',$this->storeService->getStore($id));
        return view('store.edit',[
            'user'=>$this->user->getUser(),
            'store'=>$this->storeService->getStore($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateRequest $request, $id):RedirectResponse
    {
        $this->authorize('update',$this->storeService->getStore($id));
        $data=$request->validated();
        $this->storeService->updateStore($id,$data);
        return redirect()->route('store.index')->with('success','Store updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Store $store)
    {
        //
    }
}
