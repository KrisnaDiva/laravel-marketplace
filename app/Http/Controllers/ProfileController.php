<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Image;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(): View
    {
        return view('profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request)
    {
        try {
            DB::beginTransaction();
            $user=$request->user();
            $user->fill($request->except('image'));
    
            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }
            if($request->file('image')){
                if($user->image){
                    Storage::delete($user->image->url);
                    $image=Image::where('url',$user->image->url);
                    $image->delete();
                }
                $imagePath = $request->file('image')->store('images/user-image');
                $image = Image::create(['url' => $imagePath]);
                $user->image_id = $image->id;
            }           
            $request->user()->save();
            DB::commit();
            return Redirect::route('profile.edit')->with('status', 'profile-updated');
        } catch (QueryException $error) {
            DB::rollBack();
        }   
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    
}


