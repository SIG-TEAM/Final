@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 fw-bold">Daftar Potensi Area</h1>
    
    <!-- Pesan Sukses -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <!-- Card untuk Tabel -->
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Potensi Area</h5>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('potensi-area.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Potensi Area
                </a>
            </div>
            
            @if($potensiAreas->isEmpty())
                <p class="text-muted">Belum ada data potensi area.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Deskripsi</th>
                                <th>Peta</th>
                                <th width="200">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($potensiAreas as $area)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $area->nama }}</td>
                                    <td>{{ $area->kategori }}</td>
                                    <td>{{ Str::limit($area->deskripsi, 100) }}</td>
                                    <td>
                                        <div id="map-{{ $area->id }}" class="map-container" style="height: 150px;"></div>
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function () {
                                                var map = L.map('map-{{ $area->id }}').setView([0, 0], 13);
                                                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                                                }).addTo(map);

                                                @if($area->polygon)
                                                    var polygon = L.polygon({!! $area->polygon !!}, {
                                                        color: 'blue',
                                                        fillColor: '#3388ff',
                                                        fillOpacity: 0.5
                                                    }).addTo(map);
                                                    map.fitBounds(polygon.getBounds());
                                                @endif
                                            });
                                        </script>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('potensi-area.show', $area->id) }}" class="btn btn-info btn-sm">
                                                <i class="bi bi-eye"></i> Detail
                                            </a>
                                            <a href="{{ route('potensi-area.edit', $area->id) }}" class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                            <form action="{{ route('potensi-area.destroy', $area->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination if needed -->
                @if($potensiAreas instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="mt-3">
                        {{ $potensiAreas->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection

@section('head')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endsection

@section('scripts')
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endsection