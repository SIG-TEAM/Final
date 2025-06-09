<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZDmvgsLscfcgz3faTixl54JobWg0xGAY"></script>
<script>
    let map;
    let currentMarker;
    let selectedLocation;
    let approved = {!! json_encode(isset($approvedAreas) ? $approvedAreas : []) !!};
    const userRole = "{{ Auth::check() ? Auth::user()->role : 'guest' }}";

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: -7.0875, lng: 107.4500 },
            zoom: 13,
            disableDefaultUI: true,
            styles: [
                { featureType: "poi", elementType: "labels", stylers: [{ visibility: "off" }] },
                { featureType: "transit", elementType: "all", stylers: [{ visibility: "off" }] }
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

        approved.forEach(area => {
            const marker = new google.maps.Marker({
                position: { lat: parseFloat(area.latitude), lng: parseFloat(area.longitude) },
                map: map,
                title: area.nama,
                icon: { url: "http://maps.google.com/mapfiles/ms/icons/green-dot.png" }
            });

            marker.addListener('click', function() {
                showSidebarAreaInfo(area);
            });

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

                    new google.maps.Polygon({
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
            }
            // Pengguna lain (termasuk yang tidak login) hanya bisa melihat data, tidak bisa menambah marker, dan tidak ada alert.
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

    function showSidebarAreaInfo(area) {
        const sidebar = document.getElementById("sidebar");
        const sidebarContent = document.getElementById("sidebar-content");
        sidebar.classList.add("w-96");
        sidebar.classList.remove("w-0");
        fetch(`/sidebar-area-info?area=${encodeURIComponent(JSON.stringify(area))}`)
            .then(response => response.text())
            .then(html => {
                sidebarContent.innerHTML = html;
            })
            .catch(() => {
                sidebarContent.innerHTML = '<div class="p-4 text-red-600">Gagal memuat detail area.</div>';
            });
    }
</script>
