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
        $location = $request->input('location');
        $type = $request->input('type');
        $harga = $request->input('harga');
        $facilities = $request->input('facilities', []);

        $query = Kost::withCount('ratings')->withAvg('ratings', 'rating');

        // Bobot untuk masing-masing kriteria
        $bobotLokasi = 0.3;
        $bobotHarga = 0.2;
        $bobotTipe = 0.2;
        $bobotFasilitas = 0.3;

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

        // Hitung rata-rata rating global (C) dari semua kost yang memiliki rating
        $ratedKosts = Kost::whereHas('ratings')->withAvg('ratings', 'rating')->get();
        $C = $ratedKosts->avg('ratings_avg_rating') ?? 0;
        $m = 5; // Minimum jumlah review agar diperhitungkan

        $kosts = $kosts->map(function ($kost) use ($C, $m, $location, $type, $harga, $facilities, $bobotLokasi, $bobotHarga, $bobotTipe, $bobotFasilitas) {
            $v = $kost->ratings_count;
            $R = $kost->ratings_avg_rating ?? 0;

            // Hitung Weighted Rating dengan formula IMDB
            $weightedRating = ($v > 0) ? (($v / ($v + $m)) * $R + ($m / ($v + $m)) * $C) : 0;

            // Hitung skor berbobot
            $score = 0;

            // Bobot lokasi
            if (!empty($location) && $kost->location == $location) {
                $score += $bobotLokasi * 100;
            }

            // Bobot tipe
            if (!empty($type) && $kost->type == $type) {
                $score += $bobotTipe * 100;
            }

            // Bobot harga
            if (!empty($harga)) {
                if ($harga == 'murah' && $kost->harga < 1000000) {
                    $score += $bobotHarga * 100;
                } elseif ($harga == 'mahal' && $kost->harga >= 1000000) {
                    $score += $bobotHarga * 100;
                }
            }

            // Bobot fasilitas
            $matchingFacilities = 0;

            if (!empty($facilities) && is_array($facilities)) {
                // Pastikan data fasilitas dari database didekode dengan aman
                $kostFacilities = is_string($kost->facilities) ? json_decode($kost->facilities, true) : (is_array($kost->facilities) ? $kost->facilities : []);

                if (!empty($kostFacilities) && is_array($kostFacilities)) {
                    foreach ($facilities as $facility) {
                        if (!empty($facility) && in_array($facility, $kostFacilities)) {
                            $matchingFacilities++;
                        }
                    }
                }

                $totalFacilities = count($facilities);
                if ($totalFacilities > 0) {
                    $score += $bobotFasilitas * (100 * ($matchingFacilities / $totalFacilities));
                }
            }

            // Gabungkan Weighted Rating dan skor berbobot
            $kost->finalScore = (0.5 * $weightedRating) + (0.5 * $score);

            return $kost;
        });

        // Urutkan berdasarkan skor tertinggi
        $kosts = $kosts->sortByDesc('finalScore')->values();

        return view('frontend.index', compact('kosts', 'facilities'));
    }


    public function formulir()
    {
        return view('frontend.formulir');
    }


    public function hunian_lain(Request $request)
    {

        $location = $request->input('location');
        $tipe_hunian = $request->input('tipe_hunian');
        $status = $request->input('status');
        $harga = $request->input('harga');

        $query = HunianLain::query();

        if (!empty($location)) {
            $query->where('location', $location);
        }

        if (!empty($tipe_hunian)) {
            $query->where('tipe_hunian', $tipe_hunian);
        }

        if (!empty($status)) {
            $query->where('status', $status);
        }

        if (!empty($harga)) {
            if ($harga == 'murah') {
                $query->where('harga', '<', 1000000)->orderBy('harga', 'asc');
            } elseif ($harga == 'mahal') {
                $query->where('harga', '>=', 1000000)->orderBy('harga', 'desc');
            }
        }

        // Ambil data hunian
        $hunians = $query->get();

        // **Bobot Kriteria** (Total 1.0)
        $bobotLokasi = 0.30;  
        $bobotTipe = 0.25;    
        $bobotStatus = 0.20;  
        $bobotHarga = 0.25;   

        // Hitung Weighted Score untuk setiap hunian
        $hunians = $hunians->map(function ($hunian) use ($bobotLokasi, $bobotTipe, $bobotStatus, $bobotHarga, $location, $tipe_hunian, $status, $harga) {
            // Skor lokasi
            $lokasiScore = (!empty($location) && $hunian->location == $location) ? 1 : 0;

            // Skor tipe hunian
            $tipeScore = (!empty($tipe_hunian) && $hunian->tipe_hunian == $tipe_hunian) ? 1 : 0;

            // Skor status hunian
            $statusScore = (!empty($status) && $hunian->status == $status) ? 1 : 0;

            // Skor harga (murah lebih baik, dibalik)
            $hargaScore = (!empty($harga) && $harga == 'murah') ? 1 : 0;
            $hargaScore = (!empty($harga) && $harga == 'mahal') ? 0 : $hargaScore;

            // Hitung Total Weighted Score
            $hunian->weightedScore =
                ($lokasiScore * $bobotLokasi) +
                ($tipeScore * $bobotTipe) +
                ($statusScore * $bobotStatus) +
                ($hargaScore * $bobotHarga);

            return $hunian;
        });

        // Urutkan berdasarkan skor tertinggi
        $hunians = $hunians->sortByDesc('weightedScore')->values();

        // Kembalikan hasil pencarian ke view
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
