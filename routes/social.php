<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Social Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/auth/redirect', function () {
    return Socialite::driver('google')->redirect();
});
 
Route::get('/login/google/callback-url', function () {
    $user = Socialite::driver('google')->user();
    $user = User::updateOrCreate([
        'email' => $user->email,
    ], [
        'name' => $user->name,
        'password' =>Hash::make('google-auth-password'), // Generate password

    ]);
 
    Auth::login($user);
 
    return redirect('/home');
});