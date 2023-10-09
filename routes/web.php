<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login/google', 
[App\Http\Controllers\GoogleLoginController::class, 
'redirect'])->name('login.google-redirect');

Route::get('/login/google/callback', 
[App\Http\Controllers\GoogleLoginController::class, 
'callback'])->name('login.google-callback');

