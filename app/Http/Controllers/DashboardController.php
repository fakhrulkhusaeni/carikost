<?php

namespace App\Http\Controllers;

use App\Models\HunianLain;
use App\Models\Kost;
use App\Models\Pembayaran;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('super_admin')) {

            $totalPengguna = User::count();
            $totalKost = Kost::count();
            $totalHunianLain = HunianLain::count();

            return view('dashboard.admin', compact('totalPengguna', 'totalKost', 'totalHunianLain'));
        } elseif ($user->hasRole('pemilik_kost')) {

            $totalKost = Kost::where('user_id', $user->id)->count();
            $totalPemesanan = Pembayaran::whereHas('kost', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->count();

            return view('dashboard.pemilik', compact('totalKost', 'totalPemesanan'));
        } elseif ($user->hasRole('pencari_kost')) {
            return view('dashboard.pencari');
        } else {
            abort(403, 'Role tidak dikenali.');
        }
    }
}
