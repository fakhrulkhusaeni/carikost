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

        $query = Kost::withCount('ratings')->withAvg('ratings', 'rating');

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
        $harga = $request->input('harga');
        $facilities = $request->input('facilities', []);

        $query = Kost::query();

        // Filter berdasarkan input
        if (!empty($location)) {
            $query->where('location', $location);
        }

        if (!empty($type)) {
            $query->where('type', $type);
        }

        if (!empty($harga)) {
            if ($harga == 'murah') {
                $query->where('harga', '<', 1000000)->orderBy('harga', 'asc');
            } elseif ($harga == 'mahal') {
                $query->where('harga', '>=', 1000000)->orderBy('harga', 'desc');
            }
        }

        if (!empty($facilities)) {
            $query->where(function ($q) use ($facilities) {
                foreach ($facilities as $facility) {
                    if (!empty($facility)) {
                        $q->orWhereJsonContains('facilities', $facility);
                    }
                }
            });
        }

        $kosts = $query->get();

        // Bobot kriteria
        $bobotLokasi = 0.3;
        $bobotHarga = 0.2;
        $bobotTipe = 0.2;
        $bobotFasilitas = 0.3;

        $kosts = $kosts->map(function ($kost) use ($location, $type, $harga, $facilities, $bobotLokasi, $bobotHarga, $bobotTipe, $bobotFasilitas) {
            $score = 0;

            // Lokasi
            if (!empty($location) && $kost->location == $location) {
                $score += $bobotLokasi * 100;
            }

            // Tipe
            if (!empty($type) && $kost->type == $type) {
                $score += $bobotTipe * 100;
            }

            // Harga
            if (!empty($harga)) {
                if ($harga == 'murah' && $kost->harga < 1000000) {
                    $score += $bobotHarga * 100;
                } elseif ($harga == 'mahal' && $kost->harga >= 1000000) {
                    $score += $bobotHarga * 100;
                }
            }

            // Fasilitas
            $matchingFacilities = 0;
            $kostFacilities = is_string($kost->facilities) ? json_decode($kost->facilities, true) : (is_array($kost->facilities) ? $kost->facilities : []);

            if (!empty($facilities) && is_array($kostFacilities)) {
                foreach ($facilities as $facility) {
                    if (!empty($facility) && in_array($facility, $kostFacilities)) {
                        $matchingFacilities++;
                    }
                }

                $totalFacilities = count($facilities);
                if ($totalFacilities > 0) {
                    $score += $bobotFasilitas * (100 * ($matchingFacilities / $totalFacilities));
                }
            }

            $kost->bobotScore = $score;

            return $kost;
        });

        // Urutkan berdasarkan skor berbobot
        $kosts = $kosts->sortByDesc('bobotScore')->values();

        return view('frontend.rekomendasi', compact('kosts', 'facilities'));
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
