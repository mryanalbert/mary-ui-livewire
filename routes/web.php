<?php

use App\Livewire\Items;
use App\Livewire\Login;
use App\Livewire\RequestItems;
use App\Livewire\ViewWord;
use App\Livewire\Welcome;
use App\Models\FederatedUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

// Route::middleware('auth')
//     ->get('/dashboard', Welcome::class)
//     ->name('dashboard');

Route::middleware(['auth']) // Apply the auth middleware to this group
    ->group(function () {
        Route::get('/dashboard', Welcome::class)->name('dashboard');
        Route::get('/word/view/{id}', ViewWord::class)->name('word.view');
        Route::get('/items', Items::class)->name('items');
        Route::get('/request-items', RequestItems::class)->name('request-items');
    });


Route::get('/logout', function () {
    // Auth::logout();
    session()->invalidate();
    session()->regenerateToken();

    return redirect()->route('login');
})->name('logout');


// Function: google login 
// Description: This will redirect to Google
Route::get('auth/google', function () {
    return Socialite::driver('google')->redirect();
})->name('auth.google');


// Function: google authentication
// Description: This will authenticate the user through the google account
Route::get('auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->user();

    $user = DB::select("
        SELECT
            email,
            name,
            priviledgeCode,
            appusrId,
            gUserName,
            appusr_federated.isActive AS is_app_user_active,
            usr_federated.isActive AS is_user_active
        FROM usr_federated
        JOIN appusr_federated
            ON usr_federated.userName = appusr_federated.gUserName
        WHERE email = ?
        AND appId = ?
    ", [$googleUser->email, 'PURJO']);

    $user = collect($user)->first();

    if ($user) {
        $userForAuth = FederatedUser::where('email', $user->email)->first();

        Auth::login($userForAuth);
        session([
            'id' => $user->appusrId,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->priviledgeCode,
            'userName' => $user->gUserName,
            'isUserActive' => $user->is_user_active,
            'isAppUserActive' => $user->is_app_user_active,
        ]);
    }

    return redirect()->route('dashboard');
});
