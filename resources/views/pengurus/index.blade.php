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

    {{-- Catalog Potensi Area --}}
    <div class="p-12 m-10 bg-white shadow sm:rounded-lg">
        <h2 class="mb-6 text-xl font-semibold" style="color:#1B3B0D;">Catalog Potensi Area</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($potensiAreas ?? [] as $area)
                <div class="bg-[#FAFAF9] border border-[#E9ECEF] rounded-lg shadow hover:shadow-lg transition-shadow duration-200 p-6 flex flex-col">
                    <div class="mb-4">
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold"
                              style="background-color:#28A745; color:white;">
                            {{ $area->kategori ?? 'Tanpa Kategori' }}
                        </span>
                    </div>
                    <h3 class="text-lg font-bold mb-2" style="color:#2D5016;">{{ $area->nama }}</h3>
                    <p class="text-sm mb-2" style="color:#6C757D;">{{ $area->deskripsi }}</p>
                    <div class="flex flex-wrap gap-2 mt-auto">
                        <span class="inline-block px-2 py-1 rounded bg-[#F8F9FA] text-xs text-[#2C3E50] border border-[#E9ECEF]">
                            Luas: {{ $area->luas ?? '-' }} m²
                        </span>
                        <span class="inline-block px-2 py-1 rounded bg-[#F8F9FA] text-xs text-[#2C3E50] border border-[#E9ECEF]">
                            Lokasi: {{ $area->lokasi ?? '-' }}
                        </span>
                        @if($area->status === 'aktif')
                            <span class="inline-block px-2 py-1 rounded bg-[#28A745] text-white text-xs">Aktif</span>
                        @else
                            <span class="inline-block px-2 py-1 rounded bg-[#DC3545] text-white text-xs">Nonaktif</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center text-gray-500 py-8">
                    Tidak ada data potensi area.
                </div>
            @endforelse
        </div>
    </div>
    {{-- End Catalog Potensi Area --}}
@endsection

@section('scripts')
    <script src="{{ asset('vendor/larapex-charts/apexcharts.js') }}"></script>
    {{ $potensiDesaChart->script() }}
    {{ $potensiAreaChart->script() }}
@endsection 
