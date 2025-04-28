@extends('layouts.app', ['title' => 'Admin Dashboard'])



@section('content')
<div class="p-12 bg-white shadow sm:rounded-lg m-10 h-full min-h-screen">

    <div class="border-b border-gray-200">
        <h1 class="text-4xl font-semibold text-gray-900">
            Admin Dashboard
        </h1>
    </div>

    <div class="grid grid-cols-3 gap-4 mt-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold">Total Pengguna:</h2>
            <!-- TO DO: kasih total -->
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold">Total Admin:</h2>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold">Total Comments:</h2>
        </div>
    </div>
</div>
@endsection
