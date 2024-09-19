<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Contracts\Providers\Auth;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:8|max:20'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validate->errors()
            ], 403);
        }

        $credentials = $request->only(['email', 'password']);

        $token =  auth()->attempt($credentials);

        if (!$token) {
            return response()->json([
                'status' => false,
                'error' => 'Invalid Email or Password'
            ]);
        } else {
            return response()->json([
                'status' => true,
                'token' => $token
            ]);
        }
    }

    public function register(Request $request): JsonResponse
    {
        $validate = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255|',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'password' => 'required|string|min:8|max:20'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validate->errors()
            ]);
        }

        $user = User::query()->where('email', $request->email)->first();

        if ($user) {
            return response()->json([
                'status' => false,
                'error' => 'User with Email Already Exists'
            ]);
        }

        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User Registered Successfully'
        ], 201);
    }

    public function logout(): JsonResponse
    {
        auth('api')->logout();
        return response()->json([
            'status' => 'true',
            'message' => 'Logged Out Successfully'
        ]);
    }

    public function user()
    {
        return auth()->user();
    }
}
