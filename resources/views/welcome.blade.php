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
                                },
                                {
                                    title: "Sayuran",
                                    description: "Budidaya sayuran organik seluas 75 hektar yang mencakup kangkung, bayam, dan sawi."
                                }
                            ]
                        },
                        {
                            name: "Infrastruktur",
                            icon: "🏗️",
                            items: [
                                {
                                    title: "Irigasi",
                                    description: "Sistem irigasi teknis yang mengairi 85% lahan pertanian dengan sumber dari sungai Cidurian."
                                }
                            ]
                        }
                    ]
                }
            },
            {
                position: { lat: -6.9303, lng: 107.7290 },
                title: "Peternakan Sapi Cileunyi",
                category: "Peternakan",
                details: {
                    title: "Peternakan Sapi Cileunyi",
                    categories: [
                        {
                            name: "Peternakan",
                            icon: "🐄",
                            items: [
                                {
                                    title: "Sapi Perah",
                                    description: "250 ekor sapi perah dengan produksi susu 12-15 liter per ekor per hari, dikelola oleh koperasi susu desa."
                                },
                                {
                                    title: "Domba",
                                    description: "Peternakan domba rakyat dengan total 800 ekor yang tersebar di seluruh desa."
                                }
                            ]
                        },
                        {
                            name: "Ekonomi",
                            icon: "💰",
                            items: [
                                {
                                    title: "Koperasi Susu",
                                    description: "Koperasi dengan 75 anggota aktif, mengelola distribusi susu ke pengepul di Bandung."
                                }
                            ]
                        }
                    ]
                }
            },
            {
                position: { lat: -6.9423, lng: 107.7100 },
                title: "Industri Rumahan Cileunyi",
                category: "Ekonomi",
                details: {
                    title: "Industri Rumahan Cileunyi",
                    categories: [
                        {
                            name: "Ekonomi",
                            icon: "💰",
                            items: [
                                {
                                    title: "Kerajinan Bambu",
                                    description: "40 pengrajin bambu yang membuat berbagai produk seperti anyaman, furniture, dan souvenir."
                                },
                                {
                                    title: "Produksi Makanan",
                                    description: "25 UMKM makanan olahan dengan produk unggulan keripik singkong dan dodol."
                                }
                            ]
                        },
                        {
                            name: "SDA",
                            icon: "🌳",
                            items: [
                                {
                                    title: "Bambu",
                                    description: "Hutan bambu seluas 40 hektar yang dikelola secara berkelanjutan untuk bahan baku kerajinan."
                                }
                            ]
                        }
                    ]
                }
            },
            {
                position: { lat: -6.9353, lng: 107.7240 },
                title: "Sumber Mata Air Cileunyi",
                category: "SDA",
                details: {
                    title: "Sumber Mata Air Cileunyi",
                    categories: [
                        {
                            name: "SDA",
                            icon: "🌳",
                            items: [
                                {
                                    title: "Mata Air Cibiru",
                                    description: "Sumber mata air dengan debit 25 liter/detik yang menjadi sumber air bersih bagi 60% penduduk desa."
                                },
                                {
                                    title: "Hutan Lindung",
                                    description: "Area hutan lindung seluas 100 hektar yang berfungsi sebagai daerah resapan air."
                                }
                            ]
                        },
                        {
                            name: "Infrastruktur",
                            icon: "🏗️",
                            items: [
                                {
                                    title: "Sistem Distribusi Air",
                                    description: "Jaringan pipa air bersih sepanjang 7 km yang menjangkau 5 dusun di desa Cileunyi."
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

        map.addListener("click", (event) => {
            new google.maps.Marker({
                position: event.latLng,
                map: map,
                title: "Lokasi yang diklik"
            });
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