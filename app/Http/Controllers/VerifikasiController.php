<?php

namespace App\Http\Controllers;

use App\Models\Kost;

use Illuminate\Http\Request;

class VerifikasiController extends Controller
{

    public function index()
    {
        // Ambil data kost beserta status verifikasinya, urutkan dari yang terbaru
        $kosts = Kost::with('verifikasi', 'user')
            ->orderBy('created_at', 'asc')
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
        $kost = Kost::with('verifikasi')->findOrFail($id);

        if ($kost->verifikasi && $kost->verifikasi->status_verifikasi === 'terverifikasi') {
            return redirect()->route('admin.verifikasi.index')->with('error', 'Kost sudah diverifikasi sebelumnya.');
        }

        // Perbarui status verifikasi
        $kost->verifikasi->update(['status_verifikasi' => 'terverifikasi']);

        return redirect()->route('admin.verifikasi.index')->with('success', 'Kost berhasil diverifikasi.');
    }
}
