<?php

use App\Models\Form;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;


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

Route::get('/', [FormController::class, 'index'])->name('forms.index');
Route::resource('forms', FormController::class);
// Route::get('forms/{form}', [FormController::class,'delete'])->name('forms.delete');




Route::get('/test',[TestController::class,'test'])->name('test.index');
Route::post('/test',[TestController::class,'search'])->name('test.search');
