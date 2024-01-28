<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email','password']);

        if(Auth::attempt($credentials))
        {
            $user = Auth::user();

            // Create sanctum token for user
            $token = $user->createToken('api-token', ['*'], now()->addWeek());

            return response()->json([
                'user_id' => $user->id,
                'access_token' => $token->plainTextToken,
                'token_type' => 'Bearer',
                'role_type' => $user->role_type, 
                'expires_at' => $token->accessToken->expires_at,
            ]);
        }

        return response()->json(['message' => 'Invalid Credentials'], 401);
    }

    
}
