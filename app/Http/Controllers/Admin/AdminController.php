<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PotensiDesa;
use App\Models\PotensiArea;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class AdminController extends Controller
{
    public function index()
    {
        // Explicitly define all variables used in the view
        $data = [
            'totalUsers' => User::count(),
            'totalAdmins' => User::where('role', 'admin')->count(),
            'totalPengurus' => User::where('role', 'pengurus')->count(),
            'totalPenduduk' => User::where('role', 'penduduk')->count(),
            'totalPotensiDesa' => PotensiDesa::count(),
            'totalPotensiArea' => PotensiArea::count(),
            'totalKategori' => Kategori::count(),
        ];
        
        // Get data for charts
        $potensiDesaByCategory = Kategori::withCount('potensi')
            ->orderBy('potensi_count', 'desc')
            ->get();
            
        $potensiAreaByCategory = PotensiArea::select('kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori')
            ->orderBy('total', 'desc')
            ->get();
        
        // Create charts with LarapexCharts
        $chart = new LarapexChart();
        
        $potensiDesaChart = $chart->pieChart()
            ->setTitle('Distribusi Titik Potensi')
            ->setColors(['#4F46E5', '#7C3AED', '#EC4899', '#F59E0B', '#10B981'])
            ->setLabels($potensiDesaByCategory->pluck('nama')->toArray())
            ->setDataset([
                [
                    'name' => 'Titik Potensi',
                    'data' => $potensiDesaByCategory->pluck('potensi_count')->toArray()
                ]
            ]);
            
        $areaChart = new LarapexChart();
        $potensiAreaChart = $areaChart->barChart()
            ->setTitle('Distribusi Area Potensi')
            ->setColors(['#6366F1'])
            ->setLabels($potensiAreaByCategory->pluck('kategori')->toArray())
            ->setDataset([
                [
                    'name' => 'Area Potensi',
                    'data' => $potensiAreaByCategory->pluck('total')->toArray()
                ]
            ]);
            
        // Add charts to data array
        $data['potensiDesaChart'] = $potensiDesaChart;
        $data['potensiAreaChart'] = $potensiAreaChart;
        
        // Ambil semua potensi area untuk katalog
        $data['potensiAreas'] = \App\Models\PotensiArea::all();
        
        // Return view with extracted variables
        return view('admin.index', $data);
    }
}
