<?php

namespace App\Http\Controllers;

use App\Models\PotensiDesa;
use Illuminate\Http\Request;

class PotensiDesaController extends Controller
{
public function index()

    {
    $potensiDesa = PotensiDesa::all();
    return view('potensidesa.index', compact('potensiDesa'));
    }
    
    public function show($id)
    {
        $potensiDesa = PotensiDesa::findOrFail($id);
        return view('potensi-desa.show', compact('potensiDesa'));
    }
    
    public function create()
    {
        return view('potensi-desa.create');
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_potensi' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'detail' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        if ($request->hasFile('gambar')) {
            $imagePath = $request->file('gambar')->store('potensi-desa', 'public');
            $validatedData['gambar'] = $imagePath;
        }
        
        PotensiDesa::create($validatedData);
        
        return redirect()->route('potensi-desa.index')
            ->with('success', 'Data potensi desa berhasil ditambahkan');
    }
    
    public function edit($id)
    {
        $potensiDesa = PotensiDesa::findOrFail($id);
        return view('potensi-desa.edit', compact('potensiDesa'));
    }
    
    public function update(Request $request, $id)
    {
        $potensiDesa = PotensiDesa::findOrFail($id);
        
        $validatedData = $request->validate([
            'nama_potensi' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'detail' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        if ($request->hasFile('gambar')) {
            $imagePath = $request->file('gambar')->store('potensi-desa', 'public');
            $validatedData['gambar'] = $imagePath;
        }
        
        $potensiDesa->update($validatedData);
        
        return redirect()->route('potensi-desa.index')
            ->with('success', 'Data potensi desa berhasil diperbarui');
    }
    
    public function destroy($id)
    {
        $potensiDesa = PotensiDesa::findOrFail($id);
        $potensiDesa->delete();
        
        return redirect()->route('potensi-desa.index')
            ->with('success', 'Data potensi desa berhasil dihapus');
    }
    
    public function map()
    {
        return view('potensi-desa.map');
    }
    
    public function getPotensiData()
    {
        $potensiDesas = PotensiDesa::all();
        return response()->json($potensiDesas);
    }
}
