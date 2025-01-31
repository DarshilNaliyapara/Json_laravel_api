<?php

use App\Http\Controllers\FormController;
use App\Http\Controllers\RolesAndPermissionController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::middleware(['auth', 'verified'])->get('/', [FormController::class, 'index'])->name('forms.index');
Route::middleware(['auth', 'verified'])->resource('forms', FormController::class);

Route::get('/register', [UserController::class, 'showregister'])->name('auth.showregister');
Route::post('/register', [UserController::class, 'register'])->name('auth.register');
Route::get('/login', [UserController::class, 'showlogin'])->name('auth.showlogin');
Route::post('/login', [UserController::class, 'login'])->name('auth.login');
Route::middleware('auth')->get('/logout', [UserController::class, 'logout'])->name('auth.logout');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
    return response()->json(["status" => true, "message" => "Login Successfully Welcome."]);
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('email/verify', function () {
    return view('verify');
})->middleware('auth')->name('verification.notice');

Route::get('/users/roles-and-permission',[RolesAndPermissionController::class,'index'])->name('users.index');
Route::get('/users/create',[RolesAndPermissionController::class,'showcreateform'])->name('users.create');
Route::post('/users/create-roles-and-permission',[RolesAndPermissionController::class,'createrolesandpermission'])->name('users.createroles');
Route::get('/users/roles-and-permission/set',[RolesAndPermissionController::class,'set_roles_and_permission'])->name('users.setroles');
Route::post('/users/roles-and-permission',[RolesAndPermissionController::class,'removeroles'])->name('users.removeroles');
Route::get('/users/roles-and-permission/remove',[RolesAndPermissionController::class,'index'])->name('users.showremoveroles');
Route::post('/users/set-roles-and-permission',[RolesAndPermissionController::class,'setroles'])->name('users.setroles');
Route::get('/users/roles-and-permission/set',[RolesAndPermissionController::class,'index'])->name('users.showsetroles');
