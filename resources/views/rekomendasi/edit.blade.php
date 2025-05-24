@extends('layouts.app')

@section('content')
<div class="card shadow">
    <div class="card-header-actions">
        <a href="{{ route('rekomendasi.index') }}" class="btn btn-sm btn-outline-primary">Kembali</a>
    </div>
    <div class="card-header">
        <h3 class="mb-0">Edit Rekomendasi</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('rekomendasi.update', $rekomendasi->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="nama_titik" class="form-label required-label">Nama Desa/Area</label>
                <input type="text" class="form-control" id="nama_titik" name="nama_titik" value="{{ $rekomendasi->nama_titik }}" required>
            </div>

            <div class="mb-3">
                <label for="jenis_potensi" class="form-label required-label">Nama Kategori</label>
                <input type="text" class="form-control" id="jenis_potensi" name="jenis_potensi" value="{{ $rekomendasi->jenis_potensi }}" required>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4">{{ $rekomendasi->deskripsi }}</textarea>
            </div>

            <div class="mb-3">
                <label for="gambar" class="form-label">Foto</label>
                <input type="file" class="form-control" id="gambar" name="gambar">
                @if($rekomendasi->gambar)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $rekomendasi->gambar) }}" alt="Gambar" style="width: 100px; height: auto;">
                </div>
                @endif
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="button" class="btn btn-secondary me-md-2" onclick="history.back()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection