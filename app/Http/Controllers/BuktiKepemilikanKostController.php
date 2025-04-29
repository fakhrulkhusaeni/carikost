<?php

namespace App\Http\Controllers;

use App\Models\BuktiKepemilikanKost;
use App\Models\Kost;
use Illuminate\Http\Request;

class BuktiKepemilikanKostController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'siuk_imb' => 'required|file|mimes:pdf,jpg,png|max:5120',
            'ktp_pemilik' => 'required|file|mimes:pdf,jpg,png|max:5120',
            'kost_id' => 'required|exists:kosts,id',
        ]);

        // Pastikan user yang mengunggah adalah pemilik kost
        $kost = Kost::findOrFail($request->kost_id);
        if ($kost->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak berhak mengunggah bukti untuk kost ini.');
        }

        // Cek apakah sudah pernah upload
        $existing = BuktiKepemilikanKost::where('kost_id', $request->kost_id)->first();
        if ($existing) {
            return redirect()->back()->with('error', 'Bukti kepemilikan sudah diunggah');
        }

        $data = [
            'kost_id' => $request->kost_id,
        ];

        if ($request->hasFile('siuk_imb')) {
            $data['siuk_imb'] = $request->file('siuk_imb')->store('bukti_kepemilikan_kost', 'public');
        }

        if ($request->hasFile('ktp_pemilik')) {
            $data['ktp_pemilik'] = $request->file('ktp_pemilik')->store('bukti_kepemilikan_kost', 'public');
        }

        BuktiKepemilikanKost::create($data);

        return redirect()->back()->with('success', 'Bukti kepemilikan berhasil diunggah!');
    }
}
