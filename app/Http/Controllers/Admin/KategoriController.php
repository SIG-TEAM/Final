<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();
        return view('admin.kategoripotensi', compact('kategori'));
    }

    /**
     * Show the form for creating a new kategori.
     */
    public function create()
    {
        return view('admin.KategoriCreate');
    }

    /**
     * Store a newly created kategori in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255|unique:kategori_potensi,nama',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('kategori.create')
                ->withErrors($validator)
                ->withInput();
        }

        // Create the kategori
        Kategori::create([
            'nama' => $request->nama,
        ]);

        // Redirect with success message
        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified kategori.
     */
    public function edit($id)
    {
        // Find the kategori
        $kategori = Kategori::findOrFail($id);
        
        // Return the edit view with the kategori
        return view('admin.KategoriEdit', compact('kategori'));
    }

    /**
     * Update the specified kategori in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the kategori
        $kategori = Kategori::findOrFail($id);
        
        // Validate the request (ignore unique rule for this kategori's ID)
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255|unique:kategori_potensi,nama,' . $id,
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('kategori.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        // Update the kategori
        $kategori->update([
            'nama' => $request->nama,
        ]);

        // Redirect with success message
        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Remove the specified kategori from storage.
     */
    public function destroy($id)
    {
        try {
            // Find the kategori
            $kategori = Kategori::findOrFail($id);
            
            // Check if any potensi uses this kategori
            if ($kategori->potensi && $kategori->potensi->count() > 0) {
                return redirect()
                    ->route('kategori.index')
                    ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh data potensi.');
            }
            
            // Delete the kategori
            $kategori->delete();
            
            // Redirect with success message
            return redirect()
                ->route('kategori.index')
                ->with('success', 'Kategori berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()
                ->route('kategori.index')
                ->with('error', 'Terjadi kesalahan saat menghapus kategori: ' . $e->getMessage());
        }
    }
}
