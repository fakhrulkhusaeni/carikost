<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Http\RedirectResponse;


class RoleController extends Controller
{
    //
    public function showForm()
    {
        return view('auth.select-role');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'account_type' => ['required', 'in:pemilik_kost,pencari_kost'],
        ]);

        $user = Auth::user();

        // Assign role
        $user->syncRoles([$request->account_type]);

        // Redirect sesuai role
        return $request->account_type === 'pemilik_kost'
            ? redirect()->route('dashboard')
            : redirect()->route('dashboard');
            
    }
}
