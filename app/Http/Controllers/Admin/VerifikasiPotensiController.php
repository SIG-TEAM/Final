<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PotensiDesa;

class VerifikasiPotensiController extends Controller
{
    public function index()
    {
        $potensiDesa = PotensiDesa::where('status', 'pending')->paginate(10);
        return view('admin.verifikasi-potensi.index', compact('potensiDesa'));
    }

    // Tambahkan method approve/reject jika diperlukan

    public function show($id)
    {
        $potensi = \App\Models\PotensiDesa::with('user')->findOrFail($id);
        return response()->json($potensi);
    }

    public function reject(Request $request, $id)
    {
        $potensi = \App\Models\PotensiDesa::findOrFail($id);
        $potensi->status = 'rejected';
        $potensi->alasan = $request->alasan;
        $potensi->save();

        return redirect()->route('admin.verifikasi-potensi')->with('success', 'Pengajuan berhasil ditolak.');
    }
}
