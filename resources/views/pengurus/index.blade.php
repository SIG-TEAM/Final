@extends('layouts.penguruslayout', ['title' => 'Pengurus Dashboard'])

@php
    use App\Models\User;
    use App\Models\PotensiDesa;
    
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
    </div>
    
@endsection 