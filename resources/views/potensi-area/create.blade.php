<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Potensi Area</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />
    <style>
        #map { 
            height: 400px; 
            border-radius: 0.375rem;
        }
        .required-label::after {
            content: " *";
            color: red;
        }
        .card-header {
            background-color: #4CAF50; /* Hijau seperti di welcome.blade.php */
            color: white;
        }
        .btn-primary {
            background-color: #4CAF50; /* Hijau */
            border-color: #4CAF50;
        }
        .btn-primary:hover {
            background-color: #45A049; /* Hijau lebih gelap */
            border-color: #45A049;
        }
        .btn-secondary {
            background-color: #f3f4f6; /* Abu-abu terang */
            color: #4CAF50; /* Hijau */
            border-color: #4CAF50;
        }
        .btn-secondary:hover {
            background-color: #e2e8f0; /* Abu-abu lebih terang */
            color: #45A049; /* Hijau lebih gelap */
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header">
                        <h3 class="mb-0">Tambah Potensi Area</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('potensi-area.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            
                            <div class="mb-3">
                                <label for="nama" class="form-label required-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                                <div class="invalid-feedback">
                                    Silakan masukkan nama area.
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="kategori" class="form-label required-label">Kategori</label>
                                <select class="form-select" id="kategori" name="kategori" required>
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    <option value="Pertanian">Pertanian</option>
                                    <option value="Peternakan">Peternakan</option>
                                    <option value="Ekonomi">Ekonomi</option>
                                    <option value="SDA">Sumber Daya Alam</option>
                                    <option value="Infrastruktur">Infrastruktur</option>
                                </select>
                                <div class="invalid-feedback">
                                    Silakan pilih kategori.
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4"></textarea>
                            </div>
                            
                            <div class="mb-4">
                                <label for="foto" class="form-label">Foto</label>
                                <input type="file" class="form-control" id="foto" name="foto">
                                <div class="form-text">Format yang didukung: JPG, PNG, GIF. Maks 2MB.</div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="map" class="form-label required-label">Gambar Titik atau Polygon di Peta</label>
                                <div id="map" class="mb-2"></div>
                                <div class="form-text mb-3">Gambar polygon area dengan mengklik tombol polygon di peta kemudian klik titik-titik di peta untuk membentuk area.</div>
                                <textarea name="polygon" id="polygon-coords" hidden></textarea>
                                <textarea name="titik_potensi" id="marker-coords" hidden></textarea>
                                <div id="polygon-status" class="alert alert-warning d-none">
                                    Titik atau Polygon belum dibuat. Silakan gambar area pada peta.
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="button" class="btn btn-secondary me-md-2" onclick="history.back()">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
    
    <script>
        // Form validation
        (function() {
            'use strict';
            var forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();

        // Initialize map
        var map = L.map('map').setView([-6.950, 107.690], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);
        
        var drawControl = new L.Control.Draw({
            draw: {
                polygon: {
                    allowIntersection: false,
                    drawError: {
                        color: '#e1e100',
                        message: '<strong>Polygon tidak valid!</strong> Garis tidak boleh bersilangan.'
                    },
                    shapeOptions: {
                        color: '#3388ff'
                    }
                },
                marker: true,
                polyline: false,
                rectangle: false,
                circle: false,
                circlemarker: false
            },
            edit: {
                featureGroup: drawnItems,
                poly: {
                    allowIntersection: false
                }
            }
        });
        map.addControl(drawControl);
        
        // Show polygon status initially
        document.getElementById('polygon-status').classList.remove('d-none');
        
        map.on('draw:created', function (e) {
            var type = e.layerType;
            var layer = e.layer;

            if (type === 'marker') {
                var markerCoords = [layer.getLatLng().lng, layer.getLatLng().lat];
                document.getElementById('marker-coords').value = JSON.stringify(markerCoords);
                console.log('Titik Potensi:', markerCoords); // Debug titik potensi
            } else if (type === 'polygon') {
                var coordinates = layer.getLatLngs()[0].map(p => [p.lng, p.lat]);
                document.getElementById('polygon-coords').value = JSON.stringify(coordinates);
                console.log('Polygon:', coordinates); // Debug polygon
            }

            drawnItems.addLayer(layer);
            
            // Update status
            document.getElementById('polygon-status').classList.remove('alert-warning');
            document.getElementById('polygon-status').classList.add('alert-success');
            document.getElementById('polygon-status').innerHTML = 'Titik atau Polygon berhasil dibuat. Area telah ditandai pada peta.';
            document.getElementById('polygon-status').classList.remove('d-none');
        });

        map.on('draw:deleted', function() {
            // Clear coordinates when polygon is deleted
            document.getElementById('polygon-coords').value = '';
            
            // Reset status
            document.getElementById('polygon-status').classList.remove('alert-success');
            document.getElementById('polygon-status').classList.add('alert-warning');
            document.getElementById('polygon-status').innerHTML = 'Titik atau Polygon belum dibuat. Silakan gambar area pada peta.';
            document.getElementById('polygon-status').classList.remove('d-none');
        });

        // Resize map when window is resized
        window.addEventListener('resize', function() {
            map.invalidateSize();
        });

        // Validate polygon and marker before form submission
        document.querySelector('form').addEventListener('submit', function(event) {
            const polygonCoords = document.getElementById('polygon-coords').value;
            const markerCoords = document.getElementById('marker-coords').value;

            if (!polygonCoords && !markerCoords) {
                event.preventDefault();
                alert('Silakan tambahkan Polygon atau Titik Potensi di peta sebelum menyimpan.');
                return;
            }
        });
    </script>
</body>
</html>