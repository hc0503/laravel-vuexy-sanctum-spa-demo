<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\AuthResource;

class AuthController extends Controller
{
    /**
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|string',
            'password' => 'required',
        ]);

        $user = User::where('email', "$request->email")->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(null, 401);
        }

        return response()->json([
            'token' => $user->createToken('token', ['user:token'])->plainTextToken,
            'user_info' => $user
        ]);
    }

    /**
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLogout(Request $request)
    {
        // Get user who requested the logout
        $user = request()->user(); //or Auth::user()
        // Revoke current user token
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
