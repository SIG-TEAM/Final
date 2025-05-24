@extends('layouts.app')

@section('content')
<div class="container py-2">
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered align-middle text-center">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <a href="{{ route('rekomendasi.create') }}" class="btn btn-primary">+ Tambah Rekomendasi</a>
                </div>
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Area</th>
                        <th>Jenis Potensi</th>
                        <th>Deskripsi</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rekomendasi as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->nama_titik }}</td>
                        <td>{{ $item->jenis_potensi }}</td>
                        <td class="text-start" style="white-space: normal; max-width: 200px;">
                            {{ $item->deskripsi }}
                        </td>
                        <td>
                            @if($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar" style="max-width: 80px; height: auto; border-radius: 6px;">
                            @else
                            <span class="text-muted">Tidak ada</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('rekomendasi.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('rekomendasi.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
@endsection