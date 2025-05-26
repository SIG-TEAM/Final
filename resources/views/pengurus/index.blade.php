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

    <!-- Card Atas -->
    <div class="grid grid-cols-2 gap-6 px-12 mt-6 mb-8">
        <div class="h-32 p-4 rounded-lg shadow bg-gradient-to-tr from-blue-500 to-blue-200 flex flex-col justify-between">
            <h2 class="text-xl font-semibold text-white">Total Akun Penduduk</h2>
            <p class="text-4xl font-bold text-white">{{ $totalPenduduk }}</p>
        </div>
        <div class="h-32 p-4 rounded-lg shadow bg-gradient-to-tr from-green-500 to-green-200 flex flex-col justify-between">
            <h2 class="text-xl font-semibold text-white">Total Kategori</h2>
            <p class="text-4xl font-bold text-white">{{ $totalKategori }}</p>
        </div>
    </div>
    
    <!-- Statistik Potensi Desa -->
    <div class="p-10 mx-12 mb-8 bg-white shadow rounded-lg">
        <h2 class="mb-6 text-xl font-semibold text-gray-800">Statistik Potensi Desa</h2>
        <div class="grid grid-cols-2 gap-6 mb-10">
            <div class="p-6 text-center bg-purple-100 rounded-lg shadow flex flex-col justify-center">
                <h3 class="text-lg font-medium text-purple-800">Total Titik Potensi</h3>
                <p class="mt-2 text-3xl font-bold text-purple-600">{{ $totalPotensiDesa }}</p>
            </div>
            <div class="p-6 text-center bg-indigo-100 rounded-lg shadow flex flex-col justify-center">
                <h3 class="text-lg font-medium text-indigo-800">Total Area Potensi</h3>
                <p class="mt-2 text-3xl font-bold text-indigo-600">{{ $totalPotensiArea }}</p>
            </div>
        </div>
        <!-- Chart -->
        <div class="grid grid-cols-2 gap-8">
            <div class="p-6 bg-white rounded-lg shadow">
                <h3 class="mb-4 text-lg font-medium text-gray-800">Distribusi Titik Potensi</h3>
                {!! $potensiDesaChart->container() !!}
            </div>
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
