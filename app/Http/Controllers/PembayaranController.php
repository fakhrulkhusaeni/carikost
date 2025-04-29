<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use App\Models\Riwayat;
use App\Models\Pembayaran;
use GuzzleHttp\Client;
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
        })
            ->orderBy('tanggal_booking', 'asc')
            ->get();

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
            'kartu_identitas' => 'required|file|mimes:jpeg,png,pdf|max:2048',
        ]);

        // Ambil data kost
        $kost = Kost::findOrFail($validated['kost_id']);

        // Cek apakah kamar masih tersedia
        if ($kost->sisaKamar() <= 0) {
            return redirect()->back()->with('error', 'Maaf, semua kamar sudah penuh.');
        }

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

        $kost = Kost::find($validated['kost_id']);

        // Bersihkan dan konversi harga ke integer
        $harga = (int) preg_replace('/[^0-9]/', '', $kost->harga);
        $margin = 0;
        $totalHarga = $harga + $margin;

        // Buat array data body
        $body = [
            'transaction_details' => [
                'order_id' => (string) time(),
                'gross_amount' => $totalHarga,
            ],
            'credit_card' => [
                'secure' => true,
            ],
        ];

        $client = new Client();
        $response = $client->request('POST', env("MIDTRANS_ENDPOINT"), [
            'body' => json_encode($body),
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Basic ' . base64_encode(env("MIDTRANS_SERVER_KEY") . ":"),
                'content-type' => 'application/json',
            ],
        ]);

        $midtransToken = json_decode($response->getBody())->token;

        // Simpan data pembayaran
        Pembayaran::create([
            'kost_id' => $validated['kost_id'],
            'user_id' => auth()->id(),
            'tanggal_booking' => $validated['tanggal_booking'],
            'status_konfirmasi' => 'Pending',
            'kartu_identitas' => $kartuIdentitasPath,
            'transaksi_id' =>  $midtransToken,
        ]);

        // Simpan data riwayat
        Riwayat::create([
            'kost_id' => $validated['kost_id'],
            'user_id' => auth()->id(),
            'tanggal_booking' => $validated['tanggal_booking'],
            'status_konfirmasi' => 'Pending',
            'status_pembayaran' => 'Pending',
            'kartu_identitas' => $kartuIdentitasPath,
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
            'status_konfirmasi' => 'Disetujui',
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
            'status_konfirmasi' => 'Ditolak',
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
