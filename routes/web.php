<?php

use App\Livewire\Login;
use App\Livewire\ViewWord;
use App\Livewire\Welcome;
use App\Models\FederatedUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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

Route::middleware('guest')
    ->get('/', Login::class)
    ->name('login');

Route::middleware('auth')
    ->get('/dashboard', Welcome::class)
    ->name('dashboard');

Route::get('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();

    return redirect()->route('login');
})->name('logout');


// Function: google login 
// Description: This will redirect to Google
Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
})->name('auth.google');


// Function: google authentication
// Description: This will authenticate the user through the google account
Route::get('/auth/google-callback', function () {
    $googleUser = Socialite::driver('google')->user();

    $user = FederatedUser::where('email', $googleUser->getEmail())->first();

    if ($user) {
        Auth::login($user);

        session(['session_data' => Auth::user()]);
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
})->name('auth.google-callback');


Route::get('/word/view/{id}', ViewWord::class)->name('word.view');
