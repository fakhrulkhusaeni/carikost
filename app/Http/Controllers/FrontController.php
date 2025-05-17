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

        // Query semua kost terverifikasi, lengkap dengan rata-rata rating
        $query = Kost::withAvg('ratings', 'rating')
            ->whereHas('verifikasi', function ($query) {
                $query->where('status_verifikasi', 'terverifikasi');
            });

        // Filter pencarian jika ada
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('location', 'like', '%' . $search . '%')
                    ->orWhere('type', 'like', '%' . $search . '%');
            });
        }

        // Ambil data dan urutkan berdasarkan rata-rata rating
        $kosts = $query->orderByDesc('ratings_avg_rating')->paginate(9);

        return view('frontend.index', compact('kosts', 'search'));
    }
    

    public function rekomendasi(Request $request)
    {
        $location = $request->input('location');
        $type = $request->input('type');
        $hargaInput = $this->convertHargaToNumber($request->input('harga'));
        $facilities = $request->input('facilities', []);

        // Ambil hanya kost yang sudah diverifikasi
        $kosts = Kost::with('verifikasi')
            ->whereHas('verifikasi', fn($q) => $q->where('status_verifikasi', 'terverifikasi'))
            ->get();

        // Bobot untuk tiap kriteria
        $weights = [
            'location' => 0.3,
            'type' => 0.2,
            'harga' => 0.3,
            'facilities' => 0.2,
        ];

        // Hitung skor untuk tiap kost
        $kosts = $kosts->map(function ($kost) use ($location, $type, $hargaInput, $facilities, $weights) {
            $score = 0;

            // Kesesuaian lokasi
            if ($location && $kost->location == $location) {
                $score += $weights['location'] * 100;
            }

            // Kesesuaian tipe
            if ($type && $kost->type == $type) {
                $score += $weights['type'] * 100;
            }

            // Skor harga berdasarkan kedekatan nilai
            if ($hargaInput > 0) {
                $kostHarga = $this->convertHargaToNumber($kost->harga);
                $maxDiff = $hargaInput * 0.3; // toleransi 30%
                $diff = abs($kostHarga - $hargaInput);
                $hargaScore = $maxDiff > 0 ? max(0, 100 - ($diff / $maxDiff * 100)) : 0;
                $score += $weights['harga'] * $hargaScore;
            }

            // Skor fasilitas berdasarkan kemiripan
            $kostFacilities = is_string($kost->facilities) ? json_decode($kost->facilities, true) : (array) $kost->facilities;
            if (!empty($facilities) && is_array($kostFacilities)) {
                $matched = collect($facilities)->intersect($kostFacilities)->count();
                $facilityScore = count($facilities) > 0 ? ($matched / count($facilities)) * 100 : 0;
                $score += $weights['facilities'] * $facilityScore;
            }

            $kost->bobotScore = round($score, 2);
            return $kost;
        });

        // Urutkan berdasarkan skor tertinggi
        $kosts = $kosts->filter(fn($kost) => $kost->bobotScore > 0)
            ->sortByDesc('bobotScore')
            ->values();

        return view('frontend.rekomendasi', compact('kosts', 'facilities'));
    }

    // Mengubah harga string jadi angka
    private function convertHargaToNumber($harga)
    {
        $harga = str_replace(['Rp', '.', ',', ' '], '', $harga);
        return is_numeric($harga) ? floatval($harga) : 0;
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

        $hunians = $query->paginate(9);

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

        return view('frontend.detail', compact('kost', 'userHasBooked', 'averageRating', 'totalRatings', 'distribution'));
    }
}
