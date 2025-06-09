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
            center: { lat: -7.0875, lng: 107.4500 }, // Geser lebih ke kanan (longitude lebih besar)
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
                    north: -7.0125,
                    south: -7.1700,
                    west: 107.3200,
                    east: 107.5400
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

            // InfoWindow dengan informasi lengkap (opsional, bisa dihapus jika hanya ingin sidebar)
            let infoContent = `
                <div style="min-width:220px;max-width:320px">
                    <strong style="font-size:1.1em">${area.nama}</strong>
                    <br>
                    <span style="color:#008000;font-weight:500">${area.kategori ?? '-'}</span>
                    <br>
                    <span style="font-size:0.95em">${area.deskripsi ?? '-'}</span>
                    <br>
            `;
            if (area.foto) {
                infoContent += `
                    <div style="margin:8px 0">
                        <img src="${area.foto.startsWith('http') ? area.foto : '/storage/' + area.foto}" alt="Foto ${area.nama}" style="max-width:100%;max-height:120px;border-radius:6px;box-shadow:0 1px 4px #0002">
                    </div>
                `;
            }
            infoContent += `
                <div style="font-size:0.9em;margin:4px 0 2px 0">
                    <b>Koordinat:</b> <span style="font-family:monospace">${area.latitude}, ${area.longitude}</span>
                </div>
            `;
            if (area.polygon) {
                let polygonCoords;
                try {
                    polygonCoords = Array.isArray(area.polygon) ? area.polygon : JSON.parse(area.polygon);
                } catch (e) {
                    polygonCoords = null;
                }
                if (polygonCoords && Array.isArray(polygonCoords) && polygonCoords.length > 2) {
                    infoContent += `
                        <div style="font-size:0.9em">
                            <b>Polygon:</b> ${polygonCoords.length} titik
                        </div>
                    `;
                }
            }
            infoContent += `</div>`;

            // Tampilkan info di sidebar saat marker diklik
            marker.addListener('click', function() {
                showSidebarAreaInfo(area);
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

    // Tambahkan fungsi untuk menampilkan info area di sidebar
    function showSidebarAreaInfo(area) {
        const sidebar = document.getElementById("sidebar");
        const sidebarContent = document.getElementById("sidebar-content");
        sidebar.classList.add("w-96");
        sidebar.classList.remove("w-0");

        let html = `
            <div class="space-y-3">
                <div class="mb-2">
                    <h1 class="text-xl font-extrabold text-green-800 uppercase tracking-wide">Informasi Potensi Area</h1>
                </div>
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-bold text-green-900">${area.nama}</h2>
                    <button onclick="closeSidebar()" class="text-gray-500 hover:text-red-600 text-xl font-bold">&times;</button>
                </div>
                <div class="text-sm text-green-700 font-semibold">
                    <b>${area.nama}
                </div>
        `;

        // Kategori
        html += `
            <div class="text-green-700 font-semibold">${area.kategori ?? '-'}</div>
        `;

        // Foto
        if (area.foto) {
            html += `
                <div>
                    <img src="${area.foto.startsWith('http') ? area.foto : '/storage/' + area.foto}" alt="Foto ${area.nama}" class="rounded shadow max-h-48 max-w-full mx-auto">
                </div>
            `;
        }

        // Deskripsi
        html += `
            <div class="text-gray-700">${area.deskripsi ?? '-'}</div>
        `;

        // Alamat lengkap
        html += `
            <div class="text-gray-600 text-sm">
                <b>Alamat:</b> ${area.alamat ?? '-'}
            </div>
        `;

        // Koordinat
        html += `
            <div class="text-xs text-gray-600">
                <b>Koordinat:</b> <span class="font-mono">${area.latitude}, ${area.longitude}</span>
            </div>
        `;

        // Polygon info (opsional)
        if (area.polygon) {
            let polygonCoords;
            try {
                polygonCoords = Array.isArray(area.polygon) ? area.polygon : JSON.parse(area.polygon);
            } catch (e) {
                polygonCoords = null;
            }
            if (polygonCoords && Array.isArray(polygonCoords) && polygonCoords.length > 2) {
                html += `
                    <div class="text-xs text-gray-600">
                        <b>Polygon:</b> ${polygonCoords.length} titik
                    </div>
                `;
            }
        }

        html += `</div>`;

        // UX: Info box hanya tampil jika user login dan bukan penduduk
        if (userRole && userRole !== 'penduduk') {
            html += `
                <div class="mt-6 p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded text-yellow-800 flex items-start space-x-3 animate-pulse">
                    <svg class="w-6 h-6 text-yellow-500 flex-shrink-0 mt-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z"/>
                    </svg>
                    <div>
                        <div class="font-bold mb-1">Ingin Menjadi Penduduk?</div>
                        <div>
                            Untuk dapat menambahkan potensi area, Anda harus menjadi <b>penduduk</b>.<br>
                            Silakan ajukan permintaan pada halaman 
                            <a href="/profile" class="underline text-green-700 font-semibold hover:text-green-900">Profile</a> Anda.
                        </div>
                    </div>
                </div>
            `;
        }

        sidebarContent.innerHTML = html;
    }
</script>
@endsection

@section('body_attributes')
onload="initMap()"
@endsection

@section('content')
<div class="fixed inset-0 w-screen h-screen m-0 p-0 overflow-hidden">
    <!-- Informasi UX di atas peta -->
    <div class="absolute top-4 left-1/2 z-30 -translate-x-1/2">
        <div class="bg-white/90 border border-green-200 rounded-lg shadow px-5 py-3 flex items-center space-x-3 text-green-900 text-sm font-medium">
            <svg class="w-5 h-5 text-green-700 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01"/>
            </svg>
            <span>
                <b>Panduan Peta:</b>
                Klik marker hijau untuk melihat detail potensi area.<br>
                @if(Auth::check() && Auth::user()->role === 'penduduk')
                    Klik pada peta untuk menambahkan potensi area baru.
                @else
                    Login sebagai <b>penduduk</b> untuk dapat menambahkan potensi area.
                @endif
            </span>
        </div>
    </div>
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
