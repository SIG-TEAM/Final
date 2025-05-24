<?php

namespace App\Http\Controllers\Pengurus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PotensiArea;
use App\Models\PotensiDesa;

class PengurusController extends Controller
{
    public function index()
    {
        // Mengambil statistik dasar
        $data = [
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
            
        // Membuat chart potensi desa
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
            
        // Menambahkan chart ke data array
        $data['potensiDesaChart'] = $potensiDesaChart;
        $data['potensiAreaChart'] = $potensiAreaChart;
        
        return view('pengurus.index', $data);
        
    }

    public function dashboard(){
        return view('pengurus.dashboard');
    }
    public function approvalIndex(){
       $potensiAreas = PotensiArea::where('is_approved', false)->get();
       $potensiDesas = PotensiDesa::where('is_approved', false)->get();
       return view('pengurus.approval.index', compact('potensiAreas', 'potensiDesas'));
    }
} 