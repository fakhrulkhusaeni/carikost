<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hunian;

class HunianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hunians = Hunian::with('kosts') // <- sesuaikan dengan relasi yang baru
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
    
        return view('admin.hunian.index', compact('hunians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.hunian.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'deskripsi' => 'required|string',
            'location' => 'required|string',
            'alamat' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $data = $request->only(['nama', 'deskripsi', 'location', 'alamat', 'latitude', 'longitude']);
        $data['user_id'] = auth()->id();

        Hunian::create($data);

        return redirect()->route('admin.hunian.index')->with('success', 'Data hunian berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Hunian $hunian)
    {
        return view('admin.hunian.show', compact('hunian'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hunian $hunian)
    {
        return view('admin.hunian.edit', compact('hunian'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hunian $hunian)
    {
        $request->validate([
            'nama' => 'required|string',
            'deskripsi' => 'required|string',
            'location' => 'required|string',
            'alamat' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $data = $request->only(['nama', 'deskripsi', 'location', 'alamat', 'latitude', 'longitude']);

        $hunian->update($data);

        return redirect()->route('admin.hunian.index')->with('success', 'Data hunian berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hunian $hunian)
    {
        $hunian->delete();

        return redirect()->route('admin.hunian.index')->with('success', 'Data hunian berhasil dihapus.');
    }
}
