<?php

namespace App\Http\Controllers;

use App\Mail\NotifikasiBuktiPembayaran;
use App\Mail\NotifikasiPembayaranMasuk;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Models\Riwayat;
use App\Models\Rating;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

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
        $durasiText = strtolower($riwayat->durasi_sewa ?? '1 bulan');
        
        // Hitung durasi bulan
        $durasiBulan = match ($durasiText) {
            '1 bulan' => 1,
            '3 bulan' => 3,
            '1 tahun' => 12,
            default => 1,
        };
        
        $hargaDasar = $harga + $margin;
        $diskon = ($durasiText === '1 tahun') ? 0.9 : 1;
        $totalHarga = (int) round($hargaDasar * $durasiBulan * $diskon);        

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

        $existingRating = Rating::where('user_id', auth()->id())
            ->where('kost_id', $riwayat->kost->id)
            ->value('rating');

        return view('admin.riwayat.show', compact('riwayat', 'midtransToken', 'pembayaran', 'existingRating'));
    }

    public function bayar($id)
    {

        $riwayat = Riwayat::with(['user', 'kost.user'])->findOrFail($id);
        $pembayaran = Pembayaran::where("kost_id", $riwayat->kost_id)
        ->where("user_id", $riwayat->user_id)->first();

        $riwayat->status_pembayaran = "Berhasil";
        $riwayat->nominal = $riwayat->kost->harga;
        $riwayat->save();
        
        $pembayaran->status_pembayaran = "Berhasil";
        $pembayaran->nominal = $riwayat->kost->harga;
        $pembayaran->save();

        // Kirim email ke pencari kost
        Mail::to($riwayat->user->email)->send(new NotifikasiBuktiPembayaran($riwayat));

        // Kirim email ke pemilik kost
        Mail::to($riwayat->kost->user->email)->send(new NotifikasiPembayaranMasuk($riwayat));


        return json_encode([
            "berhasil" => true
        ]);
    }
}
