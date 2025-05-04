<?php

namespace App\Http\Controllers;

use App\Models\PotensiArea;
use Illuminate\Http\Request;

class PotensiAreaController extends Controller
{
    public function index()
    {
        // Ambil semua data potensi area dari database
        $potensiAreas = PotensiArea::all();

        // Kirim data ke view
        return view('potensi-area.index', compact('potensiAreas'));
    }

    public function create()
    {
        return view('potensi-area.create'); // Pastikan file Blade ini ada
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string',
            'deskripsi' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'polygon' => 'required|json', // Validasi untuk polygon
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk file foto
        ]);

        // Simpan file foto jika ada
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('potensi-area-foto', 'public');
            $validated['foto'] = $fotoPath;
        }

        // Simpan data ke database
        PotensiArea::create($validated);

        return redirect()->route('potensi-area.index')->with('success', 'Potensi area berhasil ditambahkan.');
    }
}