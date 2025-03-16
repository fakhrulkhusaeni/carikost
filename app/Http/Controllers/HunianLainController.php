<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HunianLain;
use Illuminate\Support\Facades\Storage;


class HunianLainController extends Controller
{
    // Menampilkan daftar data hunian
    public function index()
    {
        $hunians = HunianLain::all();
        return view('admin.hunian_lain.index', compact('hunians'));
    }

    // Form untuk membuat hunian baru
    public function create()
    {
        return view('admin.hunian_lain.create');
    }

    // Menyimpan hunian baru ke database
    public function store(Request $request)
    {
        // Validasi input dari pengguna
        $validated = $request->validate([
            'nama_pemilik' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tipe_hunian' => 'required|string',
            'harga' => 'required|numeric',
            'status' => 'required|string',
            'location' => 'required|string',
            'alamat' => 'required|string',
            'telepon' => 'required|numeric',
            'status_verifikasi' => 'nullable|string',
            'fasilitas' => 'nullable|array',
            'fasilitas.*' => 'string|max:255', // Setiap item dalam array harus berupa string maksimal 255 karakter
            'detail_hunian' => 'nullable|array',
            'detail_hunian.*' => 'string|max:255', // Setiap item dalam array harus berupa string maksimal 255 karakter
            'foto' => 'nullable|array',
            'foto.*' => 'image|mimes:jpeg,png,jpg|max:2048', // Validasi untuk foto (gambar dengan ukuran maksimum 2MB)
        ]);

        // Menyimpan data hunian
        $hunian = new HunianLain($validated);

        // Menyimpan foto hunian
        if ($request->hasFile('foto')) {
            $fotoPaths = [];
            foreach ($request->file('foto') as $file) {
                $path = $file->store('hunian_lain_foto', 'public');
                $fotoPaths[] = $path;
            }
            $hunian->foto = json_encode($fotoPaths); // Menyimpan foto dalam format JSON
        }

        $hunian->save();

        // Redirect ke halaman daftar hunian dengan pesan sukses
        return redirect()->route('admin.hunian_lain.index')->with('success', 'Data hunian berhasil ditambahkan.');
    }



    // Menampilkan detail hunian
    public function show(HunianLain $hunianLain)
    {
        return view('admin.hunian_lain.show', compact('hunianLain'));
    }

    // Form untuk mengedit hunian
    public function edit(HunianLain $hunianLain)
    {
        return view('admin.hunian_lain.edit', compact('hunianLain'));
    }

    // Mengupdate hunian di database
    public function update(Request $request, HunianLain $hunianLain)
    {
        // Validasi input dari pengguna
        $validated = $request->validate([
            'nama_pemilik' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tipe_hunian' => 'required|string',
            'harga' => 'required|numeric',
            'status' => 'required|string',
            'location' => 'required|string',
            'alamat' => 'required|string',
            'telepon' => 'required|numeric',
            'status_verifikasi' => 'nullable|string',
            'fasilitas' => 'nullable|array',
            'fasilitas.*' => 'string|max:255', // Setiap item dalam array harus berupa string maksimal 255 karakter
            'detail_hunian' => 'nullable|array',
            'detail_hunian.*' => 'string|max:255', // Setiap item dalam array harus berupa string maksimal 255 karakter
            'foto' => 'nullable|array',
            'foto.*' => 'image|mimes:jpeg,png,jpg|max:2048', // Validasi untuk foto (gambar dengan ukuran maksimum 2MB)
        ]);

        $data = $validated;

        // Menghapus foto lama dan menyimpan foto baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($hunianLain->foto) {
                $oldPhotos = json_decode($hunianLain->foto, true);
                foreach ($oldPhotos as $photo) {
                    Storage::disk('public')->delete($photo);
                }
            }

            // Simpan foto baru
            $fotoPaths = [];
            foreach ($request->file('foto') as $file) {
                $path = $file->store('hunian_lain_foto', 'public');
                $fotoPaths[] = $path;
            }
            $data['foto'] = json_encode($fotoPaths);
        }

        // Update data hunian
        $hunianLain->update($data);

        return redirect()->route('admin.hunian_lain.index')->with('success', 'Data hunian berhasil diperbarui.');
    }


    // Menghapus hunian
    public function destroy(HunianLain $hunianLain)
    {
        $hunianLain->delete();

        return redirect()->route('admin.hunian_lain.index')->with('success', 'Data hunian berhasil dihapus.');
    }
}
