<?php

use Illuminate\Http\Request;
use App\Http\Middleware\auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\UserController;

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
// Route::middleware('auth:sanctum')->apiResource('apis',ApiController::class);

Route::get('/',[UserController::class,'showusers'])->name('auth.show');
Route::post('/register',[UserController::class,'register'])->name('auth.register');
Route::post('/login',[UserController::class,'login'])->name('auth.login');
// Route::middleware('auth:sanctum')->post('/logout',[UserController::class,'logout'])->name('auth.logout');

