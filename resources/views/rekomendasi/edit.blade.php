@extends('layouts.app')

@section('content')
<div class="container py-5">
    <a href="{{ route('rekomendasi.edit', ['id' => $rekomendasi->id]) }}" class="btn btn-primary">Edit</a>
</div>
@endsection
<div class="container py-5">
    <h2>Edit Rekomendasi</h2>
    <form action="{{ route('rekomendasi.update', $rekomendasi->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nama_titik" class="form-label">Nama Area</label>
            <input type="text" class="form-control" id="nama_titik" name="nama_titik" value="{{ $rekomendasi->nama_titik }}" required>
        </div>
        <div class="mb-3">
            <label for="jenis_potensi" class="form-label">Jenis Potensi</label>
            <input type="text" class="form-control" id="jenis_potensi" name="jenis_potensi" value="{{ $rekomendasi->jenis_potensi }}" required>
        </div>
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required>{{ $rekomendasi->deskripsi }}</textarea>
        </div>
        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar</label>
            <input type="file" class="form-control" id="gambar" name="gambar">
            @if($rekomendasi->gambar)
            <div class="mt-2">
                <img src="{{ asset('storage/' . $rekomendasi->gambar) }}" alt="Gambar" style="width: 100px; height: auto;">
            </div>
            @endif
        </div>
        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
    </form>
</div>