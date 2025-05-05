{{-- Blade template for potensi-area map view --}}
@extends('layouts.app')

@section('styles')
<style>
    #map {
        height: calc(100vh - 64px);
        width: 100%;
    }
    .info-box {
        padding: 6px 8px;
        font-family: Arial, sans-serif;
        background: white;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .custom-button {
        background-color: #10B981 !important;
        color: white !important;
        transition: all 0.3s ease;
    }
    .custom-button:hover {
        background-color: #059669 !important;
        transform: scale(1.05);
    }
</style>
@endsection

@section('content')
<div class="relative">
    <div id="map"></div>
    <div class="absolute top-4 right-4 z-[1000]">
        <a href="{{ route('potensi-area.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg shadow-lg hover:bg-green-700 transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Tambah Potensi Area
        </a>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZDmvgsLscfcgz3faTixl54JobWg0xGAY"></script>
<script>
    let map;
    let infoWindow;

    function initMap() {
        // Inisialisasi peta
        map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: -6.9383, lng: 107.7190 },
            zoom: 13,
            restriction: {
                latLngBounds: {
                    north: -6.8583,
                    south: -7.0183,
                    east: 107.7990,
                    west: 107.6390
                },
                strictBounds: true
            },
            mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                position: google.maps.ControlPosition.TOP_LEFT
            }
        });

        infoWindow = new google.maps.InfoWindow();

        // Ambil dan tampilkan data potensi area
        fetch('{{ route("api.potensi-area") }}')
            .then(response => response.json())
            .then(data => {
                data.forEach(area => {
                    try {
                        if (area.polygon) {
                            // Buat polygon
                            const polygonPath = JSON.parse(area.polygon);
                            const polygon = new google.maps.Polygon({
                                paths: polygonPath,
                                strokeColor: "#10B981",
                                strokeOpacity: 0.8,
                                strokeWeight: 2,
                                fillColor: "#10B981",
                                fillOpacity: 0.35,
                                map: map
                            });

                            // Event listener untuk polygon
                            polygon.addListener("click", () => {
                                const bounds = new google.maps.LatLngBounds();
                                polygonPath.forEach(point => {
                                    bounds.extend(point);
                                });
                                
                                infoWindow.setContent(`
                                    <div class="info-box">
                                        <h4 style="font-weight: bold; margin-bottom: 8px;">${area.nama}</h4>
                                        <p><strong>Kategori:</strong> ${area.kategori}</p>
                                        <p><strong>Deskripsi:</strong> ${area.deskripsi || '-'}</p>
                                        <p style="margin-top: 8px;">
                                            <a href="/potensi-area/${area.id}" 
                                               style="color: #10B981; text-decoration: none; font-weight: 500;">
                                                Lihat Detail
                                            </a>
                                        </p>
                                    </div>
                                `);
                                infoWindow.setPosition(bounds.getCenter());
                                infoWindow.open(map);
                            });

                            // Tambah marker di tengah polygon
                            const bounds = new google.maps.LatLngBounds();
                            polygonPath.forEach(point => bounds.extend(point));
                            createMarker(bounds.getCenter(), area);
                        } else {
                            // Jika tidak ada polygon, tampilkan marker saja
                            const position = { 
                                lat: parseFloat(area.latitude), 
                                lng: parseFloat(area.longitude) 
                            };
                            createMarker(position, area);
                        }
                    } catch (error) {
                        console.error('Error processing area:', area, error);
                    }
                });
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                alert('Terjadi kesalahan saat memuat data');
            });
    }

    function createMarker(position, area) {
        const marker = new google.maps.Marker({
            position: position,
            map: map,
            title: area.nama
        });

        marker.addListener("click", () => {
            infoWindow.setContent(`
                <div class="info-box">
                    <h4 style="font-weight: bold; margin-bottom: 8px;">${area.nama}</h4>
                    <p><strong>Kategori:</strong> ${area.kategori}</p>
                    <p style="margin-top: 8px;">
                        <a href="/potensi-area/${area.id}" 
                           style="color: #10B981; text-decoration: none; font-weight: 500;">
                            Lihat Detail
                        </a>
                    </p>
                </div>
            `);
            infoWindow.open(map, marker);
        });

        return marker;
    }

    // Initialize the map
    window.onload = initMap;
</script>
@endsection