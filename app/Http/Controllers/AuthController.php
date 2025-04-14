<?php

namespace App\Http\Controllers;

use Exception;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SignUpRequest;
use App\Mail\ForgotPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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

    public function signup(SignUpRequest $request)
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
    
    public function forgotPassword(Request $request)
    {
        if (!$email = $request->email) {
            return response()->json([
                'message' => 'Email is required',
            ], 422);
        }

        if (User::where('email', $email)->exists()) 
        {
            $token = Hash::make($email . '' . now());

            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token,
                'created_at' => now(),
            ]);

            Mail::to($email)->send(new ForgotPasswordMail($token));

            return response()->json([
                'message' => 'Password reset link sent to your email',
            ], 200);
        }
        
        else 
        {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }
    }

    public function resetPassword(ResetPasswordRequest $request) 
    {
        $email = $request->email;
        $token = $request->token;
        $password = $request->password;

        $passwordReset = DB::table('password_resets')->where('email', $email)->where('token', $token)->first();
        if (!$passwordReset) {
            return response()->json([
                'message' => 'Invalid token or email',
            ], 422);
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        $user->password = Hash::make($password);
        $user->save();

        DB::table('password_resets')->where('email', $email)->delete();

        return response()->json([
            'message' => 'Password reset successfully',
        ], 200);
    }

    public function user() 
    {
        return Auth::user();
    }
}
