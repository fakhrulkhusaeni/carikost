<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input, termasuk avatar, phone, dan account_type, gender
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg'], // Validasi avatar
            'phone' => ['nullable', 'string', 'max:15'], // Validasi nomor telepon
            'account_type' => ['required'],
            'gender' => ['nullable', 'string', 'in:laki-laki,perempuan'],
        ]);

        // Proses penyimpanan avatar jika ada
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public'); // Menyimpan avatar ke folder avatars
        }

        // Membuat user baru dan menyimpan data
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => $avatarPath, // Menyimpan path avatar
            'phone' => $request->phone, // Menyimpan nomor telepon
            'gender' => $request->gender, // Menyimpan jenis kelamin
        ]);

        if($request->account_type== 'pemilik_kost') {
            $user->assignRole('pemilik_kost');
        }
        elseif($request->account_type== 'pencari_kost') {
            $user->assignRole('pencari_kost');
        }
        else {
            $user->assignRole('pencari_kost');
        }

        // Menyimpan event registrasi
        event(new Registered($user));

        // Login pengguna yang baru terdaftar
        Auth::login($user);

        // Redirect ke dashboard
        return redirect(route('dashboard', absolute: false));
    }
}
