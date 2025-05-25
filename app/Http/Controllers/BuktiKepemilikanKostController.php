<?php

namespace App\Http\Controllers;

use App\Models\BuktiKepemilikanKost;
use App\Models\Kost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class BuktiKepemilikanKostController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'siuk_imb' => 'required|file|mimes:pdf,jpg,png|max:5120',
            'ktp_pemilik' => 'required|file|mimes:pdf,jpg,png|max:5120',
            'kost_id' => 'required|exists:kosts,id',
        ]);
    
        $kost = Kost::findOrFail($request->kost_id);
        if ($kost->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak berhak mengunggah bukti untuk kost ini.');
        }
    
        $existing = BuktiKepemilikanKost::where('kost_id', $request->kost_id)->first();
    
        // Cegah upload ulang jika status bukan "ditolak"
        if ($existing && optional($kost->verifikasi)->status_verifikasi !== 'ditolak') {
            return redirect()->back()->with('error', 'Bukti kepemilikan sudah diunggah dan sedang diverifikasi.');
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
    
        if ($existing) {
            // Hapus file lama
            if ($existing->siuk_imb && Storage::disk('public')->exists($existing->siuk_imb)) {
                Storage::disk('public')->delete($existing->siuk_imb);
            }
    
            if ($existing->ktp_pemilik && Storage::disk('public')->exists($existing->ktp_pemilik)) {
                Storage::disk('public')->delete($existing->ktp_pemilik);
            }
    
            $existing->update($data);
        } else {
            BuktiKepemilikanKost::create($data);
        }
    
        // Reset status verifikasi ke "menunggu" (jika ada field verifikasi)
        if ($kost->verifikasi) {
            $kost->verifikasi->update([
                'status_verifikasi' => 'menunggu',
            ]);
        }
    
        return redirect()->back()->with('success', 'Bukti kepemilikan berhasil diunggah.');
    }
}
