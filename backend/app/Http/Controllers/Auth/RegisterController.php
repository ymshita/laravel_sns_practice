<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Fortify\Contracts\RegisterResponse;

class RegisterController extends Controller
{
    /**
     * ソーシャルログインの認証後、ユーザーアカウントがなかった場合の登録画面
     */
    public function showProviderUserRegistrationForm(Request $request, string $provider)
    {
        $token = $request->token;
        $providerUser = Socialite::driver($provider)->userFromToken($token);
        return view('auth.social_register', [
            'provider' => $provider,
            'email' => $providerUser->getEmail(),
            'token' => $token,
        ]);
    }

    /**
     * ソーシャルログインの認証後、ユーザーアカウントがなかった場合の登録処理
     */
    public function registerProviderUser(Request $request, string $provider)
    {
        $request->validate([
            'name' => ['required', 'string', 'alpha_num', 'min:3', 'max:16', 'unique:users'],
            'token' => ['required', 'string'],
        ]);

        $token = $request->token;
        // $copied = clone $token;
        $providerUser = Socialite::driver($provider)->userFromToken($token);

        $user = User::create(
            [
                'name' => $request->name,
                'email' => $providerUser->getEmail(),
                'password' => Hash::make(Str::random()),
                'fb_id' => $providerUser->id,
                'fb_token' => $providerUser->token,
            ]
        );

        auth()->login($user, true);

        return app(RegisterResponse::class);
    }
}
