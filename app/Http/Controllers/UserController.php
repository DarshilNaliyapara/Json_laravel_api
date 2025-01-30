<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    public function showregister()
    {
        return view('register');
    }
    public function showlogin()
    {
        return view('login');
    }

    public function register(Request $request, User $user)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:4',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),

            ]);

            event(new Registered($user));

            Auth::login($user);

            $user = Auth::user();
            
            Session::regenerate();
            
            $token = $user->createToken($request->name)->plainTextToken;
            if ($user) {
                return redirect('/');
                return response()->json([
                    "status" => true,
                    "message" => "User Created Successfully.",
                    "response_data" => $user,
                    'token' => $token,
                ], 200);
            } 
            
            else {
                return response()->json([
                    "status" => false,
                    "message" => "Failed to Create User.",
                    'token' => $token,
                ], 404);
            }
        } catch (ValidationException $e) {

            return response()->json([
                "status" => false,
                "message" => "Validation Error",
                "errors" => $e->errors(),
            ], 422);
        }
    }
    public function login(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|min:4',
        ]);

        Auth::attempt($validated);

        $user = Auth::user();

        $request->session()->regenerate();
        if ($user) {
            $token = $user->createToken($request->name);

            return redirect('/');

            return response()->json(["status" => true, "message" => "Login Successfully Welcome $user->name.", "response_data" => $user, 'token' => $token->plainTextToken,], 200);
        } else {
            return response()->json(["status" => false, "message" => "Failed To login User,Check your Input "], 404);
        }
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');

        return response()->json(["status" => true, "message" => "user has beeen logout"], 200);
    }
   
}
