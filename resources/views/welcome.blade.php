@extends('layouts.app')

@section('head')
<!-- Google Maps API -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZDmvgsLscfcgz3faTixl54JobWg0xGAY"></script>
<script>
    let map;
    let currentMarker;
    let selectedLocation;
    // Gunakan array kosong jika $approvedAreas tidak ada
    let approved = {!! json_encode(isset($approvedAreas) ? $approvedAreas : []) !!};

    const userRole = "{{ Auth::check() ? Auth::user()->role : '' }}";

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: -6.9383, lng: 107.7190 },
            zoom: 13,
            disableDefaultUI: true,
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

        // Tampilkan marker dan polygon untuk setiap area yang approved
        approved.forEach(area => {
            // Marker
            const marker = new google.maps.Marker({
                position: { lat: parseFloat(area.latitude), lng: parseFloat(area.longitude) },
                map: map,
                title: area.nama,
                icon: {
                    url: "http://maps.google.com/mapfiles/ms/icons/green-dot.png"
                }
            });

            // InfoWindow
            const infoWindow = new google.maps.InfoWindow({
                content: `<strong>${area.nama}</strong><br>${area.kategori}<br>${area.deskripsi}`
            });
            marker.addListener('click', function() {
                infoWindow.open(map, marker);
            });

            // Polygon (jika ada)
            if (area.polygon) {
                let polygonCoords;
                try {
                    polygonCoords = Array.isArray(area.polygon) ? area.polygon : JSON.parse(area.polygon);
                } catch (e) {
                    polygonCoords = null;
                }
                if (polygonCoords && Array.isArray(polygonCoords) && polygonCoords.length > 2) {
                    // Format koordinat ke Google Maps
                    const path = polygonCoords.map(p => {
                        if (Array.isArray(p)) {
                            return { lat: parseFloat(p[0]), lng: parseFloat(p[1]) };
                        } else if (typeof p === 'object' && p.lat && p.lng) {
                            return { lat: parseFloat(p.lat), lng: parseFloat(p.lng) };
                        }
                        return null;
                    }).filter(Boolean);

                    const polygon = new google.maps.Polygon({
                        paths: path,
                        strokeColor: '#008000',
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        fillColor: '#008000',
                        fillOpacity: 0.2,
                        map: map
                    });
                }
            }
        });

        map.addListener("click", function (event) {
            if (userRole === 'penduduk') {
                addMarker(event.latLng);
            } else {
                alert("Anda tidak memiliki izin untuk menambahkan marker.");
            }
        });
    }

    function addMarker(location) {
        if (currentMarker) {
            currentMarker.setMap(null);
        }

        currentMarker = new google.maps.Marker({
            position: location,
            map: map,
            draggable: true,
            animation: google.maps.Animation.DROP
        });

        google.maps.event.addListener(currentMarker, 'dragend', function() {
            selectedLocation = currentMarker.getPosition();
            updateSidebarLocation(selectedLocation);
        });

        selectedLocation = location;
        openSidebar(location);
    }

    function updateSidebarLocation(location) {
        document.getElementById('latitude').value = location.lat();
        document.getElementById('longitude').value = location.lng();
    }

    function openSidebar(location) {
        const sidebar = document.getElementById("sidebar");
        const sidebarContent = document.getElementById("sidebar-content");

        sidebar.classList.add("w-96");
        sidebar.classList.remove("w-0");

        // Ambil template form yang sudah dirender server-side
        const template = document.getElementById("potensi-area-form-template").content.cloneNode(true);
        template.querySelector('#latitude').value = location.lat();
        template.querySelector('#longitude').value = location.lng();

        sidebarContent.innerHTML = '';
        sidebarContent.appendChild(template);
    }

    function closeSidebar() {
        const sidebar = document.getElementById("sidebar");
        sidebar.classList.add("w-0");
        sidebar.classList.remove("w-96");

        if (currentMarker) {
            currentMarker.setMap(null);
            currentMarker = null;
        }
    }
</script>
@endsection

@section('body_attributes')
onload="initMap()"
@endsection

@section('content')
<div class="fixed inset-0 w-screen h-screen m-0 p-0 overflow-hidden">
    <div class="flex h-full w-full overflow-hidden">
        <div id="map" class="flex-grow h-full w-full"></div>
        <div id="sidebar" class="w-0 bg-white transition-all duration-300 shadow-xl border-l border-gray-200 h-full">
            <div id="sidebar-content" class="p-5 h-full overflow-y-auto">
                <x-sidebar-default />
            </div>
        </div>
    </div>
    <!-- Template form sidebar, siap di-clone oleh JS -->
    <template id="potensi-area-form-template">
        @component('components.potensi-area-form')
        @endcomponent
    </template>
</div>
@endsection
