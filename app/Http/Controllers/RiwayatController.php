<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Models\Riwayat;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class RiwayatController extends Controller
{

    public function index()
    {
        $riwayatBookings = Riwayat::where('user_id', auth()->id()) // Hanya riwayat milik pengguna yang login
            ->with('kost') // Ambil relasi ke model Kost
            ->latest() // Urutkan berdasarkan waktu terbaru
            ->get();

        return view('admin.riwayat.index', compact('riwayatBookings'));
    }

    public function show($id)
    {
        $riwayat = Riwayat::where('user_id', auth()->id()) // Pastikan hanya pengguna terkait yang dapat melihat
            ->with('kost')
            ->findOrFail($id);

        // Bersihkan dan konversi harga ke integer
        $harga = (int) preg_replace('/[^0-9]/', '', $riwayat->kost->harga);
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

        $pembayaran = Pembayaran::where('user_id', auth()->id())
            ->findOrFail($id);
        $pembayaran->transaksi_id = $midtransToken;
        $pembayaran->save();

        return view('admin.riwayat.show', compact('riwayat', 'midtransToken', 'pembayaran'));
    }

    public function bayar($id)
    {

        $riwayat = Riwayat::find($id);

        $riwayat->status_pembayaran = "Berhasil";
        $riwayat->save();


        return json_encode([
            "berhasil" => true
        ]);
    }
}
