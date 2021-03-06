<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ソーシャルログイン
Route::prefix('login')->name('login.')->group(function () {
    Route::get('/{provider}', [LoginController::class, 'redirectToProvider'])->name('{provider}');
    Route::get('/{provider}/callback',  [LoginController::class, 'handleProviderCallback'])->name('{provider}.callback');
});
// ソーシャルログインからのユーザー登録
Route::prefix('register')->name('register.')->group(function () {
    Route::get('/{provider}/callback', [RegisterController::class, 'showProviderUserRegistrationForm'])->name('{provider}.callback');
    Route::post('/{provider}', [RegisterController::class, 'registerProviderUser'])->name('{provider}');
});

Route::get('/', [ArticleController::class, 'index'])->name('articles.index');
Route::resource('articles', ArticleController::class)->except(['index', 'show'])->middleware('auth');
Route::resource('articles', ArticleController::class)->only(['show']);
Route::prefix('articles')->name('articles.')->group(function () {
    Route::put('/{article}/like', [ArticleController::class, 'like'])->name('like')->middleware('auth');
    Route::delete('/{article}/like', [ArticleController::class, 'unlike'])->name('like')->middleware('auth');
});
Route::get('/tags/{name}', [TagController::class, 'show'])->name('tags.show');
Route::prefix('users')->name('users.')->group(function () {
    Route::get('/{name}', [UserController::class, 'show'])->name('show');
    Route::get('/{name}/likes', [UserController::class, 'likes'])->name('likes');
    Route::get('/{name}/followings', [UserController::class, 'followings'])->name('followings');
    Route::get('/{name}/followers', [UserController::class, 'followers'])->name('followers');
    Route::middleware('auth')->group(function () {
        Route::put('/{name}/follow', [UserController::class, 'follow'])->name('follow');
        Route::delete('/{name}/follow', [UserController::class, 'unfollow'])->name('unfollow');
    });
});

// for password reset, get request page
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

// for password reset, submit request
Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);
    $status = Password::sendResetLink(
        $request->only('email')
    );
    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

// for password reset, get new password form
Route::get('/reset-password/{token}', function ($token, Request $request) {
    return view(
        'auth.reset-password',
        [
            'token' => $token,
            'email' => $request->email
        ]
    );
})->middleware('guest')->name('password.reset');

// for password reset, submit new password
Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) use ($request) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status == Password::PASSWORD_RESET
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');
