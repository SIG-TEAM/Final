@extends('layouts.adminlayout', ['title' => 'Edit Kategori'])

@section('content')
<div class="px-12 py-4 bg-white">
    <h1 class="text-2xl font-semibold text-gray-900">
        Edit Kategori
    </h1>
</div>

<div class="h-full min-h-screen p-12 m-10 bg-white shadow sm:rounded-lg">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.kategori.index') }}" class="inline-flex items-center px-4 py-2 text-gray-700 transition-colors duration-200 bg-gray-200 rounded-md hover:bg-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    <!-- Error Messages -->
    @if ($errors->any())
    <div class="px-4 py-3 mb-6 text-red-700 bg-red-100 border border-red-400 rounded">
        <strong>Oops! Ada kesalahan:</strong>
        <ul class="mt-2 ml-5 list-disc">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form -->
    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="nama" class="block mb-2 text-sm font-bold text-gray-700">Nama Kategori:</label>
                    <input type="text" name="nama" id="nama" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('nama') border-red-500 @enderror" value="{{ old('nama', $kategori->nama) }}" required autofocus>
                    @error('nama')
                        <p class="mt-1 text-xs italic text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex items-center justify-end mt-6">
                    <button type="submit" class="px-4 py-2 font-bold text-white transition-colors duration-200 bg-blue-500 rounded hover:bg-blue-600 focus:outline-none focus:shadow-outline">
                        Perbarui Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
