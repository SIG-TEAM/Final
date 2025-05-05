@extends('layouts.app')

@section('content')
<div class="card shadow">
    <div class="card-header-actions">
        <a href="{{ route('rekomendasi.index') }}" class="btn btn-sm btn-outline-primary">Kembali</a>
    </div>
    <div class="card-header">
        <h3 class="mb-0">Tambah Rekomendasi</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('rekomendasi.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf

            <div class="mb-3">
                <label for="nama_titik" class="form-label required-label">Nama Desa/Area</label>
                <input type="text" class="form-control" id="nama_titik" name="nama_titik" required>
                <div class="invalid-feedback">
                    Silakan masukkan nama area.
                </div>
            </div>

            <div class="mb-3">
                <label for="jenis_potensi" class="form-label required-label">Nama Kategori</label>
                <input type="text" class="form-control" id="jenis_potensi" name="jenis_potensi" required>
                <div class="invalid-feedback">
                    Silakan masukkan nama area.
                </div>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4"></textarea>
            </div>

            <div class="mb-4">
                <label for="gambar" class="form-label">Foto</label>
                <input type="file" class="form-control" id="gambar" name="gambar">
                <div class="form-text">Format yang didukung: JPG, PNG, GIF. Maks 2MB.</div>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="button" class="btn btn-secondary me-md-2" onclick="history.back()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection