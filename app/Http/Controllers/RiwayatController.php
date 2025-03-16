<?php

namespace App\Http\Controllers;

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

        $harga = (int)$riwayat->kost->harga;
        $margin = 2000;

        $client = new Client();
        $response = $client->request('POST', env("MIDTRANS_ENDPOINT"), [
            'body' => '{"transaction_details":{"order_id":" ' . time() .  '","gross_amount": ' . $harga + $margin . ' },"credit_card":{"secure":true}}',
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Basic ' . base64_encode(env("MIDTRANS_SERVER_KEY") . ":"),
                'content-type' => 'application/json',
            ],
        ]);
        $midtransToken = json_decode($response->getBody())->token;


        return view('admin.riwayat.show', compact('riwayat', 'midtransToken'));
    }
}
