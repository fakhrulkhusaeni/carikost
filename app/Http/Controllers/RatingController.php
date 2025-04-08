<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        // Pastikan pengguna login
        if (!auth()->check()) {
            return response()->json(['message' => 'Anda harus login untuk memberikan rating.'], 403);
        }

        // Pastikan pengguna memiliki role 'pencari_kost'
        if (!auth()->user()->hasRole('pencari_kost')) {
            return response()->json(['message' => 'Hanya pencari kost yang dapat memberikan rating.'], 403);
        }

        // Validasi input
        $request->validate([
            'rating' => 'required|integer|min:1|max:5', // Rating harus antara 1-5
            'kost_id' => 'required|exists:kosts,id',   // Harus valid dan ada di tabel kosts
        ]);

        // Periksa apakah pengguna sudah memberikan rating untuk kost yang sama
        $existingRating = Rating::where('user_id', auth()->id())
            ->where('kost_id', $request->kost_id)
            ->first();

        if ($existingRating) {
            return response()->json(['message' => 'Anda sudah memberikan rating untuk kost/kontrakan ini.'], 403);
        }

        // Simpan rating ke database
        Rating::create([
            'rating' => $request->rating,
            'kost_id' => $request->kost_id,
            'user_id' => auth()->id(), // Ambil ID pengguna yang sedang login
        ]);

        return response()->json(['message' => 'Terima Kasih telah memberikan rating'], 200);
    }
}
