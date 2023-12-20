<?php 
namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserRepository
{
    public function getUser()
    {
        return Auth::user();
    }

    public function getUserId()
    {
        return Auth::id();
    }

}