@extends('layouts.penguruslayout', ['title' => 'Pengurus Dashboard'])

@php
    use App\Models\User;
    use App\Models\PotensiDesa;
    use Illuminate\Support\Facades\Storage;

    $totalUsers = User::where('role', 'penduduk')->count();
    $totalPotensi = PotensiDesa::count();
@endphp

@section('content')
    <div class="px-12 py-4 bg-white">
        <h1 class="text-2xl font-semibold text-gray-900">
            Pengurus Dashboard
        </h1>
    </div>
    <div class="grid grid-cols-4 gap-4 px-12 mt-6">
        <div class="h-32 p-4 rounded-lg shadow bg-gradient-to-tr from-blue-500 to-blue-200">
            <h2 class="text-2xl font-semibold text-white">Total Akun Penduduk</h2>
            <p class="mt-2 text-4xl font-bold text-white">{{ $totalPenduduk }}</p>
        </div>
        <div class="h-32 p-4 rounded-lg shadow bg-gradient-to-tr from-green-500 to-green-200">
            <h2 class="text-2xl font-semibold text-white">Total Kategori</h2>
            <p class="mt-2 text-4xl font-bold text-white">{{ $totalKategori }}</p>
        </div>
    </div>
    
    <div class="p-12 m-10 bg-white shadow sm:rounded-lg">
        <h2 class="mb-6 text-xl font-semibold text-gray-800">Statistik Potensi Desa</h2>
        
        <!-- Potensi Stats Cards -->
        <div class="grid grid-cols-3 gap-6 mb-10">
            <div class="p-6 text-center bg-purple-100 rounded-lg shadow">
                <h3 class="text-lg font-medium text-purple-800">Total Titik Potensi</h3>
                <p class="mt-2 text-3xl font-bold text-purple-600">{{ $totalPotensiDesa }}</p>
            </div>

            <div class="p-6 text-center bg-indigo-100 rounded-lg shadow">
                <h3 class="text-lg font-medium text-indigo-800">Total Area Potensi</h3>
                <p class="mt-2 text-3xl font-bold text-indigo-600">{{ $totalPotensiArea }}</p>
            </div>

        </div>
        
        <!-- Charts Container -->
        <div class="grid grid-cols-2 gap-8">
            <!-- Chart for Potensi Desa by Category -->
            <div class="p-6 bg-white rounded-lg shadow">
                <h3 class="mb-4 text-lg font-medium text-gray-800">Distribusi Titik Potensi</h3>
                {!! $potensiDesaChart->container() !!}
            </div>
            
            <!-- Chart for Potensi Area by Category -->
            <div class="p-6 bg-white rounded-lg shadow">
                <h3 class="mb-4 text-lg font-medium text-gray-800">Distribusi Area Potensi</h3>
                {!! $potensiAreaChart->container() !!}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('vendor/larapex-charts/apexcharts.js') }}"></script>
    {{ $potensiDesaChart->script() }}
    {{ $potensiAreaChart->script() }}
@endsection 
