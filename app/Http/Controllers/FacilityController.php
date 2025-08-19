<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facility;
use Illuminate\Validation\Rule;

class FacilityController extends Controller
{

    public function index(Request $request)
    {
        $query = Facility::query();

        if (!empty($request->search)) {
            $keywords = explode(' ', trim($request->search));

            $query->where(function ($q) use ($keywords) {
                foreach ($keywords as $word) {
                    $q->where('nama_fasilitas', 'like', "%$word%");
                }
            });
        }

        $facilities = $query->paginate(10)->withQueryString();

        return view('admin.facilities.index', compact('facilities'));
    }

    public function create()
    {
        return view('admin.facilities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_fasilitas' => ['required', 'string',
                Rule::unique('facilities')->where(function ($query) use ($request) {
                    return $query->whereRaw('LOWER(nama_fasilitas) = ?', [strtolower($request->nama_fasilitas)]);
                }),
            ],
        ], ['nama_fasilitas.unique' => 'Nama fasilitas sudah terdaftar.',]);
    
        Facility::create([
            'nama_fasilitas' => $request->nama_fasilitas,
        ]);
    
        return redirect()->route('admin.facilities.index')->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $facility = Facility::findOrFail($id);
        return view('admin.facilities.edit', compact('facility'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_fasilitas' => 'required|string',
        ]);

        $facility = Facility::findOrFail($id);
        $facility->update([
            'nama_fasilitas' => $request->nama_fasilitas,
        ]);

        return redirect()->route('admin.facilities.index')->with('success', 'Fasilitas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $facility = Facility::findOrFail($id);
        $facility->delete();

        return redirect()->route('admin.facilities.index')->with('success', 'Fasilitas berhasil dihapus.');
    }
}
