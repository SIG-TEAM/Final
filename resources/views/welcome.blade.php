<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Potensi Desa</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style>
            body {
                font-family: 'Figtree', sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f3f4f6;
            }
            .navbar {
                background-color: #ffffff;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                padding: 1rem 2rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .navbar a {
                text-decoration: none;
                color: #374151;
                margin-left: 1rem;
                font-weight: 600;
            }
            .navbar a:hover {
                color: #1f2937;
            }
            .map-container {
                height: 80vh;
                width: 100%;
            }
            footer {
                text-align: center;
                padding: 1rem;
                background-color: #ffffff;
                color: #6b7280;
                font-size: 0.875rem;
                box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.1);
            }
        </style>

        <!-- Google Maps API -->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZDmvgsLscfcgz3faTixl54JobWg0xGAY"></script>
        <script>
            function initMap() {
                const map = new google.maps.Map(document.getElementById('map'), {
                    center: { lat: -7.250445, lng: 112.768845 }, // Ganti dengan koordinat wilayah Anda
                    zoom: 10,
                });

                // Contoh marker
                const marker = new google.maps.Marker({
                    position: { lat: -7.250445, lng: 112.768845 },
                    map: map,
                    title: "Contoh Potensi Desa",
                });
            }
        </script>
    </head>
    <body onload="initMap()">
        <!-- Navbar -->
        <nav class="navbar">
            <div>
                <a href="{{ url('/') }}" class="font-semibold">Potensi Desa</a>
            </div>
            <div>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>

        <!-- Map Container -->
        <div id="map" class="map-container"></div>

        <!-- Footer -->
        <footer>
            &copy; {{ date('Y') }} Potensi Desa. All rights reserved.
        </footer>
    </body>
</html>
