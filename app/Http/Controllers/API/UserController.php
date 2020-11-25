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
     * @param \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDetail(Request $request, User $user)
    {
        return new UserResource($user);
    }

    /**
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postCreate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);
        $user = User::create([
            'email' => $request->email,
            'name' => $request->name,
            'password' => $request->password,
            'status' => $request->status,
        ]);
        $user->assignRole($request->roles['name']);
        
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
        $result = $user->delete();

        return response()->json([
            'success' => $result
        ]);
    }
}
