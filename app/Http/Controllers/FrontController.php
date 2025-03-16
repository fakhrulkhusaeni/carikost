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
        $location = $request->input('location');
        $type = $request->input('type');
    
        $query = Kost::withCount('ratings')->withAvg('ratings', 'rating');
    
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'LIKE', '%' . $search . '%')
                    ->orWhere('alamat', 'LIKE', '%' . $search . '%')
                    ->orWhere('deskripsi', 'LIKE', '%' . $search . '%')
                    ->orWhere('jumlah_kamar', 'LIKE', '%' . $search . '%')
                    ->orWhere('harga', 'LIKE', '%' . $search . '%')
                    ->orWhere('facilities', 'LIKE', '%' . $search . '%')
                    ->orWhere('rules', 'LIKE', '%' . $search . '%');
            });
        }
    
        if (!empty($location)) {
            $query->where('location', $location);
        }
    
        if (!empty($type)) {
            $query->where('type', $type);
        }
    
        $kosts = $query->get();
    
        // Ambil rata-rata rating global (C) dari semua kost yang memiliki rating
        $ratedKosts = Kost::whereHas('ratings')->withAvg('ratings', 'rating')->get();
        $C = $ratedKosts->avg('ratings_avg_rating') ?? 0;
        $m = 5;
    
        $weights = [
            'harga' => 0.3,
            'facilities' => 0.25,
            'location' => 0.2,
            'rating' => 0.25
        ];
    
        $maxHarga = $kosts->max('harga') ?: 1;
        $maxFasilitas = $kosts->max(fn($kost) => count(is_string($kost->facilities) ? explode(',', $kost->facilities) : (array) $kost->facilities)) ?: 1;
        $maxRating = 5;
    
        $kosts = $kosts->map(function ($kost) use ($C, $m, $weights, $maxHarga, $maxFasilitas, $maxRating, $location) {
            $v = $kost->ratings_count;
            $R = $kost->ratings_avg_rating ?? 0;
    
            // Hitung Weighted Rating dengan formula IMDB
            $kost->weightedRating = ($v > 0) ? (($v / ($v + $m)) * $R + ($m / ($v + $m)) * $C) : 0;
    
            $normalizedHarga = 1 - ($kost->harga / $maxHarga);
    
            // Pastikan facilities adalah string sebelum dipecah
            $facilities = is_string($kost->facilities) ? $kost->facilities : implode(',', (array) $kost->facilities);
            $jumlahFasilitas = count(explode(',', $facilities));
    
            $normalizedFasilitas = $jumlahFasilitas / $maxFasilitas;
            $normalizedLokasi = (!empty($location) && $kost->location === $location) ? 1 : 0;
            $normalizedRating = $kost->weightedRating / $maxRating;
    
            $kost->finalScore = (
                ($normalizedHarga * $weights['harga']) +
                ($normalizedFasilitas * $weights['facilities']) +
                ($normalizedLokasi * $weights['location']) +
                ($normalizedRating * $weights['rating'])
            );
    
            return $kost;
        });
    
        $kosts = $kosts->sortByDesc('finalScore')->values();
    
        return view('frontend.index', compact('kosts'));
    }
    


    public function formulir()
    {
        return view('frontend.formulir');
    }


    public function hunian_lain(Request $request)
    {
        // Ambil data pencarian
        $search = $request->input('search');
        $location = $request->input('location');
        $tipe_hunian = $request->input('tipe_hunian');
        $status = $request->input('status');

        // Mulai query untuk mencari hunian lain
        $query = HunianLain::query();

        // Jika ada pencarian, lakukan filter berdasarkan harga, alamat, fasilitas, atau detail_hunian
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('harga', 'LIKE', '%' . $search . '%')
                    ->orWhere('alamat', 'LIKE', '%' . $search . '%')
                    ->orWhere('deskripsi', 'LIKE', '%' . $search . '%')
                    ->orWhere('fasilitas', 'LIKE', '%' . $search . '%')
                    ->orWhere('detail_hunian', 'LIKE', '%' . $search . '%');
            });
        }

        // Filter berdasarkan lokasi jika dipilih
        if (!empty($location)) {
            $query->where('location', $location);
        }

        // Filter berdasarkan jenis hunian jika dipilih
        if (!empty($tipe_hunian)) {
            $query->where('tipe_hunian', $tipe_hunian);
        }

        // Filter berdasarkan status hunian (dijual/disewakan)
        if (!empty($status)) {
            $query->where('status', $status);
        }

        // Ambil data hunian
        $hunians = $query->get();

        // **Cek jika tidak ada hunian yang ditemukan**
        if ($hunians->isEmpty()) {
            return view('frontend.hunian_lain', compact('hunians'));
        }

        // **Bobot Kriteria** (Total 100%)
        $bobotHarga = 40;     // Harga lebih terjangkau
        $bobotFasilitas = 35; // Fasilitas lengkap
        $bobotLokasi = 25;    // Lokasi strategis

        // **Tentukan nilai rata-rata untuk normalisasi**
        $hargaMax = $hunians->max('harga');
        $hargaMin = $hunians->min('harga');
        $hargaRange = max(1, $hargaMax - $hargaMin); // Cegah pembagian dengan nol

        // Hitung Weighted Score untuk setiap hunian
        $hunians = $hunians->map(function ($hunian) use ($bobotHarga, $bobotFasilitas, $bobotLokasi, $hargaMin, $hargaRange) {
            // Harga lebih murah lebih baik (dibalik)
            $hargaScore = 1 - (($hunian->harga - $hargaMin) / $hargaRange);

            // Cek apakah fasilitas berupa array atau string
            if (is_array($hunian->fasilitas)) {
                $fasilitasScore = count($hunian->fasilitas) / 10;
            } elseif (is_string($hunian->fasilitas)) {
                $fasilitasScore = count(explode(',', $hunian->fasilitas)) / 10;
            } else {
                $fasilitasScore = 0;
            }

            // Jika lokasi tersedia, nilai 1, jika tidak 0
            $lokasiScore = !empty($hunian->location) ? 1 : 0;

            // Hitung Total Weighted Score
            $hunian->weightedScore =
                ($hargaScore * $bobotHarga / 100) +
                ($fasilitasScore * $bobotFasilitas / 100) +
                ($lokasiScore * $bobotLokasi / 100);

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
