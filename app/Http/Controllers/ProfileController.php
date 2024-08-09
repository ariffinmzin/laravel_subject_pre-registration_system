<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //
    public function getProfile()
    {
        $user = auth()->user();
        return view('pages.profile', compact('user'));
    }

    public function postProfile(Request $request){

        // dd($request);

        $user = auth()->user();

        $validated_data = $request->validate([
            'name' => 'required|min:5|max:255',
            'email' => ['required','email','unique:users,email,'.$user->id],
            'password' => 'nullable|min:8|confirmed',
        ]);

           // Update user profile
        $user->name = $validated_data['name'];
        $user->email = $validated_data['email'];

        if ($validated_data['password']) {
            $user->password = bcrypt($validated_data['password']);
        }

        $user->save();

        return redirect()->route('profile.get')->with('message', 'Profile updated successfully');



      

    }
}
