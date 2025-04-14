<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Potensi Desa</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style>
            body {
                font-family: 'Figtree', sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f3f4f6;
            }
            
            /* Navbar styling */
            .navbar {
                background-color: white;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
                padding: 0.5rem 1rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
                height: 60px; /* Increased height for larger logo */
            }
            
            .navbar-left {
                display: flex;
                align-items: center;
            }
            
            .logo-container {
                display: flex;
                align-items: center;
            }
            
            .logo {
                height: 50px; /* Increased logo size from 36px to 50px */
                margin-right: 12px;
            }
            
            .site-title {
                font-weight: 600;
                color: #166534;
                font-size: 1.2rem; /* Slightly larger font to match the logo */
                text-decoration: none;
                white-space: nowrap;
            }
            
            .navbar-center {
                position: absolute;
                left: 50%;
                transform: translateX(-50%);
            }
            
            .search-container {
                display: flex;
                align-items: center;
                background-color: #f3f4f6;
                border-radius: 20px;
                padding: 0.25rem 0.75rem;
            }
            
            .search-container input {
                border: none;
                background-color: transparent;
                outline: none;
                font-size: 0.9rem;
                width: 180px;
                padding: 0.25rem;
            }
            
            .search-icon {
                color: #9ca3af;
                margin-right: 5px;
                font-size: 0.9rem;
            }
            
            .navbar-right {
                display: flex;
                gap: 10px;
            }
            
            .login-btn {
                background-color: #166534;
                color: white;
                font-weight: 600;
                padding: 0.5rem 1rem;
                border-radius: 4px;
                text-decoration: none;
                font-size: 0.9rem;
                border: none;
                cursor: pointer;
            }
            
            .register-btn {
                background-color: white;
                color: #166534;
                font-weight: 600;
                padding: 0.5rem 1rem;
                border-radius: 4px;
                text-decoration: none;
                font-size: 0.9rem;
                border: 1px solid #166534;
                cursor: pointer;
            }
            
            .register-btn:hover {
                background-color: #f9fafb;
            }
            
            .user-menu {
                position: relative;
            }
            
            .user-btn {
                background-color: white;
                color: #166534;
                font-weight: 600;
                padding: 0.5rem 1rem;
                border-radius: 4px;
                text-decoration: none;
                font-size: 0.9rem;
                border: 1px solid #166534;
                cursor: pointer;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }
            
            .dropdown-content {
                display: none;
                position: absolute;
                right: 0;
                top: 110%;
                background-color: white;
                min-width: 180px;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
                border-radius: 6px;
                padding: 0.5rem 0;
                z-index: 100;
            }
            
            .user-menu:hover .dropdown-content {
                display: block;
            }
            
            .dropdown-content a {
                color: #374151;
                padding: 0.5rem 1rem;
                text-decoration: none;
                display: block;
                font-size: 0.9rem;
            }
            
            .dropdown-content a:hover {
                background-color: #f3f4f6;
            }
            
            /* Category bar styling */
            .category-bar {
                display: flex;
                justify-content: center;
                align-items: center;
                background-color: white;
                padding: 0.5rem 1rem;
                border-bottom: 1px solid #e5e7eb;
            }
            
            .category-nav {
                display: flex;
                align-items: center;
                gap: 1rem;
                margin-right: 5rem;
            }
            
            .category-btn {
                color: #4b5563;
                font-weight: 500;
                font-size: 0.9rem;
                padding: 0.25rem 0.75rem;
                border-radius: 20px;
                text-decoration: none;
                transition: background-color 0.2s;
            }
            
            .category-btn:hover, .category-btn.active {
                background-color: #ecfdf5;
                color: #047857;
            }
            
            .category-btn.active {
                font-weight: 600;
            }
            
            .dropdown-container {
                position: absolute;
                right: 20px;
            }
            
            .dropdown-btn {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                background-color: white;
                border: 1px solid #e5e7eb;
                padding: 0.4rem 0.8rem;
                border-radius: 4px;
                font-size: 0.9rem;
                color: #4b5563;
                cursor: pointer;
            }
            
            .dropdown-btn:hover {
                background-color: #f9fafb;
            }
            
            .dropdown-content {
                display: none;
                position: absolute;
                right: 0;
                top: 110%;
                background-color: white;
                min-width: 180px;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
                border-radius: 6px;
                padding: 0.5rem 0;
                z-index: 100;
            }
            
            .dropdown-container:hover .dropdown-content {
                display: block;
            }
            
            .dropdown-content a {
                color: #374151;
                padding: 0.5rem 1rem;
                text-decoration: none;
                display: block;
                font-size: 0.9rem;
            }
            
            .dropdown-content a:hover {
                background-color: #f3f4f6;
            }
            
            /* Map Container */
            .map-container {
                display: flex;
                height: calc(100vh - 120px);  /* Adjusted for larger navbar */
            }
            
            #map {
                flex-grow: 1;
                height: 100%;
            }
            
            /* Sidebar for displaying village potential info */
            .sidebar {
                width: 0;
                background-color: white;
                height: 100%;
                overflow-y: auto;
                transition: width 0.3s ease;
                box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
            }
            
            .sidebar.open {
                width: 350px;
            }
            
            .sidebar-content {
                padding: 20px;
            }
            
            .sidebar-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 15px;
                border-bottom: 1px solid #e5e7eb;
                padding-bottom: 10px;
            }
            
            .sidebar-title {
                font-size: 1.2rem;
                font-weight: 600;
                color: #166534;
            }
            
            .close-sidebar {
                background: none;
                border: none;
                font-size: 1.5rem;
                cursor: pointer;
                color: #6b7280;
            }
            
            .potential-category {
                margin-bottom: 20px;
            }
            
            .category-title {
                font-weight: 600;
                color: #166534;
                margin-bottom: 10px;
                display: flex;
                align-items: center;
            }
            
            .category-title i {
                margin-right: 8px;
            }
            
            .potential-item {
                background-color: #f9fafb;
                border-radius: 8px;
                padding: 12px;
                margin-bottom: 10px;
            }
            
            .potential-item-title {
                font-weight: 500;
                margin-bottom: 5px;
            }
            
            .potential-item-desc {
                color: #6b7280;
                font-size: 0.9rem;
            }
            
            /* Footer */
            footer {
                text-align: center;
                padding: 1rem;
                background-color: #ffffff;
                color: #6b7280;
                font-size: 0.875rem;
                box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.05);
            }
        </style>

        <!-- Google Maps API -->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZDmvgsLscfcgz3faTixl54JobWg0xGAY"></script>
        <script>
            function initMap() {
                const map = new google.maps.Map(document.getElementById('map'), {
                    center: { lat: -6.9383, lng: 107.7190 }, // Koordinat Cileunyi Kulon
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

                // Tambahkan marker untuk desa Cileunyi
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

                // Buat marker dan tambahkan event listener untuk setiap marker
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

                    // Tambahkan event listener
                    marker.addListener("click", () => {
                        openSidebar(markerInfo.details);
                    });
                });

                // Tambahkan event listener untuk klik pada peta (masih dipertahankan)
                map.addListener("click", (event) => {
                    new google.maps.Marker({
                        position: event.latLng,
                        map: map,
                        title: "Lokasi yang diklik"
                    });
                });
            }

            // Fungsi untuk mendapatkan icon marker berdasarkan kategori
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

            // Fungsi untuk membuka sidebar dan menampilkan informasi
            function openSidebar(details) {
                const sidebar = document.getElementById("sidebar");
                sidebar.classList.add("open");
                
                // Isi sidebar dengan informasi potensi desa
                const sidebarContent = document.getElementById("sidebar-content");
                
                let contentHTML = `
                    <div class="sidebar-header">
                        <div class="sidebar-title">${details.title}</div>
                        <button class="close-sidebar" onclick="closeSidebar()">×</button>
                    </div>
                `;
                
                // Tambahkan setiap kategori dan item-nya
                details.categories.forEach(category => {
                    contentHTML += `
                        <div class="potential-category">
                            <div class="category-title">
                                <span>${category.icon}</span> ${category.name}
                            </div>
                    `;
                    
                    // Tambahkan item-item dalam kategori
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
            
            // Fungsi untuk menutup sidebar
            function closeSidebar() {
                const sidebar = document.getElementById("sidebar");
                sidebar.classList.remove("open");
            }
        </script>
    </head>
    <body onload="initMap()">
        <!-- Navbar -->
        <nav class="navbar">
            <div class="navbar-left">
                <div class="logo-container">
                    <!-- Logo yang sudah diperbesar -->
                    <img src="{{ asset('images/NUSA.png') }}" alt="" class="logo">
                    <a href="#" class="site-title">Potensi Desa</a>
                </div>
            </div>
            
            <div class="navbar-center">
                <div class="search-container">
                    <span class="search-icon">🔍</span>
                    <input type="text" placeholder="Search">
                </div>
            </div>
            
            <div class="navbar-right">
                @auth
                    <div class="user-menu">
                        <button class="user-btn">
                            {{ Auth::user()->name }}
                            <span>▼</span>
                        </button>
                        <div class="dropdown-content">
                            <a href="/profile">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                    Log Out
                                </a>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('register') }}" class="register-btn">Register</a>
                    <a href="{{ route('login') }}" class="login-btn">Login</a>
                @endauth
            </div>
        </nav>

        <!-- Category Bar - Now Centered -->
        <div class="category-bar">
            <div class="category-nav">
                <a href="#" class="category-btn active">All</a>
                <a href="#" class="category-btn">Pertanian</a>
                <a href="#" class="category-btn">Peternakan</a>
                <a href="#" class="category-btn">Ekonomi</a>
                <a href="#" class="category-btn">SDA</a>
                <a href="#" class="category-btn">Infrastruktur</a>
            </div>
            <div class="dropdown-container">
                <button class="dropdown-btn">
                    Select a Category
                    <span>▼</span>
                </button>
                <div class="dropdown-content">
                    <a href="#">Pertanian</a>
                    <a href="#">Peternakan</a>
                    <a href="#">Ekonomi</a>
                    <a href="#">SDA</a>
                    <a href="#">Infrastruktur</a>
                </div>
            </div>
        </div>

        <!-- Map Container with Sidebar -->
        <div class="map-container">
            <div id="map"></div>
            <div id="sidebar" class="sidebar">
                <div id="sidebar-content" class="sidebar-content">
                    <!-- Content will be added dynamically via JavaScript -->
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer>
            &copy; 2025 Potensi Desa. All rights reserved.
        </footer>
    </body>
</html>