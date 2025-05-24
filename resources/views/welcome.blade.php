@extends('layouts.app')

@section('styles')
<!-- Tailwind styles for the welcome page -->
@endsection

@section('head')
<!-- Google Maps API -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZDmvgsLscfcgz3faTixl54JobWg0xGAY"></script>
<script>
    let map;
    let currentMarker;
    let selectedLocation;

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

        // Tambahkan kelas untuk menampilkan sidebar
        sidebar.classList.add("w-96");
        sidebar.classList.remove("w-0");

        sidebarContent.innerHTML = `
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold text-green-700">Tambah Potensi Area</h2>
                </div>
                
                <div class="bg-green-50 p-4 rounded-lg mb-6 border border-green-200">
                    <p class="text-sm text-green-800">
                        <span class="font-medium">Lokasi dipilih!</span> Tentukan detail potensi area pada titik ini.
                    </p>
                </div>

                <form id="locationForm" method="POST" action="/potensi-area" class="space-y-4">
                    @csrf
                    <div class="mb-4">
                        <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
                        <input type="text" id="latitude" name="latitude" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" value="${location.lat()}" readonly>
                    </div>
                    <div class="mb-4">
                        <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
                        <input type="text" id="longitude" name="longitude" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" value="${location.lng()}" readonly>
                    </div>
                    
                    <div class="pt-4 flex flex-col gap-3">
                        <!-- Tambah Potensi Area -->
                        <a href="/potensi-area/create" class="w-full inline-flex justify-center items-center px-4 py-2 border border-black text-sm font-medium rounded-md shadow-sm text-black bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Potensi Area
                        </a>

                        <!-- Lihat Semua Potensi Area -->
                        <a href="/potensi-area" class="w-full inline-flex justify-center items-center px-4 py-2 border border-green-600 text-sm font-medium rounded-md text-green-700 bg-white hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            Lihat Semua Potensi Area
                        </a>

                        <!-- Tombol Batal -->
                        <button type="button" onclick="closeSidebar()" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        `;
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
<div class="relative">
    <div class="flex h-screen">
        <div id="map" class="flex-grow"></div>
        <div id="sidebar" class="w-0 bg-white h-full overflow-hidden transition-all duration-300 shadow-xl border-l border-gray-200">
            <div id="sidebar-content" class="p-5">
                <!-- Content will be added dynamically via JavaScript -->
                <div class="mt-4">
                    <a href="/potensi-area/create" class="w-full inline-flex justify-center items-center px-4 py-3 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Potensi Area
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
