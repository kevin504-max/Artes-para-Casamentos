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
        if ($request->password !== $request->password_confirmation) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'password' => [
                        'The password confirmation does not match.',
                    ],
                ],
            ], 422);
        }

        $input = $request->validated();

        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        $token = Auth::login($user);

        return response()->json([
            'auth' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
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
                'message' => 'Unauthorizeda',
            ], 401);
        }

        return response()->json([
            'auth' => Auth::user(),
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }

    public function logout()
    {
        Auth::logout();

        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }

    public function getAuthUser()
    {
        return response()->json([
            'auth' => Auth::user(),
            'expires_in' => Auth::factory()->getTTL(),
        ]);
    }
}
