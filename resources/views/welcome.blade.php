@extends('layouts.app')

@section('styles')
<!-- Tailwind styles for the welcome page -->
@endsection

@section('head')

<!-- Google Maps API -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZDmvgsLscfcgz3faTixl54JobWg0xGAY"></script>
<script>
    function initMap() {
        const map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: -6.9383, lng: 107.7190 },
            zoom: 13,
            styles: [
                {
                    featureType: "poi",
                    elementType: "labels",
                    stylers: [{ visibility: "off" }]
                },
                {
                    featureType: "transit",
                    elementType: "all",
                    stylers: [{ visibility: "off" }]
                }
            ],
            restriction: {
                latLngBounds: {
                    north: -6.8583,
                    south: -7.0183,
                    west: 107.6390,
                    east: 107.7990
                },
                strictBounds: true
            }
        });

        // Tambahkan marker untuk setiap potensi area
        const cileunyiMarkers = [
            {
                position: { lat: -6.9383, lng: 107.7190 },
                title: "Pertanian Padi Cileunyi",
                category: "Pertanian",
                details: {
                    title: "Pertanian Padi Cileunyi",
                    categories: [
                        {
                            name: "Pertanian",
                            icon: "🌾",
                            items: [
                                {
                                    title: "Padi Sawah",
                                    description: "Luas area 450 hektar dengan produksi rata-rata 5.8 ton/hektar per panen. Panen dilakukan 2-3 kali setahun."
                                }
                            ]
                        }
                    ]
                }
            }
        ];

        cileunyiMarkers.forEach(markerInfo => {
            const marker = new google.maps.Marker({
                position: markerInfo.position,
                map: map,
                title: markerInfo.title,
                icon: {
                    url: getCategoryIcon(markerInfo.category),
                    scaledSize: new google.maps.Size(32, 32)
                }
            });

            marker.addListener("click", () => {
                openSidebar(markerInfo.details);
            });
        });

        // Tambahkan polygon untuk setiap potensi area
        @if(isset($potensiAreas) && $potensiAreas->count() > 0)
            @foreach ($potensiAreas as $area)
                const polygon{{ $area->id }}Coords = {!! $area->polygon !!};
                const polygon{{ $area->id }} = new google.maps.Polygon({
                    paths: polygon{{ $area->id }}Coords.map(coord => ({ lng: coord[0], lat: coord[1] })),
                    strokeColor: '#FF0000',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: '#FF0000',
                    fillOpacity: 0.35,
                    map: map
                });

                polygon{{ $area->id }}.addListener("click", function(event) {
                    openSidebar({
                        title: "{{ $area->nama }}",
                        categories: [{
                            name: "{{ $area->kategori }}",
                            icon: "📍",
                            items: [{
                                title: "{{ $area->nama }}",
                                description: `{!! nl2br(e($area->deskripsi)) !!}`
                            }]
                        }]
                    });
                });
            @endforeach
        @endif

        // Example polygon
        const examplePolygonCoords = [
            [107.7190, -6.9383],
            [107.7290, -6.9303],
            [107.7100, -6.9423],
            [107.7240, -6.9353]
        ];
        const examplePolygon = new google.maps.Polygon({
            paths: examplePolygonCoords.map(coord => ({ lng: coord[0], lat: coord[1] })),
            strokeColor: '#0000FF',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#0000FF',
            fillOpacity: 0.35,
            map: map
        });
    }

    function getCategoryIcon(category) {
        switch(category) {
            case "Pertanian":
                return "https://maps.google.com/mapfiles/ms/icons/green-dot.png";
            case "Peternakan":
                return "https://maps.google.com/mapfiles/ms/icons/blue-dot.png";
            case "Ekonomi":
                return "https://maps.google.com/mapfiles/ms/icons/yellow-dot.png";
            case "SDA":
                return "https://maps.google.com/mapfiles/ms/icons/purple-dot.png";
            case "Infrastruktur": 
                return "https://maps.google.com/mapfiles/ms/icons/orange-dot.png";
            default:
                return "https://maps.google.com/mapfiles/ms/icons/red-dot.png";
        }
    }

    function openSidebar(details) {
        const sidebar = document.getElementById("sidebar");
        sidebar.classList.add("open");
        
        const sidebarContent = document.getElementById("sidebar-content");
        
        let contentHTML = `
            <div class="sidebar-header">
                <div class="sidebar-title">${details.title}</div>
                <button class="close-sidebar" onclick="closeSidebar()">×</button>
            </div>
        `;
        
        details.categories.forEach(category => {
            contentHTML += `
                <div class="potential-category">
                    <div class="category-title">
                        <span>${category.icon}</span> ${category.name}
                    </div>
            `;
            
            category.items.forEach(item => {
                contentHTML += `
                    <div class="potential-item">
                        <div class="potential-item-title">${item.title}</div>
                        <div class="potential-item-desc">${item.description}</div>
                    </div>
                `;
            });
            
            contentHTML += `</div>`;
        });
        
        sidebarContent.innerHTML = contentHTML;
    }
    
    function closeSidebar() {
        const sidebar = document.getElementById("sidebar");
        sidebar.classList.remove("open");
    }
</script>
@endsection

@section('body_attributes')
onload="initMap()"
@endsection

@section('content')
<div class="flex h-screen">
    <div id="map" class="flex-grow"></div>
    <div id="sidebar" class="w-0 bg-white h-full overflow-y-auto transition-width duration-300 shadow-lg">
        <div id="sidebar-content" class="p-5">
            <!-- Content will be added dynamically via JavaScript -->
        </div>
    </div>
</div>
@endsection