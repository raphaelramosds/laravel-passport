<?php

namespace App\Http\Controllers\Admin;

use Exception;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        try 
        {
            if (Auth::attempt($request->only('email', 'password'))) 
            {
                // Get authenticated user
                $user = Auth::user();
                $token = $user->createToken('app')->accessToken;

                // Return success response with token
                return response()->json([
                    'message' => 'Login successful',
                    'token' => $token,
                    'user' => $user
                ], 200);
            }
        }
        
        catch (Exception $e) {
            return response()->json([
                'message' => 'Login failed',
                'error' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);
    }

    public function register() {
        
    }
}
