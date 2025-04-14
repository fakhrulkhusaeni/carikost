<?php

namespace App\Http\Controllers;

use App\Models\BuktiKepemilikanKost;
use Illuminate\Http\Request;

class BuktiKepemilikanKostController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'shm_hgb' => 'required|file|mimes:pdf,jpg,png|max:5120',
            'siuk_imb' => 'required|file|mimes:pdf,jpg,png|max:5120',
            'ktp_pemilik' => 'required|file|mimes:pdf,jpg,png|max:5120',
            'kost_id' => 'required|exists:kosts,id',
        ]);

        $data = [
            'kost_id' => $request->kost_id,
            'user_id' => auth()->id(),
        ];

        // Cek apakah sudah pernah upload
        $existing = BuktiKepemilikanKost::where('kost_id', $request->kost_id)->first();
        if ($existing) {
            return redirect()->back()->with('error', 'Bukti kepemilikan sudah diunggah');
        }

        if ($request->hasFile('shm_hgb')) {
            $data['shm_hgb'] = $request->file('shm_hgb')->store('bukti_kepemilikan_kost', 'public');
        }

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
