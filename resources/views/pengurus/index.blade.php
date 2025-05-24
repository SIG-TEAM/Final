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
    <div class="grid grid-cols-2 gap-4 px-12 mt-6">
        <div class="h-32 p-4 rounded-lg shadow bg-gradient-to-tr from-blue-500 to-blue-200">
            <h2 class="text-2xl font-semibold text-white">Total Penduduk</h2>
            <p class="mt-2 text-4xl font-bold text-white">{{ $totalUsers }}</p>
        </div>
        <div class="h-32 p-4 rounded-lg shadow bg-gradient-to-tr from-green-500 to-green-200">
            <h2 class="text-2xl font-semibold text-white">Total Potensi Desa</h2>
            <p class="mt-2 text-4xl font-bold text-white">{{ $totalPotensi }}</p>
        </div>
    </div>
    <div class="h-full min-h-screen p-12 m-10 bg-white shadow sm:rounded-lg">
        <h2 class="text-xl font-semibold mb-4">Katalog Potensi Desa</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow text-sm">
                <thead class="bg-gradient-to-r from-blue-500 to-green-400 text-white">
                    <tr>
                        <th class="py-3 px-4 align-middle text-center">No</th>
                        <th class="py-3 px-4 align-middle text-center">Foto</th>
                        <th class="py-3 px-4 align-middle">Nama</th>
                        <th class="py-3 px-4 align-middle">Kategori</th>
                        <th class="py-3 px-4 align-middle">Deskripsi</th>
                        <th class="py-3 px-4 align-middle">Lokasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($potensiAreas as $i => $potensi)
                    <tr class="border-b hover:bg-gray-50 align-middle">
                        <td class="py-2 px-4 align-middle text-center">{{ $i+1 }}</td>
                        <td class="py-2 px-4 align-middle text-center">
                            @if($potensi->foto)
                                @if(Str::startsWith($potensi->foto, ['http://', 'https://']))
                                    <img src="{{ $potensi->foto }}" alt="{{ $potensi->nama }}" class="w-24 h-16 object-cover rounded shadow border mx-auto">
                                @elseif(Storage::disk('public')->exists($potensi->foto))
                                    <img src="{{ asset('storage/' . $potensi->foto) }}" alt="{{ $potensi->nama }}" class="w-24 h-16 object-cover rounded shadow border mx-auto">
                                @else
                                    <span class="text-gray-400 italic">Tidak ada gambar</span>
                                @endif
                            @else
                                <span class="text-gray-400 italic">Tidak ada gambar</span>
                            @endif
                        </td>
                        <td class="py-2 px-4 align-middle font-semibold">{{ $potensi->nama }}</td>
                        <td class="py-2 px-4 align-middle">{{ $potensi->kategori }}</td>
                        <td class="py-2 px-4 align-middle max-w-xs whitespace-normal">{{ \Illuminate\Support\Str::limit($potensi->deskripsi, 80) }}</td>
                        <td class="py-2 px-4 align-middle">
                            @if($potensi->latitude && $potensi->longitude)
                                <span class="text-xs">{{ $potensi->latitude }}, {{ $potensi->longitude }}</span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-4 text-center text-gray-500">Tidak ada data potensi desa.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection