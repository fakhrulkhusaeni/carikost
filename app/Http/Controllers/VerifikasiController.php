<?php

namespace App\Http\Controllers;

use App\Mail\NotifikasiVerifikasiDitolakKost;
use App\Mail\NotifikasiVerifikasiKost;
use App\Models\Kost;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;

class VerifikasiController extends Controller
{

    public function index()
    {
        // Ambil data kost beserta status verifikasinya, urutkan dari yang terbaru
        $kosts = Kost::with('verifikasi', 'user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.verifikasi.index', compact('kosts'));
    }


    public function show($id)
    {
        $kost = Kost::with('verifikasi', 'user')->findOrFail($id);

        return view('admin.verifikasi.show', compact('kost'));
    }

    public function destroy($id)
    {
        $kost = Kost::findOrFail($id);

        // Hapus data kost
        $kost->delete();

        return redirect()->route('admin.verifikasi.index')->with('success', 'Kost berhasil dihapus.');
    }

    public function verifikasi($id)
    {
        $kost = Kost::with('verifikasi', 'user')->findOrFail($id);

        if ($kost->verifikasi && $kost->verifikasi->status_verifikasi === 'terverifikasi') {
            return redirect()->route('admin.verifikasi.index')->with('error', 'Kost/Kontrakan sudah diverifikasi sebelumnya.');
        }

        // Update status verifikasi
        $kost->verifikasi->update(['status_verifikasi' => 'terverifikasi']);

        // Kirim email ke user pemilik kost
        Mail::to($kost->user->email)->send(new NotifikasiVerifikasiKost($kost, $kost->user));

        return redirect()->route('admin.verifikasi.index')->with('success', 'Kost/Kontrakan berhasil diverifikasi.');
    }

    public function tolak($id)
    {
        $kost = Kost::with('verifikasi', 'user')->findOrFail($id);

        if ($kost->verifikasi && $kost->verifikasi->status_verifikasi === 'ditolak') {
            return redirect()->route('admin.verifikasi.index')->with('error', 'Kost/Kontrakan sudah ditolak sebelumnya.');
        }

        // Update status verifikasi
        $kost->verifikasi->update(['status_verifikasi' => 'ditolak']);

        // Kirim email ke user pemilik kost
        Mail::to($kost->user->email)->send(new NotifikasiVerifikasiDitolakKost($kost, $kost->user));

        return redirect()->route('admin.verifikasi.index')->with('success', 'Kost/Kontrakan telah ditolak.');
    }
}
