<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\User;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Permission;
use Illuminate\Console\Scheduling\Schedule;
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
            $role = Role::firstOrCreate(['name' => 'writer']);
            $permission = Permission::firstOrCreate(['name' => 'edit articles']);

            $role->givePermissionTo($permission);
            $token = $user->createToken($request->name)->plainTextToken;
            if ($user) {
                return redirect('/');
                return response()->json([
                    "status" => true,
                    "message" => "User Created Successfully.",
                    "response_data" => $user,
                    'token' => $token,
                ], 200);
            } else {
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
            'email' => 'required|email',
            'password' => 'required|min:4',
        ]);

        Auth::attempt($validated);

        $user = Auth::user();

        $request->session()->regenerate();
        if ($user) {
            $token = $user->createToken($request->email);

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
    public function exportData()
    {
        return Excel::download(new UsersExport, 'users.pdf');
    }
    public function importData(Request $request)
    {
        $request->validate([
            "importexcel" => ["required", "file"]
        ]);

        Excel::import(new UsersImport, $request->file("importexcel"));
        return redirect()->back()->with("status", "Data Imported successfully");
    }
    public function exportpdf(Request $request)
    {
        $customers = Form::where('meta_name', 'customers')->first();
        $data = [];
        $forms = [];
        if (!empty($customers)) {
            $data = isset($customers->meta_value) ? json_decode($customers->meta_value, true) : [];

            $forms = array_map(function ($item) {
                return $item;
            }, $data);

        }

        $users = User::all();
        $data = [
            'title' => "Pdf export",
            'date' => date('d/m/y'),
            'users' => $users,
            'forms'=> $forms
        ];
        $pdf = Pdf::loadView('invoice', $data);
        return $pdf->download(
            'invoice.pdf'
        );
    }
}
