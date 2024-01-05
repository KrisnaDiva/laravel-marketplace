<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\OrderDetail;
use App\Models\Rating;
use App\Models\Review;
use App\Repositories\UserRepository;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(private UserRepository $user){}
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(OrderDetail $orderDetail)
    {
        $this->authorize('create',$orderDetail);
        return view('order.review.create',[
            'user'=>$this->user->getUser(),
            'detail'=>$orderDetail,
            'ratings'=>Rating::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, OrderDetail $orderDetail)
    {
        $validatedData=$request->validate([
            'rating_id'=>'required',
            'comment'=>'required|max:255',
        ]);
        $review=Review::create([
            'comment'=>$request->comment,
            'rating_id'=>$request->rating_id,
            'detail_id'=>$orderDetail->id
        ]);
        if($request->file('image')){
            $validatedData['image']=$request->file('image');
            try {
                DB::beginTransaction();
                for($i=0;$i<count($validatedData['image']);$i++){
                    $imagePath = $validatedData["image"][$i]->store('images/review-image');
                    $image = Image::create(['url' => $imagePath]);
                    $review->images()->attach($image->id);
                }
                DB::commit();
            } catch (QueryException $error) {
                DB::rollBack();
            }  
        }

        return redirect()->route('order.hasPaid')->with('success','review created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderDetail $orderDetail)
    {
        $this->authorize('update',$orderDetail);
        return view('order.review.edit',[
            'user'=>$this->user->getUser(),
            'review'=>$orderDetail->review,
            'ratings'=>Rating::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderDetail $orderDetail)
    {
        $this->authorize('update',$orderDetail);
        $validatedData=$request->validate([
            'rating_id'=>'required',
            'comment'=>'required|max:255',
        ]);
        $review=$orderDetail->review;
        $review->update($validatedData);
        if($request->file('image')){
            $validatedData['image']=$request->file('image');
            try {
                DB::beginTransaction();
                for($i=0;$i<count($validatedData['image']);$i++){
                    $imagePath = $validatedData["image"][$i]->store('images/review-image');
                    $image = Image::create(['url' => $imagePath]);
                    $review->images()->attach($image->id);
                }
                DB::commit();
            } catch (QueryException $error) {
                DB::rollBack();
            }  
        }

        return redirect()->route('order.hasPaid')->with('success','review updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        //
    }
    public function destroyImage(OrderDetail $orderDetail,Image $image){
        $review=$orderDetail->review;
        $this->authorize('update',$orderDetail);
        try{
            DB::beginTransaction();
            Storage::delete($image->url);
            $image->reviews()->detach($review);
            $image->delete();
            DB::commit();
        }catch(QueryException $e){
            DB::rollBack();
        }
        return redirect()->route('review.edit',$orderDetail);
    }
}
