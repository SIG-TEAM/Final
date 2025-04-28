@extends('layouts.adminlayout', ['title' => 'Admin Dashboard'])

@php
    use App\Models\User;
    
    $totalUsers = User::count();
    $totalAdmins = User::where('role', 'admin')->count();
    $totalPengurus = User::where('role', 'pengurus')->count();
    $totalPenduduk = User::where('role', 'penduduk')->count();
@endphp

@section('content')
    <div class="bg-white px-12 py-4">
        <h1 class="text-2xl font-semibold text-gray-900">
            Admin Dashboard
        </h1>
    </div>
    <div class="grid grid-cols-4 gap-4 mt-6 px-12">
        <div class="bg-gradient-to-tr from-blue-500 to-blue-200 p-6 rounded-lg shadow aspect-video">
            <h2 class="text-lg text-white font-semibold">Total User</h2>
            <p class="text-3xl font-bold text-white mt-2">{{ $totalUsers }}</p>
        </div>
        <div class="bg-gradient-to-tr from-green-500 to-green-200 p-6 rounded-lg shadow aspect-video">
            <h2 class="text-lg text-white font-semibold">Total Admin</h2>
            <p class="text-3xl font-bold text-white mt-2">{{ $totalAdmins }}</p>
        </div>
        <div class="bg-gradient-to-tr from-orange-500 to-orange-200 p-6 rounded-lg shadow aspect-video">
            <h2 class="text-lg text-white font-semibold">Total Pengurus</h2>
            <p class="text-3xl font-bold text-white mt-2">{{ $totalPengurus }}</p>
        </div>
        <div class="bg-gradient-to-tr from-red-500 to-red-200 p-6 rounded-lg shadow aspect-video">
            <h2 class="text-lg text-white font-semibold">Total Akun Penduduk</h2>
            <p class="text-3xl font-bold text-white mt-2">{{ $totalPenduduk }}</p>
        </div>
    </div>
    <div class="p-12 bg-white shadow sm:rounded-lg m-10 h-full min-h-screen">


    </div>
@endsection
