<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $input = $request->validated();

        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        $token = Auth::login();

        return response()->json([
            'auth' => Auth::user(),
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
        ]);
    }

    public function login(LoginRequest $request)
    {
        $input = $request->validated();

        if (! $token = Auth::attempt([
            'email' => $input['email'],
            'password' => $input['password'],
        ])) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        return response()->json([
            // 'auth' => Auth::user(),
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
        ]);
    }

    public function logout()
    {
        Auth::logout();

        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
}
