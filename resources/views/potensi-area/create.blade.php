<!-- Tambahkan di atas @section('content') -->
<style>
    html, body {
        height: auto !important;
        min-height: 100%;
        overflow-y: auto !important;
    }
</style>

@extends('layouts.app')

@section('content')
<div class="px-4 py-12">
    <div class="max-w-4xl mx-auto">
        <div class="overflow-hidden bg-white rounded-lg shadow-sm">
            <div class="p-4 text-white bg-green-900">
                <h3 class="text-xl font-semibold">Tambah Potensi Area</h3>
            </div>
            <div class="p-6">
                <form action="{{ route('potensi-area.store') }}" method="POST" enctype="multipart/form-data" id="area-form">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="nama" class="block text-sm font-medium text-gray-700 after:content-['*'] after:text-red-500">
                            Nama
                        </label>
                        <input type="text" id="nama" name="nama" required
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                        <p class="hidden mt-1 text-sm text-red-600" id="nama-error">Silakan masukkan nama area.</p>
                    </div>
                    
                    <div class="mb-4">
                        <label for="kategori" class="block text-sm font-medium text-gray-700 after:content-['*'] after:text-red-500">
                            Kategori
                        </label>
                        <select id="kategori" name="kategori" required
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                            <option value="" disabled selected>Pilih Kategori</option>
                            <option value="Pertanian">Pertanian</option>
                            <option value="Peternakan">Peternakan</option>
                            <option value="Ekonomi">Ekonomi</option>
                            <option value="SDA">Sumber Daya Alam</option>
                            <option value="Infrastruktur">Infrastruktur</option>
                        </select>
                        <p class="hidden mt-1 text-sm text-red-600" id="kategori-error">Silakan pilih kategori.</p>
                    </div>
                    
                    <div class="mb-4">
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700">
                            Deskripsi
                        </label>
                        <textarea id="deskripsi" name="deskripsi" rows="4"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50"></textarea>
                    </div>
                    
                    <div class="mb-6">
                        <label for="foto" class="block text-sm font-medium text-gray-700">
                            Foto
                        </label>
                        <input type="file" id="foto" name="foto"
                            class="block w-full mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                        <p class="mt-1 text-xs text-gray-500">Format yang didukung: JPG, PNG, GIF. Maks 2MB.</p>
                    </div>
                    
                    <div class="mb-6">
                        <label for="map" class="block text-sm font-medium text-gray-700 after:content-['*'] after:text-red-500">
                            Gambar Titik atau Polygon di Peta
                        </label>
                        <div class="w-full mt-1 rounded-md overflow-hidden border border-gray-300" style="height: 400px; min-height: 300px;">
                            <div id="map" style="width: 100%; height: 100%;"></div>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">
                            Gambar polygon area dengan mengklik tombol polygon di peta kemudian klik titik-titik di peta untuk membentuk area.
                        </p>
                        <textarea name="polygon" id="polygon-coords" class="hidden"></textarea>
                        <textarea name="titik_potensi" id="marker-coords" class="hidden"></textarea>
                        <div id="polygon-status" class="hidden px-4 py-3 mt-3 text-yellow-700 border border-yellow-400 rounded-md bg-yellow-50">
                            Titik atau Polygon belum dibuat. Silakan gambar area pada peta.
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="latitude" class="block text-sm font-medium text-gray-700 after:content-['*'] after:text-red-500">
                            Latitude
                        </label>
                        <input type="text" id="latitude" name="latitude" required
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                        <p class="hidden mt-1 text-sm text-red-600" id="latitude-error">Silakan masukkan latitude.</p>
                    </div>

                    <div class="mb-6">
                        <label for="longitude" class="block text-sm font-medium text-gray-700 after:content-['*'] after:text-red-500">
                            Longitude
                        </label>
                        <input type="text" id="longitude" name="longitude" required
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                        <p class="hidden mt-1 text-sm text-red-600" id="longitude-error">Silakan masukkan longitude.</p>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="history.back()" 
                            class="px-4 py-2 text-green-800 bg-gray-100 border border-green-700 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Batal
                        </button>
                        <button type="submit" 
                            class="px-4 py-2 text-white bg-green-800 rounded-md hover:bg-green-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Keep the Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />

<!-- Keep the Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>

