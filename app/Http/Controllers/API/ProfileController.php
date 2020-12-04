<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ProfileResource;

class ProfileController extends Controller
{
    /**
     * @param \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\ProfileResource
     */
    public function getProfile(Request $request)
    {
        $user = $request->user();
        
        return new ProfileResource($user);
    }

    /**
     * @param \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\ProfileResource
     */
    public function postUpdate(Request $request)
    {
        $user = $request->user();
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email:filter|max:255|unique:users,email,'.$user->id,
            'confirm_password' => 'same:password'
        ]);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);

        return new ProfileResource($user);
    }
}
