@extends('layouts.adminlayout', ['title' => 'Admin Dashboard'])

@php
    use App\Models\User;
    
    $totalUsers = User::count();
    $totalAdmins = User::where('role', 'admin')->count();
    $totalPengurus = User::where('role', 'pengurus')->count();
    $totalPenduduk = User::where('role', 'penduduk')->count();
@endphp

@section('content')
    <div class="px-12 py-4 bg-white">
        <h1 class="text-2xl font-semibold text-gray-900">
            Admin Dashboard
        </h1>
    </div>
    <div class="grid grid-cols-4 gap-4 px-12 mt-6">
        <div class="h-32 p-4 rounded-lg shadow bg-gradient-to-tr from-blue-500 to-blue-200">
            <h2 class="text-2xl font-semibold text-white">Total User</h2>
            <p class="mt-2 text-4xl font-bold text-white">{{ $totalUsers }}</p>
        </div>
        <div class="h-32 p-4 rounded-lg shadow bg-gradient-to-tr from-green-500 to-green-200">
            <h2 class="text-2xl font-semibold text-white">Total Admin</h2>
            <p class="mt-2 text-4xl font-bold text-white">{{ $totalAdmins }}</p>
        </div>
        <div class="h-32 p-4 rounded-lg shadow bg-gradient-to-tr from-orange-500 to-orange-200">
            <h2 class="text-2xl font-semibold text-white">Total Pengurus</h2>
            <p class="mt-2 text-4xl font-bold text-white">{{ $totalPengurus }}</p>
        </div>
        <div class="h-32 p-4 rounded-lg shadow bg-gradient-to-tr from-red-500 to-red-200">
            <h2 class="text-2xl font-semibold text-white">Total Akun Penduduk</h2>
            <p class="mt-2 text-4xl font-bold text-white">{{ $totalPenduduk }}</p>
        </div>
    </div>
    <div class="h-full min-h-screen p-12 m-10 bg-white shadow sm:rounded-lg">


    </div>
@endsection
