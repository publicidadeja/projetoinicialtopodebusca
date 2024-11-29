<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->scopes([
                'openid',
                'https://www.googleapis.com/auth/userinfo.profile',
                'https://www.googleapis.com/auth/userinfo.email',
                'https://www.googleapis.com/auth/business.manage',
                'https://www.googleapis.com/auth/plus.business.manage'
            ])
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();

            $finduser = User::where('google_id', $user->id)->first();

            if(!$finduser){
                $finduser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'password' => encrypt('123456dummy'),
                    'google_token' => $user->token,
                    'google_refresh_token' => $user->refreshToken,
                ]);
            } else {
                // Atualizar tokens existentes
                $finduser->update([
                    'google_token' => $user->token,
                    'google_refresh_token' => $user->refreshToken,
                ]);
            }

            Auth::login($finduser);

            return redirect()->intended('/dashboard');

        } catch (Exception $e) {
            return redirect('login')->with('error', 'Erro ao fazer login com Google: ' . $e->getMessage());
        }
    }
}