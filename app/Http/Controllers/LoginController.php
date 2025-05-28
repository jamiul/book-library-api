<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    // login method
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $data = $request->all();

            // check email
            $user = User::where('email', $data['email'])->first();

            // check password
            if (!$user || !Hash::check($data['password'], $user->password)) {
                return response()->json(['message' => 'Credentials not matched!'], Response::HTTP_UNAUTHORIZED);
            }

            $token = $user->createToken('private')->plainTextToken;

            $response = [
                'user' => $user,
                'token' => $token
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred during login.', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // logout method
    public function logout(Request $request): JsonResponse
    {
        try {
            if (Auth::check()) {
                $request->user()->currentAccessToken()->delete();
                $cookie = Cookie::forget('jwt');
                return response()->json(["message" => "Successfully logged out"])->withCookie($cookie);
            } else {
                return response()->json(["message" => "User not authenticated"], Response::HTTP_UNAUTHORIZED);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred during logout.', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
