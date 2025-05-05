@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Daftar Potensi Area</h1>
        <a href="{{ route('potensi-area.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Tambah Potensi Area
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6 flex flex-col items-center justify-center">
            <div class="text-3xl font-bold text-blue-600">{{ $potensiAreas->count() }}</div>
            <div class="text-gray-500 mt-2">Total Area</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6 flex flex-col items-center justify-center">
            <div class="text-3xl font-bold text-green-600">{{ $potensiAreas->pluck('kategori')->unique()->count() }}</div>
            <div class="text-gray-500 mt-2">Kategori</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6 flex flex-col items-center justify-center">
            <div class="text-3xl font-bold text-purple-600">
                @if($potensiAreas->count() > 0)
                    {{ $potensiAreas->max('updated_at')->diffInDays(now()) }}
                @else
                    0
                @endif
            </div>
            <div class="text-gray-500 mt-2">Hari terakhir diperbarui</div>
        </div>
    </div>

    <!-- Peta -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Peta Potensi Area</h2>
        </div>
        <div class="relative" style="height: 600px;">
            <!-- Div Peta -->
            <div id="map" class="w-full h-full" style="height: 600px;"></div>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Latitude</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Longitude</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Polygon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Updated At</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($potensiAreas as $area)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $area->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $area->nama }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $area->kategori }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $area->deskripsi }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $area->latitude }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $area->longitude }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $area->polygon }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @if($area->foto)
                                <img src="{{ asset('storage/' . $area->foto) }}" alt="Foto {{ $area->nama }}" class="h-12 w-12 object-cover rounded-md">
                            @else
                                <span class="text-gray-400">Tidak ada foto</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $area->created_at }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $area->updated_at }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="px-6 py-4 text-center text-gray-500">Tidak ada data potensi area</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let map;
    let markers = [];
    let infoWindows = [];
    let polygons = [];

    function initMap() {
        // Default location (Indonesia)
        const defaultLocation = { lat: -2.5489, lng: 118.0149 };
        
        // Initialize map
        map = new google.maps.Map(document.getElementById('map'), {
            center: defaultLocation,
            zoom: 5,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                position: google.maps.ControlPosition.TOP_RIGHT
            },
            fullscreenControl: true,
            streetViewControl: true,
            zoomControl: true
        });

        // Add markers and polygons for each area
        @foreach($potensiAreas as $area)
            @if($area->latitude && $area->longitude)
                // Create marker
                const marker_{{ $area->id }} = new google.maps.Marker({
                    position: { 
                        lat: parseFloat("{{ $area->latitude }}"), 
                        lng: parseFloat("{{ $area->longitude }}") 
                    },
                    map: map,
                    title: "{{ $area->nama }}",
                    animation: google.maps.Animation.DROP,
                    icon: {
                        url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png"
                    }
                });
                markers.push(marker_{{ $area->id }});

                // Create info window with area details
                const contentString_{{ $area->id }} = `
                    <div class="info-window" style="width: 250px; padding: 10px;">
                        <h3 style="margin-top: 0; color: #1d4ed8; font-weight: bold;">{{ $area->nama }}</h3>
                        <p><strong>Kategori:</strong> {{ $area->kategori }}</p>
                        <p><strong>Deskripsi:</strong> {{ $area->deskripsi }}</p>
                        <p><strong>Koordinat:</strong> {{ $area->latitude }}, {{ $area->longitude }}</p>
                        @if($area->foto)
                            <img src="{{ asset('storage/' . $area->foto) }}" alt="Foto {{ $area->nama }}" style="width: 100%; max-height: 150px; object-fit: cover; border-radius: 4px; margin-top: 8px;">
                        @endif
                    </div>
                `;

                const infoWindow_{{ $area->id }} = new google.maps.InfoWindow({
                    content: contentString_{{ $area->id }}
                });
                infoWindows.push(infoWindow_{{ $area->id }});

                // Add click event to marker
                marker_{{ $area->id }}.addListener("click", () => {
                    // Close all open info windows
                    infoWindows.forEach(iw => iw.close());
                    
                    // Open this info window
                    infoWindow_{{ $area->id }}.open(map, marker_{{ $area->id }});
                    
                    // Center map on marker
                    map.setCenter(marker_{{ $area->id }}.getPosition());
                    map.setZoom(14);
                });

                // Handle polygon data if exists
                @if($area->polygon)
                    try {
                        // Parse polygon data safely
                        const polygonData_{{ $area->id }} = {!! $area->polygon !!};
                        
                        // Create polygon path
                        const polygonPath_{{ $area->id }} = polygonData_{{ $area->id }}.map(coord => {
                            return { lat: parseFloat(coord.lat), lng: parseFloat(coord.lng) };
                        });
                        
                        // Create polygon
                        const polygon_{{ $area->id }} = new google.maps.Polygon({
                            paths: polygonPath_{{ $area->id }},
                            strokeColor: "#FF0000",
                            strokeOpacity: 0.8,
                            strokeWeight: 2,
                            fillColor: "#FF0000",
                            fillOpacity: 0.35,
                            map: map
                        });
                        
                        polygons.push(polygon_{{ $area->id }});
                        
                        // Add click event to polygon
                        polygon_{{ $area->id }}.addListener("click", () => {
                            // Close all open info windows
                            infoWindows.forEach(iw => iw.close());
                            
                            // Open this info window
                            infoWindow_{{ $area->id }}.open(map, marker_{{ $area->id }});
                        });
                    } catch (e) {
                        console.error("Error parsing polygon data for area {{ $area->id }}:", e);
                    }
                @endif
            @endif
        @endforeach

        // Adjust map to show all markers if we have any
        if (markers.length > 0) {
            const bounds = new google.maps.LatLngBounds();
            markers.forEach(marker => {
                bounds.extend(marker.getPosition());
            });
            map.fitBounds(bounds);
            
            // Don't zoom in too far
            if (map.getZoom() > 15) {
                map.setZoom(15);
            }
        }
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZDmvgsLscfcgz3faTixl54JobWg0xGAY&callback=initMap" async defer></script>
@endpush