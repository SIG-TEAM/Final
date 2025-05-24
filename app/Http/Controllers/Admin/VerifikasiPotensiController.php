<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PotensiArea;

class VerifikasiPotensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data yang belum diverifikasi
        $potensiDesa = PotensiArea::whereNull('is_approved')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.verifikasi-potensi.index', compact('potensiDesa'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $potensi = PotensiArea::with('user')->findOrFail($id);
        return response()->json($potensi);
    }

    /**
     * Approve the specified resource.
     */
    public function approve($id)
    {
        $potensi = PotensiArea::findOrFail($id);
        $potensi->is_approved = 1;
        $potensi->save();

        return redirect()->back()->with('success', 'Potensi area berhasil disetujui.');
    }

    /**
     * Reject the specified resource.
     */
    public function reject(Request $request, $id)
    {
        $potensi = PotensiArea::findOrFail($id);
        $potensi->is_approved = null; // Ubah ke null
        $potensi->alasan = $request->alasan;
        $potensi->save();

        return redirect()->back()->with('success', 'Potensi area dikembalikan ke status pending.');
    }

    /**
     * Get pending verification count for dashboard
     */
    public function getPendingCount()
    {
        return PotensiArea::whereNull('is_approved')->count();
    }

    /**
     * Bulk approve multiple items
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:potensi_areas,id'
        ]);

        try {
            PotensiArea::whereIn('id', $request->ids)
                ->whereNull('is_approved')
                ->update([
                    'is_approved' => 1,
                    'approved_at' => now(),
                    'approved_by' => auth()->id()
                ]);

            return redirect()->back()->with('success', 'Potensi area terpilih berhasil disetujui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyetujui potensi area.');
        }
    }

    /**
     * Filter data by status
     */
    public function filter(Request $request)
    {
        $query = PotensiArea::with('user');

        // Filter by approval status
        if ($request->has('status') && $request->status !== '') {
            if ($request->status === 'pending') {
                $query->whereNull('is_approved');
            } elseif ($request->status === 'approved') {
                $query->where('is_approved', 1);
            } elseif ($request->status === 'rejected') {
                $query->where('is_approved', 0);
            }
        }

        // Filter by category
        if ($request->has('kategori') && $request->kategori !== '') {
            $query->where('kategori', 'like', '%' . $request->kategori . '%');
        }

        // Search by name
        if ($request->has('search') && $request->search !== '') {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $potensiDesa = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.verifikasi-potensi.index', compact('potensiDesa'));
    }

    /**
     * Set the specified resource as pending.
     */
    public function setPending($id)
    {
        $potensi = PotensiArea::findOrFail($id);
        $potensi->is_approved = null;
        $potensi->save();

        return redirect()->back()->with('success', 'Status potensi area direset ke pending.');
    }
}