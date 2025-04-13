<?php

namespace App\Http\Controllers;

use Exception;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function register(RegisterRequest $request)
    {
        try 
        {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $token = $user->createToken('app')->accessToken;

            // Return success response
            return response()->json([
                'message' => 'User registered successfully',
                'user' => $user,
                'token' => $token
            ], 201);
        } 
        
        catch (Exception $e) 
        {
            return response()->json([
                'message' => 'Registration failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
