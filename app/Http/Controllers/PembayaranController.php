<?php

namespace App\Http\Controllers;

use App\Models\Riwayat;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembayarans = Pembayaran::whereHas('kost', function ($query) {
            $query->where('user_id', auth()->user()->id);
        })->get();
        return view('admin.pembayaran.index', compact('pembayarans'));
    }

    public function store(Request $request)
    {
        // Memastikan hanya pengguna dengan peran 'pencari_kost' yang bisa booking
        if (!auth()->user()->hasRole('pencari_kost')) {
            return redirect()->back()->with('error', 'Hanya pencari kost yang bisa melakukan booking!');
        }

        $validated = $request->validate([
            'tanggal_booking' => 'required|date',
            'kost_id' => 'required|exists:kosts,id',
            'kartu_identitas' => 'required|file|mimes:jpeg,png,pdf|max:2048', // Validasi file
        ]);

        // Cek apakah pengguna sudah booking kost ini
        $existingBooking = Pembayaran::where('kost_id', $validated['kost_id'])
            ->where('user_id', auth()->id())
            ->exists();

        if ($existingBooking) {
            return redirect()->back()->with('error', 'Anda sudah pernah booking kost ini.');
        }

        // Simpan file kartu identitas
        if ($request->hasFile('kartu_identitas')) {
            $kartuIdentitasPath = $request->file('kartu_identitas')->store('kartu_identitas', 'public');
        } else {
            return redirect()->back()->with('error', 'Kartu identitas wajib diunggah.');
        }

        // Simpan data pembayaran
        $pembayaran = Pembayaran::create([
            'kost_id' => $validated['kost_id'],
            'user_id' => auth()->id(),
            'tanggal_booking' => $validated['tanggal_booking'],
            'status' => 'Pending',
            'kartu_identitas' => $kartuIdentitasPath, // Tambahkan kartu identitas ke pembayaran
        ]);

        // Simpan data riwayat termasuk kartu identitas
        Riwayat::create([
            'kost_id' => $validated['kost_id'],
            'user_id' => auth()->id(),
            'tanggal_booking' => $validated['tanggal_booking'],
            'status_konfirmasi' => 'Pending',
            'status_pembayaran' => 'Pending',
            'kartu_identitas' => $kartuIdentitasPath, // Simpan path kartu identitas di riwayat
        ]);

        return redirect()->back()->with('success', 'Booking berhasil diajukan!');
    }



    public function show($id)
    {
        $pembayaran = Pembayaran::with('kost', 'user') // Memuat relasi dengan kost dan user
            ->findOrFail($id);

        return view('admin.pembayaran.show', compact('pembayaran'));
    }

    public function approve($id)
    {
        // Menemukan pembayaran berdasarkan ID
        $pembayaran = Pembayaran::findOrFail($id);

        // Pastikan hanya pemilik kost yang dapat mengonfirmasi
        if ($pembayaran->kost->user_id != auth()->user()->id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengonfirmasi pembayaran ini.');
        }

        // Update status pembayaran menjadi Disetujui
        $pembayaran->update([
            'status' => 'Disetujui',
        ]);

        // Update riwayat konfirmasi
        $riwayat = Riwayat::where('kost_id', $pembayaran->kost_id)
            ->where('user_id', $pembayaran->user_id)
            ->where('tanggal_booking', $pembayaran->tanggal_booking)
            ->first();

        if ($riwayat) {
            $riwayat->update([
                'status_konfirmasi' => 'Disetujui',
            ]);
        }

        return redirect()->route('admin.pembayaran.index')->with('success', 'Pembayaran telah disetujui.');
    }

    public function reject($id)
    {
        // Menemukan pembayaran berdasarkan ID
        $pembayaran = Pembayaran::findOrFail($id);

        // Pastikan hanya pemilik kost yang dapat menolak
        if ($pembayaran->kost->user_id != auth()->user()->id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menolak pembayaran ini.');
        }

        // Update status pembayaran menjadi Ditolak
        $pembayaran->update([
            'status' => 'Ditolak',
        ]);

        // Update riwayat konfirmasi
        $riwayat = Riwayat::where('kost_id', $pembayaran->kost_id)
            ->where('user_id', $pembayaran->user_id)
            ->where('tanggal_booking', $pembayaran->tanggal_booking)
            ->first();

        if ($riwayat) {
            $riwayat->update([
                'status_konfirmasi' => 'Ditolak',
            ]);
        }

        return redirect()->route('admin.pembayaran.index')->with('error', 'Pembayaran telah ditolak.');
    }
}
