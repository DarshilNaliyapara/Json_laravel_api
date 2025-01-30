<?php

use Illuminate\Http\Request;
use App\Http\Middleware\auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware(['auth:sanctum','verified'])->apiResource('apis',ApiController::class);

Route::get('/',[UserController::class,'showusers'])->name('auth.show');
Route::post('/register',[UserController::class,'register'])->name('auth.register');
Route::post('/login',[UserController::class,'login'])->name('auth.login');
Route::middleware('auth:sanctum')->post('/logout',[UserController::class,'logout'])->name('auth.logout');
// Route::post('/email/verification',[UserController::class,'verifyemail'])->name('auth.verifyemail');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return response()->json(["status" => true, "message" => "Login Successfully Welcome."]);
})->middleware(['auth:sanctum','signed'])->name('verification.verify');
