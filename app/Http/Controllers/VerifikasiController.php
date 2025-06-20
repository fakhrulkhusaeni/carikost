<?php

namespace App\Http\Controllers;

use App\Mail\NotifikasiVerifikasiDitolakKost;
use App\Mail\NotifikasiVerifikasiKost;
use App\Models\Kost;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;

class VerifikasiController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');

        // Inisialisasi query builder
        $query = Kost::with('verifikasi', 'user');

        // Tambahkan pencarian jika ada keyword
        if (!empty($search)) {
            $keywords = explode(' ', $search);

            $query->whereHas('user', function ($q) use ($keywords) {
                foreach ($keywords as $word) {
                    $q->where(function ($subQuery) use ($word) {
                        $subQuery->where('name', 'like', "%$word%")
                            ->orWhere('email', 'like', "%$word%")
                            ->orWhere('phone', 'like', "%$word%")
                            ->orWhere('nama', 'like', "%$word%")
                            ->orWhere('location', 'like', "%$word%")
                            ->orWhere('alamat', 'like', "%$word%");
                    });
                }
            });
        }

        // Eksekusi query dengan urutan terbaru
        $kosts = $query->orderBy('created_at', 'desc')->get();

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
