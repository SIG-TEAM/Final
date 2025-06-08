@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 px-4 overflow-auto min-h-screen">
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Koordinat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($potensiAreas as $area)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $area->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $area->nama }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if(stripos($area->kategori, 'wisata') !== false) bg-blue-100 text-blue-800 
                                @elseif(stripos($area->kategori, 'peternakan') !== false) bg-yellow-100 text-yellow-800 
                                @elseif(stripos($area->kategori, 'pertanian') !== false) bg-green-100 text-green-800 
                                @elseif(stripos($area->kategori, 'kuliner') !== false) bg-purple-100 text-purple-800 
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($area->kategori) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 max-w-xs">
                                <p class="truncate" title="{{ $area->deskripsi }}">{{ Str::limit($area->deskripsi, 50) }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                            <div>Lat: {{ number_format($area->latitude, 6) }}</div>
                            <div>Lng: {{ number_format($area->longitude, 6) }}</div>
                            @if($area->alamat)
                                <div class="mt-1 text-gray-700 text-xs"><b>Alamat:</b> {{ $area->alamat }}</div>
                            @else
                                <div class="mt-1 text-gray-400 text-xs"><b>Alamat:</b> <i>Tidak tersedia</i></div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($area->status === 'pending')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Menunggu Verifikasi
                                </span>
                            @elseif($area->status === 'approved')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Disetujui
                                </span>
                            @elseif($area->status === 'rejected')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Ditolak
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if(!empty($area->foto) && $area->foto !== 'null')
                                <img src="{{ asset('storage/' . $area->foto) }}" alt="Foto {{ e($area->nama) }}"
                                     class="h-12 w-12 object-cover rounded-md cursor-pointer hover:opacity-75"
                                     onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';"
                                     onclick="showImageModal('{{ asset('storage/' . $area->foto) }}', '{{ addslashes($area->nama) }}')">
                            @else
                                <img src="{{ asset('images/no-image.png') }}" alt="Tidak ada foto"
                                     class="h-12 w-12 object-cover rounded-md opacity-50">
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $area->created_at ? $area->created_at->format('d/m/Y') : '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center py-8">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="mt-2 text-sm">Tidak ada data potensi area.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75" onclick="closeImageModal()"></div>
        </div>
        <div class="inline-block align-bottom bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            <div class="bg-white p-4">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-lg font-medium text-gray-900" id="modalImageTitle">Foto Potensi Area</h3>
                    <button onclick="closeImageModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div id="modalImageContent" class="flex justify-center">
                    <!-- Image will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map {
        width: 100%;
        height: 100%;
        min-height: 400px;
        border-radius: 8px;
    }
    
    .leaflet-popup-content {
        margin: 8px 12px;
        line-height: 1.4;
    }
    
    .leaflet-popup-content h3 {
        margin: 0 0 8px 0;
        color: #1d4ed8;
        font-weight: bold;
    }
    
    .leaflet-popup-content p {
        margin: 4px 0;
        font-size: 13px;
    }
    
    .leaflet-popup-content img {
        width: 100%;
        max-width: 200px;
        max-height: 150px;
        object-fit: cover;
        border-radius: 4px;
        margin-top: 8px;
    }
</style>
@endpush

@push('scripts')
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>
<script>
    let map;
    let markers = [];
    let polygons = [];
    let allData = @json($potensiAreas);

    allData = allData.map(area => ({
        ...area,
        foto: area.foto && area.foto !== 'null' ? `/storage/${area.foto}` : '',
        created_at: area.created_at ? (new Date(area.created_at)).toLocaleDateString('id-ID') : '-',
    }));

    // Custom icons for different categories
    const categoryIcons = {
        wisata: L.divIcon({
            className: 'custom-div-icon',
            html: '<div style="background-color: #3b82f6; width: 12px; height: 12px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>',
            iconSize: [16, 16],
            iconAnchor: [8, 8]
        }),
        pertanian: L.divIcon({
            className: 'custom-div-icon',
            html: '<div style="background-color: #10b981; width: 12px; height: 12px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>',
            iconSize: [16, 16],
            iconAnchor: [8, 8]
        }),
        peternakan: L.divIcon({
            className: 'custom-div-icon',
            html: '<div style="background-color: #f59e0b; width: 12px; height: 12px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>',
            iconSize: [16, 16],
            iconAnchor: [8, 8]
        }),
        kuliner: L.divIcon({
            className: 'custom-div-icon',
            html: '<div style="background-color: #8b5cf6; width: 12px; height: 12px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>',
            iconSize: [16, 16],
            iconAnchor: [8, 8]
        }),
        default: L.divIcon({
            className: 'custom-div-icon',
            html: '<div style="background-color: #6b7280; width: 12px; height: 12px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>',
            iconSize: [16, 16],
            iconAnchor: [8, 8]
        })
    };

    const categoryColors = {
        wisata: '#3b82f6',
        pertanian: '#10b981',
        peternakan: '#f59e0b',
        kuliner: '#8b5cf6',
        default: '#6b7280'
    };

    function safeParsePolygon(polygon) {
        if (!polygon) return null;
        try {
            if (typeof polygon === 'string') {
                return JSON.parse(polygon);
            }
            return polygon;
        } catch (e) {
            return null;
        }
    }

    function addAreaToMap(area) {
        // Tentukan icon & warna
        let icon = categoryIcons.default;
        let color = categoryColors.default;
        Object.keys(categoryIcons).forEach(cat => {
            if (cat !== 'default' && area.kategori && area.kategori.toLowerCase().includes(cat)) {
                icon = categoryIcons[cat];
                color = categoryColors[cat];
            }
        });

        // Marker
        const marker = L.marker([area.latitude, area.longitude], { icon: icon }).addTo(map);

        // Popup
        const statusBadge = area.status === 'pending' ? 
            '<span style="background: #fef3c7; color: #92400e; padding: 2px 8px; border-radius: 12px; font-size: 11px;">Menunggu Verifikasi</span>' :
            area.status === 'approved' ? 
            '<span style="background: #d1fae5; color: #065f46; padding: 2px 8px; border-radius: 12px; font-size: 11px;">Disetujui</span>' :
            '<span style="background: #fee2e2; color: #991b1b; padding: 2px 8px; border-radius: 12px; font-size: 11px;">Ditolak</span>';

        const popupContent = `
            <div style="min-width: 200px;">
                <h3>${area.nama}</h3>
                <p><strong>Kategori:</strong> ${area.kategori}</p>
                <p><strong>Status:</strong> ${statusBadge}</p>
                <p><strong>Deskripsi:</strong> ${area.deskripsi}</p>
                <p><strong>Alamat:</strong> ${area.alamat ?? '-'}</p>
                <p><strong>Koordinat:</strong> ${area.latitude.toFixed(6)}, ${area.longitude.toFixed(6)}</p>
                <p><strong>Tanggal:</strong> ${area.created_at}</p>
                ${area.foto ? `<img src='${area.foto}' alt='Foto ${area.nama.replace(/'/g, '&apos;')}' style='max-width:150px;max-height:100px;'/>` : ''}
            </div>
        `;
        marker.bindPopup(popupContent);
        marker.areaData = area;
        markers.push(marker);

        // Polygon (jika ada)
        if (area.polygon && Array.isArray(area.polygon) && area.polygon.length > 2) {
            let coords = [];
            if (typeof area.polygon[0] === 'object' && 'lat' in area.polygon[0] && 'lng' in area.polygon[0]) {
                coords = area.polygon.map(p => [p.lat, p.lng]);
            } else if (Array.isArray(area.polygon[0])) {
                coords = area.polygon.map(p => [p[1], p[0]]);
            }
            const polygon = L.polygon(coords, {
                color: color,
                weight: 2,
                opacity: 0.8,
                fillColor: color,
                fillOpacity: 0.35
            }).addTo(map);
            polygon.bindPopup(popupContent);
            polygon.areaData = area;
            polygons.push(polygon);
        }
    }

    function initMap() {
        // Hide placeholder
        const placeholder = document.getElementById('mapPlaceholder');
        if (placeholder) placeholder.style.display = 'none';

        map = L.map('map').setView([-2.5489, 118.0149], 5);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);

        // Tambahkan marker/polygon jika ada data
        allData.forEach(area => {
            if (area.latitude && area.longitude) {
                addAreaToMap({
                    id: area.id,
                    nama: area.nama,
                    kategori: area.kategori,
                    deskripsi: area.deskripsi,
                    alamat: area.alamat, // tambahkan alamat
                    latitude: parseFloat(area.latitude),
                    longitude: parseFloat(area.longitude),
                    foto: area.foto && area.foto !== 'null' ? asset('storage/' + area.foto) : '',
                    status: area.status,
                    polygon: safeParsePolygon(area.polygon),
                    created_at: area.created_at ? area.created_at : ''
                });
            }
        });

        // Fit map jika ada marker
        if (markers.length > 0) {
            const group = new L.featureGroup(markers);
            map.fitBounds(group.getBounds().pad(0.1));
        }
    }

    function focusOnMap(lat, lng, name) {
        map.setView([lat, lng], 16);
        
        // Find and open popup for this marker
        markers.forEach(marker => {
            if (marker.areaData && marker.areaData.latitude === lat && marker.areaData.longitude === lng) {
                marker.openPopup();
            }
        });
    }

    function filterByCategory(kategori) {
        markers.forEach(marker => {
            if (!kategori || marker.areaData.kategori.toLowerCase().includes(kategori.toLowerCase())) {
                marker.addTo(map);
            } else {
                map.removeLayer(marker);
            }
        });

        polygons.forEach(polygon => {
            if (!kategori || polygon.areaData.kategori.toLowerCase().includes(kategori.toLowerCase())) {
                polygon.addTo(map);
            } else {
                map.removeLayer(polygon);
            }
        });
    }

    function showAll() {
        markers.forEach(marker => marker.addTo(map));
        polygons.forEach(polygon => polygon.addTo(map));
        
        if (markers.length > 0) {
            const group = new L.featureGroup(markers);
            map.fitBounds(group.getBounds().pad(0.1));
        }
    }

    function togglePolygons() {
        polygons.forEach(polygon => {
            if (map.hasLayer(polygon)) {
                map.removeLayer(polygon);
            } else {
                polygon.addTo(map);
            }
        });
    }

    function showImageModal(imageSrc, title) {
        const modal = document.getElementById('imageModal');
        const modalContent = document.getElementById('modalImageContent');
        const modalTitle = document.getElementById('modalImageTitle');
        
        modalTitle.textContent = `Foto ${title}`;
        modalContent.innerHTML = `<img src="${imageSrc}" alt="Foto ${title}" class="max-w-full max-h-96 h-auto rounded-lg shadow-lg">`;
        modal.classList.remove('hidden');
    }

    function closeImageModal() {
        document.getElementById('imageModal').classList.add('hidden');
    }

    // Event listeners
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(initMap, 300);

        // Category filter
        document.getElementById('kategoriFilter').addEventListener('change', function() {
            filterByCategory(this.value);
        });

        // Show all button
        document.getElementById('showAllBtn').addEventListener('click', showAll);

        // Toggle polygons button
        document.getElementById('togglePolygons').addEventListener('click', togglePolygons);

        // Close modal when clicking outside
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });
    });
</script>
@endpush