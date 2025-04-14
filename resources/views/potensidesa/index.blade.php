@extends('layouts.app')

@section('styles')
<style>
    #mapContainer {
        height: 600px;
        width: 100%;
    }
    .custom-info-window {
        max-width: 300px;
    }
    .custom-info-window img {
        width: 100%;
        max-height: 150px;
        object-fit: cover;
        border-radius: 4px;
        margin-bottom: 10px;
    }
    .marker-detail-link {
        display: inline-block;
        margin-top: 10px;
        padding: 5px 10px;
        background-color: #3490dc;
        color: white;
        text-decoration: none;
        border-radius: 4px;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Peta Sebaran Potensi Desa</h3>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="filterKategori">Filter Kategori:</label>
                        <select id="filterKategori" class="form-control">
                            <option value="">Semua Kategori</option>
                            <!-- Kategori akan diisi secara dinamis menggunakan JavaScript -->
                        </select>
                    </div>
                    <div id="mapContainer"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&callback=initMap" async defer></script>
<script>
    let map;
    let markers = [];
    let infoWindows = [];
    let potensiData = [];
    let uniqueCategories = new Set();
    
    function initMap() {
        // Posisi default peta (pusat Indonesia atau koordinat desa)
        const defaultPosition = { lat: -2.5489, lng: 118.0149 };
        
        map = new google.maps.Map(document.getElementById("mapContainer"), {
            zoom: 5,
            center: defaultPosition,
        });
        
        // Ambil data dari API
        fetch('{{ route('api.potensi-desa') }}')
            .then(response => response.json())
            .then(data => {
                potensiData = data;
                // Ambil kategori unik untuk filter
                data.forEach(potensi => {
                    uniqueCategories.add(potensi.kategori);
                });
                
                // Isi dropdown filter kategori
                const filterSelect = document.getElementById('filterKategori');
                uniqueCategories.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category;
                    option.textContent = category;
                    filterSelect.appendChild(option);
                });
                
                // Tampilkan semua marker
                createMarkers(data);
            })
            .catch(error => console.error('Error fetching data:', error));
    }
    
    function createMarkers(data) {
        // Hapus marker yang sudah ada
        markers.forEach(marker => marker.setMap(null));
        markers = [];
        infoWindows = [];
        
        // Buat marker baru
        data.forEach(potensi => {
            const marker = new google.maps.Marker({
                map: map,
                title: potensi.nama_potensi,
                // Opsional: Tambahkan icon berbeda untuk setiap kategori
                // icon: getMarkerIconByCategory(potensi.kategori)
            });
            
            const contentString = `
                <div class="custom-info-window">
                    <h5>${potensi.nama_potensi}</h5>
                    ${potensi.gambar ? `<img src="/storage/${potensi.gambar}" alt="${potensi.nama_potensi}">` : ''}
                    <p><strong>Kategori:</strong> ${potensi.kategori}</p>
                    <p>${potensi.deskripsi}</p>
                    <a href="/potensi-desa/${potensi.id}" class="marker-detail-link">Lihat Detail</a>
                </div>
            `;
            
            const infoWindow = new google.maps.InfoWindow({
                content: contentString,
                maxWidth: 300
            });
            
            marker.addListener("click", () => {
                // Tutup infoWindow yang terbuka
                infoWindows.forEach(iw => iw.close());
                
                // Buka infoWindow yang diklik
                infoWindow.open(map, marker);
            });
            
            markers.push(marker);
            infoWindows.push(infoWindow);
        });
    }
    
    // Event listener untuk filter kategori
    document.getElementById('filterKategori').addEventListener('change', function() {
        const selectedCategory = this.value;
        
        if (selectedCategory === '') {
            // Jika "Semua Kategori" dipilih, tampilkan semua data
            createMarkers(potensiData);
        } else {
            // Filter data berdasarkan kategori
            const filteredData = potensiData.filter(potensi => potensi.kategori === selectedCategory);
            createMarkers(filteredData);
        }
    });
    
    // Fungsi opsional untuk mendapatkan ikon marker berdasarkan kategori
    function getMarkerIconByCategory(category) {
        // Implementasikan logika untuk mengembalikan URL ikon berbeda untuk setiap kategori
        switch(category) {
            case 'Pertanian':
                return '/icons/agriculture.png';
            case 'Pariwisata':
                return '/icons/tourism.png';
            case 'Industri':
                return '/icons/industry.png';
            default:
                return '/icons/default.png';
        }
    }
</script>
@endsection

<!-- File: resources/views/potensi-desa/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>{{ $potensiDesass->nama_potensi }}</h3>
                    <div>
                        <a href="{{ route('potensi-desa.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if($potensiDesass->gambar)
                        <div class="col-md-6">
                            <img src="{{ asset('storage/' . $potensiDesas->gambar) }}" alt="{{ $potensiDesas->nama_potensi }}" class="img-fluid rounded">
                        </div>
                        <div class="col-md-6">
                        @else
                        <div class="col-md-12">
                        @endif
                            <table class="table table-bordered">
                                <tr>
                                    <th>Kategori</th>
                                    <td>{{ $potensiDesas->kategori }}</td>
                                </tr>
                                <tr>
                                    <th>Deskripsi</th>
                                    <td>{{ $potensiDesas->deskripsi }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h4>Detail Informasi</h4>
                            <div class="border p-3 rounded">
                                {!! $potensiDesas->detail !!}
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h4>Lokasi</h4>
                            <div id="detailMap" style="height: 400px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&callback=initDetailMap" async defer></script>
<script>
        const map = new google.maps.Map(document.getElementById("detailMap"), {
            zoom: 15,
            center: position,
        });
        
        const marker = new google.maps.Marker({
            position: position,
            map: map,
            title: "{{ $potensiDesas->nama_potensi }}"
        });
</script>
@endsection