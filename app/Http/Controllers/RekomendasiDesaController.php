<?php

namespace App\Http\Controllers;

use App\Models\RekomendasiDesa;
use Illuminate\Http\Request;

class RekomendasiDesaController extends Controller
{
    public function index()
    {
        $rekomendasi = RekomendasiDesa::all(); // Or however you're retrieving your data
        return view('rekomendasi.index', ['rekomendasi' => $rekomendasi]);
    }

    public function show($id)
    {
        $rekomendasi = RekomendasiDesa::findOrFail($id);
        return view('rekomendasi.show', ['rekomendasi' => $rekomendasi]);
    }

    public function create()
    {
        return view('rekomendasi.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_titik' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'jenis_potensi' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            $imagePath = $request->file('gambar')->store('gambar-rekomendasi', 'public');
            $validatedData['gambar'] = $imagePath;
        }

        RekomendasiDesa::create($validatedData);

        return redirect()->route('rekomendasi.index')
            ->with('success', 'Data rekomendasi desa berhasil ditambahkan');
    }

    public function edit($id)
    {
        $rekomendasi = RekomendasiDesa::findOrFail($id);
        return view('rekomendasi.edit', ['rekomendasi' => $rekomendasi]);
    }

    public function update(Request $request, $id)
    {
        $rekomendasi = RekomendasiDesa::findOrFail($id);

        $validatedData = $request->validate([
            'nama_titik' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'jenis_potensi' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            $imagePath = $request->file('gambar')->store('gambar-rekomendasi', 'public');
            $validatedData['gambar'] = $imagePath;
        }

        $rekomendasi->update($validatedData);

        return redirect()->route('rekomendasi.index')
            ->with('success', 'Data rekomendasi desa berhasil diperbarui');
    }

    public function destroy($id)
    {
        $rekomendasi = RekomendasiDesa::findOrFail($id);
        $rekomendasi->delete();

        return redirect()->route('rekomendasi.index')
            ->with('success', 'Data rekomendasi desa berhasil dihapus');
    }

    // public function map()
    // {
    //     return view('rekomendasi.map');
    // }

    // public function getRekomendasiData()
    // {
    //     $rekomendasiDesas = RekomendasiDesa::all();
    //     return response()->json($rekomendasiDesas);
    // }
}
