@extends('layouts.app')

@section('content')
<div class="container py-5">
    <a href="{{ route('rekomendasi.create') }}" class="btn btn-primary">Tambah Rekomendasi</a>
</div>
@endsection
<div class="container-tabel" style="margin-top: 30px;">
    <table class="table table-bordered">
        <thead>
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
                <td>{{ $item->deskripsi }}</td>
                <td>
                    @if($item->gambar)
                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar" style="width: 100px; height: auto;">
                    @else
                    Tidak ada gambar
                    @endif
                </td>
                <td>
                    <a href="{{ route('rekomendasi.edit', ['id' => $item->id]) }}" class="btn btn-primary">Edit</a>
                    <form action="{{ route('rekomendasi.destroy', $item->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>