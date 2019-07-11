<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function followUser(int $id)
    {
        $user = User::find($id);
        if(! $user) 
        {
            return redirect()->back()->with('error', 'User does not exist.'); 
        }

        $user->followings()->attach(auth()->user()->id);

        return redirect()->back()->with('success', 'Successfully followed the user.');
    }

    public function unFollowUser(int $id)
    {
        $user = User::find($id);
        if(! $user) 
        {   
         return redirect()->back()->with('error', 'User does not exist.'); 
        }

        $user->followings()->detach(auth()->user()->id);
        
        return redirect()->back()->with('success', 'Successfully unfollowed the user.');
    }
}
