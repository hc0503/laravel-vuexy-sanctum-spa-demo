<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    /**
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getList(Request $request)
    {
        $users = User::all();

        return UserResource::collection($users);
    }

    /**
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postCreate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191'
        ]);
        $user = User::create([
            'email' => $request->email,
            'name' => $request->name,
            'password' => $request->password
        ]);
        
        return new UserResource($user);
    }

    /**
     * @param \Illuminate\Http\Request  $request
     * @param \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUpdate(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191'
        ]);
        $user->update([
            'email' => $request->email
        ]);

        return new UserResource($user);
    }

    /**
     * @param \Illuminate\Http\Request  $request
     * @param \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDelete(Request $request, User $user)
    {
        $user->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }
}
