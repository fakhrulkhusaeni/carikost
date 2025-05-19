<?php

namespace App\Http\Controllers;

use App\Models\HunianLain;
use App\Models\Kost;
use App\Models\Pembayaran;
use App\Models\Riwayat;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('super_admin')) {

            // Hitung semua user kecuali yang memiliki role 'super_admin'
            $totalPengguna = User::whereDoesntHave('roles', function ($query) {
                $query->where('name', 'super_admin');
            })->count();
            $totalKost = Kost::count();
            $totalHunianLain = HunianLain::count();

            return view('dashboard.admin', compact('totalPengguna', 'totalKost', 'totalHunianLain'));
        } elseif ($user->hasRole('pemilik_kost')) {

            $totalKost = Kost::where('user_id', $user->id)->count();
            $totalPemesanan = Pembayaran::whereHas('kost', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->count();

            $totalSaldo = $user->saldo;

            return view('dashboard.pemilik', compact('totalSaldo', 'totalKost', 'totalPemesanan'));
        } elseif ($user->hasRole('pencari_kost')) {
            return view('dashboard.pencari');
        } else {
            abort(403, 'Role tidak dikenali.');
        }
    }
}
