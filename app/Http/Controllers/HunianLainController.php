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
        $hunians = HunianLain::orderBy('created_at', 'desc')->get();
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
            'harga' => 'required|string',
            'status' => 'required|string',
            'location' => 'required|string',
            'alamat' => 'required|string',
            'telepon' => 'required|numeric',
            'status_verifikasi' => 'nullable|string',
            'fasilitas' => 'nullable|array',
            'fasilitas.*' => 'string|max:255',
            'detail_hunian' => 'nullable|array',
            'detail_hunian.*' => 'string|max:255',
            'foto' => 'nullable|array',
            'foto.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'bukti_kepemilikan' => 'nullable|array', // <- array
            'bukti_kepemilikan.*' => 'file|mimes:jpeg,png,jpg,pdf|max:2048', // <- tiap file validasi
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
            $hunian->foto = json_encode($fotoPaths);
        }

        // Menyimpan bukti kepemilikan
        if ($request->hasFile('bukti_kepemilikan')) {
            $buktiPaths = [];
            foreach ($request->file('bukti_kepemilikan') as $file) {
                $path = $file->store('bukti_kepemilikan_hunian_lain', 'public');
                $buktiPaths[] = $path;
            }
            $hunian->bukti_kepemilikan = json_encode($buktiPaths);
        }

        $hunian->save();

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
        $validated = $request->validate([
            'nama_pemilik' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tipe_hunian' => 'required|string',
            'harga' => 'required|string',
            'status' => 'required|string',
            'location' => 'required|string',
            'alamat' => 'required|string',
            'telepon' => 'required|numeric',
            'status_verifikasi' => 'nullable|string',
            'fasilitas' => 'nullable|array',
            'fasilitas.*' => 'string|max:255',
            'detail_hunian' => 'nullable|array',
            'detail_hunian.*' => 'string|max:255',
            'foto' => 'nullable|array',
            'foto.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'bukti_kepemilikan' => 'nullable|array',
            'bukti_kepemilikan.*' => 'file|mimes:jpeg,png,jpg,pdf|max:2048',
            'existing_foto' => 'nullable|array',
            'existing_bukti' => 'nullable|array',
        ]);

        $data = $validated;

        // Simpan foto lama (jika ada) + foto baru
        $existingFoto = $request->input('existing_foto', []);
        $fotoPaths = $existingFoto;

        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $path = $file->store('hunian_lain_foto', 'public');
                $fotoPaths[] = $path;
            }
        }

        $data['foto'] = json_encode($fotoPaths);

        // Simpan bukti kepemilikan lama (jika ada) + yang baru
        $existingBukti = $request->input('existing_bukti', []);
        $buktiPaths = $existingBukti;

        if ($request->hasFile('bukti_kepemilikan')) {
            foreach ($request->file('bukti_kepemilikan') as $file) {
                $path = $file->store('bukti_kepemilikan_hunian_lain', 'public');
                $buktiPaths[] = $path;
            }
        }

        $data['bukti_kepemilikan'] = json_encode($buktiPaths);

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
