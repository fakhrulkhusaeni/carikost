<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kost;
use App\Models\Pembayaran;
use App\Models\Rating;
use App\Models\Hunian;
use App\Models\Facility;
use App\Models\HunianLain;
use App\Models\Riwayat;

class FrontController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Query semua kost terverifikasi, lengkap dengan rata-rata rating dan kamar tersedia
        $query = Kost::withAvg('ratings', 'rating')
            ->whereHas('verifikasi', fn($q) => $q->where('status_verifikasi', 'terverifikasi'))
            ->tersedia();

        // Filter pencarian
        if (!empty($search)) {
            $keywords = explode(' ', $search);

            $query->where(function ($q) use ($keywords) {
                foreach ($keywords as $word) {
                    $q->where(function ($subQuery) use ($word) {
                        $subQuery->where('nama', 'like', "%$word%")
                            ->orWhere('location', 'like', "%$word%")
                            ->orWhere('type', 'like', "%$word%")
                            ->orWhere('alamat', 'like', "%$word%")
                            ->orWhere('facilities', 'like', "%$word%")
                            ->orWhere('rules', 'like', "%$word%")
                            ->orWhere('deskripsi', 'like', "%$word%");
                    });
                }
            });
        }

        // Ambil data dan urutkan berdasarkan rata-rata rating
        $kosts = $query->orderByDesc('ratings_avg_rating')->paginate(9);

        $kosts = $query->orderByDesc('ratings_avg_rating')->paginate(9);

        // Hitung rating gabungan dari semua kost dalam satu hunian
        $kosts->getCollection()->transform(function ($kost) {
            $allRatings = \App\Models\Rating::whereIn('kost_id', function ($query) use ($kost) {
                $query->select('id')
                    ->from('kosts')
                    ->where('hunian_id', $kost->hunian_id);
            })->pluck('rating');

            $avgRating = $allRatings->avg();
            $kost->combined_avg_rating = $avgRating ?? 0;
            return $kost;
        });


        $totalKamarPerHunian = Kost::selectRaw('hunian_id, SUM(jumlah_kamar) as total')
            ->groupBy('hunian_id')
            ->pluck('total', 'hunian_id');

        return view('frontend.index', compact('kosts', 'search', 'totalKamarPerHunian'));
    }


    public function rekomendasi(Request $request)
    {
        // Ambil input user
        $location = $request->input('location');
        $type = $request->input('type');
        $hargaInput = $this->convertHargaToNumber($request->input('harga'));
        $facilities = $request->input('facilities', []);
        $kriteriaOrder = $request->input('kriteria', []);

        // Ambil lokasi user (latitude & longitude dari hunian milik user)
        $hunianUser = Hunian::where('user_id', auth()->id())->first();
        $userLat = $hunianUser->latitude ?? 0;
        $userLng = $hunianUser->longitude ?? 0;

        // Bobot otomatis berdasarkan urutan
        $defaultWeights = [0.4, 0.3, 0.2, 0.1];
        $weights = [];
        foreach ($kriteriaOrder as $index => $kriteria) {
            $weights[$kriteria] = $defaultWeights[$index] ?? 0;
        }

        // Ambil semua kost yang terverifikasi dan masih ada kamar
        $kosts = Kost::with('verifikasi')
            ->whereHas('verifikasi', fn($q) => $q->where('status_verifikasi', 'terverifikasi'))
            ->get()
            ->filter(fn($kost) => $kost->sisaKamar() > 0);

        // Konversi harga dan tipe untuk normalisasi
        $hargaList = $kosts->map(fn($kost) => $this->convertHargaToNumber($kost->harga))->filter()->values();
        $hargaMin = $hargaList->min();

        $typeMapping = ['Kontrakan' => 1, 'Campur' => 2, 'Putri' => 3, 'Putra' => 4];
        $typeMax = max($typeMapping);

        // Hitung skor masing-masing kost
        $kosts = $kosts->map(function ($kost) use ($userLat, $userLng, $type, $hargaMin, $facilities, $weights, $typeMapping, $typeMax) {
            // Lokasi - hitung jarak (semakin dekat semakin baik)
            $jarak = $this->hitungJarak($userLat, $userLng, $kost->latitude, $kost->longitude);
            $locationScore = ($jarak > 0) ? 1 / $jarak : 1; // Benefit (semakin dekat semakin tinggi)

            // Tipe
            $kostTypeValue = $typeMapping[$kost->type] ?? 0;
            $typeScore = ($typeMax > 0) ? ($kostTypeValue / $typeMax) : 0;

            // Harga
            $kostHarga = $this->convertHargaToNumber($kost->harga);
            $hargaScore = ($kostHarga > 0) ? ($hargaMin / $kostHarga) : 0;

            // Fasilitas
            $kostFacilities = is_string($kost->facilities) ? json_decode($kost->facilities, true) : (array) $kost->facilities;
            $matched = collect($facilities)->intersect($kostFacilities)->count();
            $facilityScore = (count($facilities) > 0) ? $matched / count($facilities) : 0;

            // Total skor (SAW)
            $totalScore = 0;
            $totalScore += ($weights['location'] ?? 0) * $locationScore;
            $totalScore += ($weights['type'] ?? 0) * $typeScore;
            $totalScore += ($weights['harga'] ?? 0) * $hargaScore;
            $totalScore += ($weights['facilities'] ?? 0) * $facilityScore;

            $kost->bobotScore = round($totalScore * 100, 2);
            return $kost;
        });

        // Urutkan berdasarkan skor tertinggi
        $kosts = $kosts->sortByDesc('bobotScore')->values();

        $totalKamarPerHunian = Kost::selectRaw('hunian_id, SUM(jumlah_kamar) as total')
            ->groupBy('hunian_id')
            ->pluck('total', 'hunian_id');

        $availableFacilities = Facility::pluck('nama_fasilitas')->toArray();

        return view('frontend.rekomendasi', compact('kosts', 'facilities', 'kriteriaOrder', 'totalKamarPerHunian', 'availableFacilities'));
    }


    private function hitungJarak($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // km

        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;

        $a = sin($dlat / 2) ** 2 + cos($lat1) * cos($lat2) * sin($dlon / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
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
            $keywords = explode(' ', $search);

            $query->where(function ($q) use ($keywords) {
                foreach ($keywords as $word) {
                    $q->where(function ($subQuery) use ($word) {
                        $subQuery->where('location', 'like', "%$word%")
                            ->orWhere('tipe_hunian', 'like', "%$word%")
                            ->orWhere('alamat', 'like', "%$word%")
                            ->orWhere('status', 'like', "%$word%")
                            ->orWhere('fasilitas', 'like', "%$word%")
                            ->orWhere('detail_hunian', 'like', "%$word%")
                            ->orWhere('deskripsi', 'like', "%$word%");
                    });
                }
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

    public function detail_kamar($id)
    {
        $kosts = Kost::withAvg('ratings', 'rating')
                    ->where('hunian_id', $id)
                    ->get(); // Ambil semua kamar berdasarkan hunian_id dan sertakan rata-rata rating

        return view('frontend.detail_kamar', compact('kosts'));
    }
    

    public function detail($id)
    {
        $kost = Kost::with('user')->findOrFail($id);

        $userHasBooked = auth()->check() && $c = Riwayat::where('kost_id', $kost->id)
            ->where('user_id', auth()->id())
            ->where('tanggal_keluar', null)
            ->where('status_konfirmasi', '!=', 'Ditolak')
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

    public function kebijakan_privasi()
    {
        return view('frontend.kebijakan_privasi');
    }

    public function syarat_ketentuan()
    {
        return view('frontend.syarat_ketentuan');
    }
}
