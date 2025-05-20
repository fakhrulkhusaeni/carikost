<?php

namespace App\Http\Controllers;

use App\Models\BuktiKepemilikanKost;
use Illuminate\Http\Request;
use App\Models\Kost;
use App\Models\Pembayaran;
use App\Models\Riwayat;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class KostController extends Controller
{
    public function index()
    {
        // Ambil hanya kost milik user yang sedang login, urutkan dari yang terbaru
        $kosts = Kost::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.kost.index', compact('kosts'));
    }


    public function create()
    {
        return view('admin.kost.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'type' => 'required|string',
            'jumlah_kamar' => 'required|integer',
            'location' => 'required|string',
            'alamat' => 'required|string',
            'harga' => 'required|string',
            'facilities' => 'required|array',
            'facilities.*' => 'string|max:255',
            'rules' => 'required|array',
            'rules.*' => 'string|max:255',
            'foto' => 'required|array',
            'foto.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('foto');

        // Tambahkan user_id ke data
        $data['user_id'] = auth()->id();

        if ($request->hasFile('foto')) {
            $fotoPaths = [];
            foreach ($request->file('foto') as $file) {
                $path = $file->store('kosts', 'public');
                $fotoPaths[] = $path;
            }
            $data['foto'] = json_encode($fotoPaths);
        }

        Kost::create($data);

        return redirect()->route('admin.kost.index')->with('success', 'Data kost berhasil ditambahkan.');
    }

    public function show(Kost $kost)
    {
        $bukti = BuktiKepemilikanKost::where('kost_id', $kost->id)->first();

        $sudahUpload = !is_null($bukti);
        $sudahTerverifikasi = $bukti && $bukti->kost->verifikasi->status_verifikasi === 'terverifikasi';

        // Ambil pengguna yang disetujui
        $penghuni = Riwayat::where('kost_id', $kost->id)
            ->where("tanggal_keluar", null)
            ->where('status_konfirmasi', 'Disetujui')
            ->with('user')
            ->get();

        return view('admin.kost.show', compact('kost', 'sudahUpload', 'sudahTerverifikasi', 'bukti', 'penghuni'));
    }

    public function edit(Kost $kost)
    {
        return view('admin.kost.edit', compact('kost'));
    }

    public function update(Request $request, Kost $kost)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'type' => 'required|string',
            'jumlah_kamar' => 'required|integer',
            'location' => 'required|string',
            'alamat' => 'required|string',
            'harga' => 'required|string',
            'facilities' => 'required|array',
            'facilities.*' => 'string|max:255',
            'rules' => 'required|array',
            'rules.*' => 'string|max:255',
            'foto' => 'nullable|array',
            'foto.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'existing_foto' => 'nullable|array',
        ]);

        // Ambil semua data kecuali foto
        $data = $request->except('foto');

        // Ambil foto lama dari input hidden (jika ada)
        $existingFoto = $request->input('existing_foto', []);
        $fotoPaths = $existingFoto;

        // Tambahkan foto baru jika ada
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $path = $file->store('kosts', 'public');
                $fotoPaths[] = $path;
            }
        }

        // Simpan kembali semua foto (lama + baru)
        $data['foto'] = json_encode($fotoPaths);

        $kost->update($data);

        return redirect()->route('admin.kost.index')->with('success', 'Data kost berhasil diperbarui.');
    }

    public function destroy(Kost $kost)
    {
        if ($kost->foto) {
            $oldPhotos = json_decode($kost->foto, true);
            foreach ($oldPhotos as $photo) {
                Storage::disk('public')->delete($photo);
            }
        }

        $kost->delete();

        return redirect()->route('admin.kost.index')->with('success', 'Data kost berhasil dihapus.');
    }

    public function keluar($id)
    {
        $r = Riwayat::findOrFail($id);
        $r->tanggal_keluar = Carbon::now();
        $r->save();
        
        // Ambil semua pembayaran terkait user dan kost
        $pembayaranList = Pembayaran::where('user_id', $r->user_id)
            ->where('kost_id', $r->kost_id)
            ->get();

        foreach ($pembayaranList as $pembayaran) {
            $pembayaran->tanggal_keluar = Carbon::now();
            $pembayaran->save();
        }


        return redirect()->back()->with('success', 'Penghuni telah berhasil dikeluarkan.');
    }
}