<script>
    // Custom form validation replacement for Bootstrap validation
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('area-form');
        
        form.addEventListener('submit', function(event) {
            let isValid = true;
            
            // Check required fields
            const requiredFields = form.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                if (!field.value) {
                    event.preventDefault();
                    isValid = false;
                    
                    // Show error message
                    const errorElement = document.getElementById(field.id + '-error');
                    if (errorElement) {
                        errorElement.classList.remove('hidden');
                    }
                    
                    // Add red border to invalid field
                    field.classList.add('border-red-500');
                    field.classList.remove('border-gray-300');
                } else {
                    // Hide error message
                    const errorElement = document.getElementById(field.id + '-error');
                    if (errorElement) {
                        errorElement.classList.add('hidden');
                    }
                    
                    // Reset border
                    field.classList.remove('border-red-500');
                    field.classList.add('border-gray-300');
                }
            });
            
            // Check polygon/marker
            const polygonCoords = document.getElementById('polygon-coords').value;
            const markerCoords = document.getElementById('marker-coords').value;
            
            if (!polygonCoords && !markerCoords) {
                event.preventDefault();
                alert('Silakan tambahkan Polygon atau Titik Potensi di peta sebelum menyimpan.');
                return;
            }
            
            return isValid;
        });
    });

    // Initialize map (keep this code exactly as it was)
    var map = L.map('map').setView([-6.950, 107.690], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    
    var drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);
    
    var drawControl = new L.Control.Draw({
        draw: {
            polygon: {
                allowIntersection: false,
                drawError: {
                    color: '#e1e100',
                    message: '<strong>Polygon tidak valid!</strong> Garis tidak boleh bersilangan.'
                },
                shapeOptions: {
                    color: '#3388ff'
                }
            },
            marker: true,
            polyline: false,
            rectangle: false,
            circle: false,
            circlemarker: false
        },
        edit: {
            featureGroup: drawnItems,
            poly: {
                allowIntersection: false
            }
        }
    });
    map.addControl(drawControl);
    
    // Show polygon status initially (tailwind-ified)
    document.getElementById('polygon-status').classList.remove('hidden');
    
    map.on('draw:created', function (e) {
        var type = e.layerType;
        var layer = e.layer;

        if (type === 'marker') {
            var markerCoords = [layer.getLatLng().lng, layer.getLatLng().lat];
            document.getElementById('marker-coords').value = JSON.stringify(markerCoords);
            console.log('Titik Potensi:', markerCoords);
        } else if (type === 'polygon') {
            var coordinates = layer.getLatLngs()[0].map(p => [p.lng, p.lat]);
            document.getElementById('polygon-coords').value = JSON.stringify(coordinates);
            console.log('Polygon:', coordinates);
        }

        drawnItems.addLayer(layer);
        
        // Update status
        const statusEl = document.getElementById('polygon-status');
        statusEl.classList.remove('bg-yellow-50', 'border-yellow-400', 'text-yellow-700');
        statusEl.classList.add('bg-green-50', 'border-green-400', 'text-green-700');
        statusEl.innerHTML = 'Titik atau Polygon berhasil dibuat. Area telah ditandai pada peta.';
        statusEl.classList.remove('hidden');

        // Set latitude and longitude to the center of the polygon
        var center = layer.getBounds().getCenter();
        document.getElementById('latitude').value = center.lat;
        document.getElementById('longitude').value = center.lng;
    });

    map.on('draw:deleted', function() {
        // Clear coordinates when polygon is deleted
        document.getElementById('polygon-coords').value = '';
        document.getElementById('latitude').value = '';
        document.getElementById('longitude').value = '';
        
        // Reset status
        const statusEl = document.getElementById('polygon-status');
        statusEl.classList.remove('bg-green-50', 'border-green-400', 'text-green-700');
        statusEl.classList.add('bg-yellow-50', 'border-yellow-400', 'text-yellow-700');
        statusEl.innerHTML = 'Titik atau Polygon belum dibuat. Silakan gambar area pada peta.';
        statusEl.classList.remove('hidden');
    });

    // Handle map click to set latitude and longitude
    map.on('click', function(e) {
        var latlng = e.latlng;
        document.getElementById('latitude').value = latlng.lat;
        document.getElementById('longitude').value = latlng.lng;

        // Update status
        const statusEl = document.getElementById('polygon-status');
        statusEl.classList.remove('bg-yellow-50', 'border-yellow-400', 'text-yellow-700');
        statusEl.classList.add('bg-green-50', 'border-green-400', 'text-green-700');
        statusEl.innerHTML = 'Titik koordinat berhasil ditentukan: ' + latlng.lat.toFixed(6) + ', ' + latlng.lng.toFixed(6);
        statusEl.classList.remove('hidden');
    });

    // Resize map when window is resized
    window.addEventListener('resize', function() {
        map.invalidateSize();
    });
</script>
@endsection