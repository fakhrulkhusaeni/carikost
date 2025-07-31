<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => bcrypt(str()->random(12)),
                'email_verified_at' => now()
            ]);
        }

        Auth::login($user);
        // Jika belum punya role, arahkan ke pemilihan
        if (!$user->hasAnyRole(['pemilik_kost', 'pencari_kost'])) {
            return redirect()->route('select-role');
        }

        // Redirect ke dashboard sesuai role
        return $user->hasRole('pemilik_kost')
            ? redirect()->route('dashboard')
            : redirect()->route('dashboard');
    }

}

