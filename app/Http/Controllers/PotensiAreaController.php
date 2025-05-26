<?php

namespace App\Http\Controllers;

use App\Models\PotensiArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PotensiAreaController extends Controller
{
    public function index()
    {
        // Contoh: tampilkan semua data yang sudah di-approve
        $potensiAreas = \App\Models\PotensiArea::where('is_approved', 1)->get();
        return view('potensi-area.index', compact('potensiAreas'));
    }

    public function create()
    {
        return view('potensi-area.create'); // Pastikan file Blade ini ada
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'kategori' => 'required',
            'deskripsi' => 'nullable',
            'foto' => 'nullable|image|max:2048',
            'polygon' => 'nullable',
            'titik_potensi' => 'nullable',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        // Handle upload foto
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('potensi-area-foto', 'public');
        }

        // Jangan isi is_approved, biarkan NULL
        \App\Models\PotensiArea::create($validated);

        return redirect()->route('potensi-area.index')->with('success', 'Potensi area berhasil ditambahkan.');
    }

    // Tampilkan detail satu data potensi
    public function show(PotensiArea $potensiArea)
    {
        return view('potensi-area.show', compact('potensiArea'));
    }

    // Tampilkan form edit
    public function edit(PotensiArea $potensiArea)
    {
        return view('potensi-area.edit', compact('potensiArea'));
    }

    // Simpan perubahan data
    public function update(Request $request, PotensiArea $potensiArea)
    {
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'polygon' => 'nullable|json',
            'titik_potensi' => 'nullable|json',
            'foto' => 'nullable|image|max:2048',
        ]);

        // Validasi tambahan: pastikan polygon atau titik_potensi tidak keduanya kosong
        if (empty($validated['polygon']) && empty($validated['titik_potensi'])) {
            return back()->withErrors(['polygon' => 'Polygon atau Titik Potensi harus diisi.'])->withInput();
        }

        // Simpan file foto baru jika ada
        if ($request->hasFile('foto')) {
            if ($potensiArea->foto) {
                Storage::disk('public')->delete($potensiArea->foto);
            }

            $validated['foto'] = $request->file('foto')->store('foto-potensi', 'public');
        }

        // Update data di database
        $potensiArea->update($validated);

        return redirect()->route('potensi-area.index')->with('success', 'Data potensi berhasil diperbarui!');
    }

    // Hapus data potensi
    public function destroy(PotensiArea $potensiArea)
    {
        // Hapus file foto jika ada
        if ($potensiArea->foto) {
            Storage::disk('public')->delete($potensiArea->foto);
        }

        // Hapus data dari database
        $potensiArea->delete();

        return redirect()->route('potensi-area.index')->with('success', 'Data potensi berhasil dihapus!');
    }

    public function approve($id)
    {
        $potensiArea = PotensiArea::findOrFail($id);
        $potensiArea->is_approved = true;
        $potensiArea->save();
        return redirect()->route('potensi-area.index')
            ->with('success', 'Data potensi area berhasil disetujui');
    }
}
