<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kost;
use App\Models\Pembayaran;
use App\Models\Rating;

use App\Models\HunianLain;


class FrontController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Membuat query untuk kost dan memeriksa status verifikasi
        $query = Kost::withCount('ratings')
            ->withAvg('ratings', 'rating')
            ->whereHas('verifikasi', function ($query) {
                $query->where('status_verifikasi', 'terverifikasi'); // Pastikan hanya yang terverifikasi
            });
            
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('location', 'like', '%' . $search . '%')
                    ->orWhere('type', 'like', '%' . $search . '%');
            });
        }

        // Ambil semua data kost, baik yang punya rating maupun tidak
        $allKosts = $query->get();

        // Hitung rata-rata global rating hanya dari yang punya rating
        $C = $allKosts->where('ratings_count', '>', 0)->avg('ratings_avg_rating') ?? 0;
        $m = 5;

        $kosts = $allKosts->map(function ($kost) use ($C, $m) {
            $v = $kost->ratings_count;
            $R = $kost->ratings_avg_rating ?? 0;

            $weightedRating = ($v > 0) ? (($v / ($v + $m)) * $R + ($m / ($v + $m)) * $C) : 0;
            $kost->weightedRating = $weightedRating;

            return $kost;
        });

        $kosts = $kosts->sortByDesc('weightedRating')->values();

        return view('frontend.index', compact('kosts', 'search'));
    }


    public function rekomendasi(Request $request)
    {
        $location = $request->input('location');
        $type = $request->input('type');
        $hargaInput = $request->input('harga'); // Ini harga dari input manual
        $facilities = $request->input('facilities', []);

        // Mengambil semua data kost
        $kosts = Kost::all();

        // Bobot untuk masing-masing kriteria
        $weights = [
            'location' => 0.3,
            'type' => 0.1,
            'harga' => 0.4,
            'facilities' => 0.2,
        ];

        $kosts = $kosts->map(function ($kost) use ($location, $type, $hargaInput, $facilities, $weights) {
            $score = 0;

            if ($location && $kost->location == $location) {
                $score += $weights['location'] * 100;
            }

            if ($type && $kost->type == $type) {
                $score += $weights['type'] * 100;
            }

            if ($hargaInput) {
                // Mengonversi harga input menjadi float
                $hargaInput = $this->convertHargaToNumber($hargaInput);

                // Mengonversi harga dari kost menjadi float
                $kostHarga = $this->convertHargaToNumber($kost->harga);

                // Toleransi dinamis dari harga input
                $toleransiPersentase = 0.4;
                $maxSelisih = $hargaInput * $toleransiPersentase;

                $selisih = abs($kostHarga - $hargaInput);

                // Hitung skor harga berdasarkan kedekatan
                $hargaScore = $maxSelisih > 0 ? max(0, 100 - ($selisih / $maxSelisih * 100)) : 0;
                $score += $weights['harga'] * $hargaScore;
            }

            // Menangani fasilitas
            $kostFacilities = is_string($kost->facilities) ? json_decode($kost->facilities, true) : (array) $kost->facilities;
            if (!empty($facilities) && is_array($kostFacilities)) {
                $matchingFacilities = collect($facilities)->intersect($kostFacilities)->count();
                $totalFacilities = count($facilities);

                if ($totalFacilities > 0) {
                    $facilityScore = ($matchingFacilities / $totalFacilities) * 100;
                    $score += $weights['facilities'] * $facilityScore;
                }
            }

            // Menyimpan skor ke objek kost
            $kost->bobotScore = $score;
            return $kost;
        });

        // Memfilter dan mengurutkan kost berdasarkan skor tertinggi
        $kosts = $kosts->filter(function ($kost) {
            return $kost->bobotScore > 0;
        })->sortByDesc('bobotScore')->values();

        return view('frontend.rekomendasi', compact('kosts', 'facilities'));
    }

    // Fungsi untuk mengonversi harga menjadi angka (menghapus simbol dan titik)
    private function convertHargaToNumber($harga)
    {
        // Menghapus "Rp" dan titik, lalu mengonversi ke float
        $harga = str_replace(['Rp', '.'], '', $harga);
        return floatval($harga);
    }


    public function formulir()
    {
        return view('frontend.formulir');
    }


    public function hunian_lain(Request $request)
    {
        $search = $request->input('search');

        $query = HunianLain::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('location', 'like', '%' . $search . '%')
                    ->orWhere('tipe_hunian', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%');
            });
        }

        $hunians = $query->get();

        return view('frontend.hunian_lain', compact('hunians'));
    }


    public function detail_hunianlain($id)
    {
        $hunianLain = HunianLain::findOrFail($id); // Mengambil data berdasarkan ID
        return view('frontend.detail_hunianlain', compact('hunianLain'));
    }


    public function promosi()
    {
        return view('frontend.promosi');
    }

    public function request()
    {
        return view('frontend.request');
    }

    public function detail($id)
    {
        $kost = Kost::with('user')->findOrFail($id);

        $userHasBooked = auth()->check() && Pembayaran::where('kost_id', $kost->id)
            ->where('user_id', auth()->id())
            ->exists();

        $ratings = Rating::where('kost_id', $kost->id)->get();
        $totalRatings = $ratings->count();

        if ($totalRatings > 0) {
            $averageRating = $ratings->avg('rating');
            $distribution = [
                '5' => $ratings->where('rating', 5)->count(),
                '4' => $ratings->where('rating', 4)->count(),
                '3' => $ratings->where('rating', 3)->count(),
                '2' => $ratings->where('rating', 2)->count(),
                '1' => $ratings->where('rating', 1)->count(),
            ];
        } else {
            $averageRating = 0;
            $distribution = ['5' => 0, '4' => 0, '3' => 0, '2' => 0, '1' => 0];
        }

        // Ambil rata-rata rating global (C) dari semua kost yang memiliki rating
        $ratedKosts = Kost::whereHas('ratings')->withAvg('ratings', 'rating')->get();
        $C = $ratedKosts->avg('ratings_avg_rating') ?? 0;
        $m = 5;
        $v = $totalRatings;
        $R = $averageRating;

        // Hitung Weighted Rating dengan formula IMDB
        $weightedRating = ($v > 0) ? (($v / ($v + $m)) * $R + ($m / ($v + $m)) * $C) : 0;

        return view('frontend.detail', compact('kost', 'userHasBooked', 'averageRating', 'totalRatings', 'distribution', 'weightedRating'));
    }
}
