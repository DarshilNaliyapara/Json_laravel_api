<?php

namespace App\Http\Controllers;

use Generator;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

        public function showusers()
    {
        return User::all();
    }

    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:4'
            ]);


            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),

            ]);
            Auth::attempt($validated);
            $user = Auth::user();

            $token = $user->createToken($request->name)->plainTextToken;
            if ($user) {
                return response()->json([
                    "status" => true,
                    "message" =>  "User Created Successfully.",
                    "response_data" => $user,
                    'token' => $token
                ], 200);
            } else {
                return response()->json([
                    "status" => false,
                    "message" =>  "Failed to Create User.",
                    'token' => $token
                ], 404);
            }
        } catch (ValidationException $e) {

            return response()->json([
                "status" => false,
                "message" => "Validation Error",
                "errors" => $e->errors()
            ], 422);
        }
    }
    public function login(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|min:4'
        ]);

       Auth::attempt($validated);

        $user = Auth::user();
        if ($user) {

            $token = $user->createToken($request->name);
            return response()->json(["status" => true, "message" => "Login Successfully Welcome $user->name.", "response_data" => $user, 'token' => $token->plainTextToken,], 200);
        } else {
            return response()->json(["status" => false, "message" => "Failed To login User,Check your Input "], 404);
        }
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(["status" => true, "message" => "user has beeen logout"], 200);
    }
    
}
